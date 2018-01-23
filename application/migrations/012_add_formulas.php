<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_formulas extends CI_Migration
{

    public function up()
    {

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'deleted' => array(
                'type' => 'INT',
            ),
            'user_id' => array(
                'type' => 'INT',
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('formulas');

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'product_id' => array(
                'type' => 'INT',
            ),
            'formula_id' => array(
                'type' => 'INT',
            ),
            'weight' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'deleted' => array(
                'type' => 'INT',
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('formula_ingredients');

    }


    public function down()
    {
        $this->dbforge->drop_table('formulas');
        $this->dbforge->drop_table('formula_ingredients');
    }

}