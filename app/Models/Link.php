<?php

namespace App\Models;


class Link extends Model
{
    //
    protected $fillable = ['title', 'link'];

    public $cacheKey = 'fanbbs_link';
    public $cacheExpire = 600;

    public function getAllCache()
    {
        return \Cache::remember($this->cacheKey, $this->cacheExpire, function () {
            return $this->all();
        });
    }
}
