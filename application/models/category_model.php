<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class category_model extends MY_Model {

    protected $_table = 'categories';
    protected $soft_delete = TRUE;

    public function defaultSettings()
    {
        $category = new stdClass();
        $category->name = '';
        $category->parent_id = 0;
        $category->description = '';
        return $category;
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