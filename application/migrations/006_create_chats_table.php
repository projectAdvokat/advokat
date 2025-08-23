<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_chats_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type'=>'INT','unsigned'=>TRUE,'auto_increment'=>TRUE],
            'booking_id' => ['type'=>'INT','unsigned'=>TRUE],
            'client_id' => ['type'=>'INT','unsigned'=>TRUE],
            'lawyer_id' => ['type'=>'INT','unsigned'=>TRUE],
            'opened_at' => ['type'=>'DATETIME','null'=>TRUE],
            'start_time' => ['type'=>'DATETIME','null'=>TRUE], // reply pertama lawyer
            'end_time' => ['type'=>'DATETIME','null'=>TRUE],
            'closed_reason' => ['type'=>'ENUM','constraint'=>['timeout','manual','refund'],'null'=>TRUE],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('chats');

        $this->db->query("ALTER TABLE `chats` ADD CONSTRAINT `fk_chats_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE `chats` ADD CONSTRAINT `fk_chats_client` FOREIGN KEY (`client_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE `chats` ADD CONSTRAINT `fk_chats_lawyer` FOREIGN KEY (`lawyer_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
    }

    public function down()
    {
        $this->dbforge->drop_table('chats');
    }
}
