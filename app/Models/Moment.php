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

    public function like()
    {
        return $this->hasMany(Like::class, 'sid', 'id')->where('type', 2)->where('user_id', \Auth::id());
    }

//    public function scopeNew()
//    {
//        return $this->orderBy('id','desc')->take(10);
//    }
}
