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
require SYSDIR . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'Email.php';

class Patients extends REST_Controller
{

    function __construct()
    {

        parent::__construct();

//      $this->load->helper();
        $this->load->model(array('patient_model', 'user_model', 'address_model', 'address_type_model', 'state_model', 'login_attempt_model', 'gc_session_model', 'role_model'));
        $this->load->library(array('form_validation', 'Authentication', 'Pagination'));
        
    }

    public function index_get()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        $data = array(
            'content' => 'modules/patients/patients',
        );

        $pagination = new CI_Pagination();

        $config['base_url'] = base_url('patients');
        $config['total_rows'] = $this->db->count_all('patients');
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

        $data["patients"] = $this->patient_model->fetch_patients($config["per_page"], $page);

        $data["links"] = $pagination->create_links();

        if (!$this->session->flashdata('message') == FALSE) {
            $data['message'] = $this->session->flashdata('message');
        }

        $this->load->view($this->config->item('standard-page'), $data);
    }

    public function view_get() {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        if (!$this->uri->segment(3) === FALSE AND $this->patient_model->is_client($this->uri->segment(3))) {

            $data = array(
                'title' => 'Edit Patient',
                'path' => 'patients/edit',
                'content' => 'modules/patients/patients-view',
                'patient' => $this->patient_model->getPatientProfile($this->uri->segment(3)),
                'mode' => 'view'
            );

            $this->load->view($this->config->item('standard-page'), $data);

        } else {
            $this->session->set_flashdata('message', 'Unable to find the patient requested. Please try again.');
            redirect('patients');
        }

    }

    public function add_get()
    {
        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        $data = array(
            'title' => 'Add Patient',
            'content' => 'modules/patients/form',
            'path' => 'patients/add',
            'patient' => $this->patient_model->defaultSettings(),
            'states' => $this->state_model->get_all(),
            'mode' => 'add'
        );

        if (!$this->session->flashdata('message') == FALSE) {
            $data['message'] = $this->session->flashdata('message');
        }

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

        //--------------------------------------------------------------------
        //  If the the validation returns true
        //--------------------------------------------------------------------

        // ----
        // Email not strictly required so only look for matches if it's *not* blank.
        // ----
        $unique_email = true;
        if ($this->input->post('email')) $unique_email = $this->patient_model->checkUniqueEmail($this->input->post('email'));

        if ($this->form_validation->run() && $unique_email === true) {

            $session = $this->session->all_userdata();

            $patient = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'email' => $this->input->post('email'),
                'area_code' => $this->input->post('area_code'),
                'phone' => $this->input->post('phone'),
                'created_at' => date("Y-m-d H:i:s"),
                'status' => $this->input->post('status'),
                'user_id' => $session['user_data']
            );

            //-----------------------------------------------------
            //  insert new patient
            //-----------------------------------------------------

            $this->patient_model->insert($patient);

            $patientID = $this->db->insert_id();

            //-----------------------------------------------------
            //  insert new address
            //-----------------------------------------------------

            $billingAddress = array(
                'patient_id' => $patientID,
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
                    'patient_id' => $patientID,
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

            $this->db->insert_batch('patientAddress', $addresses);

            $this->session->set_flashdata('message', $this->input->post('firstName') . ' ' . $this->input->post('lastName') . ' has been added,');

            redirect('patients');

        } else {

            $patient = new stdClass();
            $patient->firstName = $this->input->post('firstName');
            $patient->lastName = $this->input->post('lastName');
            $patient->email = $this->input->post('email');
            $patient->area_code = $this->input->post('area_code');
            $patient->phone = $this->input->post('phone');
            $patient->status = $this->input->post('status');
            $patient->bstreetAddress = $this->input->post('bstreetAddress');
            $patient->bcity = $this->input->post('bcity');
            $patient->bstate = $this->input->post('bstate');
            $patient->bzip = $this->input->post('bzip');
            $patient->shstreetAddress = $this->input->post('shstreetAddress');
            $patient->shcity = $this->input->post('shcity');
            $patient->shstate = $this->input->post('shstate');
            $patient->shzip = $this->input->post('shzip');

						if ($unique_email === false) {
							$error_messages = array('This email is already in use, please choose a unique email for this patient.');
						} else {
							$error_messages = $this->form_validation->_error_array;
						}

            $data = array(
                'error_messages' => $error_messages,
                'title' => 'Add Patient',
                'content' => 'modules/patients/form',
                'path' => 'patients/add',
                'patient' => $patient,
                'states' => $this->state_model->get_all(),
                'mode' => 'add'
            );

            $this->load->view($this->config->item('standard-page'), $data);

        }
    }

    public function edit_get()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        if (!$this->uri->segment(3) === FALSE AND $this->patient_model->is_client($this->uri->segment(3))) {

            $data = array(
                'title' => 'Edit Patient',
                'path' => 'patients/edit',
                'content' => 'modules/patients/form',
                'states' => $this->state_model->get_all(),
                'patient' => $this->patient_model->getPatientProfile($this->uri->segment(3)),
                'mode' => 'edit'
            );

            $this->load->view($this->config->item('standard-page'), $data);

        } else {
            $this->session->set_flashdata('message', 'Unable to find the patient requested. Please try again.');
            redirect('patients');
        }

    }

    public function edit_post()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        //--------------------------------------------------------------------
        // Form Validation Rules
        //--------------------------------------------------------------------

        $this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required');

        //--------------------------------------------------------------------
        //  If the the validation returns true
        //--------------------------------------------------------------------


        if ($this->form_validation->run() AND $this->patient_model->is_client($this->input->post('id'))) {

            $patient = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'email' => $this->input->post('email'),
                'area_code' => $this->input->post('area_code'),
                'phone' => $this->input->post('phone')
            );

            //-----------------------------------------------------
            //  update patient
            //-----------------------------------------------------

            $this->patient_model->update( $this->input->post('id') , $patient );

            //-----------------------------------------------------
            //  update address
            //-----------------------------------------------------

            $billingAddress = array(
                'patient_id' => $this->input->post('id'),
                'addressType' => 1,
                'street' => $this->input->post('bstreetAddress'),
                'city' => $this->input->post('bcity'),
                'state_id' => $this->input->post('bstate'),
                'zip' => $this->input->post('bzip'),
            );

            $this->db->where('id', $this->input->post('billing_record_id'));
            $this->db->update( 'patientAddress', $billingAddress );

            $shippingAddress = array(
                'patient_id' => $this->input->post('id'),
                'addressType' => 2,
                'street' => $this->input->post('shstreetAddress'),
                'city' => $this->input->post('shcity'),
                'state_id' => $this->input->post('shstate'),
                'zip' => $this->input->post('shzip'),
            );

            $this->db->where('id', $this->input->post('shipping_record_id'));
            $this->db->update( 'patientAddress', $shippingAddress );

            redirect('patients');

        } else {

            $patient = new stdClass();
            $patient->firstName = $this->input->post('firstName');
            $patient->lastName = $this->input->post('lastName');
            $patient->email = $this->input->post('email');
            $patient->area_code = $this->input->post('area_code');
            $patient->phone = $this->input->post('phone');
            $patient->status = $this->input->post('status');
            $patient->bstreetAddress = $this->input->post('bstreetAddress');
            $patient->bcity = $this->input->post('bcity');
            $patient->bstate = $this->input->post('bstate');
            $patient->bzip = $this->input->post('bzip');
            $patient->shstreetAddress = $this->input->post('shstreetAddress');
            $patient->shcity = $this->input->post('shcity');
            $patient->shstate = $this->input->post('shstate');
            $patient->shzip = $this->input->post('shzip');

            $error_messages = $this->form_validation->_error_array;

						print_r($error_messages);

            $data = array(
                'error_messages' => $error_messages,
                'title' => 'Edit Patient',
                'content' => 'modules/patients/form',
                'path' => 'patients/edit',
                'patient' => $patient,
                'states' => $this->state_model->get_all(),
                'mode' => 'edit'
            );

            $this->load->view($this->config->item('standard-page'), $data);

        }
    }

    public function delete_get()
    {
      if (!$this->authentication->is_logged_in()) {
          redirect('login');
      }

      if ( $this->patient_model->is_client($this->uri->segment(3)) == FALSE ) {
          redirect('patients');
      }

      $this->patient_model->delete($this->uri->segment(3));


      $this->session->set_flashdata('message', 'The patient has been deleted.');

      redirect('patients');
    }
    
    public function reactivate_get() {
      if (!$this->authentication->is_logged_in()) {
          redirect('login');
      }

      if ( $this->patient_model->is_client($this->uri->segment(3)) == FALSE ) {
          redirect('patients');
      }

      $this->patient_model->reactivate($this->uri->segment(3));


      $this->session->set_flashdata('message', 'The patient has been reactivated.');

      redirect('patients');
      
    }


}
