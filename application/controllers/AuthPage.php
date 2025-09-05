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

    
    private function request($api_url, $post_data)
    {
        // Request ke API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


        $result = json_decode($response, true);

        return $result;
    }

    public function regis()
{
    $name     = $this->input->post('name');
    $email    = $this->input->post('email');
    $phone    = $this->input->post('phone');
    $role     = $this->input->post('role');
    $password = $this->input->post('password');

    $years_experience = $this->input->post('years_experience') ?? '';
    $specialties      = $this->input->post('specialties') ?? '';
    $price_30m        = $this->input->post('price_30m') ?? '';
    $bio              = $this->input->post('bio') ?? '';

    // --- 1. Register user ---
    $post_data = [
        'name'     => $name,
        'email'    => $email,
        'phone'    => $phone,
        'role'     => $role,
        'password' => $password,
    ];

    $result  = $this->request(base_url('Api/Auth/register'), $post_data);
    $result1 = true; // default true untuk client
    $wallet  = null;

    if ($result && !empty($result['data']['user_id'])) {
        $user_id = $result['data']['user_id'];

        // --- 2. Lawyer detail jika role lawyer ---
        if ($role === 'lawyer') {
            $post_data1 = [
                'user_id'     => $user_id,
                'years'       => $years_experience,
                'specialties' => $specialties,
                'price_30m'   => $price_30m,
                'bio'         => $bio
            ];
            $result1 = $this->request(base_url('Api/Auth/req_lawyer_detail'), $post_data1);
        }

        // --- 3. Create wallet ---
        $wallet_data = [
            'user_id' => $user_id,
            'balance' => 0
        ];
        $wallet = $this->request(base_url('Api/Wallet/create'), $wallet_data);
    }

    // --- 4. Final validasi terakhir ---
    if (
        $result && !empty($result['data']['user_id']) &&
        $result1 && (!is_array($result1) || (isset($result1['status']) && $result1['status'] === true)) &&
        $wallet && isset($wallet['status']) && $wallet['status'] === true
    ) {
        $this->load->view('auth/register', [
            'status'  => 200,
            'message' => 'Register berhasil, wallet dibuat'
        ]);
    } else {
        $this->load->view('auth/register', [
            'status'  => 400,
            'message' => 'Register gagal'
        ]);
    }
}





    public function filter()
    {
        if ($this->input->method() === 'post') {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            // kirim ke API Auth/login
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, base_url('Api/Auth/login'));
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
                if ($role === 'lawyer' || $role === 'admin') {
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