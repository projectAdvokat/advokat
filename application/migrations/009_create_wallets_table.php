<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_wallets_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'user_id' => ['type'=>'INT','unsigned'=>TRUE],
            'balance' => ['type'=>'DECIMAL','constraint'=>'12,2','default'=>0.00],
        ]);
        $this->dbforge->add_key('user_id', TRUE);
        $this->dbforge->create_table('wallets');

        $this->db->query('ALTER TABLE wallets 
            ADD CONSTRAINT fk_wallets_user 
            FOREIGN KEY (user_id) REFERENCES users(id) 
            ON DELETE CASCADE 
            ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->dbforge->drop_table('wallets');
    }
}
