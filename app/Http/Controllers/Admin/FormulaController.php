<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Formula;

class FormulaController extends Controller
{
    protected $roleArray = ['2','3','4'];
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            return redirect()->route('dashboardindex');
        }
        
        $formulas = new Formula;
        if(\Auth::user()->user_roles_id == 2)
        {
            $getFormulas = $formulas->adminFormulas();
        }

        if(\Auth::user()->user_roles_id == 3)
        {
            $getFormulas = $formulas->practitionerFormulas();
        }

        if(\Auth::user()->user_roles_id == 4)
        {
            $getFormulas = $formulas->studentFormulas();
        }

        $results = [
            'formulas' => $getFormulas
        ];

        return view('dashboard.formulas.index',$results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            return redirect()->route('dashboardindex');
        }
        
        return view('dashboard.formulas.create'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            return redirect()->route('dashboardindex');
        }
        
        $formulas = new Formula;        
        
        return redirect()->route('formulasindex')->with('status', 'Formula Created!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            return redirect()->route('dashboardindex');
        }
    }

    /**
     * Duplicate the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate($id)
    {
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            return redirect()->route('dashboardindex');
        }
        
        $formula = new Formula;
        $getFormula = $formula::find($id);

        $result = [
            'result' => $getFormula,
        ];
        
        return view('dashboard.formulas.duplicate', $result); 
    }

    /**
     * Share the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function share($id)
    {
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            return redirect()->route('dashboardindex');
        }
        
        $formula = new Formula;
        $getFormula = $formula::find($id);

        $result = [
            'result' => $getFormula,
        ];
        
        return view('dashboard.formulas.duplicate', $result); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            return redirect()->route('dashboardindex');
        }
        
        $formula = new Formula;
        $getFormula = $formula::find($id);

        $result = [
            'result' => $getFormula,
        ];
        
        return view('dashboard.formulas.edit', $result); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            return redirect()->route('dashboardindex');
        }
        
        $formula = new Formula;
        $getFormula = $formula::find($id);

        return redirect()->route('formulasindex')->with('status', 'Formula Was Updated!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!in_array(\Auth::user()->user_roles_id,$this->roleArray))
        {
            return redirect()->route('dashboardindex');
        }
         return redirect()->route('formulasindex'); 
    }

    /**
     * ajax get functions to be built into laravel compatible
     * 
     */


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
}
