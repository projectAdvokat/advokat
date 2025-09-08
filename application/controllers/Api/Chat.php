<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Messages_Model', 'message');

        $this->load->library('session'); // load session
        
        $this->load->model('Chats_Model', 'chat');
        
        header('Content-Type: application/json');
    }
    public function index() {
         $booking_id = $this->input->get('booking_id');

         

         if (!$booking_id) {
            api_response(false, null, 'booking_id is required');
            return;
        }

        $messages = $this->message->get_messages_by_booking($booking_id);
        api_response(true, $messages);

 
    }
    public function create() {
        $data = json_decode($this->input->raw_input_stream, true);

        if (empty($data)) {
            api_response(false, null, 'No data provided');
            return;
        }

        $insert_id = $this->chat->insert($data);
        if ($insert_id) {
            api_response(true, ['id' => $insert_id], 'Chat Session create successfully');
        } else {
            api_response(false, null, 'Failed to create chat session');
        }
    }

    public function get_chat($chat_id)
    {
        $chat = $this->chat->get_by_id($chat_id);
        api_response(true, $chat);
    }

   public function send_messages($chat_id) {
    $sender_id = $this->session->userdata('user_id'); // user login
    $text = $this->input->post('text');
    $booking_id = $this->input->post('booking_id');

    // simpan pesan
    $this->message->insert([
        'chat_id'    => $chat_id,
        'sender_id'  => $sender_id,
        'text'       => $text,
        'created_at' => date('Y-m-d H:i:s')
    ]);

    // cek apakah chat baru dimulai oleh lawyer
    $chat_session = $this->chat->get_by_id($chat_id);
    if ($sender_id == $chat_session['lawyer_id'] && $chat_session['start_time'] == null) {
        $this->chat->update(

            $chat_id,
            [
                'start_time' => date('Y-m-d H:i:s'),
                'end_time'   => date('Y-m-d H:i:s', strtotime($chat_session['duration_minutes'] . ' minutes'))
            ]
        );
    }

    // setelah insert redirect balik ke halaman chat
    redirect('chat/booking/'.$booking_id);  
}

    public function my_chats() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        api_response(false, null, 'Invalid request method, use POST.');
        return;
    }


    $input = json_decode($this->input->raw_input_stream, true);
    $user_role  = isset($input['user_role']) ? $input['user_role'] : '';
    $user_id = isset($input['user_id']) ? intval($input['user_id']) : 0;

    if (!$user_id) {
        api_response(false, null, 'Parameter user_id wajib diisi');
        return;
    }


    // validasi benar-benar lawyer

    if($user_role == 'lawyer') {
     $lawyer = $this->db->get_where('users', ['id' => $user_id, 'role' => 'lawyer'])->row_array();
    if (!$lawyer) {
        api_response(false, null, 'Lawyer tidak ditemukan atau bukan role lawyer');
        return;
    }

    // ambil chat dari model
    $chats = $this->chat->get_by_lawyer($user_id);

    // tambahin flag expired (jika end_time terisi atau closed_reason ada)
    foreach ($chats as &$chat) {
        $chat['expired'] = (!empty($chat['end_time']) || !empty($chat['closed_reason'])) ? true : false;
    }

    api_response(true, $chats, 'berhasil memuat chats');

    }

    if($user_role == 'client') {
        $client = $this->db->get_where('users', ['id' => $user_id, 'role' => 'client'])->row_array();
        if (!$client) {
            api_response(false, null, 'Client tidak ditemukan atau bukan role client');
            return;
        }

        // ambil chat dari model
        $chats = $this->chat->get_by_client($user_id);

        // tambahin flag expired
        foreach ($chats as &$chat) {
            $chat['expired'] = (!empty($chat['end_time']) || !empty($chat['closed_reason'])) ? true : false;
        }

        api_response(true, $chats, 'berhasil memuat chats');
        return;
    }

}
}