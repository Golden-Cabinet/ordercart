<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebGilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param mixed $data
     * @return none
     */
    public function create($data)
    {
        $orderInfo = $this->order_model->getView($orderID);
        $practitioner = $this->user_model->getProfile($orderInfo->user_id);
        $shippingInfo = $this->order_model->getShippingDetailsRaw($orderID);
        $paymentInfo = $this->order_model->getPaymentDetails($orderID);
        $formulaInfo = $this->formula_model->getView($orderInfo->formula_id);
        $patientInfo = $this->patient_model->getPatientProfile($orderInfo->patient_id);
        
        // factor in ratio for individual ingredient cost/qty
        foreach($formulaInfo['ingredients'] as $key => $ingredient) {
          $formulaInfo['ingredients'][$key]->subtotal = round($orderInfo->ratio * $formulaInfo['ingredients'][$key]->subtotal,1 );
          $formulaInfo['ingredients'][$key]->weight  = round($orderInfo->ratio * $formulaInfo['ingredients'][$key]->weight, 1);
        }
        
        // factor in ratio for overall cost
        $formulaInfo['cost'] *= $orderInfo->ratio;
                
        $data = array(
            'title' => 'Order Details',
            'practitioner' => $practitioner,
            'orderDetails' => $this->statusName($orderInfo),
            'formula' => $formulaInfo['formula'],
            'formula_cost' => $formulaInfo['cost'],
            'ingredients' => $formulaInfo['ingredients'],
            'shipping' => $shippingInfo,
            'payment' => $paymentInfo,
            'patientInfo' => $patientInfo,
            'ratio' => $orderInfo->ratio
        );
      

       $orderBuilder = new OrderBuilder();
       $orderBuilder->orderXml($data);

                 // $this->order_model->orderXml($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
