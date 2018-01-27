<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormulaIngredient extends Model
{
    protected $fillable = ['products_id','formulas_id','weight','deleted'];

    public function product()
    {
        return $this->belongsToMany('App\Product');
    }

    public function formula()
    {
        return $this->belongsToMany('App\Formula');
    }
}
