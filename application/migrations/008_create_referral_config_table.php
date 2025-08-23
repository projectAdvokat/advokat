<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_referral_config_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type'=>'INT','unsigned'=>TRUE],
            'platform_fee_pct' => ['type'=>'DECIMAL','constraint'=>'5,2'],
            'company_pct_of_fee' => ['type'=>'DECIMAL','constraint'=>'5,2'],
            'l1_pct_of_pool' => ['type'=>'DECIMAL','constraint'=>'5,2'],
            'l2_pct_of_pool' => ['type'=>'DECIMAL','constraint'=>'5,2'],
            'l3_pct_of_pool' => ['type'=>'DECIMAL','constraint'=>'5,2'],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('referral_config');

        $this->db->insert('referral_config', [
            'id' => 1,
            'platform_fee_pct' => 0.00,
            'company_pct_of_fee' => 0.00,
            'l1_pct_of_pool' => 0.00,
            'l2_pct_of_pool' => 0.00,
            'l3_pct_of_pool' => 0.00,
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_table('referral_config');
    }
}
