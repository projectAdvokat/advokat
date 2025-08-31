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
  $chat = $this->db->get_where('chats', ['booking_id' => $booking_id])->row_array();
    // // ambil pesan sesuai chat_id
    $messages = $this->db->get_where('messages', ['chat_id' => $chat['id']])->result_array();

     $booking = $this->db->get_where('bookings', ['id' => $booking_id])->row_array();
        $lawyer = null;
    $user = null;

    if ($booking && isset($booking['lawyer_id'])) {
        // ambil lawyer
        $lawyer = $this->db->get_where('lawyers', ['user_id' => $booking['lawyer_id']])->row_array();

        if ($lawyer && isset($lawyer['user_id'])) {
            
            // ambil user dari lawyer
            $user = $this->db->get_where('users', ['id' => $lawyer['user_id']])->row_array();
            $lawyer['user'] = $user;
        }
    }

    // response
    return [
        "ok" => true,
        "data" => [
            "chat" => $chat,
            "messages" => $messages,
            "lawyer" => $lawyer
        ],
        "message" => null
    ];
}


}
