<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lawyer_Model extends CI_Model {

    protected $table = 'lawyers';

    public function __construct() {
        parent::__construct();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

      public function get_all($online = null, $sort = null) {
        $this->db->select('*');
        $this->db->from('lawyers');

        if ($online !== null) {
            $this->db->where('is_online', $online); // 0 atau 1
        }

        if ($sort === 'online') {
            $this->db->order_by('is_online', 'DESC');
        }

        return $this->db->get()->result_array();
    }
    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
     public function toggle_online($id) {
        $lawyer = $this->get_by_id($id);
        if (!$lawyer) return false;

        $new_status = $lawyer['is_online'] ? 0 : 1;

        $this->db->where('id', $id);
        $this->db->update('lawyers', ['is_online' => $new_status]);

        return $new_status;
    }
}
