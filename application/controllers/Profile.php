<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_Model', 'user'); // pastikan model user ada
        $this->load->model('Lawyer_Model', 'lawyer'); // pastikan model user ada
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('login');
        }

        $data['user'] = $this->user->get_by_id($user_id);

        $this->load->view('dashboard/profile/index', $data);
    }

    public function edit()
    {
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('user_role');

        if(!$user_id)
            redirect('login');

        $data['user'] = $this->user->get_by_id($user_id);

        
        if($user_role == "lawyer"){
            $data['user'] = $this->lawyer->get_by_id($user_id);
        }

        $this->load->view('dashboard/profile/edit', $data);
    }

    private function request($api_url, $post_data)
    {
        // Request ke API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, base_url($api_url));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


        $result = json_decode($response, true);


        return [$httpcode, $result];
    }

    public function edit_profile()
    {
        $input = $this->input->post();
        $user_id = $this->session->userdata('user_id');

        $password = $input['password'];

        $post_data = [
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'status' => $input['status']
        ];

        if (!empty($password)) {
            $post_data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $post_data_lawyer = [];

        if($this->session->userdata('user_role') == "lawyer"){
            $post_data_lawyer = [
                'years_experience' => $input['years_experience'],
                'specialties' => $input['specialties'],
                'price_30m' => $input['price_30m'],
                'bio' => $input['bio']
            ];
        }

        $result = $this->request('Api/Auth/update/' . $user_id, $post_data);
        $result1 = $this->request('Api/Lawyer/update/' . $user_id, $post_data_lawyer);

        if ($this->session->userdata('user_role') == "lawyer") {
            if($result[0] == 200 && $result1[0] == 200){
                // simpan pesan sukses
                $this->session->set_flashdata('message', [
                    'type' => 'success',
                    'text' => 'Profil berhasil diperbarui.'
                ]);
            }

        } else if ($result[0] == 200){
            // simpan pesan sukses
            $this->session->set_flashdata('message', [
                'type' => 'success',
                'text' => 'Profil berhasil diperbarui.'
            ]);
        } else {
            // simpan pesan error
            $this->session->set_flashdata('message', [
                'type' => 'danger',
                'text' => 'Gagal memperbarui profil.'
            ]);
        }

        redirect('dashboard/profile/');
    }
}