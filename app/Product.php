<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['pinyin','latin_name','common_name','brand_id','concentration','costPerGram','deleted'];

    public function brand()
    {
        return $this->belongsToMany('App\Brand');
    }
}
