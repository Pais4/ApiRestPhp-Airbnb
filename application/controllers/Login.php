<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index()
	{
		echo 'Index Login Controller';
    }
    
    public function loginUser(){

        $method = $_SERVER['REQUEST_METHOD'];

        if($method === 'POST'){
            
            $json = file_get_contents('php://input');
            $data = json_decode($json);

            $user = $this->LoginModel->loginUser($data);
            
            if($data->email == ""){
                http_response_code(200); // ARREGLAR CODIGO
                header('content-type: application/json');
                $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'Email is necessary']]);
                echo json_encode($response);
            } 
            elseif($data->password == ""){
                http_response_code(200); // ARREGLAR CODIGO
                header('content-type: application/json');
                $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'Password is necessary']]);
                echo json_encode($response);
            }
            elseif(!empty($user)) {
                http_response_code(200); // ARREGLAR CODIGO
                header('content-type: application/json');
                $response = array('res' => ['success'=> true, 'data' => 'Logged Succesfully', 'error' => ['title' => '', 'message' => '']]);
                echo json_encode($response);
            }
            else 
            {
                http_response_code(200); // ARREGLAR CODIGO
                header('content-type: application/json');
                $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'User or Password wrong! ¿Would you like to recover your user?']]);
                echo json_encode($response);
            }
           
        } else {
            http_response_code(404);
            header('content-type: application/json');
            $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'This is a POST Request, please change it if you want to use the API']]);
            echo json_encode($response);
        }

    }

}

//header("Access-Control-Allow-_Origin: *") -> Para conectarnos desde cualquier parte