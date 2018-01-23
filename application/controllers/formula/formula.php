<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'REST_Controller.php';

class formula extends REST_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('formula_model','product_model','formula_ingredient_model'));
        $this->load->library(array('form_validation', 'Authentication','Pagination'));
    }

    public function index_get()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }
        
        $data = array(
            'content' => 'modules/formula/formulas',
        );

        $pagination = new CI_Pagination();

        $config['base_url'] = base_url('formulas');
        $config['total_rows'] = $this->db->count_all('formulas');
        if(!$this->authentication->is_admin()){
          $config['per_page'] = 20000;
        }else {
          $config['per_page'] = 10000;
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

        $data["formulas"] = $this->formula_model->fetch_formulas($config["per_page"], $page);

        $data["links"] = $pagination->create_links();

        if (!$this->session->flashdata('message') == FALSE) {
            $data['message'] = $this->session->flashdata('message');
        }
        
        $data['is_admin'] = $this->authentication->is_admin();
        $session = $this->session->all_userdata();
        $data['currentUserId'] = $session['user_data'];

        $this->load->view($this->config->item('standard-page'), $data);
    }

    public function add_get()
    {
        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        $data = array(
            'title' => 'Add Formula',
            'content' => 'modules/formula/form',
            'path' => 'formulas/add',
            'formula' => $this->formula_model->defaultSettings(),
            'mode' => 'add',
            'is_admin' => $this->authentication->is_admin()
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

        if (!$this->authentication->is_admin()) {
            redirect();
        }

        $post = $this->formula_model->filter($this->input->post());

        if ($post) {
            $this->formula_model->insert($post);
            $this->session->set_flashdata('message', $post['name'] . 'has been added,');
            redirect('formulas');
        } else {
            redirect('formulas/add');
        }

    }

    public function delete_get()
    {

        if ($this->uri->segment(3) == FALSE) {
            redirect('formulas');
        }

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        if (!$this->formula_model->isMyFormula($this->uri->segment(3))) {
            redirect('formulas');
        }

        $this->formula_model->delete($this->uri->segment(3));

        $this->session->set_flashdata('message', 'The formula has been deleted.');

        redirect('formulas');

    }

    public function build_get()
    {
        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        $data = array(
            'title' => 'Build Formula',
            'content' => 'modules/formula/build-formula',
            'path' => 'formulas/build',
            'formula' => $this->formula_model->defaultSettings(),
            'mode' => 'build',
            'products' =>$this->product_model->getProductsJson()
        );

        if (!$this->session->flashdata('message') == FALSE) {
            $data['message'] = $this->session->flashdata('message');
        }

        $this->load->view($this->config->item('formula'), $data);

    }

    public function build_post()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        //--------------------------------------------------------------------
        // Get all Ingredients
        //--------------------------------------------------------------------
        $ingredients = $this->formula_model->getIngredients($this->input->post());
        //--------------------------------------------------------------------
        // Add formula name and record to the formulas table
        //--------------------------------------------------------------------
        $session = $this->session->all_userdata();
        $currentUserID = $session['user_data'];
        $this->db->insert('formulas', array(
          'name' => $this->input->post('formula_name') , 
          'user_id' => $currentUserID,
          'creator_id' => $currentUserID));          
        $formulaID = $this->db->insert_id();
        //--------------------------------------------------------------------
        // add ingredients to the formula_ingredients table
        //--------------------------------------------------------------------
        $ingredientsForTheFormula = $this->formula_model->prepIngredients($ingredients,$formulaID);
        $this->db->insert_batch('formula_ingredients', $ingredientsForTheFormula);

        redirect('formulas');

    }

    public function view_get()
    {
      
        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }


        if (!$this->uri->segment(3) === FALSE) {

            $formulaInfo = $this->formula_model->getView($this->uri->segment(3));            
            $session = $this->session->all_userdata();

					  $data = array(
                'title' => 'Formula',
                'path' => 'formulas/edit',
                'content' => 'modules/formula/formula-view',
                'formula' => $formulaInfo['formula'],
                'cost' => number_format($formulaInfo['cost'],2),
                'ingredients' => $formulaInfo['ingredients'],
                'mode' => 'view',
                'is_admin' => $this->authentication->is_admin(),
                'currentUserId' => $session['user_data'],
                'ratio' => isset($_GET['ratio']) ? $_GET['ratio'] : 1
            );

						if (isset($_GET['hide'])) {
							$data['hide']=true;
						} else {
							$data['hide']=false;
						}

            if ($formulaInfo) {
              $this->load->view($this->config->item('standard-page'), $data);              
            }else{
              $this->session->set_flashdata('message', 'Unable to find the formula requested. Please try again.');
              redirect('formulas');              
            }
            
        } else {
            $this->session->set_flashdata('message', 'Unable to find the formula requested. Please try again.');
            redirect('formulas');
        }
    }

    public function edit_get()
    {
        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

				if (isset($_GET['duplicate'])) {
					$formulaInfo = $this->formula_model->getView($this->uri->segment(3));
          $ingredients = $formulaInfo['ingredients'];
	        //--------------------------------------------------------------------
	        // Add formula name and record to the formulas table
	        //--------------------------------------------------------------------
	        $session = $this->session->all_userdata();
	        $currentUserID = $session['user_data'];
					$formula_name = $formulaInfo['formula']->name . ' (Duplicate)';
	        $this->db->insert('formulas', array('name' => $formula_name , 'user_id' => $currentUserID));
	        $formulaID = $this->db->insert_id();
	        //--------------------------------------------------------------------
	        // add ingredients to the formula_ingredients table
	        //--------------------------------------------------------------------
	        $ingredientsForTheFormula = $this->formula_model->prepIngredients($ingredients,$formulaID);
	        $this->db->insert_batch('formula_ingredients', $ingredientsForTheFormula);
				}

        if (!$this->uri->segment(3) === FALSE) {
					
						if (isset($formulaID)) {
							$formulaInfo = $this->formula_model->getView($formulaID);
							
						} else {
							$formulaInfo = $this->formula_model->getView($this->uri->segment(3));
	            
						}
						
            $data = array(
                'title' => 'Formula',
                'path' => 'formulas/edit/'.$formulaInfo['formula']->id,
                'content' => 'modules/formula/edit-build-formula',
                'formula' => $formulaInfo['formula'],
                'cost' => $formulaInfo['cost'],
                'ingredients' => $formulaInfo['ingredients'],
                'mode' => 'edit',
                'products' =>$this->product_model->getProductsJson()
            );

            $this->load->view($this->config->item('formula'), $data);

        } else {
            $this->session->set_flashdata('message', 'Unable to find the formula requested. Please try again.');
            redirect('formulas');
        }
    }

    public function edit_post()
    {

        if (!$this->authentication->is_logged_in()) {
            redirect('login');
        }

        //--------------------------------------------------------------------
        // check is current users formula or the user is admin
        //--------------------------------------------------------------------

        if (!$this->formula_model->isMyFormula($this->input->post('id'))) {
            redirect('formulas');
        }


        // update formula


        //--------------------------------------------------------------------
        // Update formula name
        //--------------------------------------------------------------------
        $this->formula_model->update( $this->input->post('id') , array('name' => $this->input->post('formula_name')));
        //--------------------------------------------------------------------
        // Get all Ingredients
        //--------------------------------------------------------------------
        $ingredients = $this->formula_model->getIngredients($this->input->post());
        //--------------------------------------------------------------------
        // Delete original Ingredients for the formula
        //--------------------------------------------------------------------
        $this->formula_ingredient_model->delete_by( 'formula_id', $this->input->post('id'));
        //--------------------------------------------------------------------
        // cycle through ingredients - Build array for batch insert
        //--------------------------------------------------------------------
        $ingredientsForTheFormula = $this->formula_model->prepIngredients( $ingredients , $this->input->post('id') );
        $this->db->insert_batch('formula_ingredients', $ingredientsForTheFormula);


        // $this->session->set_flashdata('message', 'The Formula has been updated.');
        // $url = 'formulas/edit/' . $this->input->post('id');
        // redirect($url);
				redirect('/formulas/');
    }
    
    public function share_get($formula)
    {
        if (!$this->authentication->is_logged_in() || !$this->authentication->is_admin()) {
            redirect('login');
        }
        
        $session = $this->session->all_userdata();
        $currentUserId = $session['user_data'];        

        $formulas = $this->db->select("formulas.*, users.firstName, users.lastName")->from("formulas")->where(array("formulas.deleted" => 0))->join("users", "users.id=user_id")->order_by("name", "asc")->where("formulas.user_id = $currentUserId")->get()->result();
        $users = $this->db->query("SELECT * FROM users WHERE id != $currentUserId ORDER BY firstname ASC")->result();
        
        // Build a list of *already shared* formulas.
        // This was a little tricky and ultimately better served by a separate table.
        // $shared_formulas = $this->db->query("SELECT * FROM formulas WHERE id IN (SELECT DISTINCT reference_id  FROM formulas WHERE creator_id=$currentUserId AND reference_id IS NOT NULL)")->result();
        
        $shared_formulas = $this->db->query("SELECT *, count(*) as shares FROM formulas WHERE creator_id=$currentUserId AND reference_id IS NOT NULL GROUP BY reference_id")->result();

        $data = array(
          'formulas' => $formulas,
          'shared_formulas' => $shared_formulas,
          'users' => $users,
          'content' => 'modules/formula/share',
          'selected_formula' => $formula
        );

        $this->load->view($this->config->item('formula'), $data);        
    }      
    
    public function share_post() {
      if (!$this->authentication->is_logged_in() || !$this->authentication->is_admin()) {
          redirect('login');
      }
      
			$formulas = $this->input->post('formulas');
			$users = $this->input->post('users');
      
      foreach ($formulas as $formula) {
        // pull the formula data and clear the ID and associated user ID
        $formula_data = $this->db->select("formulas.*")->from("formulas")->where(array("formulas.deleted" => 0, "formulas.id" => $formula))->get()->row();      
        $formula_data->reference_id = $formula_data->id;
        $formula_data->id = null;
        $formula_data->user_id = null;
        
        $formula_ingredients = $this->formula_model->getIngredientsByFormulaRaw($formula);
          
        // insert formula into table and associate with practitioner
        // we're sharing the formula with.
        foreach ($users as $user_id) {
          $formula_data->user_id = $user_id;
          $this->formula_model->insert($formula_data);
          $formula_id = $this->db->insert_id();
          
          // update ingredients
          $formula_ingredients_copy = array();
          foreach ($formula_ingredients as $ingredient) {
            $ingredient->id = null;
            $ingredient->formula_id = $formula_id;            
            array_push($formula_ingredients_copy, $ingredient);
          }          
          $this->db->insert_batch('formula_ingredients', $formula_ingredients);          
        }
      }
      
      redirect('/formulas/share');      
    
    }
    
    public function unshare_get($formula)
    {
        if (!$this->authentication->is_logged_in() || !$this->authentication->is_admin()) {
            redirect('login');
        }
        
        // delete the associated referenced formulas and ingredients when this
        // formula as shared.
        $deleted_ingredients = $this->db->query("DELETE FROM formula_ingredients WHERE formula_id in (SELECT id FROM formulas WHERE reference_id=$formula);");
        $deleted_formulas =  $this->db->query(" DELETE FROM formulas WHERE reference_id=$formula;");
                
        redirect('/formulas/share');
    }

    public function checkname_post() {
	    if (!$this->authentication->is_logged_in()) {
           redirect('login');
       }

			$name_check = $this->formula_model->checkFormulaName($this->input->post('formula_name'),$this->input->post('formula_id'));
			print_r($name_check);
			die();
		}

    public function getFormulaCost_post(){

        if($this->input->post('formula_id') == FALSE){
            redirect();
        }else{
           echo $this->formula_model->getFormulaPrice($this->input->post('formula_id'));
           die();
        }

    }
    
    public function getFormulaIngredients_post() {

      if($this->input->post('formula_id') == FALSE){
          redirect();
      }else{
         echo json_encode($this->formula_model->getIngredientsByFormula($this->input->post('formula_id')));
         die();
      }
    
    }

    public function getShippingCost_post(){

        if($this->input->post('formula_id') == FALSE){
            redirect();
        }else{
          
            $ratio = $this->input->post('ratio') ? $this->input->post('ratio') : 1;
            $ingredients = $this->formula_model->getIngredientsByFormulaRaw($this->input->post('formula_id'));
            echo $this->formula_model->getShippingCost($ingredients, $ratio);
            die();
        }

    }


} 