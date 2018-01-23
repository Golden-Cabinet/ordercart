<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR .'REST_Controller.php';
require SYSDIR . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR .'Email.php';
require APPPATH . 'third_party' . DIRECTORY_SEPARATOR . 'recaptchalib.php';

class Testing extends REST_Controller
{

    function __construct()
    {

        parent::__construct();

        //$this->load->model(array('auth_model'));
        $this->load->model(array('contact_model', 'order_model', 'formula_model', 'user_model', 'login_attempt_model', 'role_model'));
        $this->load->helper(array('form', 'url','email'));
        $this->load->library(array('form_validation','Authentication', 'OrderBuilder', 'email'));

    }
    
    public function index_get() {
      $mail = new GCEmail ($this->config->item('email'));
      $mail_result = $mail->send("george.mandis@gmail.com", "PHPMailer Test test " . time(), "<p>This is my message</p>");
      
      if ($mail_result) {
        echo "Sent!";
      }else{
        echo "No send.";
        print_r($mail_result);
      }
    }


} 