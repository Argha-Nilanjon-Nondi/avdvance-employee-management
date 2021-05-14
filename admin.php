<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;");
require_once("./api/database.php");
require_once("./api/validation.php");
require_once("./api/admin.php");
if($_SERVER["REQUEST_METHOD"]=="POST"){
  $json = file_get_contents('php://input');
  $json_data=json_decode($json,true);
  $objValidation=new Validation();
  $objValidation->data=$json_data;
  if($objValidation->checkArray(array("token","action","data"))==true){
    $token= $json_data["token"];
    $action=$json_data["action"];
    $data=$json_data["data"];
    $objValidation->token=$token;
    if(($objValidation->ValidToken()==true)){
      $objValidation->userid=$objValidation->tokenToId();
      if($objValidation->isAdmin()==true){
        //actual code is here
        $objAdmin= new Admin();
        $objAdmin->data=$data;
        if($action=="add-user"){
          //add a use
          $objAdmin->add_user();
        }
        else if($action=="get-users"){
          //get users list
          $objAdmin->get_users();
        }
        else if($action=="update-profile"){
          $objAdmin->update_profile();
        }
        else{
          $data=array();
          $data["code"]="3006";
          $data["message"]="Can not find requested action";
          echo json_encode($data); 
        }
      }
      else{
        $data=array();
        $data["code"]="3007";
        $data["message"]="You are not admin";
        echo json_encode($data); 
      }
    }
    else{
      $data=array();
      $data["code"]="3004";
      $data["message"]="Token is not valid";
      echo json_encode($data);
    }
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