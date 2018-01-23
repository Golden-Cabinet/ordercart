<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class formula_model extends MY_Model
{

    protected $_table = 'formulas';
    protected $soft_delete = TRUE;

    public function __construct()
    {

        parent::__construct();
        $this->load->model(array('product_model'));

    }

    /**
     * @return stdClass
     */

    public function defaultSettings()
    {
        $formula = new stdClass();
        $formula->name = '';
        return $formula;
    }

    /**
     * @param $input
     * @return array|bool
     */

    public function filter($input)
    {

        if (is_array($input) AND !empty($input)) {

            foreach ($input as $key => $value) {
                $input[$key] = trim(strip_tags($value));
            }

            return $input;

        } else {
            return FALSE;
        }

    }

    /**
     * @param $limit
     * @param $start
     * @return array|bool
     */

    public function fetch_formulas($limit, $start)
    {

        $auth = new Authentication();

        if ($auth->is_admin()) {
            // $query = $this->db->get_where($this->_table, array('deleted' => 0), $limit, $start);
            $query = $this->db->select("formulas.*, users.firstName, users.lastName")->from($this->_table)->where(array("formulas.deleted" => 0))->join("users", "users.id=user_id")->limit($limit, $start)->get();
        } else {
            $session = $this->session->all_userdata();
            $currentUserID = $session['user_data'];
            $query = $this->db->get_where($this->_table, array('deleted' => 0, 'user_id' => $currentUserID), $limit, $start);
        }
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }

        } else {
					
						$data = array();
					
				}

        return $data;

    }

		public function checkFormulaName($formula_name, $formula_id) {
		  $session = $this->session->all_userdata();
      $currentUserID = $session['user_data'];
			if ($formula_id == 0) {
				$sql = "SELECT id FROM formulas WHERE name = '$formula_name' AND user_id = $currentUserID AND deleted = 0";
			} else {
				$sql = "SELECT id FROM formulas WHERE name = '$formula_name' AND user_id = $currentUserID AND deleted = 0 AND id != $formula_id";
			}
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return 1;
			} else {
				return 0;
				
			}
		}

    /**
     * @description - Used to parse the post array returned from the build form.
     * @param $data
     * @return array
     */

    public function getIngredients($data)
    {

        $ingredients = array();
        foreach ($data as $key => $row) {
            if (preg_match('/^product_id_row_/', $key)) {
                $this->db->where('id', trim($row));
                $query = $this->db->get('products');
                $result = $query->result();
                $weight = 'weight_' . str_replace("product_id_row_", "", trim($key));
                $result[0]->weight = $data[$weight];
                $ingredients[] = $result[0];
            }
        }

        return $ingredients;

    }

    /**
     * @description - Used to get all ingredients of a formula
     * @param Int - $formulaID
     * @return mixed - array of objects
     */

    public function getIngredientsByFormulaRaw($formulaID)
    {

        $ingredients = $this->db->get_where('formula_ingredients', array('formula_id' => $formulaID));
        return $ingredients->result();

    }

    /**
     * @description  Used to prepare a user friendly view of a formula.
     * @param int $formulaID - The id of the formulas
     * @return array array of objects to pass to the view
     */

    public function getIngredientsByFormula($formulaID)
    {

        $query = $this->db->get_where('formula_ingredients', array('formula_id' => $formulaID));

        $data = array();
        foreach ($query->result() as $row) {
            //--------------------------------------------------------------------
            // get ingredient info
            //--------------------------------------------------------------------

            $ingredientQry = $this->db->get_where('products', array('id' => $row->product_id));
            $ingredientInfo = $ingredientQry->result();
            $ingredient = $ingredientInfo[0];

            //--------------------------------------------------------------------
            // get brand info
            //--------------------------------------------------------------------

            $brand = $this->db->get_where('brands', array('id' => $ingredient->brand_id));
            $brandNameInfo = $brand->result();
            $brandName = $brandNameInfo[0];

            //--------------------------------------------------------------------
            // build nice array of objects to pass to the view
            //--------------------------------------------------------------------


            $values = new stdClass();
            $values->product_id = $row->product_id;
            $values->formula_id = $row->formula_id;
            $values->weight = $row->weight;
            $values->pinyin = $ingredient->pinyin;
            $values->latin_name = $ingredient->latin_name;
            $values->common_name = $ingredient->common_name;
            $values->concentration = $ingredient->concentration;
            $values->costPerGram = $ingredient->costPerGram;
            $values->brand_name = $brandName->name;

            $data[] = $values;

        }

        return $data;
    }

    /**
     * @param mixed[] $ingredients Array of object containing the ingredients of a formula.
     * @return array Array of Objects - added cost of ingredient based on the amount needed.
     */

    public function getIngredientCost($ingredients)
    {

        $cost = 0;

        //--------------------------------------------------------------------
        // get sub total for each ingredient of a recipe
        //--------------------------------------------------------------------

        $data = array();

        foreach ($ingredients as $row) {
						$rounded = money_format('%#1.2n',$row->costPerGram);
						$row->costPerGram = $rounded;
            $row->subtotal = money_format('%#1.2n',round($row->weight * $row->costPerGram, 2));

            $data[] = $row;

        }

        return $data;

    }

    /**
     * @param mixed[] $ingredients Array of object containing the ingredients of a formula.
     * @return string Cost of shipping based on weight.
     */

    public function getShippingCost($ingredients, $ratio=1)
    {

        $weight = 0;

        //--------------------------------------------------------------------
        // get shipping cost of a formula
        //--------------------------------------------------------------------

        foreach ($ingredients as $row) {

            $weight = $weight + ($row->weight * $ratio);
        }

        if($weight < 275){
            return "3.75";
        }else{
            return "7.00";
        }

    }


    /**
     * @param $ingredients
     * @return float|int
     */

    public function getFormulaCost($ingredients)
    {

        //--------------------------------------------------------------------
        // Get Sub Total of the recipe prior to any discounts
        //--------------------------------------------------------------------

        $cost = 0;

        foreach ($ingredients as $key => $ingredient) {
            $cost = money_format('%#1.2n',round($cost + $ingredient->subtotal, 2));
        }

        return $cost;

    }

    /**
     * @param $ingredients
     * @param $formulaID
     * @return array
     */

    public function prepIngredients($ingredients, $formulaID)
    {

        $data = array();

        foreach ($ingredients as $row) {

            $ingredient = array();
						if (!isset($row->product_id)) {
            	$ingredient['product_id'] = $row->id;
						} else {
							$ingredient['product_id'] = $row->product_id;
						}
            $ingredient['formula_id'] = $formulaID;
            $ingredient['weight'] = $row->weight;
            $data[] = $ingredient;

        }

        return $data;

    }

    /**
     * @param $formulaID
     * @return array
     */

    public function getView($formulaID, $xml = false)
    {

        $auth = new Authentication();

        if ($auth->is_admin() || $xml) {
            $query = $this->get_many_by(array('id' => $formulaID, 'deleted' => 0));
        } else {
            $session = $this->session->all_userdata();
            $currentUserID = $session['user_data'];
            $query = $this->get_many_by(array('id' => $formulaID, 'deleted' => 0, 'user_id' => $currentUserID));
        }

        $formula = $query[0];

        if ($formula) {
          $ingredients = $this->getIngredientCost($this->getIngredientsByFormula($formula->id));

          return array(
              'formula' => $formula,
              'ingredients' => $ingredients,
              'cost' => $this->getFormulaCost($ingredients)
          );          
        }else{
          return false;
        }

    }

    /**
     * @param $formulaID
     * @return bool
     */

    public function isMyFormula($formulaID)
    {

        $auth = new Authentication();

        if ($auth->is_admin()) {
            return true;
        } else {
            $session = $this->session->all_userdata();
            $currentUserID = $session['user_data'];
            $formula = $this->get($formulaID);

            if ($formula->user_id == $currentUserID) {
                return true;
            } else {
                return false;
            }

        }

    }

    public function getFormulasApi(){

        $auth = new Authentication();

        $data = array();

          if ($auth->is_admin()) {
              $query = $this->db->get_where($this->_table, array('deleted' => 0));
          } else {
              $session = $this->session->all_userdata();
              $currentUserID = $session['user_data'];
              $query = $this->db->get_where($this->_table, array('deleted' => 0, 'user_id' => $currentUserID));
          }

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {

                $data[] = $row;


            }

        }

				usort($data, 'sort_formula');

        return $data;

    }



    public function getFormulaPrice($formulaID){

        $ingredients = $this->getIngredientCost($this->getIngredientsByFormula($formulaID));
        return json_encode(array('cost' => $this->getFormulaCost($ingredients)));

    }




}

function sort_formula($a, $b) { 
  return strcasecmp($a->name,$b->name);
}