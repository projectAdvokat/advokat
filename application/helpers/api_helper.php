<?php
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
