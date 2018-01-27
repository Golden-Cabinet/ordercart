<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    protected $fillable = ['name','users_id','deleted'];

    public function ingredients()
    {
        return $this->hasMany('App\FormulaIngredient');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
