<?php

class crud_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // IMPORTANT
    }
    public function getAll($table)
    {   
        $this->db->select('*');
        $this->db->from($table);
        // $this->db->like('status','');

        $this->db->order_by('id','asc');
        $this->db->limit(100,0);

        $query = $this->db->get();
        if ($query) {

            return $query->result();
        } else {
            
        }
    }
    public function insert($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    
    public function getUser($table, $data)
    {
        $query=$this->db->get_where($table,array('id'=>$data));
        return $query->row(); 
    }
}
