<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_lawyers_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'user_id' => ['type'=>'INT','unsigned'=>TRUE],
            'years_experience' => ['type'=>'INT','default'=>0],
            'specialties' => ['type'=>'TEXT'],
            'price_30m' => ['type'=>'DECIMAL','constraint'=>'10,2'],
            'bio' => ['type'=>'TEXT','null'=>TRUE],
            'is_online' => ['type'=>'TINYINT','constraint'=>1,'default'=>0],
            'verified_at' => ['type'=>'DATETIME','null'=>TRUE]
        ]);
        $this->dbforge->add_key('user_id', TRUE);
        $this->dbforge->create_table('lawyers');

        $this->db->query("ALTER TABLE `lawyers` ADD CONSTRAINT `fk_lawyers_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
    }

    public function down()
    {
        $this->dbforge->drop_table('lawyers');
    }
}
