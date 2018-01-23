<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class patient_model extends MY_Model {

    protected $_table = 'patients';
    protected $soft_delete = TRUE;

    public function __construct(){
        parent::__construct();
    }

    public function defaultSettings()
    {
        $patient = new stdClass();
        $patient->firstName = '';
        $patient->lastName = '';
        $patient->email = '';
        $patient->bzip = '';
        $patient->bstreetAddress = '';
        $patient->bcity = '';
        $patient->shzip = '';
        $patient->shstreetAddress = '';
        $patient->shcity = '';
				$patient->area_code = '';
        $patient->phone = '';
        $patient->ext = '';
        $patient->status = '';
        return $patient;
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

    public function fetch_active_patients($limit, $start)
    {

      $auth = new Authentication();

      if ($auth->is_admin()) {

          $sql = "SELECT patients.id,
              patients.firstName,
              patients.lastName,
              patients.email,
              users.firstName as practitionerFirstName,
              users.lastname as practitionerLastName,
              patients.deleted
              FROM `patients`
              JOIN users ON patients.user_id = users.id
              WHERE patients.deleted = 0
              LIMIT $start , $limit";

      }else{

          $session = $this->session->all_userdata();
          $currentUserID = $session['user_data'];

          $sql = "SELECT patients.id,
              patients.firstName,
              patients.lastName,
              patients.email,
              users.firstName as practitionerFirstName,
              users.lastname as practitionerLastName,
              patients.deleted                
              FROM `patients`
              JOIN users ON patients.user_id = users.id
              WHERE patients.user_id = $currentUserID
              AND patients.deleted = 0 AND patients.user_id = $currentUserID
              LIMIT $start , $limit";
      }

      $query = $this->db->query($sql);

      if ($query->num_rows() > 0) {

          foreach ($query->result() as $row) {
              $data[] = $row;
          }
					usort($data, 'sort_patients');

          return $data;

      }



      return false;

    }

    public function fetch_patients($limit, $start)
    {

        $auth = new Authentication();

        if ($auth->is_admin()) {

            $sql = "SELECT patients.id,
                patients.firstName,
                patients.lastName,
                patients.email,
                users.firstName as practitionerFirstName,
                users.lastname as practitionerLastName,
                patients.deleted
                FROM `patients`
                JOIN users ON patients.user_id = users.id
                /*WHERE patients.deleted = 0*/
                LIMIT $start , $limit";

        }else{

            $session = $this->session->all_userdata();
            $currentUserID = $session['user_data'];

            $sql = "SELECT patients.id,
                patients.firstName,
                patients.lastName,
                patients.email,
                users.firstName as practitionerFirstName,
                users.lastname as practitionerLastName,
                patients.deleted                
                FROM `patients`
                JOIN users ON patients.user_id = users.id
                WHERE patients.user_id = $currentUserID
                /* WHERE patients.deleted = 0 AND patients.user_id = $currentUserID */
                LIMIT $start , $limit";

        }
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
						usort($data, 'sort_patients');

            return $data;

        }



        return false;

    }


    /**
     * @description - check if the user is either admin or is the practitioner who created the client profile.
     * @param $patientID
     * @return bool
     */


    public function is_client($patientID){

        $session = $this->session->all_userdata();
        $session['user_data'];

        $auth = new Authentication();

        if ($auth->is_admin()) {

            return true;

        }else{

            $result = $this->db->get_where($this->_table , array('user_id' => $session['user_data'] , 'id' => $patientID));

            if($result->num_rows() > 0){
                return true;
            }else{
                return false;
            }

        }

    }

    public function getPatientProfile($id)
    {

        $auth = new Authentication();

        // For admins we can load deleted patients
        // normal users cannot.
        
        $auth = new Authentication();

        if ($auth->is_admin()) {
          $sql = "SELECT patients.*
              FROM `patients`
              JOIN users ON patients.user_id = users.id
              WHERE patients.id = $id";

              $query = $this->db->query($sql);

              if ($query->num_rows() > 0) {
                  foreach ($query->result() as $row) {
                      $patient = $row;
                  }
              }

        }else{
          $sql = "SELECT patients.*
              FROM `patients`
              JOIN users ON patients.user_id = users.id
              WHERE patients.id = $id";

              $query = $this->db->query($sql);

              if ($query->num_rows() > 0) {
                  foreach ($query->result() as $row) {
                      $patient = $row;
                  }
              }
          // $patient = $this->get($id);
        }      

        $this->db->select( '*' );
        $this->db->where( 'patient_id' , $id );
        $address = $this->db->get( 'patientAddress' );
        if ($address->num_rows() > 0) {

            foreach ($address->result() as $row) {

                if ($row->addressType == 1) {
                    $patient->bstreetAddress = $row->street;
                    $patient->bcity = $row->city;
                    $patient->bstate_id = $row->state_id;
                    $patient->bzip = $row->zip;
                    $patient->bRecordID = $row->id;
                }

                if ($row->addressType == 2) {
                    $patient->shstreetAddress = $row->street;
                    $patient->shcity = $row->city;
                    $patient->shstate_id = $row->state_id;
                    $patient->shzip = $row->zip;
                    $patient->shRecordID = $row->id;
                }

            }
		        $this->load->model(array('address_model','state_model', 'order_model'));

						$patient->bstate = $this->state_model->getStateName($patient->bstate_id);

						$patient->orders = $this->order_model->getByPatient($id);
            return $patient;

        }

        return false;

    }

    /**
     * @param $id
     * @return mixed
     */

    function getPatientFriendlyName($id)
    {

        $this->db->select('firstName','lastName');
        $this->db->where('id', $id);
        $patient = $this->db->get($this->_table);

        return $patient;

    }

    function checkUniqueEmail($email)
    {

        $this->db->select('firstName','lastName');
        $this->db->where('email', $email);
        $result = $this->db->get_where($this->_table , array('email' => $email));

        if($result->num_rows() > 0){
            return false;
        }else{
            return true;
        }

    }
    
    function reactivate($id) 
    {       
      $sql = "UPDATE patients SET deleted=0 WHERE id=$id";
      $query = $this->db->query($sql);

      return $query;
    }



}

function sort_patients($a, $b) { 
  return strcasecmp($a->lastName,$b->lastName);
}