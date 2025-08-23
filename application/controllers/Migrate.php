<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('migration');
    }

    public function index()
    {
        if ($this->migration->latest() === FALSE)
        {
            show_error($this->migration->error_string());
        } else {
            echo "Migrasi berhasil ke versi terbaru.";
        }
    }

    public function reset()
    {
        if ($this->migration->version(0) === FALSE)
        {
            show_error($this->migration->error_string());
        } else {
            echo "Rollback berhasil, semua tabel sudah dihapus.";
        }
    }

    public function version($version)
    {
        if ($this->migration->version($version) === FALSE)
        {
            show_error($this->migration->error_string());
        } else {
            echo "Migrasi berhasil ke versi {$version}.";
        }
    }
}
