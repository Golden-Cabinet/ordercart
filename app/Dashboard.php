<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
use App\Formula;
use App\Patient;

class Dashboard extends Model
{
    public function orders()
    {
        $orders = new Order;
        $getOrders = $orders::all();
        return $getOrders;
    }

    public function formulas()
    {
        $formulas = new Formula;
        $getFormulas = $formulas::all();
        return $getFormulas;
    }

    public function patients()
    {
        $patients = new Patient;
        $getPatients = $patients::all();
        return $getPatients;
    } 
}
