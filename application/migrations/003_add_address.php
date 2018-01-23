<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_address extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
            ),
            'addressType' => array(
                'type' => 'INT',
            ),
            'street' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'city' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'state_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'zip' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('address');
    }

    public function down()
    {
        $this->dbforge->drop_table('address');
    }
}