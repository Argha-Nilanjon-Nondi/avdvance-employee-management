<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;");
  if($_SERVER["REQUEST_METHOD"]=="POST"){
    $json = file_get_contents('php://input');
    $json_data=json_decode($json,true);
    if((isset($json_data["token"])==true)){
      
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