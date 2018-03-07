<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserRole;
use App\AddressState;
use App\Address;

class UsersController extends Controller
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
        $users = new User;
        $getUsers = $users->adminUsers();

        $results = [
            'users' => $getUsers
        ];

        return view('dashboard.users.index',$results);
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

        $getStates = new AddressState;
        $states = $getStates::where('name','!=',null)->orderBy('name', 'asc')->get();

        $getUserRoles = new UserRole;
        $roles = $getUserRoles::where('name','!=','Patient')->orderBy('name', 'asc')->get();

        $results = [
            'roles' => $roles,
            'states' => $states
        ];
        
        return view('dashboard.users.create',$results); 
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

        $user = new User;
        $billingAddress = new Address;
        $shippingAddress = new Address;

        // check that updated password first
        if($request->updated_password != $request->updated_password_confirmation)
        {
            return back()->withInput()->with('error', 'Passwords Do Not Match'); 
        }
                
        $user->name = $request->first_name.' '.$request->last_name;
        $user->email = $request->email;
        $user->phonePre = $request->area_code;
        $user->phonePost = $request->phone;
        $user->license_state = $request->license_state;
        $user->user_roles_id = $request->user_role;
        $user->is_approved = $request->user_status;
        $user->password = bcrypt($request->updated_password);
        $user->save();

        $billingAddress->users_id = $user->id;
        $billingAddress->street = $request->billing_street;
        $billingAddress->city = $request->billing_city;
        $billingAddress->address_states_id = $request->billing_state;
        $billingAddress->zip = $request->billing_zip;
        $billingAddress->address_types_id = 1;
        $billingAddress->save();
        
        if($request->inlineRadioOptions == "No")
        {            
            $shippingAddress->users_id = $user->id;
            $shippingAddress->street = $request->shipping_address;
            $shippingAddress->city = $request->shipping_city;
            $shippingAddress->address_states_id = $request->shipping_state;
            $shippingAddress->zip = $request->shipping_zip;
            $shippingAddress->address_types_id = 2;
        } else {
            $shippingAddress->users_id = $user->id;
            $shippingAddress->street = $request->billing_street;
            $shippingAddress->city = $request->billing_city;
            $shippingAddress->address_states_id = $request->billing_state;
            $shippingAddress->zip = $request->billing_zip;
            $shippingAddress->address_types_id = 2;
        }
        $shippingAddress->save();
        

        
        if($request->passwordUpdateNotify == "Yes") {
            // function to send email out about the update
        }
        
        return redirect()->route('usersindex')->with('success', $request->first_name.' '.$request->last_name.' Has Been Created!'); 
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
        
        $user = new User;
        $getUser = $user::find($id);

        $result = [
            'result' => $getUser,
        ];
        return view('dashboard.users.show', $result); 
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

        $getUser = new User;
        $user = $getUser::find($id);

        $getBillingAddress = new Address;
        $billingAddress = $getBillingAddress::where('users_id',$id)
        ->where('address_types_id',1)
        ->first();

        $getShippingAddress = new Address;
        $shippingAddress = $getShippingAddress::where('users_id',$id)
        ->where('address_types_id',2)
        ->first();

        $getStates = new AddressState;
        $states = $getStates::where('name','!=',null)->orderBy('name', 'asc')->get();

        $getUserRoles = new UserRole;
        $roles = $getUserRoles::where('name','!=','Patient')->orderBy('name', 'asc')->get();

        $split_name = explode(' ', $user->name);
        $result = [
            'first_name' => $split_name[0],
            'last_name' => $split_name[1],
            'result' => $user,
            'shipping' => $shippingAddress,
            'billing' => $billingAddress,
            'roles' => $roles,
            'states' => $states
        ];
        return view('dashboard.users.edit', $result); 
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
        if(\Auth::user()->user_roles_id != 2)
        {
            return redirect()->route('dashboardindex');
        }

        $getUser = new User;
        $user = $getUser::find($id);

        $getBillingAddress = new Address;
        $billingAddress = $getBillingAddress::find($request->bid);
        $getShippingAddress = new Address;
        $shippingAddress = $getShippingAddress::find($request->sid);

        // check that updated password first
        if($request->updated_password != $request->updated_password_confirmation)
        {
            return back()->withInput()->with('error', 'Passwords Do Not Match'); 
        }        
                
        $user->name = $request->first_name.' '.$request->last_name;
        $user->email = $request->email;
        $user->phonePre = $request->area_code;
        $user->phonePost = $request->phone;
        $user->license_state = $request->license_state;
        $user->user_roles_id = $request->user_role;
        $user->is_approved = $request->user_status;
        if($request->updated_password != ''){
            $user->password = bcrypt($request->updated_password);
        }
        $user->save();

        $billingAddress->users_id = $user->id;
        $billingAddress->street = $request->billing_street;
        $billingAddress->city = $request->billing_city;
        $billingAddress->address_states_id = $request->billing_state;
        $billingAddress->zip = $request->billing_zip;
        $billingAddress->address_types_id = 1;
        
        if($request->inlineRadioOptions == "No")
        {            
            $shippingAddress->users_id = $user->id;
            $shippingAddress->street = $request->shipping_address;
            $shippingAddress->city = $request->shipping_city;
            $shippingAddress->address_states_id = $request->shipping_state;
            $shippingAddress->zip = $request->shipping_zip;
            $shippingAddress->address_types_id = 2;
        } else {
            $shippingAddress->users_id = $user->id;
            $shippingAddress->street = $request->billing_street;
            $shippingAddress->city = $request->billing_city;
            $shippingAddress->address_states_id = $request->billing_state;
            $shippingAddress->zip = $request->billing_zip;
            $shippingAddress->address_types_id = 2;
        }
        $shippingAddress->save();
        
        if($request->passwordUpdateNotify == "Yes") {
            // function to send email out about the update
        }

        return redirect()->route('usersindex')->with('success', $request->first_name.' '.$request->last_name.' Was Updated!');; 
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
        


        return redirect()->route('usersindex')->with('warning', 'User Was Deleted!'); 
    }

}
