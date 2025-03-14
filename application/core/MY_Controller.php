<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Func_model');
        $this->load->helper('cookie');
        date_default_timezone_set("Asia/Jakarta");
        if ($this->session->userdata('login') !== "Backend") {
            redirect('auth');
        }
    }
    public function set_flash($message, $icon = 'success') {
        $this->session->set_flashdata('notifikasi', $message);
        $this->session->set_flashdata('icon', $icon);
    }
}