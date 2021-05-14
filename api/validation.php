<?php


  class Validation{

  public function validPassword(){
          for($i=0;$i<strlen($this->password);$i++){
             if($this->password[$i]==" "){
               return false;             
          }
      }

      if(strlen($this->password)<8){
          return false;
      }

      return true;
  }

  public function validEmail(){
    if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        return false;
      }
      return true;
  }

  public function validID(){
    $obj=new Database();
    $obj->getConnection();
     $obj->sql="SELECT userid FROM users WHERE userid='".$this->id."'";
     $sqlRep=$obj->runSql();
     if(count($sqlRep)==0){
       return false;
     }
     return true;
  }

  public function ValidToken(){
    $obj=new Database();
    $obj->getConnection();
     $obj->sql="SELECT userid FROM users WHERE token='".$this->token."'";
     $sqlRep=$obj->runSql();
     if(count($sqlRep)==0){
       return false;
     }
     return true;
  }

  public function tokenToId(){
    $obj=new Database();
    $obj->getConnection();
     $obj->sql="SELECT userid FROM users WHERE token='".$this->token."'";
     $sqlRep=$obj->runSql();
     return $sqlRep[0]["userid"];
  }

  public function validContactNO(){
    for($i=0;$i<strlen($this->contactno);$i++){
       if($this->contactno[$i]==" "){
         return false;             
        }
     }

     if(strlen($this->contactno)<11){
       return false; 
      }
    return true;
  }
  
  public function isAdmin(){
    $objDatabase=new Database();
    $objDatabase->getConnection();
     $objDatabase->sql="SELECT usertype FROM profiles WHERE usertype='admin' AND userid='".$this->userid."'";
     $sqlRep=$objDatabase->runSql();
     if(count($sqlRep)==0){
       return false;
     }
     return true;
  }

  public function isIdExist(){
    $objDatabase=new Database();
    $objDatabase->getConnection();
     $objDatabase->sql="SELECT userid FROM profiles WHERE userid='".$this->userid."'";
     $sqlRep=$objDatabase->runSql();
     if(count($sqlRep)==0){
       return false;
     }
     return true;
  }

  public function isEmailExist(){
    $objDatabase=new Database();
    $objDatabase->getConnection();
     $objDatabase->sql="SELECT userid FROM users WHERE email='".$this->email."'";
     $sqlRep=$objDatabase->runSql();
     if(count($sqlRep)==0){
       return false;
     }
     return true;
  }

  public function checkArray($checkkey){
    for($i=0;$i<count($checkkey);$i++){
      if( (isset($this->data[$checkkey[$i]])==false)){
          return false;
      }
      else{
        if((empty($this->data[$checkkey[$i]])==true)){
          return false;
        }
      }
    }
    return true;
  }
}

// $obj=new Validation();
// $obj->password="hhjijh9999";
// $obj->token="931e7780fdb2d079eacbdc0886030c98a51ba667f5f59a8e";
// $obj->email="admin@gmail.com";
// $obj->id="657634785";
// echo json_encode($obj->validID());
?>