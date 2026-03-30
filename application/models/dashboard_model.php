<?php

class dashboard_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // IMPORTANT
    }
    public function loadData($table,$where,$status) {
        if(trim($where)==""){
            return $this->db->count_all($table);
            }
            else{
               return $this->db->where($where, $status)->count_all_results($table);
        }
    }
}
