<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoadEnvHook {
    public function loadEnvironment() {
        // Load helper env
        if (file_exists(APPPATH . 'helpers/env_helper.php')) {
            include_once(APPPATH . 'helpers/env_helper.php');
            
            if (function_exists('load_dotenv')) {
                load_dotenv();
            }
        }
    }
}