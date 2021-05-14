<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;");
require_once("./api/database.php");
require_once("./api/validation.php");
require_once("./api/login.php");
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $json = file_get_contents('php://input');
    $json_data=json_decode($json,true);
    $objValidation=new Validation();
    $objValidation->data=$json_data;
    if($objValidation->checkArray(array("email","password"))==true){
        $email= $json_data["email"];
        $password= $json_data["password"];
        $objLogin=new Login();
        $objLogin->email=$email;
        $objLogin->password=$password;
        $objLogin->logmein();  
     }
    else{
     $data=array();
     $data["code"]="3002";
     $data["message"]="Required fields are not found";
     echo json_encode($data);
    }
  }
else{
     $data=array();
     $data["code"]="3001";
     $data["message"]="Requests must be POST";
     echo json_encode($data);
}
?>