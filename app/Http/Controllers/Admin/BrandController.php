<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = new Brand;
        $getBrands = $brands::all();

        $results = [
            'brands' => $getBrands
        ];

        return view('dashboard.brands.index',$results);
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
        
        return view('dashboard.brands.create'); 
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
        
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->save();        
        
        return redirect()->route('brandsindex')->with('status', 'Brand Created!'); 
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
        
        $brand = new Brand;
        $getBrand = $brand::find($id);
        $result = [
            'brand' => $getBrand,
        ];
        
        return view('dashboard.brands.edit', $result); 
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
        
        $brand = new Brand;
        $getBrand = $brand::find($request->bid);
        $getBrand->name = $request->name;
        $getBrand->save();  

        return redirect()->route('brandsindex')->with('status', $request->name.' Was Updated!');; 
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

        $brand = new Brand;
        $getBrand = $brand::find($id);
        $getBrand->delete();  

        
        return redirect()->route('brandsindex')->with('status', $getBrand->name.'Was Deleted!');; 
    }
}
