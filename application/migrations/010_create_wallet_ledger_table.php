<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_wallet_ledger_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type'=>'INT','unsigned'=>TRUE,'auto_increment'=>TRUE],
            'user_id' => ['type'=>'INT','unsigned'=>TRUE],
            'ref_type' => ['type'=>'ENUM("commission","payout","adjustment","refund_reversal")'],
            'ref_id' => ['type'=>'INT','unsigned'=>TRUE],
            'amount' => ['type'=>'DECIMAL','constraint'=>'12,2'],
            'note' => ['type'=>'TEXT','null'=>TRUE],
            'created_at' => ['type'=>'DATETIME','null'=>TRUE],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('wallet_ledger');

        $this->db->query('ALTER TABLE wallet_ledger 
            ADD CONSTRAINT fk_wallet_ledger_user 
            FOREIGN KEY (user_id) REFERENCES users(id) 
            ON DELETE CASCADE 
            ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->dbforge->drop_table('wallet_ledger');
    }
}
