<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article_Model extends CI_Model {

    protected $table = 'articles';

    public function __construct() {
        parent::__construct();
}


public function get_latest($limit = 3) {
    return $this->db->order_by('published_at', 'DESC')->get($this->table, $limit)->result_array();
}




public function get_by_owner($owner)
{
    if ($owner === 'all') {
        // semua artikel + join author
        return $this->db->select("{$this->table}.*, users.name as author_name, users.role as author_role")
                        ->from($this->table)
                        ->join('users', "users.id = {$this->table}.owner_id")
                        ->get()
                        ->result_array();
    }

    if ($owner === 'admin') {
        // artikel yang dimiliki oleh admin
        return $this->db->select("{$this->table}.*, users.name as author_name")
                        ->from($this->table)
                        ->join('users', "users.id = {$this->table}.owner_id")
                        ->where('users.role', 'admin')
                        ->get()
                        ->result_array();
    }

    if ($owner === 'me') {
        $owner_id = $this->session->userdata('user_id'); // user id dari session login
        return $this->db->select("{$this->table}.*, users.name as author_name")
                        ->from($this->table)
                        ->join('users', "users.id = {$this->table}.owner_id")
                        ->where("{$this->table}.owner_id", $owner_id)
                        ->get()
                        ->result_array();
    }

    return []; // default kalau parameter tidak sesuai
}



    public function get_by_id($id) {
        return $this->db->select('articles.*, users.name as author_name, users.role as author_role')
                        ->from('articles')
                        ->join('users', 'users.id = articles.owner_id')
                        ->where('articles.id', $id)
                        ->get()
                        ->row_array();
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
