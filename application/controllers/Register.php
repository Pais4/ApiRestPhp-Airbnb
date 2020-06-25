<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
    
    public function addUser()
    {
    
        /* FUNCTIONS */
        function getSpecialCharacters($data, $length){
            $notAllowed = "¡@#$%&?¿*";
            $count = 0;
            for($i=0; $i<strlen($notAllowed);$i++){
                for($j=0; $j<$length; $j++){
                    if($data[$j] == $notAllowed[$i]){
                        $count++;
                    }
                }
            }
            return $count;
        }
        
        $method = $_SERVER['REQUEST_METHOD'];

        if($method === 'POST'){

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            /* FIELDS */
            $name = $data->name;
            $lastName = $data->lastname;
            $email = $data->email;
            $typeId = $data->type_id;
            $id = $data->identification;
            $pass = $data->password;
            
            /* NAME AND LASTNAME VALIDATIONS */
            $nameLength = strlen($name);
            $lastNameLength = strlen($lastName);
            $passLength = strlen($pass);
            $typeIdLength = strlen($id);
            $nameHasSpecial = getSpecialCharacters($name, $nameLength);
            $lastNameHasSpecial = getSpecialCharacters($lastName, $lastNameLength);
            $passHasSpecial = getSpecialCharacters($pass, $passLength);

            /* EMAIL VALIDATIONS */
            $emailCharacter = '@';
            $endEmailCom = '.com';
            $endEmailNet = '.net';
            $characterValidation = strpos($email, $emailCharacter);
            $endFirstValidation = strpos($email, $endEmailCom);
            $endSecondValidation = strpos($email, $endEmailNet);

            /* ID VALIDATIONS */
            $errorIdPassport = false;
            $errorIdCc = false;
            if($typeId == 'Pas' || $typeId == 'Pas')
            {
                if($typeIdLength >= 10){
                    $errorIdPassport = true;
                } 
            }
            elseif($typeId == 'cc' || $typeId == 'CC')
            {
                if(!is_numeric($id)){
                    $errorIdCc = true;
                }
            }

            /* CONDITIONS */
            if($name == "" || $lastName == "" || $email == "" || $typeId == "" || $id == "" || $pass == "")
            {
                http_response_code(200);
                header('content-type: application/json');
                $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'The field can not be Empty']]);
                echo json_encode($response);
            }
            elseif($nameLength > 40 || $lastName > 40)
            {
                http_response_code(200);
                header('content-type: application/json');
                $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'The field can not have more than 40 characters.']]);
                echo json_encode($response);
            } 
            elseif($nameHasSpecial > 0 || $lastNameHasSpecial > 0)
            {
                http_response_code(200);
                header('content-type: application/json');
                $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'The field name can not have special Characters (¡@#$%&?¿¡)']]);
                echo json_encode($response);
            }
            elseif($characterValidation == false || $endFirstValidation == false || $endSecondValidation || false)
            {
                http_response_code(200);
                header('content-type: application/json');
                $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'Invalid Email, please enter a valid email.']]);
                echo json_encode($response);
            }
            elseif($passLength < 8 || $passLength > 16)
            {
                http_response_code(200);
                header('content-type: application/json');
                $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'Your password must have at least 8 characters and no more than 16.']]);
                echo json_encode($response);
            }
            elseif($passHasSpecial < 2)
            {
                http_response_code(200);
                header('content-type: application/json');
                $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'Your password must have at least 2 special Characters Like these (¡@#$%&?¿*)']]);
                echo json_encode($response);
            }
            elseif($errorIdPassport == true)
            {
                http_response_code(200);
                header('content-type: application/json');
                $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'Your Passport should not have more than 10 characters']]);
                echo json_encode($response);
            }
            elseif($errorIdCc == true)
            {
                http_response_code(200);
                header('content-type: application/json');
                $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'Your CC should not have alphabetical characters']]);
                echo json_encode($response);
            }
            else 
            {
                $validateEmail = $this->RegisterModel->getUser($data->email);
                
                if(!empty($validateEmail)){
                    http_response_code(200);
                    header('content-type: application/json');
                    $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'The Username already exists']]);
                    echo json_encode($response);
                } else {
                    $this->RegisterModel->addUser($data);
                    http_response_code(200);
                    header('content-type: application/json');
                    $response = array('res' => ['success'=> true, 'data' => 'User Created Sucessfully', 'error' => ['title' => '', 'message' => '']]);
                    echo json_encode($response);
                }                
            }
        } else {
            http_response_code(404);
            header('content-type: application/json');
            $response = array('res'=>['success'=> false, 'data' => '', 'error' => ['title' => 'Bad Request', 'message' => 'This is a POST Request, please change it if you want to use the API']]);
            echo json_encode($response);
        } 
    
    }
}
