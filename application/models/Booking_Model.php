<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_Model extends CI_Model {

    protected $table = 'bookings';

    public function __construct() {
        parent::__construct();
    }

    

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

     public function updateByPgRef($pg_ref, $status)
    {
        return $this->db->update(
            $this->table,
            ['status' => $status],
            ['pg_ref' => $pg_ref]
        );
    }



    public function get_all() {
        return $this->db->get($this->table)->result_array();
    }

      public function getLastByUser($user_id)
    {
        return $this->db->where('client_id', $user_id)
                        ->order_by('id', 'DESC')
                        ->limit(1)
                        ->get('bookings')
                        ->row();
    }


    public function getByInvoiceId($invoice_id){
        return $this->db->get_where($this->table, ['pg_ref' => $invoice_id])->row_array();    

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
public function get_by_client($client_id) {
    $this->db->select('
        lawyers.user_id as lawyer_id, 
        lawyers.specialties as lawyer_specialties,
        users.id as user_id, 
        users.name as lawyer_name, 
        users.email as lawyer_email
    ');
    $this->db->from('bookings');
    $this->db->join('lawyers', 'bookings.lawyer_id = lawyers.user_id', 'left');
    $this->db->join('users', 'lawyers.user_id = users.id', 'left');
    $this->db->where('bookings.client_id', $client_id);
    $this->db->distinct(); // supaya unik

    return $this->db->get()->result_array();
}

}
