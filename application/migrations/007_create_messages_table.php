<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_messages_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type'=>'INT','unsigned'=>TRUE,'auto_increment'=>TRUE],
            'chat_id' => ['type'=>'INT','unsigned'=>TRUE],
            'sender_id' => ['type'=>'INT','unsigned'=>TRUE],
            'text' => ['type'=>'TEXT','null'=>TRUE],
            'attachment_url' => ['type'=>'TEXT','null'=>TRUE],
            'created_at' => ['type'=>'DATETIME','null'=>TRUE],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('messages');

        $this->db->query("ALTER TABLE `messages` ADD CONSTRAINT `fk_messages_chat` FOREIGN KEY (`chat_id`) REFERENCES `chats`(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE `messages` ADD CONSTRAINT `fk_messages_sender` FOREIGN KEY (`sender_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
    }

    public function down()
    {
        $this->dbforge->drop_table('messages');
    }
}
