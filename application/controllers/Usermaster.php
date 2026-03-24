<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Usermaster extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('crud_model');
		$user = $this->session->userdata('user_id');
		if (!$user) {
			redirect(base_url('/login'));
		}
	}
	public function index()
	{
		$this->load->view('usermaster');
	}
	public function fetch()
	{
		$data['product_details'] = $this->crud_model->getAll('users');
		echo json_encode($data);
	}

	public function insert()
	{
		
		$password = $this->input->post('password');
		$hashed_password=password_hash($password, PASSWORD_DEFAULT);
		$data = array(
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'pass' =>$hashed_password,
			'phone' => $this->input->post('phone')
		);
		$result=$this->crud_model->insert('users',$data);
		if($result){
			echo 'done';
		}
		else{
			echo 0;
		}
		
	}
}
