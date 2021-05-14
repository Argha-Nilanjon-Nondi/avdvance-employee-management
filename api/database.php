<?php
class Database{
 private $host="localhost"; 
 private $username="argha_nilanjon";
 private $password="avunix9143";
 private $database="advance-employee-management";
 public $connection=null;

 public function getConnection(){
     try{
        $dbconn=new PDO("mysql:host=".$this->host.";dbname=".$this->database, $this->username, $this->password);
        $this->connection=$dbconn;
     }
     catch(PDOException $exception){
       echo $exception->getMessage();  
     }
   return $this->connection;
 }

 public function runSql(){
   $stmt=$this->connection->prepare($this->sql);
   $stmt->execute();
   $result=array();
   while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
         array_push($result,$row);
   }
   
   return $result;
 }
 
}

// $obj=new Database();
// $obj->sql="
// INSERT users(`userid`,`email`,`username`,`password`,`token`) VALUES('657634785','admin@gmail.com','admin1234',SHA2('avunix9143',256),SHA2('12344564',256))
// ";
// $obj->getConnection();
// echo json_encode($obj->runSql());