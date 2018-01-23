<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_patients extends CI_Migration
{

    public function up()
    {

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'firstName' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ),
            'lastName' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'area_code' => array(
                'type' => 'INT',
                'constraint' => '3',
                'null' => TRUE,
            ),
            'phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '8',
                'null' => TRUE,
            ),
            'created_at' => array(
                'type' => 'TIMESTAMP',
                'default' => '0000-00-00 00:00:00'
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP',
                'default' => '0000-00-00 00:00:00'
            ),
            'status' => array(
                'type' => 'INT',
                'default' => 0
            ),
            'user_id' => array(
                'type' => 'INT',
                'null' => false,
            ),
            'deleted' => array(
                'type' => 'INT',
                'default' => 0
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('patients');

    }

    public function down()
    {
        $this->dbforge->drop_table('patients');
    }

}