<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_orders extends CI_Migration {


    public function up()
    {

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
            ),
            'patient_id' => array(
                'type' => 'INT',
            ),
            'formula_id' => array(
                'type' => 'INT',
            ),
            'sub_total' => array(
                'type' => 'VARCHAR',
                'constraint' => '80',
                'null' => false,
            ),
            'shipping_cost' => array(
                'type' => 'VARCHAR',
                'constraint' => '80',
                'null' => false,
            ),
            'discount' => array(
                'type' => 'VARCHAR',
                'constraint' => '80',
                'null' => false,
            ),
            'total_cost' => array(
                'type' => 'VARCHAR',
                'constraint' => '80',
                'null' => false,
            ),
            'numberOfScoops' => array(
                'type' => 'VARCHAR',
                'constraint' => '80',
                'null' => TRUE,
            ),
            'timesPerDay' => array(
                'type' => 'VARCHAR',
                'constraint' => '80',
                'null' => TRUE,
            ),
            'refills' => array(
                'type' => 'INT',
                'constraint' => '2',
                'null' => false,
                'default' => 0
            ),
            'shipOrPick' => array(
                'type' => 'VARCHAR',
                'constraint' => '80',
                'null' => false,
            ),
            'pickUpOption' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ),
            'shipOption' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ),
            'billing' => array(
                'type' => 'VARCHAR',
                'constraint' => '80',
                'null' => false,
            ),
            'notes' => array(
                'type' => 'text',
                'null' => true,
            ),
            'instructions' => array(
                'type' => 'text',
                'null' => true,
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
            'deleted' => array(
                'type' => 'INT',
                'default' => 0
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('orders');

    }

//    public function up()
//    {
//        $this->dbforge->add_field(array(
//            'id' => array(
//                'type' => 'INT',
//                'constraint' => 5,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
//            ),
//            'role_id' => array(
//                'type' => 'INT',
//                'constraint' => 5,
//            ),
//            'firstName' => array(
//                'type' => 'VARCHAR',
//                'constraint' => '255',
//            ),
//            'lastName' => array(
//                'type' => 'VARCHAR',
//                'constraint' => '255',
//            ),
//            'email' => array(
//                'type' => 'VARCHAR',
//                'constraint' => '255',
//            ),
//            'username' => array(
//                'type' => 'VARCHAR',
//                'constraint' => '255',
//            ),
//            'password' => array(
//                'type' => 'VARCHAR',
//                'constraint' => '255',
//            ),
//            'salt' => array(
//                'type' => 'VARCHAR',
//                'constraint' => '255',
//            ),
//            'area_code' => array(
//                'type' => 'INT',
//                'constraint' => '3',
//            ),
//            'phonePre' => array(
//                'type' => 'INT',
//                'constraint' => '3',
//            ),
//            'phonePost' => array(
//                'type' => 'INT',
//                'constraint' => '4',
//            ),
//            'ext' => array(
//                'type' => 'INT',
//                'constraint' => '5',
//                'null' => TRUE,
//            ),
//            'license_state' => array(
//                'type' => 'INT',
//                'constraint' => '5',
//            ),
//            'created_at' => array(
//                'type' => 'TIMESTAMP',
//                'default' => '0000-00-00 00:00:00'
//            ),
//            'updated_at' => array(
//                'type' => 'TIMESTAMP',
//            ),
//            'status' => array(
//                'type' => 'INT',
//                'default' => 0
//            ),
//            'deleted' => array(
//                'type' => 'TINYINT',
//                'default' => 0
//            )
//        ));
//
//        $this->dbforge->add_key('id', TRUE);
//        $this->dbforge->create_table('users');
//    }



    public function down()
    {
        $this->dbforge->drop_table('users');
    }
}