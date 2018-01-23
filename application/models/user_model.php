<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class user_model extends MY_Model
{

    protected $_table = 'users';
    protected $soft_delete = TRUE;

    function __construct()
    {
        parent::__construct();
    }

    function emailExists($email_address)
    {

      $this->db->select('*');
			$query = $this->db->get_where('users', array('email' => $email_address, 'deleted'=>0));

      if ($query->num_rows() > 0) {
				return TRUE;

      } else {

        return FALSE;

      }

    }

    function updateEmailCheck($email, $userID)
    {

        $this->db->select('*');
        $this->db->where('email', $email);
        $query = $this->db->get($this->_table);

        if ($query->num_rows() > 0) {

            $row = $query->row();

            if ($row->id == $userID) {
                return FALSE;
            } else {
                return TRUE;
            }

        } else {

            return FALSE;

        }

    }

    function getSalt($email)
    {

        $this->db->select('salt');
        $this->db->where('email', $email);
        $query = $this->db->get($this->_table);
        return $query;
    }

    public function updateProfile($id, $data)
    {

        $filteredData = array();
        foreach ($data as $key => $value) {
            $filteredData[$key] = strip_tags($value);
        }

        if ($this->update($id, $filteredData)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @return mixed
     */

    function getUserFriendlyName($id)
    {

        $this->db->select('firstName','lastName');
        $this->db->where('id', $id);
        $user = $this->db->get($this->_table);

        return $user;

    }


    public function fetch_users($limit, $start)
    {
        $sql = "SELECT users.id,
                users.firstName,
                users.lastName,
                users.status,
                users.email,
                roles.name as role_name,
                states.name as state_name
                FROM `users`
                JOIN roles ON users.role_id = roles.id
                JOIN states ON users.license_state = states.id
                 WHERE users.deleted = 0
                 LIMIT $start , $limit";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {

                if ($row->status == 0) {
                    $row->status = 'inactive';
                } else {
                    $row->status = 'active';
                }

                $data[] = $row;
            }

            return $data;

        }

        return false;

    }

    public function getProfile($id)
    {

        $user = $this->get($id);

        $this->db->select('*');
        $this->db->where('user_id', $id);
        $address = $this->db->get('address');

				if ($user) {

	        if ($address->num_rows() > 0) {

	            foreach ($address->result() as $row) {

	                if ($row->addressType == 1) {
	                    $user->bstreetAddress = $row->street;
	                    $user->bcity = $row->city;
	                    $user->bstate_id = $row->state_id;
	                    $user->bzip = $row->zip;
	                    $user->bRecordID = $row->id;
	                }

	                if ($row->addressType == 2) {
	                    $user->shstreetAddress = $row->street;
	                    $user->shcity = $row->city;
	                    $user->shstate_id = $row->state_id;
	                    $user->shzip = $row->zip;
	                    $user->shRecordID = $row->id;
	                }

	            }

					} else {
		      		$user->bstreetAddress = '';
              $user->bcity = '';
              $user->bstate_id = '';
              $user->bzip = '';
              $user->bRecordID = 0;
              $user->shstreetAddress = '';
              $user->shcity = '';
              $user->shstate_id = '';
              $user->shzip = '';
              $user->shRecordID = 0;
					}
          
          // is billing same as shippping? Not stored so we'll compare and report

          if (
            $user->bstreetAddress == $user->shstreetAddress &&
            $user->bcity == $user->shcity &&
            $user->bstate_id == $user->shstate_id &&
            $user->bzip == $user->shzip              
          ) {
            $user->billingSameAsShipping = "true";
          }else{
            $user->billingSameAsShipping = "false";
          }
					          
          return $user;

        } else {
	        return false;
				}

    }

    public function defaultSettings()
    {
        $user = new stdClass();
        $user->firstName = '';
        $user->lastName = '';
        $user->email = '';
        $user->password = '';
        $user->area_code = '';
        $user->phone = '';
        $user->ext = '';
        $user->license_state = '';
        $user->status = 0;
        $user->role_id = '';
        $user->bstreetAddress = '';
        $user->bcity = '';
        $user->bstate = '';
        $user->bzip = '';
        $user->shstreetAddress = '';
        $user->shcity = '';
        $user->shstate = '';
        $user->shzip = '';

        return $user;
    }

		public function sendConfirmationEmail($userInfo) {

			$to      = $userInfo->email;
			$subject = 'Thank you for registering with Golden Cabinet Herbal Pharmacy';
			$headers = 'From: Golden Cabinet <accounts@goldencabinetherbs.com>' . "\r\n" .
			    'Reply-To: accounts@goldencabinetherbs.com' . "\r\n" .
			    'X-Mailer: PHP/' . phpversion();

			$first = $userInfo->firstName;
			$last = $userInfo->lastName;

			$message = <<<EOF
<p>Hi $first $last,</p>
<p>Thank you for registering with Golden Cabinet Herbal Pharmacy.  Accounts are available to licensed practitioners and students of accredited Chinese Medicine colleges.  If you are already a customer and are just establishing your online account, no action is required on your part. We will look up your account and approve you shortly.  If you are not a customer already, we will attempt to verify your credentials through your state’s licensing board.  If we are unable to verify your credentials, we will contact you shortly for more information.</p> 
<p>If you are a student and are not a current customer of ours, please send us a copy of your student ID or a current transcript to verify your enrollment. Send to accounts@goldencabinetherbs.com or fax it to (888) 958-0782.  If you have already verified your enrollment with us in the past, no action is required on your part.</p>
<p>We will attempt to approve your account within 24 hours.  If you need your approval expedited, please feel free to call us at (503) 233-4102.</p>
<p>Hope you have a wonderful day!</p>
<p>All the best,<br />
The Golden Cabinet Team</p>
EOF;

      $mail = new GCEmail ($this->config->item('email'));
      if ($mail->send($to, $subject, $message)) {

        // send the admin notification email
        $this->sendAdminConfirmationEmail($userInfo);
        
        return true;
      }else{
        return false;
      }

		}

		public function sendAdminConfirmationEmail($userInfo) {

			$to      = "accounts@goldencabinetherbs.com";
			$subject = 'New Registration at Golden Cabinet Herbal Pharmacy';
			$headers = 'From: Golden Cabinet <accounts@goldencabinetherbs.com>' . "\r\n" .
			    'Reply-To: accounts@goldencabinetherbs.com' . "\r\n" .
			    'X-Mailer: PHP/' . phpversion();

			$first = $userInfo->firstName;
			$last = $userInfo->lastName;

			$message = <<<EOF
<p>New registration at Golden Cabinet Herbal Pharmacy: $first $last ($userInfo->email).</p>
<p>Manage their account status and other settings here:</p>
<p><a href="https://goldencabinetherbs.com/settings/users/edit/$userInfo->id">https://goldencabinetherbs.com/settings/users/edit/$userInfo->id</a></p>
EOF;

      $mail = new GCEmail ($this->config->item('email'));
      if ($mail->send($to, $subject, $message)) {
        return true;
      }else{
        return false;
      }

		}


}