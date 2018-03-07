<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Patient;
use App\PatientAddress;
use App\AddressState;
use App\UserRole;

class PatientsController extends Controller
{
    protected $roleArray = ['2','3'];
    
    public function index()
    {
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            return redirect()->route('dashboardindex');
        }
        
        $patients = new Patient;
        if(\Auth::user()->user_roles_id == 2)
        {
            $getPatients = $patients->adminPatients();
        }

        if(\Auth::user()->user_roles_id == 3)
        {
            $getPatients = $patients->practitionerPatients();
        }

        
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
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            return redirect()->route('dashboardindex');
        }

        $getStates = new AddressState;
        $states = $getStates::where('name','!=',null)->orderBy('name', 'asc')->get();

        $results = [
            'states' => $states
        ];
        
        return view('dashboard.patients.create',$results); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            return redirect()->route('dashboardindex');
        }
        
        $patient = new Patient;
        $billingAddress = new PatientAddress;
        $shippingAddress = new PatientAddress;
        
        $patient->users_id = \Auth::user()->id;
        $patient->name = $request->first_name.' '.$request->last_name;
        $patient->email = $request->email;
        $patient->area_code = $request->area_code;
        $patient->phone = $request->phone;
        $patient->status = '1';
        $patient->deleted = 0;
        $patient->save();

        $billingAddress->patients_id = $patient->id;
        $billingAddress->street = $request->billing_street;
        $billingAddress->city = $request->billing_city;
        $billingAddress->address_states_id = $request->billing_state;
        $billingAddress->zip = $request->billing_zip;
        $billingAddress->addressType = 1;
        $billingAddress->save();
        
        if($request->inlineRadioOptions == "No")
        {            
            $shippingAddress->patients_id = $patient->id;
            $shippingAddress->street = $request->shipping_address;
            $shippingAddress->city = $request->shipping_city;
            $shippingAddress->address_states_id = $request->shipping_state;
            $shippingAddress->zip = $request->shipping_zip;
            $shippingAddress->addressType = 2;
        } else {
            $shippingAddress->patients_id = $patient->id;
            $shippingAddress->street = $request->billing_street;
            $shippingAddress->city = $request->billing_city;
            $shippingAddress->address_states_id = $request->billing_state;
            $shippingAddress->zip = $request->billing_zip;
            $shippingAddress->addressType = 2;
        }
        $shippingAddress->save();
        
        return redirect()->route('patientsindex')->with('success', $request->first_name.' '.$request->last_name.' Created!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
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
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            return redirect()->route('dashboardindex');
        }
        
        $patient = new Patient;
        $getPatient = $patient::find($id);
        $names = explode(' ',$getPatient->name);

        $getStates = new AddressState;
        $states = $getStates::where('name','!=',null)->orderBy('name', 'asc')->get();

        $billingAddress = new PatientAddress;
        $billing = $billingAddress::where('patients_id',$id)
        ->where('addressType',1)
        ->first();

        $shippingAddress = new PatientAddress;
        $shipping = $shippingAddress::where('patients_id',$id)
        ->where('addressType',2)
        ->first();
        
        $result = [
            'first_name' => $names[0],
            'last_name' => $names[1],
            'result' => $getPatient,
            'billing' => $billing,
            'shipping' => $shipping,
            'states' => $states
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
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            return redirect()->route('dashboardindex');
        }
        
        $getPatient = new Patient;
        $patient = $getPatient::find($id);

        
        $billing = new PatientAddress;
        $billingAddress = $billing::find($request->bid);

        $shipping = new PatientAddress;
        $shippingAddress = $shipping::find($request->sid);
         
        $patient->users_id = \Auth::user()->id;
        $patient->name = $request->first_name.' '.$request->last_name;
        $patient->email = $request->email;
        $patient->area_code = $request->area_code;
        $patient->phone = $request->phone;
        $patient->status = '1';
        $patient->deleted = 0;
        $patient->save();

        $billingAddress->patients_id = $patient->id;
        $billingAddress->street = $request->billing_street;
        $billingAddress->city = $request->billing_city;
        $billingAddress->address_states_id = $request->billing_state;
        $billingAddress->zip = $request->billing_zip;
        $billingAddress->addressType = 1;
        $billingAddress->save();
        
        if($request->inlineRadioOptions == "No")
        {            
            $shippingAddress->patients_id = $patient->id;
            $shippingAddress->street = $request->shipping_address;
            $shippingAddress->city = $request->shipping_city;
            $shippingAddress->address_states_id = $request->shipping_state;
            $shippingAddress->zip = $request->shipping_zip;
            $shippingAddress->addressType = 2;
        } else {
            $shippingAddress->patients_id = $patient->id;
            $shippingAddress->street = $request->billing_street;
            $shippingAddress->city = $request->billing_city;
            $shippingAddress->address_states_id = $request->billing_state;
            $shippingAddress->zip = $request->billing_zip;
            $shippingAddress->addressType = 2;
        }
        $shippingAddress->save();

        return redirect()->route('patientsindex')->with('success', $request->first_name.' '.$request->last_name.' Was Updated!');; 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            return redirect()->route('dashboardindex');
        }
        
        return redirect()->route('patientsindex'); 
    }
}
