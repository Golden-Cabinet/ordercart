<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'REST_Controller.php';

class Products extends REST_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('product_model','product_type_model', 'category_model', 'brand_model'));
        $this->load->library(array('form_validation', 'Authentication', 'cart', 'Pagination'));
    }


    public function index_get()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        $data = array(
            'content' => 'modules/store/products/products',
        );

        $pagination = new CI_Pagination();

        $config['base_url'] = base_url('store/products');
        $config['total_rows'] = $this->db->count_all('products');
        $config['per_page'] = 20;
        $config['num_links'] = 20;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);
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

        $data["products"] = $this->product_model->fetch_products(2000, 1);

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

        if (!$this->authentication->is_admin()) {
            redirect();
        }


        $data = array(
            'title' => 'Add Product',
            'content' => 'modules/store/products/form',
            'path' => 'store/products/add',
            'categories' => $this->category_model->get_all(),
            'brands' => $this->brand_model->get_all(),
            'productTypes' => $this->product_type_model->get_all(),
            'product' => $this->product_model->defaultSettings(),
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

        if (!$this->authentication->is_admin()) {
            redirect();
        }

        $post = $this->product_model->filter($this->input->post());

        if ($post) {
            $this->product_model->insert($post);
            $this->session->set_flashdata('message', $post['common_name'] . 'has been added,');
            redirect('store/products');
        } else {
            redirect('store/products/add');
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
                'title' => 'Edit Product',
                'path' => 'store/products/edit',
                'content' => 'modules/store/products/form',
                'product' => $this->product_model->get($this->uri->segment(4)),
                'productTypes' => $this->product_type_model->get_all(),
                'brands' => $this->brand_model->get_all(),
                'mode' => 'edit'
            );

            $this->load->view($this->config->item('standard-page'), $data);

        } else {
            $this->session->set_flashdata('message', 'Unable to find the product requested. Please try again.');
            redirect('store/products');
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

        $post = $this->product_model->filter($this->input->post());

        if ($post) {
            $this->product_model->update($this->input->post('id'),$post);
            $this->session->set_flashdata('message', $post['latin_name'] . 'has been edited,');
            redirect('store/products');
        } else {

            $data = array(
                'title' => 'Edit Product',
                'path' => 'store/products/edit',
                'content' => 'modules/store/products/form',
                'product' => $this->product_model->get($this->input->post('id')),
                'brands' => $this->brand_model->get_all(),
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
            redirect('store/products');
        }

        $this->product_model->delete($this->uri->segment(4));

        $this->session->set_flashdata('message', 'The product has been deleted.');

        redirect('store/products');

    }

    public function getByCategory()
    {

    }

    public function getById()
    {

    }

    public function category_get()
    {

        if($this->uri->segment(4) === FALSE){

            $records = $this->db->count_all('products');

        }else{

            $query = $this->db->get_where('product_types',array('name' => $this->uri->segment(4), 'deleted' => 0 ));
            $category = '';
            foreach($query->result() as $row){

                $category = $row;

            }
            $this->db->where('type_id',$category->id);
            $query = $this->db->get('products');
            $records = $query->num_rows();
        }


        $data = array(
            'content' => 'modules/store/products/products-category',
        );

        $pagination = new CI_Pagination();

        $config['base_url'] = base_url('store/products/category') . '/' .$category->name ;
        $config['total_rows'] = $records;
        $config['per_page'] = 20;
        $config["uri_segment"] = 5;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);
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

        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

        $data["products"] = $this->product_model->fetchByCategory($category->id,$config["per_page"], $page);

        $data["links"] = $pagination->create_links();

        if (!$this->session->flashdata('message') == FALSE) {
            $data['message'] = $this->session->flashdata('message');
        }

        $this->load->view($this->config->item('standard-page'), $data);

    }




}