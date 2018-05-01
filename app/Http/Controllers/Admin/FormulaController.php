<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Formula;
use App\Product;
use App\Brand;

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

        $getProducts = new Product;
        $products = $getProducts::where('deleted','!=',1)->orderBy('pinyin','asc')->get();
      
        $brand = new Brand; 
        
        foreach($products as $product)
        {
            $ingredient[] = [
                'id' => $product->id,
                'name' => html_entity_decode($product->pinyin),
                'concentration' => $product->concentration,
                'brand' => $brand::getBrandName($product->brands_id),
                'costPerGram' =>$product->costPerGram
            ];
        }
        
            $results = [
                'formulas' => $ingredient
            ];
        
        return view('dashboard.formulas.create',$results); 
    }

    public function autocomplete($product,$brand)
    {       
               
        $results = array();

        $getBrand = new Brand;
        $brand = $getBrand::where('name',$brand)->first();

        
        $ingredient = \DB::table('products')
            ->where('pinyin', $product)
            ->where('brands_id',$brand->id)
            ->where('deleted','!=',1)
            ->get();

        $result = [
            'ingredient' => $ingredient
        ];
        return response()->json($result);
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

        $formula = new Formula;
        $formula->name = $request->formula_name;
        $formula->data = $request->formulaData;
        $formula->users_id = \Auth::user()->id;
        $formula->save();
       
        
        return redirect()->route('formulasindex')->with('success', $request->formula_name.' Created!'); 
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

        $newFormula = new Formula;

        // create a new record 
        $newFormula->name = $getFormula->name.' - '.\Auth::user()->name;
        $newFormula->data = $getFormula->data;
        $newFormula->users_id = $getFormula->users_id;
        $newFormula->save();

        //redirect to new edit screen  
        return redirect()->action(
            'Admin\FormulaController@edit', ['id' => $newFormula->id]
        );
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
        
        //table view stuff
        $getProducts = new Product;
        $products = $getProducts::where('deleted','!=',1)->orderBy('pinyin','asc')->get();

        //overview stuff
        $getFormulas = new Formula;
        $formula = $getFormulas::find($id);
      
        $brand = new Brand; 
        
        foreach($products as $product)
        {
            $ingredient[] = [
                'id' => $product->id,
                'name' => $product->pinyin,
                'concentration' => $product->concentration,
                'brand' => $brand::getBrandName($product->brands_id),
                'costPerGram' =>$product->costPerGram
            ];
        }
        
        $currentFormulaIngredients = json_decode($formula->data);

        foreach($currentFormulaIngredients as $key)
        {
            $getInfo = $getProducts::find($key->product_id);
            $currentFormula[] = ['id' => $getInfo->id,'name' => $getInfo->pinyin,'cpg' => $getInfo->costPerGram,'current_grams' => $key->product_grams,'subtotal' => round($getInfo->costPerGram * $key->product_grams, 2)];
        }

            $results = [
                'formulaId' => $formula->id,
                'formulaName' => $formula->name,
                'formulaDeleted' => $formula->deleted,
                'formulaIngredients' => $currentFormula,
                'formulas' => $ingredient,
            ];

        return view('dashboard.formulas.edit', $results); 
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

        $formulas = new Formula;
        $formula = $formulas::find($id);
        $formula->name = $request->formula_name;
        $formula->data = $request->formulaData;
        $formula->users_id = \Auth::user()->id;
        $formula->save();
             
        return redirect()->route('formulasindex')->with('success', $request->formula_name.' Was Updated!'); 
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

        $getFormula = new Formula;
        $formula = $getFormula::find($id);

        $formula->deleted = 1;
        $formula->save();
         return redirect()->route('formulasindex')->with('success', $formula->name.' Was Deleted!'); ; 
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
