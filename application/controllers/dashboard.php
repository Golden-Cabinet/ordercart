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

class Dashboard extends REST_Controller
{

    function __construct()
    {

        parent::__construct();

        $this->load->model(array('dashboard_model', 'address_model', 'address_type_model', 'state_model', 'login_attempt_model', 'gc_session_model', 'role_model'));
        $this->load->library(array('form_validation', 'Authentication', 'Pagination'));

    }

    public function index_get()
    {
        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        // if(!$this->authentication->is_admin()){
        //     redirect('formulas');
        // }

        $data = array(
            'content' => 'modules/dashboard/dashboard',
        );
        $pagination = new CI_Pagination();

        $config['base_url'] = base_url('dashboard');
        $config['total_rows'] = $this->db->count_all('users');
        if(!$this->authentication->is_admin()){        
          $config['per_page'] = 500;
        }else {
          $config['per_page'] = 2000;
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

        $data["orders"] = $this->dashboard_model->fetch_dashboard_orders($config["per_page"], $page);
        $data["patients"] = $this->dashboard_model->fetch_dashboard_patients($config["per_page"], $page);
        $data["formulas"] = $this->dashboard_model->fetch_dashboard_formulas($config["per_page"], $page);

        $data["links"] = $pagination->create_links();

        if (!$this->session->flashdata('message') == FALSE) {
            $data['message'] = $this->session->flashdata('message');
        }

        $this->load->view($this->config->item('standard-page'), $data);

    }

}
