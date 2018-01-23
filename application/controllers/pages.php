<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR .'REST_Controller.php';
require SYSDIR . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR .'Email.php';
require APPPATH . 'third_party' . DIRECTORY_SEPARATOR . 'recaptchalib.php';

class Pages extends REST_Controller
{

    function __construct()
    {

        parent::__construct();

        //$this->load->model(array('auth_model'));
        $this->load->model(array('contact_model', 'order_model', 'formula_model', 'user_model', 'login_attempt_model', 'role_model'));
        $this->load->helper(array('form', 'url','email'));
        $this->load->library(array('form_validation','Authentication', 'OrderBuilder'));

    }
    
    public function index_get(){
	
				$data = array(
	          'content' => 'modules/pages/home',
	          'contact' => $this->defaultSettings(),
	          'path' => '/',
	          'captcha' => recaptcha_get_html($this->config->item('recaptcha_public'))
	      );

        if(!$this->session->flashdata('message') == FALSE ){
            $data['message'] = $this->session->flashdata('message');
        }


        $this->load->view($this->config->item('theme_home'),$data);
    }

    public function index_post()
    {
        //--------------------------------------------------------------------
        // Form Validation Rules
        //--------------------------------------------------------------------

        $this->form_validation->set_rules('firstName', 'First name', 'required');
        $this->form_validation->set_rules('lastName', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('recaptcha_response_field', 'Captcha', 'callback_recaptcha_response_field_check');

        //--------------------------------------------------------------------
        // IF SUCCESSFUL - Send a confirmation email with a nice message - add record to message table.
        //--------------------------------------------------------------------
        if ($this->form_validation->run()){
        // send user a confirmation email
        $mail = new GCEmail ($this->config->item('email'));
        $mail->send($this->input-post('email'), $this->config->item('email')['contact_form_subject'], $body);        

        // add record to contact table
        $postValues = $this->filter($this->input->post());
        $data = array(
            'firstName' => $postValues['firstName'],
            'lastName' => $postValues['lastName'],
            'email' => $postValues['email'],
            'phone' => $postValues['phone'],
            'question' => $postValues['question'],
            'status' => 0,
            'created_at' => date("Y-m-d H:i:s")
        );
        $this->contact_model->insert($data);
				$data = array(
	          'content' => 'modules/pages/home',
	          'contact' => $this->defaultSettings(),
	          'path' => '/',
	          'captcha' => recaptcha_get_html($this->config->item('recaptcha_public')),
						'contact_success' => 'Your message was successfully sent'
	      );
		    $this->load->view($this->config->item('theme_home'), $data);
    		
        // $this->session->set_flashdata('message', $this->config->item('email')['contact_form_message']);
        // redirect();
        }else{

            $contact = new stdClass();
            $contact->firstName = $this->input->post('firstName');
            $contact->lastName = $this->input->post('lastName');
            $contact->email = $this->input->post('email');
            $contact->phone = $this->input->post('phone');
            $contact->question = $this->input->post('question');
            $data['contact'] = $contact;
            $data['error_messages'] = $this->form_validation->_error_array;
            $data['path'] = '/#contact';
            $data['captcha'] = recaptcha_get_html($this->config->item('recaptcha_public'));
            $data['content'] = 'modules/pages/home';
            $this->load->view($this->config->item('theme_home'), $data);
        }

    }

    public function error_404_get(){
        $data = array(
            'content' => 'modules/pages/404'
        );
        $this->load->view($this->config->item('theme_full_width'),$data);
    }

    public function about_get(){
        $data = array(
            'content' => 'modules/pages/about'
        );
        $this->load->view($this->config->item('theme_full_width'),$data);
    }

    public function policies_get(){
        $data = array(
            'content' => 'modules/pages/policies'
        );
        $this->load->view($this->config->item('theme_full_width'),$data);
    }

    public function location_get(){
        $data = array(
            'content' => 'modules/pages/location'
        );
        $this->load->view($this->config->item('standard-page'),$data);
    }
    
    public function dividends_get() {
      $data = array(
          'content' => 'modules/pages/dividends'
      );
      $this->load->view($this->config->item('theme_full_width'),$data);      
    }

    public function faq_get(){
        $data = array(
            'content' => 'modules/pages/faq'
        );
        $this->load->view($this->config->item('standard-page'),$data);
    }

    public function resources_get(){
        $data = array(
            'content' => 'modules/pages/resources'
        );
        $this->load->view($this->config->item('theme_full_width'),$data);
    }

    public function order_get(){
        $data = array(
            'content' => 'modules/pages/order'
        );
        $this->load->view($this->config->item('theme_full_width'),$data);
    }

    public function source_get(){
        $data = array(
            'content' => 'modules/pages/source'
        );
        $this->load->view($this->config->item('theme_full_width'),$data);
    }

    public function whoweare_get(){
        $data = array(
            'content' => 'modules/pages/whoweare'
        );
        $this->load->view($this->config->item('theme_full_width'),$data);
    }    
        
		public function xml_post() {
			
			if (!isset($_POST['request'])) {
				die('No request detected.');
			} else {
        
				
				$request = str_replace('?&gt;', '?>', str_replace('&lt ?', '<?',$_POST['request']));
				$request = str_replace('versi', 'version="1.0"', $request);
				$request = str_replace('Versi', 'Version="1.0"', $request);
				$request = str_replace("?><REQUEST", "?>\n<REQUEST", $request);
				$request = str_replace('encoding "UTF-8"', 'encoding="UTF-8"', $request);
				
        
        $filename = APP_PATH . '/orders/thub.request.' . time() . '.xml';
        
        // debug
        file_put_contents($filename, $request);        

				$xml = simplexml_load_string($request);
				$command = $xml->Command;
				if ($command != 'GetOrders') {
					die('Action not supported.');
				}
				$userID = $xml->UserID;
				$Password = $xml->Password;
				$downloadStartDate = $xml->DownloadStartDate;
				// $account = $this->user_model->get_by('email', "'$userID'");
        
			  // $pass = new PasswordHash(8, false);
			
      	if (($userID != 'w9MUrXn7U4tbEM2x') || ($Password != '2A9w5]IG}bh_HbayAxpRScoJBk3BT')) {
					$xml = new DOMDocument( "1.0", "UTF-8" );

		      $response = $xml->appendChild($xml->createElement('RESPONSE'));
					$attribute = $xml->createAttribute('Version');
					// Value for the created attribute
					$attribute->value = '2.8';
		     	// Don't forget to append it to the element
					$response->appendChild($attribute);

		 			$envelope = $response->appendChild($xml->createElement('Envelope'));

		      $command = $envelope->appendChild($xml->createElement('Command'));
		      $command->appendChild($xml->createCDATASection('GetOrders'));

					$status_code = $envelope->appendChild($xml->createElement('StatusCode'));
		      $status_code->appendChild($xml->createCDATASection('9000'));
					$xml->formatOutput = true;
					$xml->save($filename);
					header('Content-Type: text/xml');
					$output = file_get_contents($filename);
					echo $output;
					die();
		
				}
				
			}
			
			$order_ids = $this->order_model->getUnsyncedOrders($downloadStartDate);

			if ($order_ids) {
				
				$data = array();
				
				foreach ($order_ids as $orderID) {
					$order_id = (string) $orderID->id;
					$orderInfo = $this->order_model->getView($order_id, true);
		      $practitioner = $this->user_model->getProfile($orderInfo->user_id);
		      $shippingInfo = $this->order_model->getShippingDetailsRaw($order_id);
		      $paymentInfo = $this->order_model->getPaymentDetails($order_id);
		      $formulaInfo = $this->formula_model->getView($orderInfo->formula_id, true);
		      $patientInfo = $this->patient_model->getPatientProfile($orderInfo->patient_id);

		      $data[] = array(
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


				}
				

				
			} else {
        // $data = 0;
        $data = array(); // ?
			}
			
      $result = $this->order_model->markAsSynced($order_ids);
						
			$orderBuilder = new OrderBuilder();
      $order_filename = $orderBuilder->createThubXML($data);
      $output = file_get_contents($order_filename);
			echo $output;
			die();
			
		}


		    /**
		     * @param $captcha
		     * @return bool
		     * @todo Move this to a helper file.
		     */

		    public function recaptcha_response_field_check($captcha)
		    {

		        $resp = recaptcha_check_answer($this->config->item('recaptcha_private'), $_SERVER["REMOTE_ADDR"], $this->input->post('recaptcha_challenge_field'), $captcha);

		        if (!$resp->is_valid) {
		// What happens when the CAPTCHA was entered incorrectly
		            $this->form_validation->set_message('recaptcha_response_field_check', 'The Captcha entered was incorrect.');
		            return FALSE;
		        } else {
		            return TRUE;
		        }
		    }

		    protected function defaultSettings()
		    {
		        $contact = new stdClass();
		        $contact->firstName = '';
		        $contact->lastName = '';
		        $contact->email = '';
		        $contact->phone = '';
		        $contact->question = '';
		        return $contact;
		    }

		    protected function responseSettings()
		    {
		        $response = new stdClass();
		        $response->subject = '';
		        $response->response = '';
		        return $response;
		    }

		    /**
		     * @param $input
		     * @return array|bool
		     * @todo add to a helper file
		     */
		    protected function filter($input){

		        if(is_array($input) AND !empty($input)  ){

		            foreach($input as $key => $value){
		                $input[$key] = trim(strip_tags($value));
		            }

		            return $input;

		        }else{
		            return FALSE;
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