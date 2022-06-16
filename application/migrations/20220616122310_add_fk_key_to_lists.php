<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_fk_key_to_lists extends CI_Migration
{

        public function up()
        {
                $this->dbforge->add_column('lists', [
                        'CONSTRAINT fk_id FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE CASCADE',
                ]);
        }

        public function down()
        {
                //     $this->dbforge->drop_table('lists');
        }
}

// $this->dbforge->add_column('lists', [
//         'CONSTRAINT fk_id FOREIGN KEY(category_id) REFERENCES categories(id)',
// ]);