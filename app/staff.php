<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;
use DB;
use Carbon\Carbon;
use Carbon\CarbonInterval;

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
    
    /** returns the experience of this staff as a number**/
    public function experience()
    {
        return $this->sessions->count();
    }
    /** returns a boolean if this staff is experienced or not
     *  currently any staff with more than average experience is considered to be experienced
     **/
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

    private function _formatWorkinghours($lastdate,$minutes){
        $nicedate = new Carbon($lastdate);
        $nicedate = $nicedate->format('j M');
        $hours = (int)($minutes/60);
        $minutes = ($minutes - 60*(int)($minutes/60));
        $time = sprintf("%dh %02dm",$hours,$minutes);
        //$time = CarbonInterval::minutes($minutes)->format('h:i');
        $ans = $nicedate.': '.$time;
        return $ans;
    }
    
    public function workinghours($endmonth)
    {   
        // Get start and end of last month
        $t2 = $endmonth;
        $t2 = $t2->day(1)->hour(0)->minute(0)->second(0)->subDay(); // Sat, 31/03/2018
        $t1 = $t2->copy()->subMonth();                              // Wed, 28/02/2018
        // Note that university counts in full weeks, so need to go from Monday to Sunday
        $t1 = $t1->subDays($t1->dayOfWeek-1);                       // Mon, 26/02/2018
        $t2 = $t2->subDays($t2->dayOfWeek)->addWeek();              // Sun, 01/04/2018
        // Get relevant sessions
        $sessions = $this->sessions()->where('start_date', '>=', $t1)->where('start_date', '<=', $t2)
            ->orderBy('start_date')->get();
        // Merge sessions by date
        if(count($sessions) <= 0){return [];}
        $lastdate = $sessions[0]->date();
        $workhours = [];
        $minutes = 0;
        foreach($sessions as $s){
            if($lastdate != $s->date()){
                $workhours[] = $this->_formatWorkinghours($lastdate,$minutes);
                $lastdate = $s->date();
                $minutes = 0;
            }
            $minutes += $s->minutes();
        }
        if($lastdate != ""){
            $workhours[] = $this->_formatWorkinghours($lastdate,$minutes);
        }
        return $workhours;
    }
}
