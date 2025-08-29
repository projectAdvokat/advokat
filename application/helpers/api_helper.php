<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('api_response')) {
    function api_response($ok = true, $data = null, $message = null, $status_code = 200) {
        $ci =& get_instance();
        $ci->output
            ->set_status_header($status_code)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'ok' => $ok,
                'data' => $data,
                'message' => $message
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }
}

if (!function_exists('api_get')) {
    function api_get($url, $assoc = true) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, base_url($url));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, $assoc);
    }
}
