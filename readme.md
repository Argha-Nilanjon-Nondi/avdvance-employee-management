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


5||update an users porofile
url:http://localhost/employee_management_system/admin.php
method:POST
JSON:{
  "action":"update-profile",
  "token":"dd225a8cb1556ba965f9f39da3db92f7edd5dc593026ea72ddc41158dbb8d415",
  "data":{
    "userid":"2108963712",
    "username":"Argha Nilanjon Nondi",
    "contactno":"+8801710962",
    "address":"London",
    "position":"full Stack",
    "incomeperhour":"1000",
    "hiredate":"2021-02-30"
  }
}



6||get the user's profile
url:http://localhost/employee_management_system/admin.php
method:POST
JSON:{
  "action":"get-profile",
  "token":"dd225a8cb1556ba965f9f39da3db92f7edd5dc593026ea72ddc41158dbb8d415",
  "data":{
    "userid":"2108963712"
  }
}


7||check in a user
url:http://localhost/employee_management_system/admin.php
method:post
JSON:{
  "action":"checkin",
  "token":"dd225a8cb1556ba965f9f39da3db92f7edd5dc593026ea72ddc41158dbb8d415",
  "data":{
    "userid":"2108963712",
    "checkin":"12:11:01",
    "date":"2021-05-30"
  }
}


8||checkout a user
url:http://localhost/employee_management_system/admin.php
method:post 
JSON:{
  "action":"checkout",
  "token":"dd225a8cb1556ba965f9f39da3db92f7edd5dc593026ea72ddc41158dbb8d415",
  "data":{
    "userid":"2108963712",
    "checkout":"18:11:40",
    "date":"2021-05-30"
  }
}


9||Delete a user
url:http://localhost/employee_management_system/admin.php
method:post
JSON:{
  "action":"delete-user",
  "token":"dd225a8cb1556ba965f9f39da3db92f7edd5dc593026ea72ddc41158dbb8d415",
  "data":{
    "userid":"657634785"
  }
}

10||change password
url:http://localhost/employee_management_system/admin.php
method:post
JSON:{
  "action":"change-password",
  "token":"dd225a8cb1556ba965f9f39da3db92f7edd5dc593026ea72ddc41158dbb8d415",
  "data":{
    "token":"94ad6bb68fc3c374384ade6ed47454b9ece77dfce71919ef2762522c6117771f",
    "old-password":"9171914300",
    "new-password":"917191439900"
  }
}