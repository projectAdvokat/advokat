<?php
class AuthHook {
    public function check_login() {
        $CI =& get_instance();
        $CI->load->library('session');

        // biar Auth controller tidak terblokir
        $current_controller = $CI->router->fetch_class();

        if (!$CI->session->userdata('user_id')) {
            redirect('/login');
        }
    }
}
