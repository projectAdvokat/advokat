<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_users_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type'=>'INT','unsigned'=>TRUE,'auto_increment'=>TRUE],
            'name' => ['type'=>'VARCHAR','constraint'=>255],
            'email' => ['type'=>'VARCHAR','constraint'=>255],
            'phone' => ['type'=>'VARCHAR','constraint'=>20],
            'role' => ['type'=>'ENUM','constraint'=>['client','lawyer','admin','marketer']],
            'password_hash' => ['type'=>'VARCHAR','constraint'=>255],
            'ref_code' => ['type'=>'VARCHAR','constraint'=>10],
            'referrer_id' => ['type'=>'INT','unsigned'=>TRUE,'null'=>TRUE],
            'status' => ['type'=>'TINYINT','constraint'=>1,'default'=>1]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');

        $this->db->query("ALTER TABLE `users` ADD CONSTRAINT `fk_users_referrer_self` FOREIGN KEY (`referrer_id`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE");
    }

    public function down()
    {
        $this->dbforge->drop_table('users');
    }
}
