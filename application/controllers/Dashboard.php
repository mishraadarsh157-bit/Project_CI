<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        $user = $this->session->userdata('user_id');
        if (!$user) {
            redirect(base_url('/login'));
        }
    }
    public function index()
    {
        $this->load->view('dashboard');
    }
    public function dashboard() {}
}
