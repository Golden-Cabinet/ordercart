<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_gc_session extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'session_id' => array(
                'type' => 'varchar',
                'constraint' => 40,
                'default' => 0,
                'null' => FALSE
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '45',
                'default' => 0,
                'null' => FALSE
            ),
            'user_agent' => array(
                'type' => 'VARCHAR',
                'constraint' => '120',
                'null' => FALSE
            ),
            'last_activity' => array(
                'type' => 'INT',
                'constraint' => 10,
                'null' => FALSE,
                'unsigned' => TRUE,
                'default' => 0,
            ),
            'user_data' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
        ));

        $this->dbforge->add_key('session_id', TRUE);
        $this->dbforge->create_table('login_attempts');

    }

    public function down()
    {
        $this->dbforge->drop_table('login_attempts');
    }
}