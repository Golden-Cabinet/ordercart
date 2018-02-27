<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Brand;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->user_roles_id != 2)
        {
            return redirect()->route('dashboardindex');
        }
        
        $products = new Product;
        $getProducts = $products::where('deleted',0)->get();

        $results = [
            'products' => $getProducts
        ];

        return view('dashboard.products.index',$results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->user_roles_id != 2)
        {
            return redirect()->route('dashboardindex');
        }

        $brands = new Brand;
        $getBrands = $brands::all();

        $results = [
            'brands' =>  $getBrands
        ];
        
        return view('dashboard.products.create',$results); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->user_roles_id != 2)
        {
            return redirect()->route('dashboardindex');
        }
        
        $product = new Product;
        $product->pinyin = $request->pinyin;
        $product->latin_name = $request->latin_name;
        $product->common_name = $request->common_name;
        $product->brands_id = $request->brands_id;
        $product->types_id = $request->types_id;
        $product->concentration = $request->concentration;
        $product->costPerGram = $request->costPerGram;
        $product->deleted = 0;
        $product->save();
        
        return redirect()->route('productsindex')->with('status', 'Product Created!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(\Auth::user()->user_roles_id != 2)
        {
            return redirect()->route('dashboardindex');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(\Auth::user()->user_roles_id != 2)
        {
            return redirect()->route('dashboardindex');
        }
        
        $product = new Product;
        $getProduct = $product::find($id);

        $brands = new Brand;
        $getBrands = $brands::all();

        $result = [
            'result' => $getProduct,
            'brands' => $getBrands,
        ];
        
        return view('dashboard.products.edit', $result); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(\Auth::user()->user_roles_id != 2)
        {
            return redirect()->route('dashboardindex');
        }
        
        $getProduct = new Product;
        $product = $getProduct::find($request->prid);
        $product->pinyin = $request->pinyin;
        $product->latin_name = $request->latin_name;
        $product->common_name = $request->common_name;
        $product->brands_id = $request->brands_id;
        $product->types_id = $request->types_id;
        $product->concentration = $request->concentration;
        $product->costPerGram = $request->costPerGram;
        $product->deleted = 0;
        $product->save();

        return redirect()->route('productsindex')->with('status', 'Product Was Updated!');; 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\Auth::user()->user_roles_id != 2)
        {
            return redirect()->route('dashboardindex');
        }
        
        $product = new Product;
        $getProduct = $product::find($id);
        $getProduct->delete();
        return redirect()->route('productsindex')->with('status', 'Product Was Deleted!');; 
    }
}
