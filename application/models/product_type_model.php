<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class product_type_model extends MY_Model{
    protected $_table = 'product_types';
    protected $soft_delete = TRUE;

    public function defaultSettings()
    {
        $productType = new stdClass();
        $productType->name = '';
        return $productType;
    }

    public function filter($input){

        if(is_array($input) AND !empty($input)  ){

            foreach($input as $key => $value){
                $input[$key] = trim(strip_tags($value));
            }

            return $input;

        }else{
            return FALSE;
        }

    }

    public function fetch_categories($limit, $start)
    {
        $query = $this->db->get_where($this->_table, array('deleted' => 0), $limit, $start);

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }

            return $data;

        }

        return false;

    }
} 