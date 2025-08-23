<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_bookings_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type'=>'INT','unsigned'=>TRUE,'auto_increment'=>TRUE],
            'client_id' => ['type'=>'INT','unsigned'=>TRUE],
            'lawyer_id' => ['type'=>'INT','unsigned'=>TRUE],
            'duration_minutes' => ['type'=>'INT'],
            'price_snapshot' => ['type'=>'DECIMAL','constraint'=>'10,2'],
            'status' => ['type'=>'ENUM','constraint'=>['pending','awaiting_payment','paid','active','done','cancelled','expired'],'default'=>'pending'],
            'pg_ref' => ['type'=>'VARCHAR','constraint'=>255,'null'=>TRUE],
            'paid_at' => ['type'=>'DATETIME','null'=>TRUE],
            'created_at' => ['type'=>'DATETIME','null'=>FALSE],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('bookings');

        $this->db->query("ALTER TABLE `bookings` ADD CONSTRAINT `fk_bookings_client` FOREIGN KEY (`client_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE `bookings` ADD CONSTRAINT `fk_bookings_lawyer` FOREIGN KEY (`lawyer_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
    }

    public function down()
    {
        $this->dbforge->drop_table('bookings');
    }
}
