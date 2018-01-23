<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'REST_Controller.php';

class Orders extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('product_model', 'order_model', 'patient_model', 'formula_model'));
        $this->load->library(array('form_validation', 'Authentication', 'Pagination','OrderBuilder'));
    }

    public function index_get()
    {
        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        $data = array(
            'content' => 'modules/store/orders/orders',
        );

        $pagination = new CI_Pagination();

        $config['base_url'] = base_url('store/orders');
        $config['total_rows'] = $this->db->count_all('orders');
        if(!$this->authentication->is_admin()){        
          $config['per_page'] = 10000;
        }else {
          $config['per_page'] = 5000;
        }
        $config['full_tag_open'] = '<div class="pagination"><ul>';
        $config['full_tag_close'] = '</ul></div><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["orders"] = $this->order_model->fetch_orders($config["per_page"], $page);

        $data["links"] = $pagination->create_links();

        if (!$this->session->flashdata('message') == FALSE) {
            $data['message'] = $this->session->flashdata('message');
        }

        $this->load->view($this->config->item('standard-page'), $data);
    }

    public function add_get()
    {
        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }
        $session = $this->session->all_userdata();

        $data = array(
            'title' => 'New Order',
            'content' => 'modules/store/orders/order-form',
            'path' => 'store/orders/add',
            'formulas' => $this->formula_model->getFormulasApi(),
            'formula' => $this->order_model->defaultSettings(),
            'patients' => $this->patient_model->fetch_active_patients(1000,0),
						'user' => $this->user_model->getProfile($session['user_data']),
            'mode' => 'add'
        );
        if (!$this->session->flashdata('message') == FALSE) {
            $data['message'] = $this->session->flashdata('message');
        }

        $this->load->view($this->config->item('formula'), $data);
    }
    
    public function add_post()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        //--------------------------------------------------------------------
        // filter post values
        //--------------------------------------------------------------------
        $session = $this->session->all_userdata();

        $data = $this->order_model->filterPostValues($this->input->post(), $session['user_data']);
                
				$this->order_model->insert($data);
				$orderID = $this->db->insert_id();
        $orderInfo = $this->order_model->getView($orderID);

        $practitioner = $this->user_model->getProfile($orderInfo->user_id);
             
        //--------------------------------------------------------------------
        // send order to T-Hub
        //--------------------------------------------------------------------
        $this->sendOrder($orderID);
        
        //--------------------------------------------------------------------
        // send a confirmation email (@todo: should tie ot success of T-Hub posting successfully)
        //--------------------------------------------------------------------
				
        $message = "<p>Success, we'll take it from here!</p>
                 <p>Your order has been received and will be processed as soon as possible. We are open Monday-Friday from 9 a.m. to 6 p.m. and 9 a.m. to noon on Saturdays. If we receive your order outside of our regular hours, it will be processed on the following business day. All orders marked for shipment that are submitted by 1 p.m. are guaranteed to ship out the same business day. If you have any questions or additional instructions, feel free to call us at (503)233-4102 or email us at orders@goldencabinetherbs.com. Thank you and have a wonderful day!</p>";
               $mail = new GCEmail ($this->config->item('email'));
               $mail->send($practitioner->email, 'Order Successfully Sent', $message);  

        redirect('store/orders/?order_success=true&email='.$practitioner->email);
    }

    private function sendOrder($orderID){

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

    public function view_get()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        if (!$this->uri->segment(4) === FALSE) {

          	$orderInfoSnapshot = $this->order_model->getSnapshot($this->uri->segment(4));
            $orderInfo = $this->order_model->getView($this->uri->segment(4));
            $shippingInfo = $this->order_model->getShippingDetails($this->uri->segment(4));
            $paymentInfo = $this->order_model->getPaymentDetails($this->uri->segment(4));
					  // $formulaInfo = $this->formula_model->getView($orderInfo->formula_id);
						$orderInfo->patientFirstName = $orderInfoSnapshot->customer_first_name;
						$orderInfo->patientLastName = $orderInfoSnapshot->customer_last_name;
						$orderInfo->patientEmail = $orderInfoSnapshot->customer_email;
												
						foreach ($orderInfoSnapshot->custom_fields->custom_field as $custom_field) {
							if ($custom_field->custom_field_name == 'formula_name') {
								$formulaInfo['formula']['name'] = (string)$custom_field->custom_field_value;
							}
						}
						
						$ingredient_array = array();
						$count = 0;
                        $formulaInfo['cost'] = 0;
                        foreach ($orderInfoSnapshot->transaction_details->transaction_detail as $ingredient) {
							$ingredient_array[$count]['pinyin'] = $ingredient->product_name;
							$ingredient_array[$count]['costPerGram'] = $ingredient->product_price;
							$ingredient_array[$count]['weight'] = round((float)$ingredient->product_weight,1);
							$subTotal = (float)$ingredient_array[$count]['costPerGram']*(float)$ingredient_array[$count]['weight'];
							$ingredient_array[$count]['subtotal']=number_format($subTotal,2);
							$formulaInfo['cost'] = $formulaInfo['cost'] + $ingredient_array[$count]['subtotal'];
							$count++;
                        }

						$formulaInfo['ingredients'] = $ingredient_array;
						$formulaInfo['shipping_total'] = (string) $orderInfoSnapshot->shipping_total;

            $data = array(
                'title' => 'Order Details',
                'content' => 'modules/store/orders/order-view',
                'orderDetails' => $this->statusName($orderInfo),
                'formula' => $formulaInfo['formula'],
                'formula_cost' => number_format($formulaInfo['cost'],2),
                'ingredients' => $formulaInfo['ingredients'],
                'shipping' => $shippingInfo,
                'payment' => $paymentInfo,
                'mode' => 'view',
                'ratio' => $orderInfo->ratio
            );
            
            $this->load->view($this->config->item('standard-page'), $data);

        } else {
            $this->session->set_flashdata('message', 'Unable to find the order requested. Please try again.');
            redirect('store/order');
        }
    }

    public function updateOrderStatus_post()
    {

        if ($this->input->post() === FALSE) {
            redirect();
        } else {
            $dateUpdated = date("Y-m-d H:i:s");

            // if($this->input->post('status') == 4){
            //     $deleted = 1;
            // }else{
            //     $deleted = 0;
            // }

            $this->order_model->update($this->input->post('order_id'), array('status' => $this->input->post('status'), 'updated_at' => $dateUpdated));

            echo json_encode(array('status' => 'true', 'date' => date("F j, Y, g:i a", strtotime($dateUpdated))));
            die();
        }

    }

    public function ordersByStatus_get()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        if ($this->uri->segment(3) === FALSE) {
            redirect();
        } else {
            $data = array(
                'content' => 'modules/store/orders/orders',
                'orders' => $this->order_model->getByStatus($this->getStatus($this->uri->segment(3)))
            );
        }

        if (!$this->session->flashdata('message') == FALSE) {
            $data['message'] = $this->session->flashdata('message');
        }

        $this->load->view($this->config->item('standard-page'), $data);

    }


    private function getStatus($status)
    {

        switch ($status) {
            case 'active':
                return 0;
                break;
            case 'completed':
                return array(1,2,3);
            case 'canceled':
                return 4;
                break;
        }

    }

    private function statusName($orderDetails){

        if($orderDetails->status == 0 ){
            $orderDetails->status = 'Processing';
        }elseif($orderDetails->status == 1){
            $orderDetails->status = 'Ready For Pick up';
        }elseif($orderDetails->status == 2){
            $orderDetails->status = 'Completed - Shipped';
        }elseif($orderDetails->status == 3){
            $orderDetails->status = 'Completed - Picked up';
        }elseif($orderDetails->status == 4){
            $orderDetails->status = 'Canceled';
        }

        return $orderDetails;

    }

}