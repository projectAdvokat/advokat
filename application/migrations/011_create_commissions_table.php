<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_commissions_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type'=>'INT','unsigned'=>TRUE,'auto_increment'=>TRUE],
            'booking_id' => ['type'=>'INT','unsigned'=>TRUE],
            'gross_price' => ['type'=>'DECIMAL','constraint'=>'10,2'],
            'platform_fee' => ['type'=>'DECIMAL','constraint'=>'10,2'],
            'company_amount' => ['type'=>'DECIMAL','constraint'=>'10,2'],
            'l1_user_id' => ['type'=>'INT','unsigned'=>TRUE,'null'=>TRUE],
            'l1_amount' => ['type'=>'DECIMAL','constraint'=>'10,2','null'=>TRUE],
            'l2_user_id' => ['type'=>'INT','unsigned'=>TRUE,'null'=>TRUE],
            'l2_amount' => ['type'=>'DECIMAL','constraint'=>'10,2','null'=>TRUE],
            'l3_user_id' => ['type'=>'INT','unsigned'=>TRUE,'null'=>TRUE],
            'l3_amount' => ['type'=>'DECIMAL','constraint'=>'10,2','null'=>TRUE],
            'created_at' => ['type'=>'DATETIME','null'=>TRUE],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('commissions');

        $this->db->query("ALTER TABLE commissions ADD CONSTRAINT fk_commissions_booking FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE commissions ADD CONSTRAINT fk_commissions_l1 FOREIGN KEY (l1_user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE commissions ADD CONSTRAINT fk_commissions_l2 FOREIGN KEY (l2_user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE commissions ADD CONSTRAINT fk_commissions_l3 FOREIGN KEY (l3_user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE");
    }

    public function down()
    {
        $this->dbforge->drop_table('commissions');
    }
}
