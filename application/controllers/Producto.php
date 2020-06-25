<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto extends CI_Controller {

	public function index()
	{
		echo 'Index Producto Controller';
    }
    
    public function addProduct(){
        $method = $_SERVER['REQUEST_METHOD'];
        if($method === 'POST'){
            $json = file_get_contents('php://input');
            // Esto lo convierte en un arreglo asociativo
            $data = json_decode($json);
            // Testeamos que nos devuelve
            //var_dump($data);

            // Validamos
            if($data->title)

            $this->ProductModel->addProduct($data);
            http_response_code(200);
            header('content-type: application/json');
            $response = array('response' => 'Todo Good');
            echo json_encode($response);
        } else {
            http_response_code(200);
            header('content-type: application/json');
            $response = array('response' => 'Bad Request');
            echo json_encode($response);
        }
    }

    public function getProduct(){
        echo 'getProduct Controller';
    }

    public function updateProduct(){
        echo 'updateProduct Controller';
    }

    public function deleteProduct(){

    }
}