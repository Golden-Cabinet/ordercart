<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class order_model extends MY_Model {

    protected $_table = 'orders';
    protected $soft_delete = TRUE;
    protected $consolibyteUrl = 'https://secure.consolibyte.com/saas/installs/1529/foxycart/qbus/2496/public/foxycart/foxydata.php';

    public function __construct(){
        parent::__construct();
        $this->load->model(array('address_model','state_model','user_model','patient_model'));
    }

    public function defaultSettings()
    {
        $orders = new stdClass();
        $orders->name = '';
        $orders->parent_id = 0;
        $orders->description = '';
        return $orders;
    }


    public function filter($input){

        if(is_array($input) AND !empty($input)  ){

            foreach($input as $key => $value){
                $input[$key] = trim(strip_tags($value));
            }

            return $input;

        }else{
            return FALSE;
        }

    }

    public function fetch_orders($limit, $start)
    {

        $auth = new Authentication();

        if ($auth->is_admin()) {

            $sql = "SELECT
                orders.id,
                orders.created_at,
                orders.status,
                orders.refills,
                orders.user_id,
                orders.patient_id,
                orders.formula_id,
                orders.notes,
                formulas.name as formulaName,
                patients.firstName as patientFirstName,
                patients.lastName as patientLastName,
                patients.deleted as patientDeleted,
                users.firstName as practitionerLastName,
                users.lastName as practitionerLastName
	 							FROM `orders`
                JOIN patients ON orders.patient_id = patients.id
                JOIN users ON orders.user_id = users.id
                JOIN formulas ON orders.formula_id = formulas.id
                WHERE orders.deleted = 0
								/* AND patients.deleted = 0 */
                ORDER BY orders.created_at DESC";
        }else{

            $session = $this->session->all_userdata();
            $currentUserID = $session['user_data'];

            $sql = "SELECT
                orders.id,
                orders.created_at,
                orders.status,
                orders.refills,
                orders.user_id,
                orders.patient_id,
                orders.formula_id,
                formulas.name as formulaName,
                patients.firstName as patientFirstName,
                patients.lastName as patientLastName,
                patients.deleted as patientDeleted,
                users.firstName as practitionerLastName,
                users.lastName as practitionerLastName
                FROM `orders`
                JOIN patients ON orders.patient_id = patients.id
                JOIN users ON orders.user_id = users.id
                JOIN formulas ON orders.formula_id = formulas.id
                WHERE orders.deleted = 0 AND orders.user_id = $currentUserID
                /* AND patients.deleted = 0 */
								ORDER BY orders.created_at DESC";

        }

        $query = $this->db->query($sql);

       if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }

           return $data;

        }

        return false;

    }


    public function fetch_order($limit, $start)
    {

        $auth = new Authentication();

        if ($auth->is_admin()) {
            $query = $this->db->get_where($this->_table, array('deleted' => 0), $limit, $start);
        } else {
            $session = $this->session->all_userdata();
            $currentUserID = $session['user_data'];
            $query = $this->db->get_where($this->_table, array('deleted' => 0, 'user_id' => $currentUserID), $limit, $start);
        }


        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }

            return $data;

        }

        return false;

    }
 
    public function filterPostValues($orderDetails,$userID){

        $orderInfo = array();
        if(is_array($orderDetails) AND !empty($orderDetails)){


                $orderInfo['user_id'] = $userID;
                $orderInfo['patient_id'] = $orderDetails['patient_id'];
                $orderInfo['formula_id'] = $orderDetails['formula_id'];
                $orderInfo['sub_total'] = $orderDetails['sub_total'];
                $orderInfo['shipping_cost'] = $orderDetails['shipping_cost'];
                $orderInfo['discount'] = $orderDetails['discount'];
                $orderInfo['dividend'] = $orderDetails['dividend'];
                $orderInfo['total_cost'] = $orderDetails['formula_total'];
                $orderInfo['numberOfScoops'] = $orderDetails['numberOfScoops'];
                $orderInfo['timesPerDay'] = $orderDetails['timesPerDay'];
                $orderInfo['refills'] = $orderDetails['refills'];
                $orderInfo['shipOrPick'] = $orderDetails['ship'];
                $orderInfo['billing'] = $orderDetails['billing'];
                $orderInfo['notes'] = trim($orderDetails['notes']);
                $orderInfo['instructions'] = trim($orderDetails['instructions']);
                $orderInfo['created_at'] = date("Y-m-d H:i:s");
                $orderInfo['ratio'] = $orderDetails['ratio'];                
                
                
            if( $orderDetails['ship'] == 0){
                $orderInfo['pickUpOption'] = $orderDetails['howPickup'];
                $orderInfo['shipOption'] = 'NA';
            }else{
                $orderInfo['pickUpOption'] = 'NA';
                $orderInfo['shipOption'] = $orderDetails['howShip'];
            }
            
            /***************************************************************** 
               
               Store alternate address for shipping option, if specified 
            
            *****************************************************************/
            
            if ( in_array( $orderInfo['shipOption'], ['shipUserOther', 'shipPatientOther'] ) ) {
              $orderInfo['alternateAddress'] = json_encode(array(
                'address' => $orderDetails['other_address1'],
                'city' => $orderDetails['other_city'],
                'state' => $orderDetails['other_state'],
                'zip' => $orderDetails['other_zip']
              ));
            }
            
            return $orderInfo;

        }else{
            return false;
        }
    }

    public function getView($orderID, $xml  = false)
    {

        $auth = new Authentication();

        if ($auth->is_admin() || $xml) {

            $sql = "SELECT
                orders.id,
                orders.created_at,
                orders.status,
                orders.refills,
                orders.user_id,
                orders.total_cost,
                orders.updated_at,
                orders.shipping_cost,
                orders.discount,
                orders.dividend,
              	FORMAT(orders.sub_total, 2) as sub_total,
                orders.shipOrPick,
                orders.pickUpOption,
                orders.shipOption,
                orders.instructions,
                orders.notes,
                orders.timesPerDay,
                orders.numberOfScoops,
                formulas.name as formulaName,
                formulas.id as formula_id,
                patients.firstName as patientFirstName,
                patients.lastName as patientLastName,
                patients.email as patientEmail,
                patients.id as patient_id,
                users.id as practitionerID,
                users.firstName as practitionerFirstName,
                users.lastName as practitionerLastName,
                orders.ratio
                FROM `orders`
                JOIN patients ON orders.patient_id = patients.id
                JOIN users ON orders.user_id = users.id
                JOIN formulas ON orders.formula_id = formulas.id
                WHERE orders.id = $orderID";
        }else{

            $session = $this->session->all_userdata();
            $currentUserID = $session['user_data'];

            $sql = "SELECT
                orders.id,
                orders.created_at,
                orders.status,
                orders.refills,
                orders.user_id,
                orders.total_cost,
                orders.updated_at,
                orders.shipping_cost,
                orders.discount,
                orders.dividend,
                FORMAT(orders.sub_total, 2) as sub_total,
                orders.shipOrPick,
                orders.pickUpOption,
                orders.shipOption,
                orders.instructions,
                orders.notes,
                orders.timesPerDay,
                orders.numberOfScoops,
                formulas.name as formulaName,
                formulas.id as formula_id,
                patients.id as patient_id,
                patients.firstName as patientFirstName,
                patients.lastName as patientLastName,
                patients.email as patientEmail,
                users.id as practitionerID,
                users.firstName as practitionerFirstName,
                users.lastName as practitionerLastName,
                orders.ratio
                FROM `orders`
                JOIN patients ON orders.patient_id = patients.id
                JOIN users ON orders.user_id = users.id
                JOIN formulas ON orders.formula_id = formulas.id
                WHERE orders.id = $orderID AND orders.user_id = $currentUserID";

        }

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {

            $data = $query->result();

            return $data[0];

        }else{

            return false;

        }


    }

    public function getSnapshot($orderID)
    {

        $auth = new Authentication();

        $session = $this->session->all_userdata();
        $currentUserID = $session['user_data'];

        if ($auth->is_admin()) {
					$sql = "SELECT snapshot FROM orders WHERE id = $orderID";
				} else {
					$sql = "SELECT snapshot FROM orders WHERE id = $orderID AND user_id = $currentUserID";
				}
				
				$query = $this->db->query($sql);

        if ($query->num_rows() > 0) {

            $data = $query->result();

        }else{

            return false;

        }

				$snapshot = simplexml_load_string($data[0]->snapshot);
				
				$snapshot[0]->transactions->transaction->patientFirstName = $snapshot[0]->transactions->transaction->customer_first_name;
				$snapshot[0]->transactions->transaction->patientLastName = $snapshot[0]->transactions->transaction->customer_last_name;
				$snapshot[0]->transactions->transaction->patientEmail = $snapshot[0]->transactions->transaction->customer_email;
				$snapshot[0]->transactions->transaction->patientLastName = $snapshot[0]->transactions->transaction->customer_last_name;
				
				return $snapshot[0]->transactions->transaction;
				
		}
		
		public function getUnsyncedOrders($downloadStartDate) {
			
			$downloadStartDate = date('Y-m-d H:i:s', strtotime($downloadStartDate));
			$now = date('Y-m-d H:i:s', date('U')+(24*60*60));
			$sql = "SELECT id FROM orders WHERE (created_at BETWEEN '$downloadStartDate' AND '$now')";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {

          $data = $query->result();
					return $data;
					
      } else {

          return false;

      }
		}
		
		public function markAsSynced($order_ids) {
						
			if (is_array($order_ids)) {
			
				foreach ($order_ids as $orderID) {
					$order_id = (string) $orderID->id;
				
					$sql = "UPDATE orders SET synced_to_thub = 1 WHERE id = $order_id";
					$query = $this->db->query($sql);
				}
			
			}
			
			return true;
		}

    public function shipToOption($orderID){

        $orderInfo = $this->get($orderID);

        return $orderInfo->shipOption;

    }

    public function getShippingDetails($orderID){

        $orderInfo = $this->get($orderID);
        
        $patient = new patient_model();
        $patientInfo = $patient->getPatientProfile($orderInfo->patient_id);

        $shippingDetails = array();

        if($orderInfo->shipOrPick == 0){

            if($orderInfo->pickUpOption == 'patientPickup'){
               
                $shippingDetails['shipping_Address'] = 'Patient will pick up';

            }else{

                $shippingDetails['shipping_Address'] = 'Practitioner will pick up';
            }


        }else{

            $addressModel = new address_model();
            $states = new state_model();

            if($orderInfo->shipOption == 'shipPatient'){

                $query = $this->db->get_where('patientAddress', array('patient_id' => $orderInfo->patient_id , 'addressType' => 1));
                $shipping_AddressInfo = $query->result();
                $shipping_Address = $shipping_AddressInfo[0];

                $shippingDetails['shipping_Address'] = "<ul class='address'>
                <li>$patientInfo->firstName $patientInfo->lastName</li>
                <li>$shipping_Address->street</li>
                <li>$shipping_Address->city"
                . ' ' . $states->getStateName($shipping_Address->state_id) . ' , ' . $shipping_Address->zip.
                "</li></ul>";

            }elseif($orderInfo->shipOption ==  'shipPatientOther' OR $orderInfo->shipOption == 'shipUserOther'){

                $shippingDetails['shipping_Address'] = "<strong>(Alternate Address Used)</strong><br><ul class='address'>";
                
                foreach ( array_values( (array) json_decode($orderInfo->alternateAddress) ) as $address_piece) {
                  $shippingDetails['shipping_Address'] .= "<li>$address_piece</li>";
                }
                $shippingDetails['shipping_Address'] .= '</ul>';

            }elseif($orderInfo->shipOption == 'shipUserMailing'){

                $query = $this->db->get_where('address', array('user_id' => $orderInfo->user_id , 'addressType' => 1));

                $shipping_AddressInfo = $query->result();
                $shipping_Address = $shipping_AddressInfo[0];

                $shippingDetails['shipping_Address'] = "<ul class='address'>
                <li>$patientInfo->firstName $patientInfo->lastName</li>
                <li>$shipping_Address->street</li>
                <li>$shipping_Address->city"
                    . ' ' . $states->getStateName($shipping_Address->state_id) . ' , ' . $shipping_Address->zip.
                    "</li></ul>";
            }

        }

        return $shippingDetails;

    }

    public function getShippingDetailsRaw($orderID){

        $orderInfo = $this->get($orderID);

        if($orderInfo->shipOrPick == 0){
           return false;
        }else{

            $states = new state_model();

            if($orderInfo->shipOption == 'shipPatient'){

                $query = $this->db->get_where('patientAddress', array('patient_id' => $orderInfo->patient_id , 'addressType' => 1));
                $shipping_AddressInfo = $query->result();
                $shipping_Address = $shipping_AddressInfo[0];
                $shipping_Address->state_name = $states->getStateName($shipping_Address->state_id);

                $patient = new patient_model();
                $shipTo = $patient->get($orderInfo->patient_id);
                $shipping_Address->firstName = $shipTo->firstName;
                $shipping_Address->lastName = $shipTo->lastName;
                $shipping_Address->phone = $shipTo->area_code . ' ' .$shipTo->phone;
                return $shipping_Address;

            }elseif($orderInfo->shipOption ==  'shipPatientOther' OR $orderInfo->shipOption == 'shipUserOther'){
                
                $alternate_shipping_address = (object) json_decode( $orderInfo->alternateAddress );
                
                $shipping_Address->firstName = "See Notes Section";
                $shipping_Address->lastName = "See Notes Section";
                $shipping_Address->street = $alternate_shipping_address->address;
                $shipping_Address->phone = "";
                $shipping_Address->city = $alternate_shipping_address->city;
                $shipping_Address->state_name = $alternate_shipping_address->state;
                $shipping_Address->zip = $alternate_shipping_address->zip;
                return $shipping_Address;

            }elseif($orderInfo->shipOption == 'shipUserMailing'){

                $query = $this->db->get_where('address', array('user_id' => $orderInfo->user_id , 'addressType' => 1));
                $shipping_AddressInfo = $query->result();
                $shipping_Address = $shipping_AddressInfo[0];
                $shipping_Address->state_name = $states->getStateName($shipping_Address->state_id);
                $user = new user_model();
                $shipTo = $user->get($orderInfo->user_id);
                $shipping_Address->firstName = $shipTo->firstName;
                $shipping_Address->lastName = $shipTo->lastName;
                $shipping_Address->phone = $shipTo->area_code . ' ' .$shipTo->phone;
                return $shipping_Address;
            }

        }

    }


    public function getPaymentDetails($id){

        $orderInfo = $this->get($id);

        if($orderInfo->billing == 'chargeUserCard'){
            return 'Charged Practitioners Card on file.';
        }elseif($orderInfo->billing == 'callInCard'){
            return 'Practitioner will call with my credit card information';
        }elseif($orderInfo->billing == 'pickUpFormula.'){
            return 'Practitioner will pay when they pick up the formula.';
        }elseif($orderInfo->billing == 'mailInPayment'){
            return 'Practitioner will mail payment';
        }elseif($orderInfo->billing == 'patientPay'){
            return 'Patient will pay when picking up';
        }else{
            return 'Patient will pay - include invoice in shipment';
        }


    }

    public function getByStatus($status)
    {
        if(is_array($status)){
            $status = "orders.status IN (1, 2, 3)";
            $deleted = 0;
        }elseif($status == 4){
            $status =  "orders.status = 4" ;
            $deleted = 1;
        }else{
            $status =  "orders.status = 0" ;
            $deleted = 0;
        }

        $auth = new Authentication();

        if ($auth->is_admin()) {

            $sql = "SELECT
                orders.id,
                orders.created_at,
                orders.status,
                orders.refills,
                orders.user_id,
                formulas.name as formulaName,
                patients.firstName as patientFirstName,
                patients.lastName as patientLastName,
                users.firstName as practitionerLastName,
                users.lastName as practitionerLastName
                FROM `orders`
                JOIN patients ON orders.patient_id = patients.id
                JOIN users ON orders.user_id = users.id
                JOIN formulas ON orders.formula_id = formulas.id
                WHERE orders.deleted = $deleted AND $status";
        }else{

            $session = $this->session->all_userdata();
            $currentUserID = $session['user_data'];

            $sql = "SELECT
                orders.id,
                orders.created_at,
                orders.status,
                orders.refills,
                orders.user_id,
                formulas.name as formulaName,
                patients.firstName as patientFirstName,
                patients.lastName as patientLastName,
                users.firstName as practitionerLastName,
                users.lastName as practitionerLastName
                FROM `orders`
                JOIN patients ON orders.patient_id = patients.id
                JOIN users ON orders.user_id = users.id
                JOIN formulas ON orders.formula_id = formulas.id
                WHERE orders.deleted = $deleted AND orders.user_id = $currentUserID AND $status";

        }

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }

            return $data;

        }

        return false;

    }

    public function getByPatient($patient_id) {
  
        $sql = "SELECT
            orders.id,
            orders.created_at,
            orders.status,
            orders.refills,
            orders.user_id,
            formulas.name as formulaName,
            patients.firstName as patientFirstName,
            patients.lastName as patientLastName,
            users.firstName as practitionerLastName,
            users.lastName as practitionerLastName
            FROM `orders`
            JOIN patients ON orders.patient_id = patients.id
            JOIN users ON orders.user_id = users.id
            JOIN formulas ON orders.formula_id = formulas.id
            WHERE orders.patient_id = $patient_id";


        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }

            return $data;

        }

        return false;

    }

    public function orderXml($order){

        $orderDetails = $order['orderDetails'];
        $shipping = $order['shipping'];
        $ingredients = $order['ingredients'];

        $xml = new DOMDocument( "1.0", "UTF-8" );
        $base = $xml->appendChild($xml->createElement( 'order' ));

        // order date

        $orderdate = $base->appendChild($xml->createElement('orderdate'));
        $orderdate->appendChild($xml->createCDATASection($orderDetails->created_at));

        // practitioner

        $practitioner = $base->appendChild($xml->createElement('practitioner'));

        $firstName = $practitioner->appendChild($xml->createElement('firstname'));
        $firstName->appendChild($xml->createCDATASection($orderDetails->practitionerFirstName));

        $lastname = $practitioner->appendChild($xml->createElement('lastname'));
        $lastname->appendChild($xml->createCDATASection($orderDetails->practitionerLastName));

        // bill to

        $billTo = $base->appendChild($xml->createElement('billTo'));
        $billTo->appendChild($xml->createCDATASection($this->billto($order['payment'],$orderDetails)));

        // Ship to

        $shipTo = $base->appendChild($xml->createElement('shipTo'));

        $street = $shipTo->appendChild($xml->createElement('street'));
        $street->appendChild($xml->createCDATASection($shipping->street));

        $city = $shipTo->appendChild($xml->createElement('city'));
        $city->appendChild($xml->createCDATASection($shipping->city));

        $state = $shipTo->appendChild($xml->createElement('state'));
        $state->appendChild($xml->createCDATASection($shipping->state_name));

        $zip = $shipTo->appendChild($xml->createElement('zip'));
        $zip->appendChild($xml->createCDATASection($shipping->zip));

        // Customer Message

        $message = $base->appendChild($xml->createElement('message'));
        $message->appendChild($xml->createCDATASection($orderDetails->instructions));

        // notes

        $notes = $base->appendChild($xml->createElement('notes'));
        $notes->appendChild($xml->createCDATASection($orderDetails->notes));

        // shipping

        $shipping = $base->appendChild($xml->createElement('shipping'));
        $shipping->appendChild($xml->createCDATASection($orderDetails->shipping_cost));

        // total

        $total = $base->appendChild($xml->createElement('total'));
        $total->appendChild($xml->createCDATASection($orderDetails->total_cost));

        // dividend

        $dividend = $base->appendChild($xml->createElement('dividend'));
        $dividend->appendChild($xml->createCDATASection($orderDetails->dividend));


        // ingredients

        $items = $base->appendChild($xml->createElement('items'));

        foreach($ingredients as $value){

            $item = $items->appendChild($xml->createElement('item'));

            $product_id = $item->appendChild($xml->createElement('product_id'));
            $product_id->appendChild($xml->createCDATASection($value->product_id));

            $item_code = $item->appendChild($xml->createElement('item_code'));
            $item_code->appendChild($xml->createCDATASection($value->pinyin));

            $qty = $item->appendChild($xml->createElement('qty'));
            $qty->appendChild($xml->createCDATASection($value->weight));

            $price = $item->appendChild($xml->createElement('price'));
            $price->appendChild($xml->createCDATASection($value->costPerGram));

            $amount = $item->appendChild($xml->createElement('amount'));
            $amount->appendChild($xml->createCDATASection($value->subtotal));

        }

        $xml->formatOutput = true;
        $xml->save('order.xml');
        $orderXML = $xml->saveXML();
				// $orderXML = file_get_contents('order.xml');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_URL, $this->consolibyteUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "order=$orderXML");
        $content = curl_exec($ch);

        $curlResponse = curl_getinfo($ch);
        curl_close($ch);
        return $curlResponse;

    }

    private function billto($billingTo,$orderDetails){

        if($billingTo == 'chargeUserCard'){
            return $orderDetails->practitionerFirstName . ' ' .$orderDetails->practitionerLastName;
        }elseif($billingTo == 'callInCard'){
            return $orderDetails->practitionerFirstName . ' ' .$orderDetails->practitionerLastName;
        }elseif($billingTo == 'pickUpFormula.'){
            return $orderDetails->practitionerFirstName . ' ' . $orderDetails->practitionerLastName;
        }elseif($billingTo == 'mailInPayment'){
            return $orderDetails->practitionerFirstName . ' ' . $orderDetails->practitionerLastName;
        }elseif($billingTo == 'patientPay'){
            return $orderDetails->patientFirstName . ' ' . $orderDetails->patientLastName;
        }else{
            return $orderDetails->patientFirstName . ' ' .$orderDetails->patientLastName;
        }


    }

		public function sendConfirmationEmail($practitioner) {
			
			$to      = $practitioner->email;
			$subject = 'Thank you for your order at Golden Cabinet Herbal Pharmacy';
			$headers = 'From: Golden Cabinet <accounts@goldencabinetherbs.com>' . "\r\n" .
			    'Reply-To: accounts@goldencabinetherbs.com' . "\r\n" .
			    'X-Mailer: PHP/' . phpversion();

			$first = $practitioner->firstName;
			$last = $practitioner->lastName;
			
			$message = <<<EOF
<p>Hi $first $last,</p>
<p>Thank you so much for your order.  We will begin processing this order as soon as possible.  Our business hours are 9am-6pm Monday to Friday and 9am-noon on Saturdays.  If we received this order outside of these hours, we will process the order as soon as we return to the pharmacy.  If the order is urgent or you have any additional questions or instructions that are not included in the order, feel free to call us at (503) 233-4102.</p>
<p>Hope you have a wonderful day!</p>
<p>All the best,<br />
The Golden Cabinet Team</p>
EOF;

      $email = new GCEmail ($this->config->item('email'));			   
      if ( $email->send( $to, $subject, $message ) ) {
        return true;
      }else {
        return false;				
  		}
    }

}