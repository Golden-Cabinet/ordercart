<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @package      CodeIgniter Admin
 * @author       Danny Nunez
 * @copyright    Copyright (c) 2013 - 2014 Danny Nunez
 * @since        Version 0.1
 * @filesource
 */
// ------------------------------------------------------------------------


require APPPATH . 'libraries' . DIRECTORY_SEPARATOR . 'REST_Controller.php';
require APPPATH . 'third_party' . DIRECTORY_SEPARATOR . 'recaptchalib.php';
require APPPATH . 'third_party' . DIRECTORY_SEPARATOR . 'PasswordHash.php';
require SYSDIR . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'Email.php';

class Users extends REST_Controller
{

    function __construct()
    {

        parent::__construct();

        $this->load->model(array('user_model', 'address_model', 'address_type_model', 'state_model', 'login_attempt_model', 'gc_session_model', 'role_model'));
        $this->load->library(array('form_validation', 'Authentication', 'Pagination'));


    }

    public function index_get()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        if(!$this->authentication->is_admin()){
            redirect();
        }

        $data = array(
            'content' => 'modules/users/users',
        );

        $pagination = new CI_Pagination();

        $config['base_url'] = base_url('settings/users');
        $config['total_rows'] = $this->db->count_all('users');
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

        $data["users"] = $this->user_model->fetch_users($config["per_page"], $page);

        $data["links"] = $pagination->create_links();

        if (!$this->session->flashdata('message') == FALSE) {
            $data['message'] = $this->session->flashdata('message');
        }

