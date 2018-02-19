<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','parent_id','deleted'];

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    // user role specific

    public function adminCategory()
    {
        if(\Auth::user()->user_roles_id != 2)
        {
            return redirect()->route('dashboardindex');
        } else {
            return self::all();
        }

    }
}
