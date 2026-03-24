<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Login_model');
		$this->load->library('session');
		$user=$this->session->userdata('user_id');
		if($user){
			redirect(base_url('/dashboard'));
		}
	}

	public function index()
	{
		$this->load->view('login.php');
	}
	public function logged_in()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$user = $this->Login_model->check_login($email, $password);
		if($user){
		$this->session->set_userdata('user_id',$user->id);
		$this->session->set_userdata('email',$user->email);
		echo 'success';
		}
		else{
			echo "invalid";
		}
	}
}
