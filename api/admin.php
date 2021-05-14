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
          if(($objValidation->validEmail($email)==true) && ($objValidation->validPassword($password)==true) && ($objValidation->validContactNO($contactno)==true)){
            if($objValidation->isEmailExist($email)==false){
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

    private function update_column($column,$value,$employeeid){
      $objDatabase=new Database();
      $objDatabase->getConnection();
      $objDatabase->sql="UPDATE profiles set ".$column."='".$value."' WHERE userid='".$employeeid."'; ";
      $objDatabase->runSql();
    }

    public function update_profile(){
      $objValidation=new Validation();
      $objValidation->data=$this->data;
      
     
      if($objValidation->checkArray(array("userid"))==false){
        $data=array();
        $data["code"]="3055";
        $data["message"]="Employee user id is missing";
        echo json_encode($data);
        return 0;
      }

      
      $employeeid=$this->data["userid"];
      if($objValidation->validID($id=$employeeid)==false){
        $data=array();
        $data["code"]="3035";
        $data["message"]="Employee user id is not valid";
        echo json_encode($data);
        return 0;
      }      

      $objValidation->data=$this->data;
      foreach($this->data as $column=>$value){
        if( (isset($this->data[$column])==false) || (empty($this->data[$column])==true) ){
           $data1=array();
           $data1["code"]="3005";
           $data1["message"]="Required fields cannot be empty";
           echo json_encode($data1);
           return 0;
          }

        if($column=="username"){
            $this->update_column($column,$value,$employeeid);
        }
        
        if($column=="address"){
            $this->update_column($column,$value,$employeeid);
         }

         if($column=="contactno"){
           $objValidation=new Validation();
           if($objValidation->validContactNO($contactno=$value)==false){ 
             $data=array();
             $data["code"]="3007";
             $data["message"]="Cantact is not valid";
             echo json_encode($data);
             return 0;
            }
            $this->update_column($column,$value,$employeeid);
           
            
        }

        if($column=="position"){
          if($objValidation->validPosition($position=$value)==false){
           $data=array();
           $data["code"]="3011";
           $data["message"]="Employee position is not valid";
           echo json_encode($data);
           return 0;
          }
          
            $this->update_column($column,$objValidation->validPosition($position=$value),$employeeid);
          
        }

        if($column=="hiredate"){
          if($objValidation->validDate($date=$value)==false){
           $data=array();
           $data["code"]="3021";
           $data["message"]="Employee hire date is not valid";
           echo json_encode($data);
           return 0;
          }
            $this->update_column($column,$value,$employeeid);
        }

        if($column=="incomeperhour"){
          if(is_numeric($value)==false){
            $data=array();
            $data["code"]="3017";
            $data["message"]="Number is not valid";
            return 0;
          }
          $this->update_column($column,$value,$employeeid);
        }


      }
      $data=array();
      $data["code"]="2004";
      $data["message"]="Profile data updated successfully";
      echo json_encode($data);
    }

    public function get_profile(){
      $objValidation=new Validation();
      $objValidation->data=$this->data;
      
     
      if($objValidation->checkArray(array("userid"))==false){
        $data=array();
        $data["code"]="3055";
        $data["message"]="Employee user id is missing";
        echo json_encode($data);
        return 0;
      }

      
      $employeeid=$this->data["userid"];
      if($objValidation->validID($id=$employeeid)==false){
        $data=array();
        $data["code"]="3035";
        $data["message"]="Employee user id is not valid";
        echo json_encode($data);
        return 0;
      } 

      $objDatabase=new Database();
      $objDatabase->getConnection();
      $objDatabase->sql="SELECT email,userid,username,usertype,position,contactno,address,incomeperhour,hiredate FROM profiles LEFT JOIN users ON profiles.userid=users.usersid WHERE profilrs.userid='".$employeeid."' AND";
      $sqlRep=$objDatabase->runSql();

      $data=array();
      $data["code"]="2035";
      $data["message"]="Profile is retrived";
      $data["data"]=$sqlRep;
      echo json_encode($data);

    }
}

?>