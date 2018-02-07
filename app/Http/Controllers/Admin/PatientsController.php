<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Patient;

class PatientsController extends Controller
{
    public function index()
    {
        $patients = new Patient;
        $getPatients = $patients::all();

        $results = [
            'patients' => $getPatients
        ];

        return view('dashboard.patients.index',$results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.patients.create'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $patients = new Patient;        
        
        return redirect()->route('patientsindex')->with('status', 'Patient Created!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patient = new Patient;
        $getPatient = $patient::find($id);

        $result = [
            'result' => $getPatient,
        ];
        
        return view('dashboard.patients.edit', $result); 
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
        $patient = new Patient;
        $getPatient = $patient::find($id);

        return redirect()->route('patientsindex')->with('status', 'Patient Was Updated!');; 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = new Patient;
        $getPatient = $patient::find($id);
        $getPatient->delete();

        return redirect()->route('patientsindex')->with('status', 'Patient Was Deleted!');; 
    }
}
