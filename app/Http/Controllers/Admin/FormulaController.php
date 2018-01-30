<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Formula;

class FormulaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formulas = new Formula;
        $getFormulas = $formulas::all();

        $results = [
            'results' => $getFormulas
        ];

        return view('dashboard.formulas.index',$results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.formulas.create'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formulas = new Formula;        
        
        return redirect()->route('formulasindex')->with('status', 'Formula Created!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Duplicate the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate($id)
    {
        $formula = new Formula;
        $getFormula = $formula::find($id);

        $result = [
            'result' => $getFormula,
        ];
        
        return view('dashboard.formulas.duplicate', $result); 
    }

    /**
     * Share the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function share($id)
    {
        $formula = new Formula;
        $getFormula = $formula::find($id);

        $result = [
            'result' => $getFormula,
        ];
        
        return view('dashboard.formulas.duplicate', $result); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $formula = new Formula;
        $getFormula = $formula::find($id);

        $result = [
            'result' => $getFormula,
        ];
        
        return view('dashboard.formulas.edit', $result); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $formula = new Formula;
        $getFormula = $formula::find($id);

        return redirect()->route('formulasindex')->with('status', 'Formula Was Updated!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $formula = new Formula;
        $getFormula = $formula::find($id);
        $getFormula->delete();
        return redirect()->route('formulasindex')->with('status', 'Formula Was Deleted!');; 
    }
}
