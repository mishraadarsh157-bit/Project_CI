<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Itemmaster extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('crud_model_three');
        $user = $this->session->userdata('user_id');
        if (!$user) {
            redirect(base_url('/login'));
        }
    }
    public function index()
    {
        $this->load->view('itemmaster');
    }
    public function fetch()
    {
        // $status=$_POST['status']??"";
        $search = $_POST['search'] ?? "";
        $field = $_POST['field'] ?? "item_id";
        $order = $_POST['order'] ?? "asc";
        $limit = $_POST['limit'] ?? 20;
        $offset = $_POST['offset'] ?? 0;
        // $search,$field,$order,$limit,$offset
        $data['data'] = $this->crud_model_three->getAll('items', $search, $field, $order, $limit, $offset);
        $data['pages'] = $this->crud_model_three->getAll('items', $search, $field, $order, 100, 0);


        echo json_encode($data);
    }

    public function insert()
    {

        if ($this->form_validation->run('itemValid') === FALSE) {
            echo  validation_errors();
        } else {
            $name = trim($this->input->post('name'));

            $description = trim($this->input->post('description'));
            $price = trim($this->input->post('price'));
            $image = trim($this->input->post('image'));
            $image_name = $_FILES['image']['name'] ?? "";
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_type = $_FILES['image']['type'];
            $image_content = file_get_contents($image_tmp);
            $uploadDir = 'uploads/';
            $filePath = $uploadDir . basename($image_name);
            move_uploaded_file($image_tmp, $filePath);
            $data = array(
                'item_name' => $name,
                'description' => $description,
                'price' => $price,
                'item_image' => $filePath
            );
            $result = $this->crud_model_three->insert('items', $data);
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

        $data[] = $this->crud_model_three->getitems('items', $id);
        $dataa['data'] = $data;
        echo json_encode($dataa);
    }
    public function update($id)
    {



        if ($this->form_validation->run('itemUpdate') == FALSE) {
            echo  validation_errors();
        } else {

            $name = trim($this->input->post('name'));
            $description = trim($this->input->post('description'));
            $price = trim($this->input->post('price'));

            $data = array(
                'item_name'   => $name,
                'description' => $description,
                'price'       => $price
            );

            // ✅ only validate if image is uploaded
            if (!empty($_FILES['image']['name'])) {

                $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
                $max_size = 2 * 1024 * 1024; // 2MB

                $file_type = $_FILES['image']['type'];
                $file_size = $_FILES['image']['size'];
                $image_tmp = $_FILES['image']['tmp_name'];
                $image_name = $_FILES['image']['name'];

                // ❌ type validation
                if (!in_array($file_type, $allowed_types)) {
                    echo "invalid Only JPG, JPEG, PNG allowed";
                    return;
                }

                // ❌ size validation
                if ($file_size > $max_size) {
                    echo "invalid Max size is 2MB";
                    return;
                }

                // ✅ upload
                $uploadDir = 'uploads/';
                $filePath = $uploadDir . time() . '_' . basename($image_name);

                if (move_uploaded_file($image_tmp, $filePath)) {

                    $data['item_image'] = $filePath;

                    // 🔥 delete old image
                    $old_image = $this->input->post('old_image');
                    if (!empty($old_image) && file_exists($old_image)) {
                        unlink($old_image);
                    }
                } else {
                    echo "invalid Image upload failed";
                    return;
                }
            }

            $result = $this->crud_model_three->update('items', $data, 'item_id', $id);

            if ($result) {
                echo 'updated';
            } else {
                echo "invalid entries";
            }
        }
    }
    public function delete($id)
    {
        $result = $this->crud_model_three->delete('items', 'item_id', $id);
        if ($result) {
            echo 'deleted';
        } else {
            echo 0;
        }
    }

    public function image_check()
    {
        if (empty($_FILES['image']['name'])) {
            $this->form_validation->set_message('image_check', 'Image is required');
            return FALSE;
        }

        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
        $max_size = 2 * 1024 * 1024; // 2MB

        $file_type = $_FILES['image']['type'];
        $file_size = $_FILES['image']['size'];

        // Type validation
        if (!in_array($file_type, $allowed_types)) {
            $this->form_validation->set_message('image_check', 'Only JPG, JPEG, PNG allowed');
            return FALSE;
        }

        // Size validation
        if ($file_size > $max_size) {
            $this->form_validation->set_message('image_check', 'Max size is 2MB');
            return FALSE;
        }

        return TRUE;
    }
}
    
    // $autoload['helper'] = array('url' , 'form' , 'cookie');
    // $autoload['libraries'] = array('database' , 'session');