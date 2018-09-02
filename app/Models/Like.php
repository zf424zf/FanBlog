<?php

namespace App\Models;


class Like extends Model
{
    //
    protected $table = 'like';

    public function typem(){
        if($this->type == 1){
            return $this->belongsTo(Topic::class,'sid','id');
        }else{
            return $this->belongsTo(Moment::class,'sid','id');
        }
    }
}
