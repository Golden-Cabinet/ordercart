<?php defined('BASEPATH') OR exit('No direct script access allowed');

class contact_model extends MY_Model
{
    protected $_table = 'contact_requests';

    public function fetch_messages($limit, $start)
    {

        $this->db->limit($limit, $start);

        $query = $this->db->get($this->_table);

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }

            return $data;

        }

        return false;

    }
}