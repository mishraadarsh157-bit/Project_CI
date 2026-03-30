<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Clientmaster extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('crud_model_two');
		$user = $this->session->userdata('user_id');
		if (!$user) {
			redirect(base_url('/login'));
		}
	}
	public function index()
	{
		$this->load->view('clientmaster');
	}
	public function fetch()
	{
		$status = $_POST['status'] ?? "";
		$search = $_POST['search'] ?? "";
		$field = $_POST['field'] ?? "client_id";
		$order = $_POST['order'] ?? "asc";
		$limit = $_POST['limit'] ?? 20;
		$offset = $_POST['offset'] ?? 0;
		// $search,$field,$order,$limit,$offset
		$data['data'] = $this->crud_model_two->getAll('client', 'cities', 'states', $status, $search, $field, $order, $limit, $offset);
		$data['pages'] = $this->crud_model_two->getAll('client', 'cities', 'states', $status, $search, $field, $order, 100, 0);


		echo json_encode($data);
	}

	public function insert()
	{
		if ($this->form_validation->run('clientsValid') === false) {
			echo "valid";
			echo  json_encode(validation_errors());
		} else {
			$name = trim($this->input->post('name'));
			$email = trim($this->input->post('email'));
			$phone = trim($this->input->post('phone'));
			$address = trim($this->input->post('address'));
			$city = trim($this->input->post('city'));
			$state = trim($this->input->post('state'));
			$pincode = trim($this->input->post('pincode'));

			$data = array(
				'client_name' => $name,
				'client_email' => $email,
				'phone' => $phone,
				'address' => $address,
				'city_id' => $city,
				'state_id' => $state,
				'pincode' => $pincode
			);
			$result = $this->crud_model_two->insert('client', $data);
			if ($result) {
				echo 'inserted';
			} else {
				echo 0;
			}
		}
	}
	public function edit($id)
	{

		$data[] = $this->crud_model_two->getClient('client', $id);
		$dataa['data'] = $data;
		echo json_encode($dataa);
	}
	public function update($id)
	{
		
		if ($this->form_validation->run('updateClient') === FALSE) {
			echo  validation_errors();
		} else {
			$name = trim($this->input->post('name'));
			$email = trim($this->input->post('email'));
			$address = trim($this->input->post('address'));
			$email = trim($this->input->post('email'));
			$state = trim($this->input->post('state'));
			$city = trim($this->input->post('city'));
			$pincode = trim($this->input->post('pincode'));
			$status = trim($this->input->post('status'));
			$exist = $this->crud_model_two->if_exist('client', 'client_email', $email, $id);
			if ($exist) {
				echo "email_exists";
			} else {


				$phone = trim($this->input->post('phone'));
				$data = array(
					'client_name' => $name,
					'client_email' => $email,
					'address' => $address,
					'state_id' => $state,
					'city_id' => $city,
					'phone' => $phone,
					'pincode' => $pincode,
					'client_status' => $status,
				);
				
				$result = $this->crud_model_two->update('client', $data, 'client_id', $id);

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
		// echo "this $id";
		$result = $this->crud_model_two->delete('client', 'client_id', $id);
		if ($result) {
			echo 'deleted';
		} else {
			echo 0;
		}
	}
	public function fetchstates()
	{
		$result = $this->crud_model_two->states('states');
		if ($result) {
			echo json_encode($result);
		} else {
			echo "---";
		}
	}
	public function fetchcities($state)
	{
		$result = $this->crud_model_two->cities('cities', $state);
		if ($result) {
			echo json_encode($result);
		} else {
			echo "---";
		}
	}
}



// $autoload['helper'] = array('url' , 'form' , 'cookie');
// $autoload['libraries'] = array('database' , 'session');