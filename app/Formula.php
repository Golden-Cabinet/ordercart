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

    // user role specific

    public function adminFormulas()
    {
        $getFormulas = self::all();
        return $getFormulas;
    }

    public function practitionerFormulas()
    {
        $getFormulas = self::where('users_id',\Auth::user()->id);
        return $getFormulas;
    }
    
    public function studentFormulas()
    {        
        $getFormulas = self::where('users_id',\Auth::user()->id);
        return $getFormulas;
    }
}
