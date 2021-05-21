<?php
 
class Admin{
    public function add_user(){
        $objValidation= new Validation();
        if(
          (isset($this->data["email"])==false) ||
          (isset($this->data["password"])==false) ||
          (isset($this->data["username"])==false) ||
          (isset($this->data["usertype"])==false) ||
          (isset($this->data["position"])==false) ||
          (isset($this->data["contactno"])==false) ||
          (isset($this->data["address"])==false) ||
          (isset($this->data["hiredate"])==false) ||
          (isset($this->data["incomeperhour"])==false) ||
          (empty($this->data["email"])==true) ||
          (empty($this->data["password"])==true) ||
          (empty($this->data["username"])==true) ||
          (empty($this->data["usertype"])==true) ||
          (empty($this->data["position"])==true) ||
          (empty($this->data["contactno"])==true) ||
          (empty($this->data["address"])==true) ||
          (empty($this->data["hiredate"])==true) ||
          (empty($this->data["incomeperhour"])==true)
        ){
          $data=array();
          $data["code"]="3002";
          $data["message"]="Required fields are not found";
          echo json_encode($data);
          return 0;
        }
          $email=$this->data["email"];
          $password=$this->data["password"];
          $username=$this->data["username"];
          $usertype=$this->data["usertype"];
          $position=$this->data["position"];
          $contactno=$this->data["contactno"];
          $address=$this->data["address"];
          $hiredate=$this->data["hiredate"];
          $incomeperhour=$this->data["incomeperhour"];
          if(($objValidation->validEmail($email)==false) || 
          ($objValidation->validPassword($password)==false) || 
          ($objValidation->validContactNO($contactno)==false) ||
          ($objValidation->validPosition($position=$position)==false) ||
          ($objValidation->validUserType($type=$usertype)==false)
          ){
            $data=array();
            $data["code"]="3003";
            $data["message"]="Required fields is not valid";
            echo json_encode($data);
            return 0;
          }

          if($objValidation->isEmailExist($email)==true){
            $data=array();
            $data["code"]="3008";
            $data["message"]="Email is already exist";
            echo json_encode($data);
            return 0;
          }
              $objDatabase=new Database();
              $objDatabase->getConnection();
              $randnum=strval(mt_rand());
              $objDatabase->sql="
                 INSERT users(userid,email,password,token) VALUES('$randnum','$email',SHA2('$password',256),SHA2('$randnum',256));
                 INSERT profiles(userid,usertype,username,position,contactno,address,incomeperhour,hiredate) 
                 VALUES('$randnum','$usertype','$username','$position','$contactno','$address','$incomeperhour,'$hiredate');
              ";
              $objDatabase->runSql();
              $data=array();
              $data["code"]="2005";
              $data["message"]="User is created successfully";
              echo json_encode($data);
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
      $objDatabase->sql="SELECT users.email,profiles.userid,profiles.username,profiles.usertype,profiles.position,profiles.contactno,profiles.address,profiles.incomeperhour,profiles.hiredate FROM profiles,users  WHERE profiles.userid='$employeeid' AND users.userid='$employeeid'";
      $sqlRep1=$objDatabase->runSql();
      $objDatabase->sql="SELECT workdate,incomeperhour,checkin,checkout FROM workhours ORDER BY workdate WHERE userid='$employeeid';";
      $sqlRep2=$objDatabase->runSql();

      $data=array();
      $data["code"]="2035";
      $data["message"]="Profile is retrived";
      $data["data-1"]=$sqlRep1;
      $data["data-2"]=$sqlRep2;
      echo json_encode($data);

    }

    public function checkin(){
      $objValidation=new Validation();
      $objValidation->data=$this->data;
      
     
      if(
        (isset($this->data["userid"])==false) ||
        (empty($this->data["userid"])==true)
       ){
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

      if((isset($this->data["date"])==false) || 
         (isset($this->data["checkin"])==false) || 
         (empty($this->data["date"])==true) || 
         (empty($this->data["checkin"])==true)){
        $data1=array();
        $data1["code"]="3005";
        $data1["message"]="Required fields cannot be empty";
        echo json_encode($data1);
        return 0;
      }

      $workdate=$this->data["date"];
      $checkin=$this->data["checkin"];

      if($objValidation->validDate($date=$workdate)==false){
        $data=array();
        $data["code"]="3021";
        $data["message"]="Employee working date is not valid";
        echo json_encode($data);
        return 0;
       }


      if($objValidation->validTime($time=$checkin)==false){
        $data=array();
        $data["code"]="3031";
        $data["message"]="Employee checkin time is not valid";
        echo json_encode($data);
        return 0;
      }

      $objDatabase=new Database();
      $objDatabase->getConnection();

     $objDatabase->sql="SELECT workdate FROM workhours WHERE workdate='$workdate' AND userid='$employeeid'; ";
     $sqlRep=$objDatabase->runSql();
     if(count($sqlRep)!=0){
         $data=array();
         $data["code"]="3060";
         $data["message"]="Working date is already exist";
         echo json_encode($data);
         return 0;
      }

      $objDatabase->sql="SELECT incomeperhour FROM profiles WHERE userid='$employeeid'";
      $incomeperhour=$objDatabase->runSql()[0]['incomeperhour'];

      $objDatabase->sql="INSERT workhours(userid,workdate,incomeperhour,checkin) VALUES('$employeeid','$workdate','$incomeperhour','$checkin')";
      $sqlRep=$objDatabase->runSql();

      $data=array();
      $data["code"]="2035";
      $data["message"]="User is successfully checkin";
      echo json_encode($data);   
    }

    public function checkout(){
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

      $objValidation=new Validation();
      if((isset($this->data["date"])==false) || 
         (isset($this->data["checkout"])==false) || 
         (empty($this->data["date"])==true) || 
         (empty($this->data["checkout"])==true)){
        $data1=array();
        $data1["code"]="3005";
        $data1["message"]="Required fields cannot be empty";
        echo json_encode($data1);
        return 0;
      }

      $workdate=$this->data["date"];
      $checkout=$this->data["checkout"];

      if($objValidation->validDate($date=$workdate)==false){
        $data=array();
        $data["code"]="3021";
        $data["message"]="Employee working date is not valid";
        echo json_encode($data);
        return 0;
       }


      if($objValidation->validTime($time=$checkout)==false){
        $data=array();
        $data["code"]="3041";
        $data["message"]="Employee checkout time is not valid";
        echo json_encode($data);
        return 0;
      }

      $objDatabase=new Database();
      $objDatabase->getConnection();

     $objDatabase->sql="SELECT workdate FROM workhours WHERE workdate='$workdate' AND userid='$employeeid'; ";
     $sqlRep=$objDatabase->runSql();
     if(count($sqlRep)==0){
         $data=array();
         $data["code"]="3064";
         $data["message"]="Working date does not exist";
         echo json_encode($data);
         return 0;
      }

      $objDatabase->sql="UPDATE workhours SET checkout='$checkout' WHERE userid='$employeeid' AND workdate='$workdate' ;";
      $sqlRep=$objDatabase->runSql();

      $data=array();
      $data["code"]="2035";
      $data["message"]="User is successfully checkout";
      echo json_encode($data);   
    }

    public function deletecheck(){
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

      $objValidation=new Validation();
      if((isset($this->data["date"])==false) || 
         (empty($this->data["date"])==true)){
        $data1=array();
        $data1["code"]="3005";
        $data1["message"]="Required fields cannot be empty";
        echo json_encode($data1);
        return 0;
      }

      $workdate=$this->data["date"];

      if($objValidation->validDate($date=$workdate)==false){
        $data=array();
        $data["code"]="3021";
        $data["message"]="Employee working date is not valid";
        echo json_encode($data);
        return 0;
       }


      $objDatabase=new Database();
      $objDatabase->getConnection();

     $objDatabase->sql="SELECT workdate FROM workhours WHERE workdate='$workdate' AND userid='$employeeid'; ";
     $sqlRep=$objDatabase->runSql();
     if(count($sqlRep)==0){
         $data=array();
         $data["code"]="3064";
         $data["message"]="Working date does not exist";
         echo json_encode($data);
         return 0;
      }

      $objDatabase->sql=" DELETE FROM workhours WHERE userid='$employeeid' AND workdate='$workdate' ;";
      $sqlRep=$objDatabase->runSql();

      $data=array();
      $data["code"]="2095";
      $data["message"]="User checkout  is successfully delete";
      echo json_encode($data);   
    }

    public function deleteuser(){
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

      if($objValidation->isAdmin($userid=$employeeid)==true){
        $data=array();
        $data["code"]="3085";
        $data["message"]="Admin can not be deleted";
        echo json_encode($data);
        return 0;
      }

      $objDatabase=new Database();
      $objDatabase->getConnection();

      $objDatabase->sql=" DELETE FROM workhours WHERE userid='$employeeid';
      DELETE FROM users WHERE userid='$employeeid';
      DELETE FROM profiles WHERE userid='$employeeid';
      ";
      $sqlRep=$objDatabase->runSql();

      $data=array();
      $data["code"]="2100";
      $data["message"]="User is deleted";
      echo json_encode($data);   
    }
}

?>