        $this->load->view($this->config->item('standard-page'), $data);

    }

    public function edit_get()
    {



        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        if (!$this->authentication->is_admin()) {
            redirect();
        }



        if (!$this->uri->segment(4) === FALSE) {
            $data = array(
                'path' => 'settings/users/edit',
                'content' => 'modules/users/profile',
                'user' => $this->user_model->getProfile($this->uri->segment(4)),
                'states' => $this->state_model->get_all(),
                'status' => array('Inactive' => 0, 'Active' => 1),
                'roles' => $this->role_model->get_all(),
                'mode' => 'edit'
            );

            $this->load->view($this->config->item('standard-page'), $data);

        } else {
            $this->session->set_flashdata('message', 'Unable to find the user. Please try again.');
            redirect('users');
        }

    }

    public function edit_Post()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        //--------------------------------------------------------------------
        // Form Validation Rules
        //--------------------------------------------------------------------

        $this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required');
        $this->form_validation->set_rules('license_state', 'License State', 'required');
        $this->form_validation->set_rules('bstate', 'Billing State', 'required');
        $this->form_validation->set_rules('shstate', 'Shipping State', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_emailEdit_check');

        if($this->input->post('update_password') == 'yes'){

            $this->form_validation->set_rules('password', 'Password', 'callback_password_check');
            $this->form_validation->set_rules('passConf', 'Password Confirmation', 'required');

        }

        //--------------------------------------------------------------------
        //  If the the validation returns true and the user data and the email account does not exist add new user.
        //--------------------------------------------------------------------

        $emailCheck = $this->user_model->updateEmailCheck($this->input->post('email'),$this->input->post('user_id'));

        if ($this->form_validation->run() === TRUE AND $emailCheck === FALSE || ($emailCheck === TRUE && $this->input->post('update_password') === 'yes')) {

            $user = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'email' => $this->input->post('email'),
                'area_code' => $this->input->post('area_code'),
                'phone' => $this->input->post('phone'),
                'license_state' => $this->input->post('license_state'),
                'status' => $this->input->post('status'),
                'role_id' => $this->input->post('role_id')
            );

            if($this->input->post('update_password') == 'yes'){
                $pass = new PasswordHash(8, FALSE);
                $salt = random_string('sha1', 12);
                $user['password'] = $pass->HashPassword($this->input->post('password') . $salt);
                $user['salt'] = $salt;
            }

            //-----------------------------------------------------
            //  update user record
            //-----------------------------------------------------


            $this->user_model->update($this->input->post('user_id'), $user);

            //-----------------------------------------------------
            //  update user address
            //-----------------------------------------------------


            $billingAddress = array(
                'user_id' => $this->input->post('user_id'),
                'addressType' => 1,
                'street' => $this->input->post('bstreetAddress'),
                'city' => $this->input->post('bcity'),
                'state_id' => $this->input->post('bstate'),
                'zip' => $this->input->post('bzip'),
            );

            $shippingAddress = array(
                'user_id' => $this->input->post('user_id'),
                'addressType' => 2,
                'street' => $this->input->post('shstreetAddress'),
                'city' => $this->input->post('shcity'),
                'state_id' => $this->input->post('shstate'),
                'zip' => $this->input->post('shzip'),
            );

            // If the setting for "Use billign address as shipping" has changed
            // we'll catch that here.
            
            $billing_record_id = $this->input->post('billing_record_id');
            $shipping_record_id = $this->input->post('shipping_record_id');
            
            if ($this->input->post('billShippingSame') == 'yes') {
              $shippingAddress = $billingAddress;
              $shippingAddress['addressType'] = 2;
            }

            $this->address_model->update($this->input->post('billing_record_id'), $billingAddress);
            $this->address_model->update($this->input->post('shipping_record_id'), $shippingAddress);
          
            $this->session->set_flashdata('message', 'Profile has been updated');
            
            // if we're activating the user send the activation email (but don't send this *every* time we update their account)            
            if ($this->input->post('status') == 1 && $user['status'] != 1) {
              $message = "
                <p>Congratulations!</p>

                <p>Your online account with</p>
                
                <p><img src='".base_url('assets/images/logo.png')."' alt=''/></p>
                
                <p>is now active.</p>
                
                <p>You are now able to log in to your own personal Chinese Medicine Cabinet <a href='https://goldencabinetherbs.com'>here</a>. We think you will find the tools provided to be valuable assets when managing your patients' herbal prescriptions. This website will make it easy to add new patients and formulas to your Cabinet.* You can then create new orders using your saved patient profiles and previously written formulas. You will always have access to any formula you have created through our website, as it will be saved in your ever-expanding formula repertoire. It's time to start stocking your Cabinet!

                <p>*Students may only write formulas for personal use</p>
                
                <p>All the best,<br />
                The Golden Cabinet Team</p>";

              $mail = new GCEmail ($this->config->item('email'));
              $mail->send($this->input->post('email'), 'User Account Information', $message);
            }

            redirect('settings/users');

        } else {

            $user = $this->user_model->getProfile($this->input->post('user_id'));
            $user->firstName = $this->input->post('firstName');
            $user->lastName = $this->input->post('lastName');
            $user->email = $this->input->post('email');
            $user->area_code = $this->input->post('area_code');
            $user->phone = $this->input->post('phone');
            $user->license_state = $this->input->post('license_state');
            $user->status = $this->input->post('status');
            $user->role_id = $this->input->post('role_id');
            $user->bstreetAddress = $this->input->post('bstreetAddress');
            $user->bcity = $this->input->post('bcity');
            $user->bstate = $this->input->post('bstate');
            $user->bzip = $this->input->post('bzip');
            $user->shstreetAddress = $this->input->post('shstreetAddress');
            $user->shcity = $this->input->post('shcity');
            $user->shstate = $this->input->post('shstate');
            $user->shzip = $this->input->post('shzip');
            
						$error_messages = $this->form_validation->_error_array;

            if( $emailCheck === TRUE && !$this->input->post('update_password')) $error_messages['email_exists'] = 'The email address entered was invalid or already exists.';

            $data = array(
                'error_messages' => $error_messages,
                'path' => 'settings/users/edit',
                'content' => 'modules/users/profile',
                'user' => $user,
                'states' => $this->state_model->get_all(),
                'status' => array('Inactive' => 0, 'Active' => 1),
                'roles' => $this->role_model->get_all(),
                'mode' => 'edit'
            );

            $this->load->view($this->config->item('standard-page'), $data);
        }

    }


    public function add_get()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        $data = array(
            'path' => 'settings/users/add',
            'content' => 'modules/users/add_user',
            'user' => $this->user_model->defaultSettings(),
            'states' => $this->state_model->get_all(),
            'status' => array('Inactive' => 0, 'Active' => 1),
            'roles' => $this->role_model->get_all(),
            'mode' => 'add'
        );

        $this->load->view($this->config->item('standard-page'), $data);

    }

    public function add_post()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        //--------------------------------------------------------------------
        // Form Validation Rules
        //--------------------------------------------------------------------

        $this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'callback_password_check');
        $this->form_validation->set_rules('passConf', 'Password Confirmation', 'required');

        //--------------------------------------------------------------------
        //  If the the validation returns true and the user data and the email account does not exist add new user.
        //--------------------------------------------------------------------

        $emailCheck = $this->user_model->emailExists($this->input->post('email'));

        if ($this->form_validation->run() === TRUE AND $emailCheck === FALSE) {
            $pass = new PasswordHash(8, FALSE);
            $salt = random_string('sha1', 12);

            $user = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'email' => $this->input->post('email'),
                'area_code' => $this->input->post('area_code'),
                'phone' => $this->input->post('phone'),
                'license_state' => $this->input->post('license_state'),
                'status' => $this->input->post('status'),
                'role_id' => $this->input->post('role_id'),
                'password' => $pass->HashPassword($this->input->post('password') . $salt),
                'salt' => $salt,
                'created_at' => date("Y-m-d H:i:s")
            );

            //-----------------------------------------------------
            //  insert new user
            //-----------------------------------------------------


            $this->user_model->insert($user);
            $userID = $this->db->insert_id();

            //-----------------------------------------------------
            //  insert new address
            //-----------------------------------------------------

            $addresses = array();

            $billingAddress = array(
                'user_id' => $userID,
                'addressType' => 1,
                'street' => $this->input->post('bstreetAddress'),
                'city' => $this->input->post('bcity'),
                'state_id' => $this->input->post('bstate'),
                'zip' => $this->input->post('bzip'),
            );


            if ($this->input->post('optionsRadios') == 'option1') {
                $shippingAddress = $billingAddress;
                $shippingAddress['addressType'] = 2;
            } else {
                $shippingAddress = array(
                    'user_id' => $userID,
                    'addressType' => 2,
                    'street' => $this->input->post('shstreetAddress'),
                    'city' => $this->input->post('shcity'),
                    'state_id' => $this->input->post('shstate'),
                    'zip' => $this->input->post('shzip'),
                );
            }
            $addresses = array();
            $addresses[] = $billingAddress;
            $addresses[] = $shippingAddress;
            $this->db->insert_batch('address', $addresses);

            //-----------------------------------------------------
            //  Send new user and email
            //-----------------------------------------------------

            if ($this->input->post('notify') == 'yes') {
                $this->notifyUser($this->input->post('password'), $this->input->post('email'));
            }

            $this->session->set_flashdata('message', 'The new user has been added.');

            redirect('settings/users');

        } else {
	
            $user = new stdClass();
            $user->firstName = $this->input->post('firstName');
            $user->lastName = $this->input->post('lastName');
            $user->email = $this->input->post('email');
            $user->area_code = $this->input->post('area_code');
            $user->phone = $this->input->post('phone');
            $user->license_state = $this->input->post('license_state');
            $user->status = $this->input->post('status');
            $user->role_id = $this->input->post('role_id');
            $user->bstreetAddress = $this->input->post('bstreetAddress');
            $user->bcity = $this->input->post('bcity');
            $user->bstate = $this->input->post('bstate');
            $user->bzip = $this->input->post('bzip');
            $user->shstreetAddress = $this->input->post('shstreetAddress');
            $user->shcity = $this->input->post('shcity');
            $user->shstate = $this->input->post('shstate');
            $user->shzip = $this->input->post('shzip');

            $error_messages = $this->form_validation->_error_array;

            if( $emailCheck === TRUE){
                $error_messages['email_exists'] = 'The email address entered was invalid or already exists.';
            }
            $data = array(
                'error_messages' => $error_messages,
                'path' => 'settings/users/edit',
                'content' => 'modules/users/add_user',
                'user' => $user,
                'states' => $this->state_model->get_all(),
                'status' => array('Inactive' => 0, 'Active' => 1),
                'roles' => $this->role_model->get_all(),
                'mode' => 'add'
            );

            $this->load->view($this->config->item('standard-page'), $data);
        }


    }


    public function login_get()
    {

        //--------------------------------------------------------------------
        // Check if user login is allowed
        //--------------------------------------------------------------------

        if (!$this->config->item('user_login')) {
            redirect('/dashboard/');
        }

        //-------------------------------------------------------------------
        //  Add error message if being redirected by database error see $this->login_post
        //-------------------------------------------------------------------

        if (!$this->session->flashdata('message') == FALSE) {
            $data['message'] = $this->session->flashdata('message');
        }

        $data['path'] = 'users/login';
        $data['content'] = 'modules/users/login';
        $this->load->view($this->config->item('theme_home'), $data);
    }

    public function login_post()
    {

        //--------------------------------------------------------------------
        // Check if user registration is allowed 
        //--------------------------------------------------------------------

        if (!$this->config->item('user_login')) {
            redirect('/');
        }

        //--------------------------------------------------------------------
        //  Redirect if post is empty
        //--------------------------------------------------------------------

        if ($this->input->post(NULL, TRUE) === false) {
            redirect('/');
        }

        //--------------------------------------------------------------------
        //  Check User Name and Password
        //-------------------------------------------------------------------- 

        $results = $this->authentication->verifyLogin($this->input->post(NULL, TRUE));

        if ($results['result'] === false OR $results === false) {
            $account = $results['account'];
            //$this->login_attempt_model->loginAttempt($account->id, $this->session->all_userdata(), $results['result']);
            $this->session->set_flashdata('message', $this->config->item('user_login_error_message'));
            redirect('login');

        } else {
            $account = $results['account'];
            $session_data = array(
                'user_data' => $account->id,
            );

            //--------------------------------------------------------------------
            //  set session data 
            //--------------------------------------------------------------------

            $this->session->set_userdata($session_data);

            //------------------------------------------------------------------------------
            //  Check Permissions - Redirect to appropriate location
            //------------------------------------------------------------------------------
            // update the login_attempts database record


            $this->login_attempt_model->loginAttempt($account->id, $this->session->all_userdata(), $results['result']);

            //------------------------------------------------------------------------------
            //  Check Permissions - Redirect to appropriate location
            //------------------------------------------------------------------------------
            //$groups = $this->authentication->usergroups(); 
            // redirect to the user profile page
            // $this->session->set_flashdata('message', 'Welcome back ' . ucfirst($account->firstName) . '.');
            // $data = array(
            //     'content' => 'modules/pages/home'
            // );
            // 
            // $this->load->view($this->config->item('theme_home'),$data);
						redirect('/dashboard/');


        }
    }

    public function logout_get()
    {
        $session = $this->session->all_userdata();
        $loginInfo = $this->login_attempt_model->get_ActiveLogin($session['user_data']);
        $this->login_attempt_model->deactivate($loginInfo->id);
        // delete cookie and record in session table
        $this->gc_session_model->delete($session['session_id']);
        // send to the homepage
        redirect();
    }

    public function forgot_password_get()
    {
      if ($this->authentication->is_logged_in()) {
          // redirect('dashboard');
      }

			$data = array(
          'content' => 'modules/users/forgot-password',	 
          'path' => '/'
      );

      $this->load->view($this->config->item('standard-page'),$data);        
    }
    
    // Find email, create the reset nonce and send an email
    public function reset_password_post($token) {
        if (!$token) {
        $this->form_validation->set_rules('email', 'Email', 'callback_email_check');      
        if ($this->form_validation->run() == TRUE && $this->user_model->emailExists($email) == FALSE) {

          $token= chunk_split( bin2hex(openssl_random_pseudo_bytes(32)), 12 );
          $token = trim(preg_replace("/\r\n/", "-", $token, 5));
          $timestamp = time();
          $email = $this->input->post('email');
          $user_id = $this->db->query("SELECT id from users WHERE email='$email'")->row()->id;
          $this->db->query("DELETE FROM password_resets WHERE user_id=$user_id");
          $result = $this->db->query("INSERT INTO password_resets(date, user_id, token) VALUES($timestamp, $user_id, '$token')");

          if ($result) {
            $message ="
              <p>We've sent you a link you can use to reset the password for your account with Golden Cabinet Herbs. Follow the link below or copy and paste it into your browser:</p>
              <p><a href='https://goldencabinetherbs.com/reset-password/$token'>https://goldencabinetherbs.com/reset-password/$token</a></p>
              <p><strong>NOTE:</strong> If you did not initiate a password reset do <em>not</em> follow the reset link and please <a href='https://goldencabinetherbs.com/contact'>contact us</a> immediately.</p>
              <p>Thanks,<br />
              The Golden Cabinet Team</p>
            ";
            $mail = new GCEmail ($this->config->item('email'));
            $mail->send($email, 'Golden Cabinet Herbs Password Reset', $message);          
            redirect('/?message=reset_message');
          }else{
          
          }
        }else{
          sleep(1000);
    			$data = array(
              'content' => 'modules/users/forgot-password',
              'message' => 'The email you entered was invalid',
              'path' => '/'
          );
        
          $this->load->view($this->config->item('standard-page'),$data);                
        }
      }else{
        // Do the actual password reset      
        // only allow for 24 hours
        $user = $this->db->query("SELECT * FROM users WHERE id IN (SELECT user_id FROM password_resets WHERE token='$token' AND (UNIX_TIMESTAMP() - date) <= 86400)")->row();
        $this->form_validation->set_rules('password', 'Password', 'callback_password_check');
        $this->form_validation->set_rules('passConf', 'Password Confirmation', 'required');

        if ($user) {
          // render an interface to change the password by        
    			$data = array(
              'content' => 'modules/users/reset-password',
              'message' => "",
              'path' => '/'
          );        

          if ($this->form_validation->run() && $this->input->post('password') == $this->input->post('passConf')) {
            
            // Update with new password
            // Delete the entry in password_reset table
            $pass = new PasswordHash(8, FALSE);
            $new_salt = random_string('sha1', 12);;
            $new_password = $pass->HashPassword($this->input->post('password') . $new_salt);
                        
            $update_result = $this->db->query("UPDATE users SET password=?, salt=? WHERE id=?", array($new_password, $new_salt, $user->id));
            $remove_reste = $this->db->query("DELETE FROM password_resets WHERE user_id=?", array($user->id));
              
            redirect("/login?message=password_reset");
          }else{
            $data['message'] = "Make sure your password confirmation matches <strong>and</strong> that your password contains at least 1 uppercase letter and 1 number.";
            $data['content'] = "modules/users/reset-password";
          }
          
          $this->load->view($this->config->item('standard-page'),$data);                        
          
        }else{
          // incorrect key or time elapsed
    			$data = array(
              'content' => 'modules/users/reset-password-timeout',
              'message' => 'The email you entered was invalid',
              'path' => '/'
          );        
          $this->load->view($this->config->item('standard-page'),$data);                        
        }            
      }
      
    }
    
    public function reset_password_get($token) {
      if (!$token) redirect("/");
      // only allow for 24 hours
      $user = $this->db->query("SELECT * FROM users WHERE id IN (SELECT user_id FROM password_resets WHERE token='$token' AND (UNIX_TIMESTAMP() - date) <= 86400)")->row();
      
      if ($user) {        
        // render an interface to change the password by
  			$data = array(
            'content' => 'modules/users/reset-password',
            'path' => '/'
        );
        
        $this->load->view($this->config->item('standard-page'),$data);                        
      }else{
        // incorrect key or time elapsed
  			$data = array(
            'content' => 'modules/users/reset-password-timeout',
            'message' => 'The email you entered was invalid',
            'path' => '/'
        );
        
        $this->load->view($this->config->item('standard-page'),$data);                        
      }
    }
        

    public function register_get($code)
    {

        //--------------------------------------------------------------------
        // Check if user registration is allowed 
        //--------------------------------------------------------------------

        if (!$this->config->item('registration_status')) {
            redirect('/');
        }

        //-----------------------------------------------------------------------------------------------------------------
        //  Add error message if being redirected by database error see $this->register_post
        //-----------------------------------------------------------------------------------------------------------------

        if ($this->uri->segment(2) === 'error') {
            $data = array('error_message' => $this->config->item('user_reg_error_message'));
        }

        $data['user'] = $this->user_model->defaultSettings();

        $data['path'] = 'register';
        $data['captcha'] = recaptcha_get_html($this->config->item('recaptcha_public'));
        if (!$code) {
	        $data['content'] = 'modules/users/register';
        }else{
			$data['content'] = 'modules/users/register-beta';
        }
        
        $data['states'] = $this->state_model->get_all();

        $this->load->view($this->config->item('standard-page'), $data);
    }

    public function register_post()
    {
      
        $verifyGoogleCaptcha = new GoogleInvisibleCaptcha();            

        if (!$verifyGoogleCaptcha->verify()) {
          redirect('/login');
        }
      
        //--------------------------------------------------------------------
        // Check if user registration is allowed
        //--------------------------------------------------------------------

        if (!$this->config->item('registration_status')) {
            redirect('/');
        }

        //--------------------------------------------------------------------
        // Form Validation Rules
        //--------------------------------------------------------------------

        $this->form_validation->set_rules('email', 'Email', 'callback_email_check');
        $this->form_validation->set_rules('password', 'Password', 'callback_password_check');
        $this->form_validation->set_rules('passConf', 'Password Confirmation', 'required');

        //--------------------------------------------------------------------
        //  If the the validation returns true and the user data and the email account does not exist add new user. 
        //--------------------------------------------------------------------

				$email = sprintf($this->input->post('email'));

        if ($this->form_validation->run() == TRUE && $this->user_model->emailExists($email) == FALSE) {
            $pass = new PasswordHash(8, FALSE);
            $salt = random_string('sha1', 12);
            $newUser = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'email' => $this->input->post('email'),
                'license_state' => $this->input->post('license_state'),
                'area_code' => $this->input->post('area_code'),
                'phone' => $this->input->post('phone'),
                'salt' => $salt,
                'password' => $pass->HashPassword($this->input->post('password') . $salt),
                'created_at' => date("Y-m-d H:i:s"),
            );

            //-----------------------------------------------------
            //  Insert New User
            //-----------------------------------------------------


            $this->user_model->insert($newUser);

            $userID = $this->db->insert_id();
		        $practitioner = $this->user_model->getProfile($userID);
		      	$this->user_model->sendConfirmationEmail($practitioner);

            // set billing address

            $billingAddress = array(
                'user_id' => $userID,
                'addressType' => 1,
                'street' => $this->input->post('bstreetAddress'),
                'city' => $this->input->post('bcity'),
                'state_id' => $this->input->post('bstate'),
                'zip' => $this->input->post('bzip'),
            );

            // Check to see if user want to use billing address for shipping address.

            if ($this->input->post('optionsRadios') == 'option1') {
                $shippingAddress = $billingAddress;
                $shippingAddress['addressType'] = 2;
            } else {
                $shippingAddress = array(
                    'user_id' => $userID,
                    'addressType' => 2,
                    'street' => $this->input->post('shstreetAddress'),
                    'city' => $this->input->post('shcity'),
                    'state_id' => $this->input->post('shstate'),
                    'zip' => $this->input->post('shzip'),
                );
            }

            $this->address_model->insert($billingAddress);
            $this->address_model->insert($shippingAddress);

            $this->session->set_flashdata('message', $this->config->item('registration_message'));

            redirect('/?message=registration_success');

        } else {
        
            $user = new stdClass();
            $user->firstName = $this->input->post('firstName');
            $user->lastName = $this->input->post('lastName');
            $user->email = $this->input->post('email');
            $user->area_code = $this->input->post('area_code');
            $user->phone = $this->input->post('phone');
            $user->license_state = $this->input->post('license_state');
            $user->status = $this->input->post('status');
            $user->role_id = $this->input->post('role_id');
            $user->bstreetAddress = $this->input->post('bstreetAddress');
            $user->bcity = $this->input->post('bcity');
            $user->bstate = $this->input->post('bstate');
            $user->bzip = $this->input->post('bzip');
            $user->shstreetAddress = $this->input->post('shstreetAddress');
            $user->shcity = $this->input->post('shcity');
            $user->shstate = $this->input->post('shstate');
            $user->shzip = $this->input->post('shzip');

            $data['user'] = $user;
            $data['error_messages'] = $this->form_validation->_error_array;
						if ($this->user_model->emailExists($user->email)===TRUE) {
							$data['error_messages'] = array('email_exists'=>'This email is already in use. Please use a different email address.');
						}
            $data['path'] = 'register';
            $data['captcha'] = recaptcha_get_html($this->config->item('recaptcha_public'));
            $data['content'] = 'modules/users/register-beta';
            $data['states'] = $this->state_model->get_all();
            $this->load->view($this->config->item('standard-page'), $data);

        }


    }

