<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_articles_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type'=>'INT','unsigned'=>TRUE,'auto_increment'=>TRUE],
            'owner_id' => ['type'=>'INT','unsigned'=>TRUE,'null'=>TRUE], // null berarti admin
            'title' => ['type'=>'VARCHAR','constraint'=>255],
            'slug' => ['type'=>'VARCHAR','constraint'=>255],
            'cover_url' => ['type'=>'VARCHAR','constraint'=>255,'null'=>TRUE],
            'excerpt' => ['type'=>'TEXT','null'=>TRUE],
            'body' => ['type'=>'TEXT'],
            'published_at' => ['type'=>'DATETIME','null'=>TRUE]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('articles');

        $this->db->query("ALTER TABLE `articles` ADD CONSTRAINT `fk_articles_owner` FOREIGN KEY (`owner_id`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE");
    }

    public function down()
    {
        $this->dbforge->drop_table('articles');
    }
}
