<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @package    CodeIgniter Admin
 * @author     Danny Nunez
 * @copyright  Copyright (c) 2013 Subtext
 */
// ------------------------------------------------------------------------

class Authentication extends REST_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->model(array('user_model', 'login_attempt_model', 'role_model'));
        $this->load->library(array('form_validation'));
    }

    public function verifyLogin($data)
    {
        if ($this->form_validation->valid_email($data['email']) === true && $this->user_model->emailExists($data['email'])) {

            $account = $this->user_model->get_by('email', $data['email']);

            if ($account->status == 1) {

                $pass = new PasswordHash(8, false);
                if ($pass->CheckPassword($data['password'] . $account->salt, $account->password)) {
                    return array('result' => true, 'account' => $account);
                } else {
                    return array('result' => false, 'account' => $account);
                }

            } else {

               redirect('/?message=status_message');

            }

        }
        return FALSE;
    }

    /**
     * @Description - Verify the current cookie session data is of a person who is logged.
     * @return boolean
     */

    public function is_logged_in()
    {

        $session = $this->session->all_userdata();

        if ($session['user_data'] != '') {
            $loginInfo = $this->login_attempt_model->get_ActiveLogin($session['user_data']);
            if (is_object($loginInfo)) {
                return true;
            } else {
                return FALSE;
            }

        } else {
            return FALSE;
        }

    }



    public function is_admin()
    {

        $session = $this->session->all_userdata();

        if ($session['user_data'] != '') {

            $userRole = $this->userRole($this->user_model->get($session['user_data']));

            if ($userRole == 'Administrator') {
                return TRUE;
            } else {
                return FALSE;
            }

        } else {
            return FALSE;
        }

    }

    public function userRole($user)
    {

        $role = $this->role_model->get($user->role_id);

        return $role->name;

    }

}