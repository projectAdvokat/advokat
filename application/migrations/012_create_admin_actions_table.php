<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_admin_actions_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type'=>'INT','unsigned'=>TRUE,'auto_increment'=>TRUE],
            'admin_id' => ['type'=>'INT','unsigned'=>TRUE],
            'target_type' => ['type'=>'ENUM','constraint'=>['user','lawyer','article','booking']],
            'target_id' => ['type'=>'INT','unsigned'=>TRUE],
            'action' => ['type'=>'VARCHAR','constraint'=>255],
            'reason' => ['type'=>'TEXT'],
            'created_at' => ['type'=>'DATETIME','null'=>TRUE],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('admin_actions');

        $this->db->query("ALTER TABLE admin_actions ADD CONSTRAINT fk_admin_actions_admin FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE");
    }

    public function down()
    {
        $this->dbforge->drop_table('admin_actions');
    }
}
