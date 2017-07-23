<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class printing_data extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function printer()
    {
        return $this->belongsTo(Printers::class);
    }
}
