<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//TODO: DO WE STILL USE THIS???
class printing_data extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function staff()
    {
        return $this->belongsTo(staff::class);
    }
    public function printer()
    {
        return $this->belongsTo(Printers::class);
    }
}