//-------------------------END register_post()-------------------------------------------//


    public function delete_get()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        if ($this->uri->segment(4) == FALSE) {
            redirect('settings/users');
        }

        $this->user_model->delete($this->uri->segment(4));

        $this->session->set_flashdata('message', 'The user has been deleted.');

        redirect('settings/users');

    }

    public function editProfile_get(){

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        $session = $this->session->all_userdata();



        $user = $this->user_model->getProfile($session['user_data']);


        if($user){

            $data = array(
                'path' => 'users/editProfile',
                'content' => 'modules/users/userProfile',
                'user' => $user,
                'states' => $this->state_model->get_all(),
                'mode' => 'edit'
            );

            $this->load->view($this->config->item('standard-page'), $data);

        } else {
            $this->session->set_flashdata('message', 'Unable to find the user. Please try again.');
            redirect("/dashboard");
        }



    }


    public function editProfile_Post()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        //--------------------------------------------------------------------
        // Form Validation Rules
        //--------------------------------------------------------------------

        $this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_emailEdit_check');

        if($this->input->post('update_password') == 'yes'){

        $this->form_validation->set_rules('password', 'Password', 'callback_password_check');
        $this->form_validation->set_rules('passConf', 'Password Confirmation', 'required');

        }

        //--------------------------------------------------------------------
        //  If the the validation returns true and the user data and the email account does not exist add new user.
        //--------------------------------------------------------------------

        if ($this->form_validation->run() == TRUE) {

            $user = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'email' => $this->input->post('email'),
                'area_code' => $this->input->post('area_code'),
                'phone' => $this->input->post('phone'),
                'license_state' => $this->input->post('license_state'),
            );

            if($this->input->post('update_password') == 'yes'){
                $pass = new PasswordHash(8, FALSE);
                $salt = random_string('sha1', 12);
                $user['password'] = $pass->HashPassword($this->input->post('password') . $salt);
                $user['salt'] = $salt;
            }

            //-----------------------------------------------------
            //  update user record
            //-----------------------------------------------------


            $this->user_model->update($this->input->post('user_id'), $user);

            //-----------------------------------------------------
            //  update user address
            //-----------------------------------------------------


            $billingAddress = array(
                'user_id' => $this->input->post('user_id'),
                'addressType' => 1,
                'street' => $this->input->post('bstreetAddress'),
                'city' => $this->input->post('bcity'),
                'state_id' => $this->input->post('bstate'),
                'zip' => $this->input->post('bzip'),
            );



            $shippingAddress = array(
                'user_id' => $this->input->post('user_id'),
                'addressType' => 2,
                'street' => $this->input->post('shstreetAddress'),
                'city' => $this->input->post('shcity'),
                'state_id' => $this->input->post('shstate'),
                'zip' => $this->input->post('shzip'),
            );

            // If billing or shipping record IDs are zero
            // that means they were never created. Need to create
            // and associate with profile.
            
            if($this->input->post('billing_record_id') == 0) {
              $this->address_model->insert($billingAddress);
            }

            if($this->input->post('shipping_record_id') == 0) {
              $this->address_model->insert($shippingAddress);
            }

            $this->address_model->update($this->input->post('billing_record_id'), $billingAddress);
            $this->address_model->update($this->input->post('shipping_record_id'), $shippingAddress);

            $this->session->set_flashdata('message', 'Profile has been updated');

            redirect("/dashboard");

        } else {

            $user = new stdClass();
            $user->firstName = $this->input->post('firstName');
            $user->lastName = $this->input->post('lastName');
            $user->email = $this->input->post('email');
            $user->area_code = $this->input->post('area_code');
            $user->phone = $this->input->post('phone');
            $user->license_state = $this->input->post('license_state');
            $user->bstreetAddress = $this->input->post('bstreetAddress');
            $user->bcity = $this->input->post('bcity');
            $user->bstate = $this->input->post('bstate');
            $user->bzip = $this->input->post('bzip');
            $user->shstreetAddress = $this->input->post('shstreetAddress');
            $user->shcity = $this->input->post('shcity');
            $user->shstate = $this->input->post('shstate');
            $user->shzip = $this->input->post('shzip');

            $data = array(
                'error_messages' => $this->form_validation->_error_array,
                'path' => 'users/editProfile',
                'content' => 'modules/users/userProfile',
                'user' => $user,
                'states' => $this->state_model->get_all(),
                'status' => array('Inactive' => 0, 'Active' => 1),
                'roles' => $this->role_model->get_all(),
                'mode' => 'edit'
            );

            $this->load->view($this->config->item('standard-page'), $data);
        }

    }


