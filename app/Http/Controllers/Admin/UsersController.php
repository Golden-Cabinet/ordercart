<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserRole;

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
        
        return view('dashboard.users.create'); 
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
        
        $users = new User;        
        
        return redirect()->route('usersindex')->with('status', 'User Created!'); 
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

        $user = new User;
        $getUser = $user::find($id);

        $result = [
            'result' => $getUser,
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

        $user = new User;
        $getUser = $user::find($id);

        return redirect()->route('usersindex')->with('status', 'User Was Updated!');; 
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
        return redirect()->route('usersindex')->with('status', 'User Was Deleted!'); 
    }

}
