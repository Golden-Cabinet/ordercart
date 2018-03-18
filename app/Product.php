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

    // user role specific

    public function adminProducts()
    {
        if(\Auth::user()->user_roles_id != 2)
        {
            return redirect()->route('dashboardindex');
        } else {
            return self::all();
        }

    }

    public static function getProductName($id)
    {
        $getProduct = new Product;
        $product = $getProduct::find($id);
        return $product->pinyin;
    }
}
