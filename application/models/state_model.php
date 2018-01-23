<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class state_model extends MY_Model {

    protected $_table = 'states';

    public function getStateName($id){
        $state = $this->get($id);
				if (is_object($state)) {
					return $state->name;
				} else {
					return;
				}
    }
} 