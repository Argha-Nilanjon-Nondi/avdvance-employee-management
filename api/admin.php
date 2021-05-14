<?php
 
class Admin{
    public function add_user(){
        $objValidation= new Validation();
        $objValidation->data=$this->data;
        if($objValidation->checkArray(array("address","password","email","username","usertype","position","contactno","hiredate","incomeperhour"))==true){
          $email=$this->data["email"];
          $password=$this->data["password"];
          $username=$this->data["username"];
          $usertype=$this->data["usertype"];
          $position=$this->data["position"];
          $contactno=$this->data["contactno"];
          $address=$this->data["address"];
          $hiredate=$this->data["hiredate"];
          $incomeperhour=$this->data["incomeperhour"];
          $objValidation->email=$email;
          $objValidation->password=$password;
          $objValidation->contactno=$contactno;
          if(($objValidation->validEmail()==true) && ($objValidation->validPassword()==true) && ($objValidation->validContactNO()==true)){
            if($objValidation->isEmailExist()==false){
              $objDatabase=new Database();
              $objDatabase->getConnection();
              $randnum=strval(mt_rand());
              $objDatabase->sql="
                 INSERT users(userid,email,password,token) VALUES('".$randnum."','".$email."',SHA2('".$password."',256),SHA2('".$randnum."',256));
                 INSERT profiles(userid,usertype,username,position,contactno,address,incomeperhour,hiredate) 
                 VALUES('".$randnum."','".$usertype."','".$username."','".$position."','".$contactno."','".$address."',".$incomeperhour.",'".$hiredate."');
              ";
              $objDatabase->runSql();
              $data=array();
              $data["code"]="2005";
              $data["message"]="User is created successfully";
              echo json_encode($data);
            }
            else{
                $data=array();
                $data["code"]="3008";
                $data["message"]="Email is already exist";
                echo json_encode($data);
            } 
          }
          else{
            $data=array();
            $data["code"]="3003";
            $data["message"]="Required fields is not valid";
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

    public function get_users(){
      $objDatabase=new Database();
      $objDatabase->getConnection();
      $randnum=strval(mt_rand());
      $objDatabase->sql="SELECT userid,username FROM profiles;";
      $result=$objDatabase->runSql();
      $data=array();
      $data["code"]="2008";
      $data["message"]="User list is herey";
      $data['data']=$result;
      echo json_encode($data);
    }

    private function update_column($column,$value){
      $objDatabase=new Database();
      $objDatabase->getConnection();
      $objDatabase->sql="UPDATE profiles set ".$column."='".$value."' WHERE userid='".$this->userid."'; ";
      $objDatabase->runSql();
    }

    public function update_profile(){

    }
}

?>