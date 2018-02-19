<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
use App\Formula;
use App\Patient;

class Dashboard extends Model
{
    protected $orders;
    protected $formulas;
    protected $patients;

    public function orders($roleId)
    {
        $orders = new Order;
        
        switch($roleId)
        {
            case 2:
            $this->orders = $orders->adminOrders();
            break;

            case 3:
            $this->orders = $orders->practitionerOrders();
            break;

            case 4:
            $this->orders = $orders->studentOrders();
            break;
        }
        return $this->orders;
    }

    public function formulas($roleId)
    {
        
        $formulas = new Formula;
        
        switch($roleId)
        {
            case 2:
            $this->formulas = $formulas->adminFormulas();
            break;

            case 3:
            $this->formulas = $formulas->practitionerFormulas();
            break;

            case 4:           
            $this->formulas = $formulas->studentFormulas();
            break;
        }
        return $this->formulas;
    }

    public function patients($roleId)
    {
        
        $patients = new Patient;
        
        switch($roleId)
        {
            case 2:
            $this->patients = $patients->adminPatients();
            break;

            case 3:
            $this->patients = $patients->practitionerPatients();
            break;

            default:
            die();
        }
        return $this->patients;
    } 
}
