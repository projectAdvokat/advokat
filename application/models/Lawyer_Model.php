<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lawyer_Model extends CI_Model {

    protected $table = 'lawyers';

    public function __construct() {
        parent::__construct();
    }


    

    public function get_by_id($id) {
        $this->db->select('lawyers.*, users.name, users.email, users.phone'); // ambil kolom tambahan dari tabel user
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = lawyers.user_id', 'left'); // join tabel users
        $this->db->where('lawyers.user_id', $id);
        return $this->db->get()->row_array();
    }
public function get_all($online = null, $sort = null) {
    $this->db->select('lawyers.*, users.name as user_name, users.email as user_email'); 
    $this->db->from('lawyers');
    $this->db->join('users', 'users.id = lawyers.user_id', 'left'); // relasi lawyer ke user

    if ($online !== null) {
        $this->db->where('lawyers.is_online', $online); // 0 atau 1
    }

    if ($sort === 'online') {
        $this->db->order_by('lawyers.is_online', 'DESC');
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

        public function clients($lawyer_id) {
        // Ambil daftar client yang booking ke lawyer ini
        $this->db->select('users.id, users.name, users.email, users.phone,bookings.id as id_booking');
        $this->db->from('bookings');
        $this->db->join('users', 'users.id = bookings.client_id');
        $this->db->where('bookings.lawyer_id', $lawyer_id);
        $this->db->group_by('users.id'); // biar tidak dobel kalau booking berkali-kali

        $clients = $this->db->get()->result();

        // Response JSON
        echo json_encode([
            'status' => true,
            'lawyer_id' => $lawyer_id,
            'clients' => $clients
        ]);
    }
}
