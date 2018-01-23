<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class dashboard_model extends MY_Model
{
    protected $_table = 'products';
    protected $soft_delete = TRUE;

    function __construct()
    {
        parent::__construct();
    }


    public function defaultSettings()
    {
        $product = new stdClass();
        $product->pinyin = '';
        $product->latin_name = '';
        $product->common_name = '';
        $product->brand_id = '';
        $product->concentration = '';
        $product->costPerGram = '';

        return $product;
    }

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

    public function fetch_dashboard_orders($limit, $start) {
	    $auth = new Authentication();
	    $session = $this->session->all_userdata();
      $currentUserID = $session['user_data'];
      if ($auth->is_admin()) {

        $sql = "SELECT
                `orders`.id,
                `orders`.formula_id,
                `orders`.patient_id,
                `orders`.user_id,
                `orders`.refills,
                `orders`.created_at,
                `orders`.status,
                `orders`.notes,
                `formulas`.name as formula_name,
                `users`.firstName,
                `users`.lastName,
								`patients`.firstName as patientFirstName,
								`patients`.lastName as patientLastName
								
                FROM `orders`, `formulas`, `users`, `patients`
								WHERE `orders`.formula_id = `formulas`.id
								AND `orders`.patient_id = `patients`.id
                AND `orders`.user_id = `users`.id
								AND `orders`.deleted != 1
							  ORDER BY `orders`.created_at DESC
                LIMIT $start , $limit";
				} else {
					$sql = "SELECT
	                `orders`.id,
	                `orders`.formula_id,
	                `orders`.patient_id,
	                `orders`.user_id,
	                `orders`.refills,
	                `orders`.created_at,
	                `orders`.status,
                  `orders`.notes,
	                `formulas`.name as formula_name,
	                `users`.firstName,
	                `users`.lastName,
	             		`patients`.firstName as patientFirstName,
									`patients`.lastName as patientLastName
								  FROM `orders`, `formulas`, `users`, `patients`
									WHERE `orders`.formula_id = `formulas`.id
	                AND `orders`.user_id = `users`.id
	              	AND `orders`.patient_id = `patients`.id
									AND `orders`.user_id = $currentUserID
								 	AND `orders`.deleted != 1
								 ORDER BY `orders`.created_at DESC
	                LIMIT $start , $limit";
				}

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }


        } else {
				
					$data = array();
				
				}

				return $data;

    }

    public function fetch_dashboard_formulas($limit, $start) {
	    $auth = new Authentication();
      $session = $this->session->all_userdata();
      $currentUserID = $session['user_data'];

      if ($auth->is_admin()) {
	      $sql = "SELECT
	                `formulas`.id,
	                `formulas`.name

	                FROM `formulas`
									WHERE deleted = 0
	                ORDER BY `formulas`.name DESC
	                LIMIT $start , $limit";
			} else {
				$sql = "SELECT
	                `formulas`.id,
	                `formulas`.name

	                FROM `formulas`
									WHERE `formulas`.user_id = $currentUserID
									AND deleted = 0
	                ORDER BY `formulas`.name DESC
	                LIMIT $start , $limit";
			}



      $query = $this->db->query($sql);

       if ($query->num_rows() > 0) {

           foreach ($query->result() as $row) {
               $data[] = $row;
           }


       } else {

				$data = array();

			}

			return $data;

    }

    public function fetch_dashboard_patients($limit, $start) {
	    $auth = new Authentication();

	    $session = $this->session->all_userdata();
      $currentUserID = $session['user_data'];
      if ($auth->is_admin()) {
     
 				$sql = "SELECT
								`patients`.id,
                `patients`.firstName,
                `patients`.lastName,
                `patients`.email
             
                FROM `patients`
								WHERE deleted = 0
                ORDER BY `patients`.lastName ASC
                LIMIT $start , $limit";
			} else {
				
 				$sql = "SELECT
								`patients`.id,
                `patients`.firstName,
                `patients`.lastName,
                `patients`.email
	           
                FROM `patients`
								WHERE user_id = $currentUserID
								AND deleted = 0
                ORDER BY `patients`.lastName ASC
                LIMIT $start , $limit";
			}

      $query = $this->db->query($sql);

       if ($query->num_rows() > 0) {

           foreach ($query->result() as $row) {
               $data[] = $row;
           }


       } else {

				$data = array();

			}

			return $data;

    }

 
} 