<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lawyer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Lawyer_model');
        $this->output->set_content_type('application/json');
    }

    // GET /api/lawyers?online=1&sort=online
    public function index() {
        $online = $this->input->get('online');
        $sort   = $this->input->get('sort');

        $lawyers = $this->Lawyer_model->get_all($online, $sort);
        api_response(true, $lawyers);
    }

    // GET /api/lawyers/:id
    public function show($id) {
        $lawyer = $this->Lawyer_model->get_by_id($id);
        if ($lawyer) {
            echo json_encode(['success' => true, 'data' => $lawyer]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lawyer not found']);
        }
    }

    // POST /api/lawyers/toggle-online (role: lawyer)
    public function toggle_online() {
        // misalnya ambil ID lawyer dari session (kalau sudah login)
        $lawyer_id = $this->input->post('id'); 

        if (!$lawyer_id) {
            echo json_encode(['success' => false, 'message' => 'Lawyer ID required']);
            return;
        }

        $status = $this->Lawyer_model->toggle_online($lawyer_id);

        if ($status !== false) {
            echo json_encode(['success' => true, 'message' => 'Status updated', 'online' => $status]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lawyer not found']);
        }


    }


    public function Client($lawyer_id){
    $client = $this->Lawyer_model->clients($lawyer_id);

    api_response(true,$client);
        

    }
    
}
