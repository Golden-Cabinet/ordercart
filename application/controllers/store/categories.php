<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'REST_Controller.php';

class Categories extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('product_model', 'category_model'));
        $this->load->library(array('form_validation', 'Authentication', 'cart', 'Pagination'));
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
            'content' => 'modules/store/categories/categories',
        );

        $pagination = new CI_Pagination();

        $config['base_url'] = base_url('store/categories');
        $config['total_rows'] = $this->db->count_all('categories');
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

        $data["categories"] = $this->category_model->fetch_categories($config["per_page"], $page);

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
            'title' => 'Add Category',
            'content' => 'modules/store/categories/form',
            'path' => 'store/categories/add',
            'categories' => $this->category_model->get_all(),
            'category' => $this->category_model->defaultSettings(),
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

        $post = $this->category_model->filter($this->input->post());

        if ($post) {
            $this->category_model->insert($post);
            $this->session->set_flashdata('message', $post['name'] . 'has been added,');
            redirect('store/categories');
        } else {
            redirect('store/categories/add');
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
                'title' => 'Edit Category',
                'path' => 'store/categories/edit',
                'content' => 'modules/store/categories/form',
                'category' => $this->category_model->get($this->uri->segment(4)),
                'categories' => $this->category_model->get_all(),
                'mode' => 'edit'
            );

            $this->load->view($this->config->item('standard-page'), $data);

        } else {
            $this->session->set_flashdata('message', 'Unable to find the category requested. Please try again.');
            redirect('store/categories');
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

        $post = $this->category_model->filter($this->input->post());

        if ($post) {
            $this->category_model->update($this->input->post('id'),$post);
            $this->session->set_flashdata('message', $post['name'] . 'has been edited,');
            redirect('store/categories');
        } else {

            $data = array(
                'title' => 'Edit Category',
                'path' => 'store/categories/edit',
                'content' => 'modules/store/categories/form',
                'category' => $this->category_model->get($this->input->post('id')),
                'categories' => $this->category_model->get_all(),
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
            redirect('store/categories');
        }

        $this->category_model->delete($this->uri->segment(4));

        $this->session->set_flashdata('message', 'The category has been deleted.');

        redirect('store/categories');
    }

} 