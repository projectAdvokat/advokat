<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chats_Model extends CI_Model {

    protected $table = 'chats';

    public function __construct() {
        parent::__construct();
    }

    public function get_by_id($id) {
       $this->db->select('chats.*, bookings.id as booking_id, bookings.duration_minutes ');
    $this->db->from('chats');
    $this->db->join('bookings', 'bookings.id = chats.booking_id', 'left');
    $this->db->where('chats.id', $id);
    return $this->db->get()->row_array();
    }

    public function get_by_lawyer($lawyer_id) {
    $this->db->select('chats.*, users.name as client_name');
    $this->db->from($this->table);
    $this->db->join('users', 'users.id = chats.client_id', 'left');
    $this->db->where('chats.lawyer_id', $lawyer_id);
    $this->db->order_by('chats.opened_at', 'DESC');
    return $this->db->get()->result_array();
}
   public function get_by_client($client_id) {
    $this->db->select('chats.*, users.name as lawyer_name');
    $this->db->from($this->table);
    $this->db->join('users', 'users.id = chats.lawyer_id', 'left'); // ambil nama lawyer
    $this->db->where('chats.client_id', $client_id); // filter berdasarkan client_id
    $this->db->order_by('chats.opened_at', 'DESC');
    return $this->db->get()->result_array();
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

   
}

