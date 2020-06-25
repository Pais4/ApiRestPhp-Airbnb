<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductModel extends CI_Model {

	public function addProduct($product){
        // Nombre tabla, arreglo asociativo
        $this->db->insert('products', $product);
    }
    
    public function getProducts($user){

        
    }
}
