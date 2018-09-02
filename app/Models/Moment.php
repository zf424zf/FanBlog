<?php

namespace App\Models;


class Moment extends Model
{
    protected $fillable = ['content'];
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
