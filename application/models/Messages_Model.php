<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages_Model extends CI_Model {

    protected $table = 'messages';

    public function __construct() {
        parent::__construct();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function get_all() {
        return $this->db->get($this->table)->result_array();
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

      public function get_messages_by_booking($booking_id) {
        $this->db->select('messages.*');
        $this->db->from('messages');
        $this->db->join('chats', 'chats.id = messages.chat_id');
        $this->db->where('chats.booking_id', $booking_id);
        $this->db->order_by('messages.created_at', 'ASC');
        return $this->db->get()->result_array();
    }

}
