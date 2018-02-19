<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Dashboard;

class DashboardController extends Controller
{
    protected $roleArray = ['2','3'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        // use Dashboard model

        $dashboard = new Dashboard;
        $roleId = \Auth::user()->user_roles_id;        
        
        $orders = $dashboard->orders($roleId);             
        $formulas = $dashboard->formulas($roleId);
        if(in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            $patients = $dashboard->patients($roleId);
            $results = [
                'orders' => $orders,
                'patients' => $patients,
                'formulas' => $formulas
            ]; 
        } else {
            $results = [
                'orders' => $orders,
                'formulas' => $formulas
            ];
        }


        

        return view('dashboard.home.index', $results);      
        
    }    
}
