<?php

class crud_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // IMPORTANT
    }
    public function getAll($table,$status,$search,$field,$order,$limit,$offset)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->like('status', $status);
        $this->db->group_start();
        $this->db->like('name', $search);
        $this->db->or_like('email', $search);
        $this->db->or_like('phone', $search);
        $this->db->group_end();
        $this->db->order_by($field, $order);
        $this->db->limit($limit,$offset);

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

    public function getUser($table, $data)
    {
        $query = $this->db->get_where($table, array('id' => $data));
        return $query->row();
    }
    public function if_exist($table, $field, $value, $id)
    {
        $this->db->select($field);
        $this->db->from($table);
        if (trim($id) == '') {
            $this->db->where($field, $value);
        } else {
            $this->db->where($field, $value);
            $this->db->where('id !=', $id);
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
}
