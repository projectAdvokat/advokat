<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model', 'user');
        $this->load->library('session');
        $this->output->set_content_type('application/json');
    }

    /**
     * Generate referral code unik (5 huruf campur + 5 angka)
     */
    private function generate_ref_code()
    {
        $letters = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 5);
        $numbers = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
        return $letters . $numbers;
    }
    /**
     * Register user baru
     */

        
    public function register()
    {
        $data = json_decode($this->input->raw_input_stream, true);

        if (!$data || !isset($data['email'], $data['password'], $data['name'], $data['phone'], $data['role'])) {
            echo json_encode(['status' => false, 'message' => 'Invalid payload']);
            return;
        }

        $email = strtolower(trim($data['email']));
        $role = strtolower(trim($data['role']));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->output
                ->set_status_header(400)
                ->set_output(json_encode(['status' => false, 'message' => 'Format email tidak valid']));
            return;
        }



        $domain = substr(strrchr($email, "@"), 1);

        if (!checkdnsrr($domain, "MX")) {
            $this->output
                ->set_status_header(400)
                ->set_output(json_encode(['status' => false, 'message' => 'Domain email tidak valid']));
            return;
        }
    

        // Cek apakah email sudah ada di database
        if ($this->user->get_by_email($data['email'])) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(409) // conflict
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Email sudah terdaftar, tidak bisa daftar lagi dengan role lain'
                ]));
        }


        // Ambil referrer dari session
        $referrer_id = null;
        if ($this->session->userdata('referral_code')) {
            $ref_code = $this->session->userdata('referral_code');
            $referrer = $this->user->get_by_ref_code($ref_code);
            if ($referrer) {
                $referrer_id = $referrer->id;
            }
        }

        // Generate ref_code unik
        do {
            $ref_code_new = $this->generate_ref_code();
        } while ($this->user->get_by_ref_code($ref_code_new));

        // Simpan user
        $insert = [
            'name'         => $data['name'],
            'email'        => $email,
            'phone'        => $data['phone'],
            'role'         => $role,
            'password_hash'=> password_hash($data['password'], PASSWORD_BCRYPT),
            'ref_code'     => $ref_code_new,
            'referrer_id'  => $referrer_id,
            'status'       => 1
        ];

        $user_id = $this->user->insert($insert);

        echo json_encode([
            'status' => true,
            'message' => 'Register berhasil',
            'data' => [
                'id' => $user_id,
                'email' => $email,
                'role' => $role,
                'ref_code' => $ref_code_new,
                'referrer_id' => $referrer_id
            ]
        ]);
    }

    /**
     * Login
     */
    public function login()
    {
        // input post non json
            $email = $this->input->post('email');
    $password = $this->input->post('password');


        if (!isset($email, $password)) {
            echo json_encode(['status' => false, 'message' => 'Invalid payload']);
            return;
        }

        $user = $this->user->get_by_email($email);
        if (!$user) {
            echo json_encode(['status' => false, 'message' => 'User tidak ditemukan']);
            return;
        }

        if (!password_verify($password, $user->password_hash)) {
            echo json_encode(['status' => false, 'message' => 'Password salah']);
            return;
        }

        // Set session login
        $this->session->set_userdata(['user_id' => $user->id, 'user_role' => $user->role, 'user_email' => $user->email, 'user_name' => $user->name]);

        echo json_encode([
            'status' => true,
            'message' => 'Login berhasil',
            'data' => [
                'id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'ref_code' => $user->ref_code
            ]
        ]);
    }

    /**
     * Logout
     */
    public function logout()
{
    $this->session->unset_userdata(['user_id', 'username', 'logged_in']);
    // echo json_encode(['status' => true, 'message' => 'Logout berhasil']);
    redirect(base_url('login'));
}


}
