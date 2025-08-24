<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet_Model extends CI_Model {

    protected $table = 'wallets';

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

    
    public function get_balance($user_id) {
        return $this->db->get_where('wallets', ['user_id' => $user_id])->row();
    }

    public function get_ledger($user_id, $from = null, $to = null) {
        $this->db->where('user_id', $user_id);
        if ($from && $to) {
            $this->db->where("DATE(created_at) >=", $from);
            $this->db->where("DATE(created_at) <=", $to);
        }
        return $this->db->order_by('created_at', 'DESC')->get('wallet_ledger')->result();
    }

    public function add_ledger($data) {
        $this->db->insert('wallet_ledger', $data);
        return $this->db->insert_id();
    }

    public function update_balance($user_id, $amount) {
        $wallet = $this->get_balance($user_id);
        if ($wallet) {
            $this->db->set('balance', "balance + ({$amount})", FALSE)
                     ->where('user_id', $user_id)
                     ->update('wallets');
        } else {
            $this->db->insert('wallets', [
                'user_id' => $user_id,
                'balance' => $amount
            ]);
        }
    }
}
