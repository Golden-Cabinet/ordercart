<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'REST_Controller.php';

class productTypes extends REST_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('product_type_model'));
        $this->load->library(array('form_validation', 'Authentication','Pagination'));
    }

    public function index_get()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        if (!$this->authentication->is_admin()) {
            redirect();
        }

        $data = array(
            'content' => 'modules/store/product-types/product-types',
        );

        $pagination = new CI_Pagination();

        $config['base_url'] = base_url('store/product-types');
        $config['total_rows'] = $this->db->count_all('product_types');
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

        $data["productTypes"] = $this->product_type_model->fetch_categories($config["per_page"], $page);

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

        $data = array(
            'title' => 'Add Product Type',
            'content' => 'modules/store/product-types/form',
            'path' => 'store/product-types/add',
            'productType' => $this->product_type_model->defaultSettings(),
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

        $post = $this->product_type_model->filter($this->input->post());

        if ($post) {
            $this->product_type_model->insert($post);
            $this->session->set_flashdata('message', $post['name'] . 'has been added,');
            redirect('store/product-types');
        } else {
            redirect('store/product-types/add');
        }

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
                'title' => 'Edit Product Type',
                'path' => 'store/product-types/edit',
                'content' => 'modules/store/product-types/form',
                'productType' => $this->product_type_model->get($this->uri->segment(4)),
                'mode' => 'edit'
            );

            $this->load->view($this->config->item('standard-page'), $data);

        } else {
            $this->session->set_flashdata('message', 'Unable to find the category requested. Please try again.');
            redirect('store/product-types');
        }
    }

    public function edit_post()
    {
        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        if (!$this->authentication->is_admin()) {
            redirect();
        }

        $post = $this->product_type_model->filter($this->input->post());

        if ($post) {
            $this->product_type_model->update($this->input->post('id'),$post);
            $this->session->set_flashdata('message', $post['name'] . 'has been edited,');
            redirect('store/product-types');
        } else {

            $data = array(
                'title' => 'Edit Category',
                'path' => 'product-types/edit',
                'content' => 'modules/store/product-types/form',
                'productType' => $this->product_type_model->get($this->input->post('id')),
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

        if (!$this->authentication->is_admin()) {
            redirect();
        }

        if ($this->uri->segment(4) == FALSE) {
            redirect('store/product-types');
        }

        $this->product_type_model->delete($this->uri->segment(4));

        $this->session->set_flashdata('message', 'The product type has been deleted.');

        redirect('store/product-types');

    }

} 