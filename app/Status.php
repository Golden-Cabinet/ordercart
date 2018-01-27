<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['name'];

    public function order()
    {
        return $this->belongsTo('App\Product');
    }
    
    public function orders()
    {
        return $this->belongsToMany('App\Product');
    }
}
