<?php

class AuthPage extends CI_Controller {

      public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url'); 
    }
    

    public function login() {
        
        $this->load->view('auth/login');
    }

    public function register() {
        $this->load->view('auth/register');
    }


    public function filter()
    {
        if ($this->input->method() === 'post') {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            // kirim ke API Auth/login
            $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://advokat.japrime.id/Api/Auth/login');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'email' => $email,
                'password' => $password
            ]));
            $response = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($response, true);


            if ($result && isset($result['status']) && $result['status'] === true) {
                $role = $result['data']['role'] ?? '';

                // simpan session
                $this->session->set_userdata([
                    'user_id'    => $result['data']['id'],
                    'user_email' => $result['data']['email'],
                    'user_role'  => $role
                ]);

                // redirect sesuai role
                if ($role === 'lawyer') {
                    redirect('dashboard');
                } else if ($role === 'client') {
                    redirect('lawyers/list');
                }
            } else {
                // gagal login, tampilkan pesan error
                $this->session->set_flashdata('error', $result['message'] ?? 'Login gagal');
                redirect('login');
            }
        } else {
            $this->load->view('login'); // default load view login
        }
    }
}