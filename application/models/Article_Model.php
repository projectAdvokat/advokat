<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article_Model extends CI_Model {

    protected $table = 'articles';

    public function __construct() {
        parent::__construct();
}

public function get_by_owner($owner)
{
    if ($owner === 'all') {
        // semua artikel
        return $this->db->get($this->table)->result_array();
    }

    if ($owner === 'admin') {
        // artikel yang dimiliki oleh admin
        return $this->db->select("{$this->table}.*")
                        ->from($this->table)
                        ->join('users', 'users.id = '.$this->table.'.owner_id')
                        ->where('users.role', 'admin')
                        ->get()
                        ->result_array();
    }

    if ($owner === 'me') {
        $owner_id = $this->session->userdata('user_id'); // pastikan sudah set session user_id saat login
        return $this->db->get_where($this->table, ['owner_id' => $owner_id])->result_array();
    }

    return []; // default kalau parameter tidak sesuai
}

    public function get_by_owner_id($owner_id) {
        return $this->db->get_where($this->table, ['owner_id' => $owner_id])->result_array();
    }

    public function count_by_owner($owner_id)
    {
        return $this->db->where('owner_id', $owner_id)->count_all_results($this->table);
    }

    public function get_by_slug($slug)
    {
        return $this->db->get_where($this->table, ['slug' => $slug])->row_array();
    }

    public function delete_by_slug($slug)
    {
        return $this->db->where('slug', $slug)->delete($this->table);
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
       
}
