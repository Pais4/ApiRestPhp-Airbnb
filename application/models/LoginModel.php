<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {

	public function loginUser($data){

        $email = $data->email;
        $password = $data->password;

        $response = $this->db->query("SELECT * FROM users WHERE email = '${email}' AND password = '${password}'")->result();
        return $response;
        
    }
}

