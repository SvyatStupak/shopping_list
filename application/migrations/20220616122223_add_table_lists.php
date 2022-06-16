<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_table_lists extends CI_Migration {

        public function up() { 
                $this->dbforge->add_field(array(
                'id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                ),
                'title' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100'
                ),
                'date_added' => array(
                        'type' => 'TIMESTAMP',
                        'null' => FALSE,
                        'CURRENT_TIME' => TRUE,
                ),
                'status' => array(
                        'type' => 'BOOLEAN',
                        'DEFAULT' => FALSE,
                ),
                'category_id' => array(
                        'type' => 'INT',
                        'unsigned' => TRUE,
                ),

            ));
            $this->dbforge->add_key('id', TRUE);
        //     $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (category_id) REFERENCES categories(id)');
            $this->dbforge->create_table('lists');
        }
    
        public function down()
        {
            $this->dbforge->drop_table('lists');
        }
}

