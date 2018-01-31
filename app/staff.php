<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;

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
}
