<?php
class Login{
   public function logmein(){
    $objValidation=new Validation();
    if(($objValidation->validEmail($this->email)==false) && ($objValidation->validPassword($this->password)==false)){
      $data=array();
      $data["code"]="3003";
      $data["message"]="Email or Password is not valid";
      echo json_encode($data);
    }

    $objDatabase=new Database();
    $objDatabase->getConnection();
    
    $randnum=strval(mt_rand());
     $objDatabase->sql="SELECT token FROM users WHERE email='".$this->email."' AND password=SHA2('".$this->password."',256);
     UPDATE users set token=SHA2('".$randnum."',256) WHERE email='".$this->email."' AND password=SHA2('".$this->password."',256) ";
     $sqlRep=$objDatabase->runSql();
     if(count($sqlRep)==0){
         $data=array();
         $data["code"]="3000";
         $data["message"]="Crediantials are not correct";
         echo json_encode($data);
         return 0;
     }

     $objDatabase->sql="SELECT token FROM users WHERE email='".$this->email."' AND password=SHA2('".$this->password."',256);";
     $sqlRep=$objDatabase->runSql();
     $token=$sqlRep[0]["token"];
     $data=array();
     $data["code"]="2000";
     $data["message"]="You are logged in";
     $data["data"]=array("token"=>$token);
     echo json_encode($data);
     return 0;
   }  
}


?>