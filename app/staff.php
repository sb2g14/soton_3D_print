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
   /* public function user()
    {
        return $this->belongsTo(User::class);
    }*/
}
