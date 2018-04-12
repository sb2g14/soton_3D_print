<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;
use DB;
use Carbon\Carbon;

class staff extends BaseModel
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'role'
    ];
   public function user()
   {
       return $this->belongsTo(User::class);
   }
    // The function shows jobs approved by user
    public function printing_data(){
        return $this->hasMany(printing_data::class, 'approved_by');
    }
    public function issue_created()
    {
        return $this->hasMany(FaultData::class, 'staff_id_created_issue');
    }
    public function issue_resolved()
    {
        return $this->hasMany(FaultData::class,'staff_id_resolved_issue');
    }
    public function updates()
    {
        return $this->hasMany(FaultUpdates::class, 'staff_id');
    }
    public function sessions()
    {
        return $this->belongsToMany(Sessions::class);
    }
    public function hasRole($rolename)
    {
        return $this->user->hasRole($rolename);
    }
    public function availability()
    {
        return $this->hasMany(Availability::class);
    }
    /**returns the full name of that staff**/
    public function name()
    {
        return $this->first_name.' '.$this->last_name;
    }
    public function experience()
    {
        return $this->sessions->count();
    }
    public function isExperienced()
    {
        // Get all demonstrators
        $demonstrators = staff::where('role', 'Demonstrator')->get();
        // Average the experiences
        $cnt = 0;
        $avexp = 0;
        foreach($demonstrators as $dem){
            $avexp += $dem->experience();
            $cnt++;
        }
        $avexp = $avexp/(float)$cnt;
        
        // Check if members experience is above average
        if($this->experience() >= $avexp){
            return true;
        }
        return false;
    }
    
    public function lastSession()
    {   
        $t = $this->sessions()->orderBy('start_date','desc')->first();
        if(!$t){
            return null;
        }
        return $t->start_date; //->toDateString();
    }

    private function formatWorkinghours($lastdate,$minutes){
        $nicedate = new Carbon($lastdate);
        $nicedate = $nicedate->format('j. M');
        $hours = (int)($minutes/60);
        $minutes = ($minutes - 60*(int)($minutes/60));
        $time = sprintf("%d:%02d",$hours,$minutes);
        $ans = $nicedate.': '.$time;
        return $ans;
    }
    
    public function workinghours($endmonth)
    {   
        // Get relevant sessions
        $t2 = $endmonth;
        $t2 = $t2->day(1)->hour(0)->minute(0)->second(0);
        $t1 = $t2->copy()->subMonth();
        $sessions = $this->sessions()->where('start_date', '>=', $t1)->where('start_date', '<=', $t2)
            ->orderBy('start_date')->get();
        // Merge sessions by date
        if(count($sessions) <= 0){return [];}
        $lastdate = $sessions[0]->date();
        $workhours = [];
        $minutes = 0;
        foreach($sessions as $s){
            if($lastdate != $s->date()){
                $workhours[] = $this->formatWorkinghours($lastdate,$minutes);
                $lastdate = $s->date();
                $minutes = 0;
            }
            $minutes += $s->minutes();
        }
        if($lastdate != ""){
            $workhours[] = $this->formatWorkinghours($lastdate,$minutes);
        }
        return $workhours;
    }
}
