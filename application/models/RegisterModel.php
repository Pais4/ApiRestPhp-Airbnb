<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegisterModel extends CI_Model {

	public function addUser($user){
        // Nombre tabla, arreglo asociativo
        $this->db->insert('users', $user);
    }
    
    public function getUser($email){

        $response = $this->db->query("SELECT * FROM users WHERE email = '${email}'")->result();
        return $response;
    }
}
