<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Action_Model extends CI_Model {

    protected $table = 'admin_actions';

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

     public function get_finance_report($from, $to) {
        $sql = "
            SELECT 
                COUNT(b.id) as total_bookings,
                SUM(b.price_snapshot) as total_sales,
                SUM(p.amount) as total_paid,
                SUM(c.platform_fee) as total_fee,
                SUM(c.company_amount) as total_company,
                SUM(c.l1_amount + c.l2_amount + c.l3_amount) as total_commissions
            FROM bookings b
            LEFT JOIN payments p ON p.booking_id = b.id AND p.status = 'paid'
            LEFT JOIN commissions c ON c.booking_id = b.id
            WHERE b.created_at BETWEEN ? AND ?
        ";
        return $this->db->query($sql, [$from, $to])->row_array();
    }

      public function log_action($admin_id, $target_type, $target_id, $action, $reason = '') {
        $data = [
            'admin_id'    => $admin_id,
            'target_type' => $target_type,
            'target_id'   => $target_id,
            'action'      => $action,
            'reason'      => $reason,
            'created_at'  => date('Y-m-d H:i:s')
        ];
        $this->db->insert($this->table, $data);


    }

     public function verify_lawyer($id) {
        $now = date('Y-m-d H:i:s');
        $this->db->where('user_id', $id)
                 ->update('lawyers', ['verified_at' => $now]);
        return $this->db->affected_rows();
    }

      public function ban_article($id) {
        $this->db->where('id', $id)
                 ->update('articles', ['status' => 'banned']);
        return $this->db->affected_rows();
    }

      public function ban_user($id) {
        $this->db->where('id', $id)
                 ->update('users', ['status' => 'banned']);
        return $this->db->affected_rows();
    }
}
