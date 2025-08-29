<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['midtrans_client_key'] = '';
$config['midtrans_server_key'] = '';
$config['midtrans_is_production'] = false;

// Function untuk membaca file .env
function parse_env_file() {
    $env_file = FCPATH . '.env';
    
    if (!file_exists($env_file)) {
        return [];
    }
    
    $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env_vars = [];
    
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        // Parse key=value
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Remove quotes
            $value = trim($value, '"\'');
            
            $env_vars[$key] = $value;
        }
    }
    
    return $env_vars;
}

// Load environment variables
$env_vars = parse_env_file();

// Set config values from .env
if (!empty($env_vars)) {
    if (isset($env_vars['MIDTRANS_CLIENT_KEY'])) {
        $config['midtrans_client_key'] = $env_vars['MIDTRANS_CLIENT_KEY'];
    }
    
    if (isset($env_vars['MIDTRANS_SERVER_KEY'])) {
        $config['midtrans_server_key'] = $env_vars['MIDTRANS_SERVER_KEY'];
    }
    
    if (isset($env_vars['MIDTRANS_IS_PRODUCTION'])) {
        $config['midtrans_is_production'] = ($env_vars['MIDTRANS_IS_PRODUCTION'] === 'true');
    }
}