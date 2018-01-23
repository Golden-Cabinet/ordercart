<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class login_attempt_model extends MY_Model
{
    protected $_table = 'login_attempts';


    /**
     * @param $id INT USER_ID
     * @param $session ARRAY Session Array
     * @param $result Boolean Was the long in successful
     */
    public function loginAttempt($id, $session , $result)
    {

        $data = array(
            'ip_address' =>  $session['ip_address'],
            'created_at' => date("Y-m-d H:i:s"),
            'session_id' => $session['session_id'],
            'user_id' => $id
        );

        if($result == NULL){
            $data['result'] = 0;
            $data['status'] = 0;
        }else{
            $data['result'] = $result;
            $data['status'] = $result;
        }



        $this->insert($data);

    }

    public function get_ActiveLogin($id)
    {
        $this->db->where('user_id',$id);
        $this->db->where('status',1);
        $query = $this->db->get($this->_table);
        return $query->row();
    }

    public function deactivate($id)
    {
        return $this->update($id,array('status' => 0));
    }

} 