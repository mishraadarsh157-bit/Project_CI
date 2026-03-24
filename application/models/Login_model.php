<?php

class Login_model extends CI_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function check_login($email, $password)
    {
        $this->db->select('*');
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        if ($query->num_rows() == 1) {
            $user = $query->row();

            if (password_verify($password, $user->pass)) {
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function logout(){

    }
}
