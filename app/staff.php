<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;
use DB;

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
    public function experience()
    {
        return $this->sessions->count();
    }
    public function isExperienced()
    {
        //TODO: get experience for each staff with role demonstrator only
        //$experiences = staff::join('sessions_staff','sessions_staff.staff_id','staff.id')->groupBy('staff.id')->select(DB::raw('COUNT(sessions_staff.sessions_id) as total'))->get(); 
        $demonstrators = staff::where('role', 'Demonstrator')->get();
        // Average the experiences
        $cnt = 0;
        $avexp = 0;
        //foreach($experiences as $xp){
        //    $avexp += $xp->total;
        //    $cnt++;
        //}
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
        return $t->start_date; //->toDateString();
    }
}
