<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_contact_requests extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'firstName' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'lastName' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '25',
            ),
            'question' => array(
                'type' => 'TEXT',
            ),
            'status' => array(
                'type' => 'INT',
                'default' => 0
            ),
            'created_at' => array(
                'type' => 'TIMESTAMP',
                'default' => '0000-00-00 00:00:00'
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('contact_requests');
    }

    public function down()
    {
        $this->dbforge->drop_table('contact_requests');
    }

}