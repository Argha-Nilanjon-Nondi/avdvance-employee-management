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
  if(
    (isset($json_data["token"])==true) &&
    (isset($json_data["action"])==true) &&
    (isset($json_data["data"])==true) &&
    (empty($json_data["token"])==false) &&
    (empty($json_data["action"])==false)
   ){
    $token= $json_data["token"];
    $action=$json_data["action"];
    $data=$json_data["data"];
    if(($objValidation->ValidToken($token=$token)==true)){
      $userid=$objValidation->tokenToId($token=$token);
      if($objValidation->isAdmin($userid=$userid)==true){
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
        else if($action=="get-profile"){
          //get user"s profile
          $objAdmin->get_profile();
        }
        else if($action=="update-profile"){
          //update user data
          $objAdmin->update_profile();
        }
        else if($action=="checkin"){
          //checkin a user
          $objAdmin->checkin();
        }
        else if($action=="checkout"){
          //checkout a user
          $objAdmin->checkout();
        }
        else if($action=="delete-check"){
          //checkout a user
          $objAdmin->deletecheck();
        }
        else if($action=="delete-user"){
          //checkout a user
          $objAdmin->deleteuser();
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