<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_payments_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type'=>'INT','unsigned'=>TRUE,'auto_increment'=>TRUE],
            'booking_id' => ['type'=>'INT','unsigned'=>TRUE],
            'gateway' => ['type'=>'VARCHAR','constraint'=>50],
            'pg_tx_id' => ['type'=>'VARCHAR','constraint'=>255,'null'=>TRUE],
            'amount' => ['type'=>'DECIMAL','constraint'=>'10,2'],
            'status' => ['type'=>'ENUM','constraint'=>['created','paid','failed','expired','refunded'],'default'=>'created'],
            'raw_json' => ['type'=>'TEXT','null'=>TRUE],
            'updated_at' => ['type'=>'DATETIME','null'=>TRUE],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('payments');

        $this->db->query("ALTER TABLE `payments` ADD CONSTRAINT `fk_payments_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
    }

    public function down()
    {
        $this->dbforge->drop_table('payments');
    }
}
