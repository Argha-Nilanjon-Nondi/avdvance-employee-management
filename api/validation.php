<?php


  class Validation{

  public function validPassword($password){
          for($i=0;$i<strlen($password);$i++){
          
             if($password[$i]==" "){
               return false;             
          }
      }

      if(strlen($password)<8){
          return false;
      }

      return true;
  }

  public function validEmail($email){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
      }
      return true;
  }

  public function validID($id){
    $obj=new Database();
    $obj->getConnection();
     $obj->sql="SELECT userid FROM users WHERE userid='".$id."'";
     $sqlRep=$obj->runSql();
     if(count($sqlRep)==0){
       return false;
     }
     return true;
  }

  public function ValidToken($token){
    $obj=new Database();
    $obj->getConnection();
     $obj->sql="SELECT userid FROM users WHERE token='".$token."'";
     $sqlRep=$obj->runSql();
     if(count($sqlRep)==0){
       return false;
     }
     return true;
  }

  public function tokenToId($token){
    $obj=new Database();
    $obj->getConnection();
     $obj->sql="SELECT userid FROM users WHERE token='".$token."'";
     $sqlRep=$obj->runSql();
     return $sqlRep[0]["userid"];
  }

  public function validContactNO($contactno){
    for($i=0;$i<strlen($contactno);$i++){
       if($contactno[$i]==" "){
         return false;             
        }
     }

     if(strlen($contactno)>17 || strlen($contactno)<11){
       return false; 
      }
    return true;
  }
  
  public function isAdmin($userid){
    $objDatabase=new Database();
    $objDatabase->getConnection();
     $objDatabase->sql="SELECT usertype FROM profiles WHERE usertype='admin' AND userid='".$userid."'";
     $sqlRep=$objDatabase->runSql();
     if(count($sqlRep)==0){
       return false;
     }
     return true;
  }

  public function isIdExist($userid){
    $objDatabase=new Database();
    $objDatabase->getConnection();
     $objDatabase->sql="SELECT userid FROM profiles WHERE userid='".$userid."'";
     $sqlRep=$objDatabase->runSql();
     if(count($sqlRep)==0){
       return false;
     }
     return true;
  }

  public function isEmailExist($email){
    $objDatabase=new Database();
    $objDatabase->getConnection();
     $objDatabase->sql="SELECT userid FROM users WHERE email='".$email."'";
     $sqlRep=$objDatabase->runSql();
     if(count($sqlRep)==0){
       return false;
     }
     return true;
  }

  public function checkArray($checkkey){
    for($i=0;$i<count($checkkey);$i++){
      if(isset($this->data[$checkkey[$i]])==false){
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

  public function validPosition($position){
    $avaliable_position=array("web developer","Hacker","Marn developer","Data entTy","Full stack");
    for($i=0;$i<count($avaliable_position);$i++){
      $input_position=str_ireplace(" ","",strtolower($position));
      $db_positon=str_ireplace(" ","",strtolower($avaliable_position[$i]));
      if($db_positon==$input_position){
        return ucwords(strtolower($position));
      }
    }
    return false;
  }

  public function validUserType($type){
    $avaliable_type=array("admin","employee");
    for($i=0;$i<count($avaliable_type);$i++){
      $input_type=str_ireplace(" ","",strtolower($type));
      $db_type=str_ireplace(" ","",strtolower($avaliable_type[$i]));
      if($db_type==$input_type){
        return strtolower($type);
      }
    }
    return false;
  }  

  public function validDate($date){
    $mod_text=explode("-",$date);
    $year=$mod_text[0];
    $month=$mod_text[1];
    $day=$mod_text[2];
    return checkdate($month,$day,$year);
  }

  public function validTime($time){
    return strtotime($time);
}

  }

// $obj=new Validation();
// $obj->password="hhjijh9999";
// $obj->token="931e7780fdb2d079eacbdc0886030c98a51ba667f5f59a8e";
// $obj->email="admin@gmail.com";
// $obj->id="6634785";
// echo json_encode($obj->validID());
?>