<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model {

    protected $table = 'users';

    public function __construct() {
        parent::__construct();
    }

    

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function exists_with_role($email, $role)
    {
        return $this->db->where('email', $email)
                        ->where('role', $role)
                        ->count_all_results($this->table) > 0;
    }


     public function get_referrer_id($user_id) {
        $this->db->select('referrer_id');
        $this->db->from('users'); // ganti sesuai nama tabel user kamu
        $this->db->where('id', $user_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->referrer_id;
        }

        return null;
    }
    public function get_by_email_role($email, $role)
    {
        return $this->db->where('email', $email)
                        ->where('role', $role)
                        ->get($this->table)->row();
    }

    public function get_by_email($email)
    {
        return $this->db->where('email', $email)
                        ->get($this->table)->row();
    }
    public function get_by_phone($phone)
    {
        return $this->db->where('phone', $phone)
                        ->get($this->table)->row();
    }

    public function get_by_ref_code($ref_code)
    {
        return $this->db->where('ref_code', $ref_code)
                        ->get($this->table)->row();
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
