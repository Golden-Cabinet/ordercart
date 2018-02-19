<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name','deleted'];

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    // user role specific

    public function adminBrands()
    {
        if(\Auth::user()->user_roles_id != 2)
        {
            return redirect()->route('dashboardindex');
        } else {
            return self::all();
        }

    }
}
