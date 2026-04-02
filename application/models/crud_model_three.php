<?php

class crud_model_three extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // IMPORTANT
    }
    public function getAll($table, $search, $field, $order, $limit, $offset)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->group_start();
        $this->db->like('item_name', $search);
        $this->db->or_like('price', $search);
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

    public function getitems($table, $data)
    {
        $query = $this->db->get_where($table, array('item_id' => $data));
        return $query->row();
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
