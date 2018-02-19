<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    protected $roleArray = ['2','3','4'];
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            return redirect()->route('dashboardindex');
        }
        
        $orders = new Order;
        if(\Auth::user()->user_roles_id == 2)
        {
            $getOrders = $orders->adminOrders();
        }

        if(\Auth::user()->user_roles_id == 3)
        {
            $getOrders = $orders->practitionerOrders();
        }

        if(\Auth::user()->user_roles_id == 4)
        {
            $getOrders = $orders->studentOrders();
        }

        $results = [
            'orders' => $getOrders
        ];

        return view('dashboard.orders.index',$results);
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
        
        return view('dashboard.orders.create'); 
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
        
        $orders = new Order;        
        
        return redirect()->route('ordersindex')->with('status', 'Order Created!'); 
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
        
        $order = new Order;
        $getOrder = $order::find($id);

        $result = [
            'result' => $getOrder,
        ];
        
        return view('dashboard.orders.edit', $result); 
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
        
        $order = new Order;
        $getOrder = $order::find($id);

        return redirect()->route('ordersindex')->with('status', 'Order Was Updated!'); 
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
        return redirect()->route('ordersindex'); 
    }

}
