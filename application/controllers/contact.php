<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'REST_Controller.php';
require SYSDIR . DIRECTORY_SEPARATOR .  'libraries' . DIRECTORY_SEPARATOR . 'Email.php';
require APPPATH . 'third_party' . DIRECTORY_SEPARATOR . 'recaptchalib.php';

class Contact extends REST_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->model(array('contact_model'));
        $this->load->library(array('form_validation', 'Authentication' , 'Pagination'));

    }

    public function index_get()
    {

        $data = array(
            'contact' => $this->defaultSettings(),
            'path' => 'contact',
            'content' => 'modules/pages/contact',
            'captcha' => recaptcha_get_html($this->config->item('recaptcha_public'))
        );

        $this->load->view($this->config->item('theme_full_width'), $data);

    }

    public function index_post()
    {
        //--------------------------------------------------------------------
        // Form Validation Rules
        //--------------------------------------------------------------------
        
        $verifyGoogleCaptcha = new GoogleInvisibleCaptcha();        
        
        if ($verifyGoogleCaptcha->verify()) {

        $this->form_validation->set_rules('firstName', 'Username', 'required');
        $this->form_validation->set_rules('lastName', 'Password', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('question', 'Question', 'required');

        //--------------------------------------------------------------------
        // IF SUCCESSFUL - Send a confirmation email with a nice message - add record to message table.
        //--------------------------------------------------------------------
        if ($this->form_validation->run()){
        
        // send user a confirmation email
				$message = $this->config->item('email')['contact_form_message'];
				$message_body = str_replace('xxxlastxxx', $last, str_replace('xxxfirstxxx', $first, $message));

        $email = new GCEmail ($this->config->item('email'));        
        $email->send( $this->input->post('email'), "Thank you for contacting Golden Cabinet Herbs", $message_body );
        
        
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
        $this->session->set_flashdata('message', $this->config->item('email')['contact_form_message']);
        
        // Prep a copy of the message and send to Golden Cabinet
        $email_body = $data['firstName'] . " " . $data['lastName'] . "<br>" .$data['email'] . "<br>" . $data['phone'] . "<hr><br>" . $data['question'] . "<br>";
        $email->send("accounts@goldencabinetherbs.com", "New Contact Form Message from " . $data['firstName'] . " " . $data['lastName'] . "(" . $postValues['email'] . ")", $email_body);
        
        redirect();
        }else{

            $contact = new stdClass();
            $contact->firstName = $this->input->post('firstName');
            $contact->lastName = $this->input->post('lastName');
            $contact->email = $this->input->post('email');
            $contact->phone = $this->input->post('phone');
            $contact->question = $this->input->post('question');
            $data['contact'] = $contact;
            $data['error_messages'] = $this->form_validation->_error_array;
            $data['path'] = 'contact';
            $data['content'] = 'modules/pages/contact';
            $this->load->view($this->config->item('theme_full_width'), $data);
        }

      }else{
        redirect("/contact");
      }

    }

    public function messages_get(){

        if(!$this->authentication->is_logged_in()){
            redirect('login');
        }

        $data = array(
            'content' => 'modules/contact/messages',
        );


        $pagination = new CI_Pagination();

        $config['base_url'] = base_url('contact/messages');
        $config['total_rows'] = $this->db->count_all('contact_requests');
        $config['per_page'] = 20;
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
        $data["messages"] = $this->contact_model->fetch_messages($config["per_page"], $page);
        $data["links"] = $pagination->create_links();

        if(!$this->session->flashdata('message') == FALSE ){
            $data['message'] = $this->session->flashdata('message');
        }

        $this->load->view($this->config->item('theme_full_width'), $data);

    }

    public function message_get(){

        if(!$this->authentication->is_logged_in()){
            redirect('login');
        }

        if($this->uri->segment(3) == FALSE){
            redirect('contact/messages');
        }

        $data = array(
            'content' => 'modules/contact/message',
            'message' => $this->contact_model->get($this->uri->segment(3))
        );

        if(!$this->session->flashdata('message') == FALSE ){
            $data['message'] = $this->session->flashdata('message');
        }

        $this->load->view($this->config->item('theme_full_width'), $data);

    }

    public function respond_get(){

        if(!$this->authentication->is_logged_in()){
            redirect('login');
        }

        if($this->uri->segment(3) == FALSE){
            redirect('contact/messages');
        }

        $data = array(
            'path' => 'contact/respond',
            'response' => $this->responseSettings(),
            'content' => 'modules/contact/respond',
            'message' => $this->contact_model->get($this->uri->segment(3))
        );

        $this->load->view($this->config->item('theme_full_width'), $data);

    }

    public function respond_post(){

        if(!$this->authentication->is_logged_in()){
            redirect('login');
        }



        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('response', 'Response', 'required');

        if ($this->form_validation->run()){

            $mail = new GCEmail ($this->config->item('email'));
            $mail->send($this->input->post('email'), $this->input->post('subject'), $this->input->post('response'));

            $this->contact_model->update($this->input->post('message_id'), array('status' => 1));

            $this->session->set_flashdata('message', 'Email was successfully sent.');

            redirect('contact/messages');

        }else{

            $response = new stdClass();
            $response->subject = $this->input->post('subject');
            $response->response = $this->input->post('response');

            $data = array(
                'path' => 'respond',
                'response' => $response,
                'content' => 'modules/contact/respond',
                'error_messages' => $this->form_validation->_error_array,
                'message' => $this->contact_model->get($this->input->post('message_id'))
            );

            $this->load->view($this->config->item('theme_full_width'), $data);

        }

    }

    public function delete_get(){

        if(!$this->authentication->is_logged_in()){
            redirect('login');
        }

        if($this->uri->segment(3) == FALSE){
            redirect('contact/messages');
        }

        $this->contact_model->delete($this->uri->segment(3));

        $this->session->set_flashdata('message', 'The message was successfully deleted.');

        redirect('contact/messages');

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


} 