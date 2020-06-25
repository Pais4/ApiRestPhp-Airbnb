<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties extends CI_Controller {
    
    public function addProperty(){

        function isNumeric($field){
            if(is_numeric($field)){
                return true;
            }
        }

        $method = $_SERVER['REQUEST_METHOD'];
        if($method === 'POST'){
            $json = file_get_contents('php://input');
            $data = json_decode($json);

            /* PROPERTIES FIELDS */
            $title = $data->title;
            $property_type = $data->property_type;
            $adress = $data->adress;
            $rooms = $data->rooms;
            $price = $data->price;
            $area = $data->area;
            $id_user = $data->id_user;

            /* NUMERIC VALIDATIONS */
            $isRoomNumeric = isNumeric($rooms);
            $isPriceNumeric = isNumeric($price);
            $isAreaNumeric = isNumeric($area);

            /* CONDITIONS */
            if($title == "" || $property_type == "" || $adress == "" || $rooms == "" || $price == "" || $area == "" || $id_user == "")
            {
                http_response_code(200);
                header('content-type: application/json');
                $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'The field can not be Empty']]);
                echo json_encode($response);
            }
            elseif($isRoomNumeric != true || $isPriceNumeric != true || $isAreaNumeric != true)
            {
                http_response_code(200);
                header('content-type: application/json');
                $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'The fields Room, price and area must be numeric']]);
                echo json_encode($response);
            }
            else 
            {
                $this->PropertiesModel->addProperty($data);
                http_response_code(200);
                header('content-type: application/json');
                $response = array('res' => ['success'=> true, 'data' => 'The properties has been added sucessfully', 'error' => ['title' => '', 'message' => '']]);
                echo json_encode($response);
            }
        }   else {
            http_response_code(404);
            header('content-type: application/json');
            $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'This is a POST Request, please change it if you want to use the API']]);
            echo json_encode($response);
        } 
    }

    public function getProperties(){
        header("Access-Control-Allow_Origin: *");
        $method = $_SERVER['REQUEST_METHOD'];

        if($method === 'GET'){
            $properties = $this->PropertiesModel->getAllProperties();
            http_response_code(200);
            header('content-type: application/json');
            $response = array('res'=>['success'=> true, 'data' => $properties, 'error' => ['title' => '', 'message' => '']]);
            echo json_encode($response);
        }   else {
            http_response_code(404);
            header('content-type: application/json');
            $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'This is a GET Request, please change it if you want to use the API']]);
            echo json_encode($response);
        } 
    }

    public function getSortedProperties(){
        
        header("Access-Control-Allow_Origin: *");
        $method = $_SERVER['REQUEST_METHOD'];

        if($method === 'GET'){
            $properties = $this->PropertiesModel->getSortedProperties();
            http_response_code(200);
            header('content-type: application/json');
            $response = array('res'=>['success'=> true, 'data' => $properties, 'error' => ['title' => '', 'message' => '']]);
            echo json_encode($response);
        }   else {
            http_response_code(404);
            header('content-type: application/json');
            $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'This is a GET Request, please change it if you want to use the API']]);
            echo json_encode($response);
        } 
    }

    public function getSortedById(){
        
        $method = $_SERVER['REQUEST_METHOD'];

        if($method === 'POST'){

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            $userId = $data->userid;

            $properties = $this->PropertiesModel->getSortedUserProperties($userId);
            http_response_code(200);
            header('content-type: application/json');
            $response = array('res'=>['success'=> true, 'data' => $properties, 'error' => ['title' => '', 'message' => '']]);
            echo json_encode($response);
        } else {
            http_response_code(404);
            header('content-type: application/json');
            $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'This is a POST Request, please change it if you want to use the API']]);
            echo json_encode($response);
        } 
    }

    public function updateProperty(){

        $method = $_SERVER['REQUEST_METHOD'];

        if($method === 'PUT'){

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            $this->PropertiesModel->updateProperty($data);

            http_response_code(200);
            header('content-type: application/json');
            $response = array('res' => ['success'=> true, 'data' => $data, 'error' => ['title' => '', 'message' => '']]);
            echo json_encode($response);
        } else {
            http_response_code(404);
            header('content-type: application/json');
            $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'This is a PUT Request, please change it if you want to use the API']]);
            echo json_encode($response);
        } 
    }

    public function deleteProperty(){
        $method = $_SERVER['REQUEST_METHOD'];

        if($method === 'DELETE'){
            $json = file_get_contents('php://input');
            $data = json_decode($json);

            $this->PropertiesModel->deleteProperty($data->id);

            http_response_code(200);
            header('content-type: application/json');
            $response = array('res' => ['success'=> true, 'data' => $data, 'error' => ['title' => '', 'message' => '']]);
            echo json_encode($response);
        } else {
            http_response_code(404);
            header('content-type: application/json');
            $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'This is a DELETE Request, please change it if you want to use the API']]);
            echo json_encode($response);
        }
    }
}