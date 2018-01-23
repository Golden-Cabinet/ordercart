<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * @package    Order Builder
 * @author     Danny Nunez
 * @copyright  Copyright (c) 2013 Subtext
 */
// ------------------------------------------------------------------------


class OrderBuilder extends REST_Controller
{
    private $consolibyteUrl = "https://secure.consolibyte.com/saas/installs/1529/foxycart/qbus/2496/public/foxycart/foxydata.php";

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('user_model', 'login_attempt_model', 'role_model', 'state_model', 'order_model'));
        $this->load->library(array('form_validation'));
    }

    public function createThubXML($orders_data)
    {
        $state = new state_model();

        $xml = new DOMDocument("1.0", "UTF-8");

        $response = $xml->appendChild($xml->createElement('RESPONSE'));
        $attribute = $xml->createAttribute('Version');
            // Value for the created attribute
            $attribute->value = '2.8';
         // Don't forget to append it to the element
            $response->appendChild($attribute);
            
        $envelope = $response->appendChild($xml->createElement('Envelope'));

        $command = $envelope->appendChild($xml->createElement('Command'));
        $command->appendChild($xml->createCDATASection('GetOrders'));

        if ($orders_data == 0) {
            $status_code_value = 1000;
        } else {
            $status_code_value = 0;
        }
            
        $status_code = $envelope->appendChild($xml->createElement('StatusCode'));
        $status_code->appendChild($xml->createCDATASection($status_code_value));
      
        $provider = $envelope->appendChild($xml->createElement('Provider'));
        $provider->appendChild($xml->createCDATASection('Generic'));

        $updated_on = $envelope->appendChild($xml->createElement('UpdatedOn'));
        $updated_on->appendChild($xml->createCDATASection(date('Y-m-d H:i:s')));

        $orders = $response->appendChild($xml->createElement('Orders'));
        if (is_array($orders_data)) {
            foreach ($orders_data as $order_data) {
                $orderDetails = $order_data['orderDetails'];
                $shipping = $order_data['shipping'];
                $ingredients = $order_data['ingredients'];
                $practitioner = $order_data['practitioner'];
                $patientInfo = $order_data['patientInfo'];
                $created_date = date('m/d/Y', strtotime($orderDetails->created_at));
                $created_time = date('h:i:s', strtotime($orderDetails->created_at));
                    
          // pull data from database for this order because otherwise we don't get billing info (?)
          $order_info = $this->order_model->get($orderDetails->id);
                    
                $order = $orders->appendChild($xml->createElement('Order'));

                $id = $order->appendChild($xml->createElement('OrderID'));
                $id->appendChild($xml->createCDATASection($orderDetails->id));
              
                $customer_reference = $order->appendChild($xml->createElement('CustomerRef'));
                $customer_reference->appendChild($xml->createCDATASection($patientInfo->id));
        
                $provider_id = $order->appendChild($xml->createElement('ProviderOrderRef'));
                $provider_id->appendChild($xml->createCDATASection($orderDetails->id));

                $transaction_type = $order->appendChild($xml->createElement('TransactionType'));
                $transaction_type->appendChild($xml->createCDATASection('Sale'));

                $date = $order->appendChild($xml->createElement('Date'));
                $date->appendChild($xml->createCDATASection($created_date));

                $time = $order->appendChild($xml->createElement('Time'));
                $time->appendChild($xml->createCDATASection($created_time));

                $timezone = $order->appendChild($xml->createElement('TimeZone'));
                $timezone->appendChild($xml->createCDATASection('PST'));
      
                $storeid = $order->appendChild($xml->createElement('StoreID'));
                $storeid->appendChild($xml->createCDATASection($this->config->item('store_id')));
          
                $customer_id = $order->appendChild($xml->createElement('CustomerID'));
                $customer_id->appendChild($xml->createCDATASection($patientInfo->firstName . ' ' . $patientInfo->lastName));

                $sales_rep = $order->appendChild($xml->createElement('SalesRep'));
                $sales_rep->appendChild($xml->createCDATASection($orderDetails->practitionerFirstName.' '.$orderDetails->practitionerLastName));

                $comment = $order->appendChild($xml->createElement('Comment'));
          // $comment->appendChild($xml->createCDATASection($orderDetails->notes));
            $comment->appendChild($xml->createCDATASection($orderDetails->instructions));

                $currency = $order->appendChild($xml->createElement('Currency'));
                $currency->appendChild($xml->createCDATASection('USD'));

                $bill = $order->appendChild($xml->createElement('Bill'));
          
                $po_number = $bill->appendChild($xml->createElement('PONumber'));
                $po_number->appendChild($xml->createCDATASection($orderDetails->practitionerFirstName.' '.$orderDetails->practitionerLastName));
          

                $pay_method = $bill->appendChild($xml->createElement('PayMethod'));
                $pay_method->appendChild($xml->createCDATASection('CreditCard'));

                $pay_status = $bill->appendChild($xml->createElement('PayStatus'));
                $pay_status->appendChild($xml->createCDATASection('Cleared'));
        
          /* Are we billing the Practitioner or the Patient?
          =====================================================*/

          if ($order_info->billing == "chargeUserCard" || $order_info->billing == "callInCard" || $order_info->billing == "pickUpFormula" || $order_info->billing == "mailInPayment") {
              $billing_first_name = $practitioner->firstName;
              $billing_last_name = $practitioner->lastName;
              $billing_address = $practitioner->bstreetAddress;
              $billing_city = $practitioner->bcity;
              $billing_state = $practitioner->bstate_id;
              $billing_zip = $practitioner->bzip;
              $billing_email = $practitioner->email;
              $billing_phone = $practitioner->area_code . '-' . $practitioner->phone;
          } elseif ($order_info->billing == "patientPay") {
              // charge patient
            $billing_first_name = $patientInfo->firstName;
              $billing_last_name = $patientInfo->lastName;
              $billing_address = $patientInfo->bstreetAddress;
              $billing_city = $patientInfo->bcity;
              $billing_state = $patientInfo->bstate_id;
              $billing_zip = $patientInfo->bzip;
              $billing_email = $patientInfo->email;
              $billing_phone = $patientInfo->area_code . '-' . $patientInfo->phone;
          } else {
              // shouldn't happen
            echo "Error with determining billing information. Details below. <hr>";
              print_r($order_info);
              die();
          }
          
          // This info should always be empty on the invoice.
          // We need this line below to duplicate billing name so QB maps things correctly. (Bill name as address line 1. Ick.)
          $billing_address = $billing_first_name . ' ' . $billing_last_name;
                $billing_city = "";
                $billing_state = "";
                $billing_zip = "";
                $billing_phone = "";


          /*****************

          Where are we shipping? Practitioner or Patient? Alternate address?

          *******************/
        
          
          if ($orderDetails->shipOption == 'shipUserMailing') {
              // Ship to practitioner
            // Nothing changes I think?
          } elseif ($orderDetails->shipOption == 'shipUserOther') {
              // Ship to practitioner @ alternate address
            if (is_object($shipping)) {
                $shipping->firstName = $practitioner->firstName;
                $shipping->lastName = $practitioner->lastName;
                $shipping->phone = "";
            }
          } elseif ($orderDetails->shipOption == 'shipPatient') {
              // Ship to patient
            // Nothing changes I think?
          } elseif ($orderDetails->shipOption == 'shipPatientOther') {

            // Ship to patient @ alternate address
            if (is_object($shipping)) {
                $shipping->firstName = $patientInfo->firstName;
                $shipping->lastName = $patientInfo->lastName;
                $shipping->phone = "";
            }
          } elseif ($orderDetails->shipOption == 'NA') {
              // Pickup
            // Ship to patient @ alternate address
            if (is_object($shipping) && $shipping->firstName == 'See Notes Section') {
                $shipping->firstName = $patientInfo->firstName;
                $shipping->lastName = $patientInfo->lastName;
                $shipping->street = "";
                $shipping->phone = "";
                $shipping->city = "";
                $shipping->state_name = "";
                $shipping->zip = "";
            }
            
              if ($shipping == "") {
                  $shipping = (object) array(
                'firstName' => $patientInfo->firstName,
                'lastName' => $patientInfo->lastName,
                'street' => $orderDetails->notes,
                'phone' => '',
                'city' => '',
                'state_name' => '',
                'zip' => ''
              );
              }
          } else {
              // This shouldn't happen, but just in case
            echo "Invalid shipping option (" . $orderDetails->shipOption . ") for this order. Error information below: <hr> <pre>";
              print_r($order_data);
              die();
          }
          
            // customer_first_name

            $customer_first_name = $bill->appendChild($xml->createElement('FirstName'));
                $customer_first_name->appendChild($xml->createCDATASection($billing_first_name));

            // customer_last_name

            $customer_last_name = $bill->appendChild($xml->createElement('LastName'));
                $customer_last_name->appendChild($xml->createCDATASection($billing_last_name));

            // customer_company

            $customer_company = $bill->appendChild($xml->createElement('CompanyName'));
                $customer_company->appendChild($xml->createCDATASection(''));

            // customer_address1

            $customer_address1 = $bill->appendChild($xml->createElement('Address1'));
                $customer_address1->appendChild($xml->createCDATASection($billing_address));

            // customer_address2

            $customer_address1 = $bill->appendChild($xml->createElement('Address2'));
                $customer_address1->appendChild($xml->createCDATASection(''));

            // customer_city

            $customer_city = $bill->appendChild($xml->createElement('City'));
                $customer_city->appendChild($xml->createCDATASection($billing_city));

            // customer_state

            $customer_state = $bill->appendChild($xml->createElement('State'));
                $customer_state->appendChild($xml->createCDATASection($state->getStateName($billing_state)));

            // customer_postal_code

            $customer_postal_code = $bill->appendChild($xml->createElement('Zip'));
                $customer_postal_code->appendChild($xml->createCDATASection($billing_zip));

            // customer_country

            $customer_country = $bill->appendChild($xml->createElement('Country'));
                $customer_country->appendChild($xml->createCDATASection('usa'));

           // customer_email

            $customer_email = $bill->appendChild($xml->createElement('Email'));
                $customer_email->appendChild($xml->createCDATASection($billing_email));
       
                    // customer_phone

            $customer_phone = $bill->appendChild($xml->createElement('Phone'));
                $customer_phone->appendChild($xml->createCDATASection($billing_phone));

                $ship = $order->appendChild($xml->createElement('Ship'));

                $ship_carrier = $ship->appendChild($xml->createElement('ShipCarrierName'));
                $ship_carrier->appendChild($xml->createCDATASection('FedEx'));
                
                $ship_method = $ship->appendChild($xml->createElement('ShipMethod'));
                $ship_method->appendChild($xml->createCDATASection('Ground'));
        
                if (is_object($shipping)) {
                    
               // shipping_first_name

                $shipping_first_name = $ship->appendChild($xml->createElement('FirstName'));
                    $shipping_first_name->appendChild($xml->createCDATASection($shipping->firstName));

                // shipping_last_name

                $shipping_last_name = $ship->appendChild($xml->createElement('LastName'));
                    $shipping_last_name->appendChild($xml->createCDATASection($shipping->lastName));

                // shipping_company

                $shipping_company = $ship->appendChild($xml->createElement('CompanyName'));
                            
            /***

              If special instructions for payment put that in company field (?);

            ***/
            
            if ($order_info->billing == 'pickUpFormula' || $order_info->billing == 'callInCard') {
                // $shipping_company->appendChild($xml->createCDATASection($orderDetails->notes));
              $shipping_company->appendChild($xml->createCDATASection(''));
            } else {
                $shipping_company->appendChild($xml->createCDATASection(''));
            }

                // shipping_address1

                $shipping_address1 = $ship->appendChild($xml->createElement('Address1'));
                    if ($orderDetails->shipOption == 'shipPatient') {
                        $shipping_address1->appendChild($xml->createCDATASection($patientInfo->shstreetAddress));
                    } elseif ($orderDetails->shipOption == 'shipUserMailing') {
                        $shipping_address1->appendChild($xml->createCDATASection($practitioner->shstreetAddress));
                    } else {
                        // Use alterante shipping address associated with the order.
              $shipping_address1->appendChild($xml->createCDATASection($shipping->street));
                    }
                

                // shipping_address2

                $shipping_address2 = $ship->appendChild($xml->createElement('Address2'));
                    $shipping_address2->appendChild($xml->createCDATASection(''));

                // shipping_city

                $shipping_city = $ship->appendChild($xml->createElement('City'));
                    if ($orderDetails->shipOption == 'shipPatient') {
                        $shipping_city->appendChild($xml->createCDATASection($patientInfo->shcity));
                    } elseif ($orderDetails->shipOption == 'shipUserMailing') {
                        $shipping_city->appendChild($xml->createCDATASection($practitioner->shcity));
                    } else {
                        $shipping_city->appendChild($xml->createCDATASection($shipping->city));
                    }

                // shipping_state

                $shipping_state = $ship->appendChild($xml->createElement('State'));
                    if ($orderDetails->shipOption == 'shipPatient') {
                        $shipping_state->appendChild($xml->createCDATASection($state->getStateName($patientInfo->shstate_id)));
                    } elseif ($orderDetails->shipOption == 'shipUserMailing') {
                        $shipping_state->appendChild($xml->createCDATASection($state->getStateName($practitioner->shstate_id)));
                    } else {
                        $shipping_state->appendChild($xml->createCDATASection($shipping->state_name));
                    }


                // shipping_postal_code

                $shipping_postal_code = $ship->appendChild($xml->createElement('Zip'));
                    if ($orderDetails->shipOption == 'shipPatient') {
                        $shipping_postal_code->appendChild($xml->createCDATASection($patientInfo->shzip));
                    } elseif ($orderDetails->shipOption == 'shipUserMailing') {
                        $shipping_postal_code->appendChild($xml->createCDATASection($practitioner->shzip));
                    } else {
                        $shipping_postal_code->appendChild($xml->createCDATASection($shipping->zip));
                    }

                // shipping_country

                $shipping_country = $ship->appendChild($xml->createElement('Country'));
                    $shipping_country->appendChild($xml->createCDATASection('usa'));

                // shipping_email

                $shipping_email = $ship->appendChild($xml->createElement('Email'));
                    $shipping_email->appendChild($xml->createCDATASection('EMAIL'));

                // shipping_phone

                $shipping_phone = $ship->appendChild($xml->createElement('Phone'));
                    $shipping_phone->appendChild($xml->createCDATASection($shipping->phone));
                } else {
                    // shipping_first_name

                $shipping_first_name = $ship->appendChild($xml->createElement('FirstName'));
                    $shipping_first_name->appendChild($xml->createCDATASection(''));

                // shipping_last_name

                $shipping_last_name = $ship->appendChild($xml->createElement('LastName'));
                    $shipping_last_name->appendChild($xml->createCDATASection(''));

                // shipping_company

                $shipping_company = $ship->appendChild($xml->createElement('CompanyName'));
                    $shipping_company->appendChild($xml->createCDATASection(''));

                // shipping_address1

                $shipping_address1 = $ship->appendChild($xml->createElement('Address1'));
                    $shipping_address1->appendChild($xml->createCDATASection(''));

                // shipping_address2

                $shipping_address2 = $ship->appendChild($xml->createElement('Address2'));
                    $shipping_address2->appendChild($xml->createCDATASection(''));

                // shipping_city

                $shipping_city = $ship->appendChild($xml->createElement('City'));
                    $shipping_city->appendChild($xml->createCDATASection(''));

                // shipping_state

                $shipping_state = $ship->appendChild($xml->createElement('State'));
                    $shipping_state->appendChild($xml->createCDATASection(''));

                // shipping_postal_code

                $shipping_postal_code = $ship->appendChild($xml->createElement('Zip'));
                    $shipping_postal_code->appendChild($xml->createCDATASection(''));

                // shipping_country

                $shipping_country = $ship->appendChild($xml->createElement('Country'));
                    $shipping_country->appendChild($xml->createCDATASection(''));

                // shipping_email

                $shipping_email = $ship->appendChild($xml->createElement('Email'));
                    $shipping_email->appendChild($xml->createCDATASection(''));

                // shipping_phone

                $shipping_phone = $ship->appendChild($xml->createElement('Phone'));
                    $shipping_phone->appendChild($xml->createCDATASection(''));
                }
                        
                $items = $order->appendChild($xml->createElement('Items'));
        
                $formula_cost= 0;

                foreach ($ingredients as $value) {

                // transaction_detail

                $item = $items->appendChild($xml->createElement('Item'));

                // product_code

                $item_code = $item->appendChild($xml->createElement('ItemCode'));
                    $item_code->appendChild($xml->createCDATASection($value->pinyin));

                // product_name

                $item_description = $item->appendChild($xml->createElement('ItemDescription'));
                    $item_description->appendChild($xml->createCDATASection($value->pinyin));

                // product_quantity

                $quantity = $item->appendChild($xml->createElement('Quantity'));
                    // $quantity->appendChild($xml->createCDATASection(round($value->weight * $order_data['ratio'],1)));
                    $quantity->appendChild($xml->createCDATASection(round($value->weight * $order_data['ratio'],1) / 100 ));
                    
                // product_price

                $unit_price = $item->appendChild($xml->createElement('UnitPrice'));
                    $unit_price->appendChild($xml->createCDATASection($value->costPerGram * 100));

                    $cost_float = (float) $value->costPerGram;
                    $weight_float = (float) $value->weight;
                    $item_total_value = number_format(($cost_float * $weight_float * $order_data['ratio']), 2);

                // item_total

                $item_total = $item->appendChild($xml->createElement('ItemTotal'));
                    $item_total->appendChild($xml->createCDATASection($item_total_value));

                    $formula_cost = $formula_cost + (float) $item_total_value;

                // product_weight

                $item_unit_weight = $item->appendChild($xml->createElement('ItemUnitWeight'));
                    $item_unit_weight->appendChild($xml->createCDATASection(round($value->weight * $order_data['ratio'],1)));
                }

                $charges = $order->appendChild($xml->createElement('Charges'));
                
                    // shipping_total

            $shipping = $charges->appendChild($xml->createElement('Shipping'));
                $shipping->appendChild($xml->createCDATASection($orderDetails->shipping_cost));

            // tax_total

            $tax = $charges->appendChild($xml->createElement('Tax'));
                $tax->appendChild($xml->createCDATASection(''));
    
                $sub_total = sprintf('%s', $orderDetails->sub_total);

    
                $discount = $charges->appendChild($xml->createElement('Discount'));
                
                if ($orderDetails->sub_total < $formula_cost) {
                    $discount_amount = $sub_total - $formula_cost;
                    $discount_amount =  number_format($orderDetails->cost, 2);
                    $discount->appendChild($xml->createCDATASection((float)$discount_amount));
                } else {                    
                    $discount->appendChild($xml->createCDATASection(""));
                }
        
                // purchase_total
                                        

            $total = $charges->appendChild($xml->createElement('Total'));
                $total->appendChild($xml->createCDATASection($orderDetails->total_cost));

            // formula_name

            $custom_field_1 = $order->appendChild($xml->createElement('CustomField1'));
                $custom_field_1->appendChild($xml->createCDATASection($orderDetails->formulaName));

            // refills
          if ($orderDetails->refills == 'unlimited') {
              $orderDetails->refills = 'Yes';
          }

                $custom_field_2 = $order->appendChild($xml->createElement('CustomField2'));
                $custom_field_2->appendChild($xml->createCDATASection($orderDetails->refills));

                    // times per day

            $custom_field_3 = $order->appendChild($xml->createElement('CustomField3'));
                if ($orderDetails->timesPerDay == 'Other – add details in “Special Instructions” below') {
                    $orderDetails->timesPerDay = 'See bottle instructions';
                }
                $custom_field_3->appendChild($xml->createCDATASection($orderDetails->timesPerDay));

                    // number of scoops
                
                    $custom_field_4 = $order->appendChild($xml->createElement('CustomField4'));
          
                if ($orderDetails->numberOfScoops == 'Other – add dosage in “Special Instructions” below') {
                    $orderDetails->numberOfScoops = 'See bottle instructions';
                }
                $custom_field_4->appendChild($xml->createCDATASection($orderDetails->numberOfScoops));
        
                    // instructions

            $custom_field_5 = $order->appendChild($xml->createElement('CustomField5'));
                $custom_field_5->appendChild($xml->createCDATASection($practitioner->firstName . ' ' . $practitioner->lastName));
            }
        }
            
        $xml->formatOutput = true;
        $filename = APP_PATH . '/orders/order.createTHUBXml.' . $orderDetails->id . '.' . time() . '.xml';
        $xml->save($filename);

        return $filename;
    }

    public function orderXml($order)
    {
        $orderDetails = $order['orderDetails'];
        $shipping = $order['shipping'];
        $ingredients = $order['ingredients'];
        $practitioner = $order['practitioner'];
        $patientInfo = $order['patientInfo'];

        $state = new state_model();

        $xml = new DOMDocument("1.0", "UTF-8");

        $foxydata = $xml->appendChild($xml->createElement('foxydata'));

        $transactions = $foxydata->appendChild($xml->createElement('transactions'));

        $transaction = $transactions->appendChild($xml->createElement('transaction'));


        // practitioner name;

        $practitioner_name = $transaction->appendChild($xml->createElement('PONumber'));
        $practitioner_name->appendChild($xml->createCDATASection($orderDetails->formulaName . '-' .$orderDetails->instructions));
        
        //orderid

        $id = $transaction->appendChild($xml->createElement('id'));
        $id->appendChild($xml->createCDATASection($orderDetails->id));

        //storeid

        $storeid = $transaction->appendChild($xml->createElement('store_id'));
        $storeid->appendChild($xml->createCDATASection($this->config->item('store_id')));

        //store_version

        $store_version = $transaction->appendChild($xml->createElement('store_version'));
        $store_version->appendChild($xml->createCDATASection($this->config->item('store_version')));

        // transaction_date

        $transaction_date = $transaction->appendChild($xml->createElement('transaction_date'));
        $transaction_date->appendChild($xml->createCDATASection($orderDetails->created_at));

        // customer_id

        $customer_id = $transaction->appendChild($xml->createElement('customer_id'));
        $customer_id->appendChild($xml->createCDATASection($patientInfo->id));

        // customer_first_name

        $customer_first_name = $transaction->appendChild($xml->createElement('customer_first_name'));
        $customer_first_name->appendChild($xml->createCDATASection($patientInfo->firstName));

        // customer_last_name

        $customer_last_name = $transaction->appendChild($xml->createElement('customer_last_name'));
        $customer_last_name->appendChild($xml->createCDATASection($patientInfo->lastName));

        // customer_company

        $customer_company = $transaction->appendChild($xml->createElement('customer_company'));
        $customer_company->appendChild($xml->createCDATASection($patientInfo->firstName . ' ' . $patientInfo->lastName));

        // customer_address1

        $customer_address1 = $transaction->appendChild($xml->createElement('customer_address1'));
        $customer_address1->appendChild($xml->createCDATASection($patientInfo->bstreetAddress));

        // customer_address2

        $customer_address1 = $transaction->appendChild($xml->createElement('customer_address2'));
        $customer_address1->appendChild($xml->createCDATASection(''));

        // customer_city

        $customer_city = $transaction->appendChild($xml->createElement('customer_city'));
        $customer_city->appendChild($xml->createCDATASection($patientInfo->bcity));

        // customer_state

        $customer_state = $transaction->appendChild($xml->createElement('customer_state'));
        $customer_state->appendChild($xml->createCDATASection($state->getStateName($patientInfo->bstate_id)));

        // customer_postal_code

        $customer_postal_code = $transaction->appendChild($xml->createElement('customer_postal_code'));
        $customer_postal_code->appendChild($xml->createCDATASection($patientInfo->bzip));

        // customer_country

        $customer_country = $transaction->appendChild($xml->createElement('customer_country'));
        $customer_country->appendChild($xml->createCDATASection('usa'));

        // customer_phone

        $customer_phone = $transaction->appendChild($xml->createElement('customer_phone'));
        $customer_phone->appendChild($xml->createCDATASection($patientInfo->area_code . '-' . $patientInfo->phone));

        // customer_email

        $customer_email = $transaction->appendChild($xml->createElement('customer_email'));
        $customer_email->appendChild($xml->createCDATASection($patientInfo->email));

        // customer_ip

        $customer_ip = $transaction->appendChild($xml->createElement('customer_ip'));
        $customer_ip->appendChild($xml->createCDATASection($_SERVER['REMOTE_ADDR']));

        if (is_object($shipping)) {
                    
           // shipping_first_name

            $shipping_first_name = $transaction->appendChild($xml->createElement('shipping_first_name'));
            $shipping_first_name->appendChild($xml->createCDATASection($shipping->firstName));

            // shipping_last_name

            $shipping_last_name = $transaction->appendChild($xml->createElement('shipping_last_name'));
            $shipping_last_name->appendChild($xml->createCDATASection($shipping->lastName));

            // shipping_company

            $shipping_company = $transaction->appendChild($xml->createElement('shipping_company'));
            $shipping_company->appendChild($xml->createCDATASection(''));

            // shipping_address1

            $shipping_address1 = $transaction->appendChild($xml->createElement('shipping_address1'));
            $shipping_address1->appendChild($xml->createCDATASection($shipping->street));

            // shipping_address2

            $shipping_address2 = $transaction->appendChild($xml->createElement('shipping_address2'));
            $shipping_address2->appendChild($xml->createCDATASection(''));

            // shipping_city

            $shipping_city = $transaction->appendChild($xml->createElement('shipping_city'));
            $shipping_city->appendChild($xml->createCDATASection($shipping->city));

            // shipping_state

            $shipping_state = $transaction->appendChild($xml->createElement('shipping_state'));
            $shipping_state->appendChild($xml->createCDATASection($shipping->state_name));

            // shipping_postal_code

            $shipping_postal_code = $transaction->appendChild($xml->createElement('shipping_postal_code'));
            $shipping_postal_code->appendChild($xml->createCDATASection($shipping->zip));

            // shipping_country

            $shipping_country = $transaction->appendChild($xml->createElement('shipping_country'));
            $shipping_country->appendChild($xml->createCDATASection('usa'));

            // shipping_phone

            $shipping_phone = $transaction->appendChild($xml->createElement('shipping_phone'));
            $shipping_phone->appendChild($xml->createCDATASection($shipping->phone));
        }
        // shipto_shipping_service_description

        $shipto_shipping_service_description = $transaction->appendChild($xml->createElement('shipto_shipping_service_description'));
        $shipto_shipping_service_description->appendChild($xml->createCDATASection(''));

        // purchase_order

        $purchase_order = $transaction->appendChild($xml->createElement('purchase_order'));
        $purchase_order->appendChild($xml->createCDATASection(''));

        // purchase_total

        $purchase_total = $transaction->appendChild($xml->createElement('purchase_total'));
        $purchase_total->appendChild($xml->createCDATASection($orderDetails->total_cost));

        // tax_total

        $tax_total = $transaction->appendChild($xml->createElement('tax_total'));
        $tax_total->appendChild($xml->createCDATASection(''));

        // shipping_total

        $shipping_total = $transaction->appendChild($xml->createElement('shipping_total'));
        $shipping_total->appendChild($xml->createCDATASection($orderDetails->shipping_cost));

        // order_total

        $order_total = $transaction->appendChild($xml->createElement('order_total'));
        $order_total->appendChild($xml->createCDATASection($orderDetails->total_cost));

        // dividend

        $dividend = $transaction->appendChild($xml->createElement('dividend'));
        $dividend->appendChild($xml->createCDATASection($orderDetails->dividend));

        // discounts

        $discounts = $transaction->appendChild($xml->createElement('discounts'));
        $discount = $discounts->appendChild($xml->createElement('discount'));
        $amount = $discount->appendChild($xml->createElement('amount'));
        $amount->appendChild($xml->createCDATASection('-'.$orderDetails->discount));
        $coupon_discount_type = $discount->appendChild($xml->createElement('coupon_discount_type'));
        $coupon_discount_type->appendChild($xml->createCDATASection('price_amount'));

                //Foxycart notes (Maps to Memo in QB - Use for formula name)
                
                $notes = $transaction->appendChild($xml->createElement('notes'));
        $notes->appendChild($xml->createCDATASection($orderDetails->formulaName));
        

        // Custom Fields

        $custom_fields = $transaction->appendChild($xml->createElement('custom_fields'));

        $custom_field_notes = $custom_fields->appendChild($xml->createElement('custom_field'));

            // notes_name

            $notes_name = $custom_field_notes->appendChild($xml->createElement('custom_field_name'));
        $notes_name->appendChild($xml->createCDATASection('notes'));

            // notes_value

            $notes_value = $custom_field_notes->appendChild($xml->createElement('custom_field_value'));
        $notes_value->appendChild($xml->createCDATASection($orderDetails->notes));

        $custom_field_instructions = $custom_fields->appendChild($xml->createElement('custom_field'));

            // instructions

            $instructions_name = $custom_field_instructions->appendChild($xml->createElement('custom_field_name'));
        $instructions_name->appendChild($xml->createCDATASection('instructions'));

            // instructions_value

            $instructions_value = $custom_field_instructions->appendChild($xml->createElement('custom_field_value'));
        $instructions_value->appendChild($xml->createCDATASection($orderDetails->instructions));

        $custom_field_timesPerDay = $custom_fields->appendChild($xml->createElement('custom_field'));

            // timesPerDay_name

            $timesPerDay_name = $custom_field_timesPerDay->appendChild($xml->createElement('custom_field_name'));
        $timesPerDay_name->appendChild($xml->createCDATASection('timesPerDay'));

            // timesPerDay_value

            $timesPerDay_value = $custom_field_timesPerDay->appendChild($xml->createElement('custom_field_value'));
        $timesPerDay_value->appendChild($xml->createCDATASection($orderDetails->timesPerDay));

        $custom_field_numberOfScoops = $custom_fields->appendChild($xml->createElement('custom_field'));

            // numberOfScoops_name

            $numberOfScoops_name = $custom_field_numberOfScoops->appendChild($xml->createElement('custom_field_name'));
        $numberOfScoops_name->appendChild($xml->createCDATASection('numberOfScoops'));

            // timesPerDay_value

            $numberOfScoops_value = $custom_field_numberOfScoops->appendChild($xml->createElement('custom_field_value'));
        $numberOfScoops_value->appendChild($xml->createCDATASection($orderDetails->numberOfScoops));


        // refills

        $custom_field_refills = $custom_fields->appendChild($xml->createElement('custom_field'));

            // refills_name

            $refills_name = $custom_field_refills->appendChild($xml->createElement('custom_field_name'));
        $refills_name->appendChild($xml->createCDATASection('refills'));

            // refills_value

            $refills_value = $custom_field_refills->appendChild($xml->createElement('custom_field_value'));
        $refills_value->appendChild($xml->createCDATASection($orderDetails->refills));

        // Formula Name - AKA notes

        $custom_field_formula_name = $custom_fields->appendChild($xml->createElement('custom_field'));

        // formula_name

        $formula_name_name = $custom_field_formula_name->appendChild($xml->createElement('custom_field_name'));
        $formula_name_name->appendChild($xml->createCDATASection('formula_name'));

        // formula_value

        $formula_name_value = $custom_field_formula_name->appendChild($xml->createElement('custom_field_value'));
        $formula_name_value->appendChild($xml->createCDATASection($orderDetails->formulaName));


         // transaction_details

        $transaction_details = $transaction->appendChild($xml->createElement('transaction_details'));

        foreach ($ingredients as $value) {

            // transaction_detail

            $transaction_detail = $transaction_details->appendChild($xml->createElement('transaction_detail'));

            // product_name

            $product_name = $transaction_detail->appendChild($xml->createElement('product_name'));
            $product_name->appendChild($xml->createCDATASection($value->pinyin));

            // product_price

            $product_price = $transaction_detail->appendChild($xml->createElement('product_price'));
            $product_price->appendChild($xml->createCDATASection($value->costPerGram));

            // product_quantity

            $product_quantity = $transaction_detail->appendChild($xml->createElement('product_quantity'));
            $product_quantity->appendChild($xml->createCDATASection($value->weight));

            // product_weight

            $product_weight = $transaction_detail->appendChild($xml->createElement('product_weight'));
            $product_weight->appendChild($xml->createCDATASection($value->weight));


            // product_code

            $product_code = $transaction_detail->appendChild($xml->createElement('product_code'));
            $product_code->appendChild($xml->createCDATASection($value->product_id));

            // shipto

            $shipto = $transaction_detail->appendChild($xml->createElement('shipto'));
            $shipto->appendChild($xml->createCDATASection(''));

            // category_description

            $category_description = $transaction_detail->appendChild($xml->createElement('category_description'));
            $category_description->appendChild($xml->createCDATASection(''));

            // product_delivery_type

            $product_delivery_type = $transaction_detail->appendChild($xml->createElement('product_delivery_type'));
            $category_description->appendChild($xml->createCDATASection(''));
        }

        $xml->formatOutput = true;
        $xml->save('orders/order.orderXML.'. $orderDetails->id .'.' . time() . '.xml');
        $orderXML = $xml->saveXML();

        $escaped = $this->db->escape($orderXML);
        $escaped = trim($escaped, "'");
        $sql = 'UPDATE orders SET snapshot = "' . $escaped . '" WHERE id = ' . $orderDetails->id;
        $query = $this->db->query($sql);

        return true;
    }
}
