<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Usermaster extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
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
				public function fetch(
					
					)
					{	
						$status=$_POST['status']??"";
		$search=$_POST['search']??"";
		$field=$_POST['field']??"id";
		$order=$_POST['order']??"asc";
		$limit=$_POST['limit']??20;
		$offset=$_POST['offset']??0;
		// $search,$field,$order,$limit,$offset
		$data['data'] = $this->crud_model->getAll('users',$status,$search,$field,$order,$limit,$offset );
		$data['pages'] = $this->crud_model->getAll('users',$status,$search,$field,$order,100,0 );

		
		echo json_encode($data);
	}

	public function insert()
	{

		if ($this->form_validation->run('usersValid') === FALSE) {
			echo  validation_errors();
		} else {
			$name = trim($this->input->post('name'));
			$email = trim($this->input->post('email'));

			$phone = trim($this->input->post('phone'));
			$password = trim($this->input->post('password'));
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			$data = array(
				'name' => $name,
				'email' => $email,
				'pass' => $hashed_password,
				'phone' => $phone
			);
			$result = $this->crud_model->insert('users', $data);
			if ($result) {
				echo 'inserted';
			} else {
				echo 0;
			}
		}
		// }
	}
	public function edit($id)
	{

		$data[] = $this->crud_model->getUser('users', $id);
		$dataa['data'] = $data;
		echo json_encode($dataa);
	}
	public function update($id)
	{
		if ($this->form_validation->run('updateUser') === FALSE) {
			echo  validation_errors();
		} else {
			$name = trim($this->input->post('name'));
			$email = trim($this->input->post('email'));
			$status = trim($this->input->post('status'));
			$exist = $this->crud_model->if_exist('users', 'email', $email, $id);
			if ($exist) {
				echo "email_exists";
			} else {


				$phone = trim($this->input->post('phone'));
				$data = array(
					'name' => $name,
					'email' => $email,
					'phone' => $phone,
					'STATUS' => $status
				);
				$result = $this->crud_model->update('users', $data, 'id', $id);

				if ($result) {
					echo 'updated';
				} else {
					echo 0;
				}
			}
		}
	}
	public function delete($id)
	{
		$result = $this->crud_model->delete('users', 'id', $id);
		if ($result) {
			echo 'deleted';
		} else {
			echo 0;
		}
	}
}



// $autoload['helper'] = array('url' , 'form' , 'cookie');
// $autoload['libraries'] = array('database' , 'session');