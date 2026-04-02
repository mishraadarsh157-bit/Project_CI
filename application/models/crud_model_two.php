<?php

class crud_model_two extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // IMPORTANT
    }
    public function getAll($table1, $table2, $table3, $status, $search, $field, $order, $limit, $offset)
    {
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, 'client.city_id = cities.id', 'inner');
        $this->db->join($table3, 'client.state_id = states.id', 'inner');
        // $user = $this->session->userdata('user_id');
        // $this->db->where('id !=', $user);
        $this->db->like('client_status', $status);
        $this->db->group_start();
        $this->db->like('client_name', $search);
        $this->db->or_like('client_email', $search);
        $this->db->or_like('phone', $search);
        $this->db->group_end();
        $this->db->order_by($field, $order);
        $this->db->limit($limit, $offset);

        $query = $this->db->get();
        if ($query) {

            return $query->result();
        } else {
            return 0;
        }
    }

    public function insert($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function getClient($table, $data)
    {
        $query = $this->db->get_where($table, array('client_id' => $data));
        if ($query) {
            return $query->row();
        } else {
            return false;
        }
    }
    public function if_exist($table, $field, $value, $id)
    {
        $this->db->select($field);
        $this->db->from($table);
        if (trim($id) == '') {
            $this->db->where($field, $value);
        } else {
            $this->db->where($field, $value);
            $this->db->where('client_id !=', $id);
        }
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return true;
        } else {
            return false;
        }
    }
    public function update($table, $data, $field, $id)
    {
        $this->db->where($field, $id);
        $upd = $this->db->update($table, $data);
        if ($upd) {
            return true;
        } else {
            return false;
        }
    }
    public function delete($table, $field, $id)
    {
        $this->db->where($field, $id);
        $upd = $this->db->delete($table);
        if ($upd) {
            return true;
        } else {
            return false;
        }
    }
    public function states($table)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        if ($query) {
            return $query->result();
        } else {
            echo 0;
        }
    }
    public function cities($table, $state)
    {
        $this->db->select('*');
        $this->db->where('state_id', $state);

        $this->db->from($table);
        $this->db->order_by('city', 'ASC');
        $query = $this->db->get();
        if ($query) {
            return $query->result();
        } else {
            echo 'city';
        }
    }
}
