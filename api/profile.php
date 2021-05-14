<?php
class Profile{
    public function get_info(){
        $objDatabase=new Database();
        $objDatabase->getConnection();
        $randnum=strval(mt_rand());
        $objDatabase->sql="SELECT username,position,contactno,address,incomeperhour,hiredate FROM profiles WHERE userid='".$this->userid."';";
        $sqlRep=$objDatabase->runSql();
        $data=array();
        $data["code"]="2003";
        $data["message"]="Profile data retrieved successfully";
        $data["data"]=$sqlRep;
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
          if($objValidation->checkArray(array($column))==false){  
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
}

// $profileObj=new Profile();
// $profileObj->userid="909890890"
// $profileObj->get_info();

?>