//--------------------------------------------------------------------
// Form Validation Callbacks
//--------------------------------------------------------------------

    public function firstName_check($firstName)
    {

        if ($firstName == '') {
            $this->form_validation->set_message('firstName_check', 'Your first name is required.');
            return FALSE;
        }

        if ($this->form_validation->alpha($firstName)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('firstName_check', 'Your first name may only contain alphabetical characters.');
            return FALSE;
        }
    }

    public function lastName_check($lastName)
    {

        if ($lastName == '') {
            $this->form_validation->set_message('lastName_check', 'Your last name is required.');
            return FALSE;
        }

        if ($this->form_validation->alpha($lastName)) {
            return true;
        } else {
            $this->form_validation->set_message('lastName_check', 'Your last name may only contain alphabetical characters.');
            return FALSE;
        }
    }

    public function password_check()
    {

// verify the password is not empty

        if ($this->input->post('password') == '') {
            $this->form_validation->set_message('password_check', 'The password field is required.');
            return FALSE;
        }

// Verify the password match the password confirmation field       
        if ($this->input->post('password') === $this->input->post('passConf') && $this->valid_pass($this->input->post('password')) === true) {
            return true;
        } else {
            $this->form_validation->set_message('password_check', 'Your password did not meet the minimum requirements or did not match the password confirmation field.');
            return FALSE;
        }
    }

    /**
     *
     * @param string $candidate
     * @return boolean
     */
    public function valid_pass($candidate)
    {

        if (strlen($this->input->post('password') > 72)) {
            return FALSE;
        }

        $r1 = '/[A-Z]/'; //Uppercase
        $r4 = '/[0-9]/'; //numbers

        if (preg_match_all($r1, $candidate, $o) < 1)
            return FALSE;

        if (preg_match_all($r4, $candidate, $o) < 1)
            return FALSE;

        if (strlen($candidate) < 8)
            return FALSE;

        return TRUE;
    }

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

    public function email_check($email)
    {

// verify the email field is not empty

        if ($this->input->post('email') == '') {
            $this->form_validation->set_message('email_check', 'The email field is required.');
            return FALSE;
        }

// verify a valid email was entered

        if ($this->form_validation->valid_email($email)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('email_check', 'The email address entered was invalid or already exists.');
            return FALSE;
        }
    }

    public function callback_emailEdit_check()
    {
        if($this->user_model->updateEmailCheck()){
            return TRUE;
        }else{
            $this->form_validation->set_message('emailEdit_check', 'The email address entered was invalid or already exists.');
            return FALSE;
        }
    }

    protected function notifyUser($password, $email_address)
    {

        $message = "
          <p>Thank you for registering with Golden Cabinet Herbal Pharmacy!</p>

          <h4><strong>Please read below for important information regarding your account activation</strong></h4>

          <p>Online accounts are available to licensed practitioners and students of accredited Chinese Medicine colleges</p>

          <p><strong>Current Customers</strong></p>

          <p>If you are already a Golden Cabinet customer, no action is required on your part. We will use your name to find you in our system and activate your online account shortly</p>

          <p><strong>New Practitioner Customers</strong></p>

          <p>If you are practitioner who has not previously established an account with us, we will attempt to verify your credentials through your state’s licensing board. If we are unable to verify your credentials, we will contact you for more information via the email address or phone number you've provided</p>

          <p><strong>New Student Customers</strong></p>

          <p>If you are a student who has not previously established an account with us, please send us a copy of your student ID or a current transcript to verify your enrollment. You can send it to <a href='mailto:orders@goldencabinetherbs.com'>orders@goldencabinetherbs.com</a> or fax it to (888) 958-0782</p>

          <p>You will receive an email once your account is active. We will attempt to approve your account within 24 business hours. If you need your approval expedited, please feel free to call us at (503) 233-4102. Thank you and have a wonderful day!</p>

          <p>All the best,<br />
          The Golden Cabinet Team</p>";

        $mail = new GCEmail ($this->config->item('email'));
        $mail->send($email_address, 'User Account Information', $message);        
        
    }



}
