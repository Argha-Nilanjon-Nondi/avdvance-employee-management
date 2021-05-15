<?php
class Profile{
    public function get_info(){
        $objDatabase=new Database();
        $objDatabase->getConnection();
        $objDatabase->sql="SELECT users.email,profiles.userid,profiles.username,profiles.usertype,profiles.position,profiles.contactno,profiles.address,profiles.incomeperhour,profiles.hiredate FROM profiles,users  WHERE profiles.userid='$this->userid' AND users.userid='$this->userid'";
        $sqlRep1=$objDatabase->runSql();
        $objDatabase->sql="SELECT workdate,incomeperhour,checkin,checkout FROM workhours ORDER BY workdate WHERE userid='$this->userid' ASC;";
        $sqlRep2=$objDatabase->runSql();
        $data=array();
        $data["code"]="2003";
        $data["message"]="Profile data retrieved successfully";
        $data["data-1"]=$sqlRep1;
        $data["data-2"]=$sqlRep2;
        echo json_encode($data);
    }


    private function update_column($column,$value){
        $objDatabase=new Database();
        $objDatabase->getConnection();
        $objDatabase->sql="UPDATE profiles set ".$column."='".$value."' WHERE userid='".$this->userid."'; ";
        $objDatabase->runSql();
    }

    public function update_profile(){
      $objValidation=new Validation();
      $objValidation->data=$this->updated_data;
      foreach($this->updated_data as $column=>$value){
          if(
              (isset($this->updated_data[$column])==false) ||
              (empty($value)==true)
          ){  
               $data=array();
               $data["code"]="3005";
               $data["message"]="Required fields cannot be empty";
               echo json_encode($data);
               return 0;
          }
         if($column=="username" || $column=="address"){
             $this->update_column($column,$value);
         }

         if($column=="contactno"){
             $objValidation=new Validation();
             if($objValidation->validContactNO($contactno=$value)==true){
                $this->update_column($column,$value);
             }
             else{
                $data=array();
                $data["code"]="3007";
                $data["message"]="Cantact is not valid";
                echo json_encode($data);
             }
            
        }


      }
      $data=array();
      $data["code"]="2004";
      $data["message"]="Profile data updated successfully";
      echo json_encode($data);
    }

    public function change_password(){
     if( 
         (isset($this->updated_data["token"])==false) ||
         (isset($this->updated_data["old-password"])==false) ||
         (isset($this->updated_data["new-password"])==false) ||
         (empty($this->updated_data["token"])==true) ||
         (empty($this->updated_data["old-password"])==true) ||
         (empty($this->updated_data["new-password"])==true)
     ){
        $data=array();
        $data["code"]="3005";
        $data["message"]="Required fields cannot be empty";
        echo json_encode($data);
        return 0; 
     }
     $token=$this->updated_data["token"];
     $old_password=$this->updated_data["old-password"];
     $new_password=$this->updated_data["new-password"];

     $objValidation=new Validation();

     if(($objValidation->ValidToken($token=$token)==false)){
        $data=array();
        $data["code"]="3004";
        $data["message"]="Token is not valid";
        echo json_encode($data);
        return 0;
     }

     if(
     ($objValidation->validPassword($old_password)==false) && 
     ($objValidation->validPassword($new_password)==false)
     ){
        $data=array();
        $data["code"]="3013";
        $data["message"]="Password is not valid";
        echo json_encode($data);
      }
  

     $objDatabase=new Database();
     $objDatabase->getConnection();
     $randnum=strval(mt_rand());
     $objDatabase->sql="SELECT userid FROM users WHERE token='$token' AND password=SHA2('$old_password',256);";
     $sqlRep=$objDatabase->runSql();
     if(count($sqlRep)==0){
         $data=array();
         $data["code"]="3000";
         $data["message"]="Crediantials are not correct";
         echo json_encode($data);
         return 0;
     }

    $userid=$sqlRep[0]["userid"];

    $objDatabase->sql=" UPDATE users set password=SHA2('$new_password',256) WHERE userid='$userid'; ";
    $objDatabase->runSql();
    $data=array();
    $data["code"]="2105";
    $data["message"]="Password is sucessfully changed";
    echo json_encode($data);
    return 0;
    }
}

// $profileObj=new Profile();
// $profileObj->userid="909890890"
// $profileObj->get_info();

?>