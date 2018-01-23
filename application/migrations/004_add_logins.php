<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_logins extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'created_at' => array(
                'type' => 'TIMESTAMP',
                'default' => '0000-00-00 00:00:00'
            ),
            'session_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
            ),
            'result' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
            ),
            'status' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'default' => 0
            ),
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('login_attempts');

    }

    public function down()
    {
        $this->dbforge->drop_table('login_attempts');
    }
}