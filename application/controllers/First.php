<?php
// defined('BASEPATH') or exit('No direct script access allowed');

// class First extends CI_Controller
// {

// 	public function __construct()
// 	{
// 		parent::__construct();
// 		$this->load->model('crud_model');
// 	}

// 	public function index()
// 	{
// 		$this->load->view('First');
// 	}
// 	public function fetch()
// 	{
// 		$data['product_details'] = $this->crud_model->getAllProducts();
// 		echo json_encode($data);
// 	}
// 	public function insert()
// 	{
// 		$data = array(
// 			'name' => $this->input->post('name'),
// 			'password' => $this->input->post('password'),
// 			'email' => $this->input->post('email'),
// 			'phone' => $this->input->post('phone')
// 		);
// 		$result = $this->crud_model->insert('users', $data);
// 		echo $result;
// 	}
// 	public function edit($id)
// 	 {
		
// 		$data[]= $this->crud_model->getUser('users',$id);
// 		$dataa['data']=$data;
// 		echo json_encode($dataa);
// 	 }
// }
