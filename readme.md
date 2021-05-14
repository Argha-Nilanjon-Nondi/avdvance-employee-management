1|| login and get token for further process 
method:post
url:http://localhost/employee_management_system/login.php
JSON : {
    "email":"admin@gmail.com",
    "password":"avunix9143"
}




2|| get details for a user of given token
method:post
url:http://localhost/employee_management_system/profile.php
JSON:{
  "action":"get-data",
  "token":"dd225a8cb1556ba965f9f39da3db92f7edd5dc593026ea72ddc41158dbb8d415",
  "data":{
    }
}



3|| update details for a user of given token
method:post
url:http://localhost/employee_management_system/profile.php
JSON:{
  "action":"update-profile",
  "token":"dd225a8cb1556ba965f9f39da3db92f7edd5dc593026ea72ddc41158dbb8d415",
  "data":{
      "username":"Argha Nilanjon Nondi",
      "contactno":"+8801710962748",
      "address":"Hamdhao , Jhenidha , Khulna , Bangladesh"
    }
}
Note:You can reduce the number of key-value pair in the "data" json project



4|| add a user (only admin has the permission)
method:post
url:http://localhost/employee_management_system/admin.php
JSON:{
  "action":"add-user",
  "token":"dd225a8cb1556ba965f9f39da3db92f7edd5dc593026ea72ddc41158dbb8d415",
  "data":{
    "password":"12345678",
    "email":"user@gmail.com",
    "username":"Argha",
    "usertype":"employee",
    "position":"Web developer",
    "contactno":"+8801710962748",
    "hiredate":"2020-01-30",
    "address":"America",
    "incomeperhour":500
    }



  4|| show users list (only admin has the permission)
method:post
url:http://localhost/employee_management_system/admin.php
JSON:{
  "action":"get-users",
  "token":"dd225a8cb1556ba965f9f39da3db92f7edd5dc593026ea72ddc41158dbb8d415",
  "data":"000"
}