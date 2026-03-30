<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('dashboard_model');
        $user = $this->session->userdata('user_id');
        if (!$user) {
            redirect(base_url('/login'));
        }
    }
    public function index()
    {
        $this->load->view('dashboard');
    }
    public function fetch() {
        $data[] = $this->dashboard_model->loadData('users','','');
        $data[] = $this->dashboard_model->loadData('client','','');
        $data[] = $this->dashboard_model->loadData('items','','');
        $data[] = $this->dashboard_model->loadData('invoice','','');
        $data[] = $this->dashboard_model->loadData('users','STATUS',1);
        $data[] = $this->dashboard_model->loadData('users','STATUS !=',1);
        $data[] = $this->dashboard_model->loadData('client','client_status ',1);
        $data[] = $this->dashboard_model->loadData('client','client_status !=',1);
        echo json_encode($data);
    }
}
