<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
        $this->output->set_content_type('application/json');
    }

    // GET /users
    public function index()
    {
        $users = $this->user->get_all();
        echo json_encode(['status' => 'success', 'data' => $users]);
    }

    // GET /users/view/{id}
    public function view($id)
    {
        $user = $this->user->get_by_id($id);
        if ($user) {
            echo json_encode(['status' => 'success', 'data' => $user]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
        }
    }

    // POST /users/create
    public function create()
    {
        $data = json_decode($this->input->raw_input_stream, true);

        if (!isset($data['name'], $data['email'], $data['password_hash'], $data['role'])) {
            echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
            return;
        }

        $insert_id = $this->user->insert($data);
        echo json_encode(['status' => 'success', 'id' => $insert_id]);
    }

    // PUT /users/update/{id}
    public function update($id)
    {
        $data = json_decode($this->input->raw_input_stream, true);

        if ($this->user->update($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'User updated']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update user']);
        }
    }

    // DELETE /users/delete/{id}
    public function delete($id)
    {
        if ($this->user->delete($id)) {
            echo json_encode(['status' => 'success', 'message' => 'User deleted']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete user']);
        }
    }
}
