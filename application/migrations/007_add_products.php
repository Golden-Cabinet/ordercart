<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_products extends CI_Migration
{

    public function up()
    {

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'pinyin' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'latin_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'common_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'brand_id' => array(
                'type' => 'INT',
            ),
            'concentration' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'costPerGram' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'deleted' => array(
                'type' => 'INT',
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('products');
    }

    public function down()
    {
        $this->dbforge->drop_table('products');
    }
}