<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class gc_session_model extends MY_Model{
    protected $_table = 'gc_sessions';
    protected $primary_key = 'session_id';
}