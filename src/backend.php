<?php

// echo json_encode([
//             "status" => "Success",
//             #"authToken" => $passwordHash
//             #"authToken" => "hello world auth_token"
//         ]);

// $DBservername = "127.0.0.1";
// $DBusername = "material";
// $DBpassword = "material";
// $DBname = "material";
//
// try {
//     $conn = new PDO("mysql:host=$DBservername;dbname=$DBname", $DBusername, $DBpassword);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     #echo "Connected successfully";
// } catch(PDOException $e) {
//     #echo "Connection failed: " . $e->getMessage();
//     $response = [
//         "status" => "Fail",
//         "errorMessage" => "Unable to connect to database: " . $e->getMessage(),
//     ];
//     echo json_encode($response);
// }

// actions:

// class User {
//     public $username;
//     public $password;
//
//     function __construct($username, $password) {
//         $this->username = $username;
//         $this->password = $password;
//     }
// }


//
// $userlist = [ new User("me", "test"), new User("1", "newtest") ]

//$test = [ new User("Robert", "test") ];

$userlist = [
    "me" => "pwd",
    "test" => "test"
];


$action = $_REQUEST["action"];
#$authToken = $_REQUEST["authToken"]; # generate from cookie

if ($action === "login")
{
    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];
    #$passwordHash = password_hash($password, PASSWORD_DEFAULT); # , "PASSWORD_DEFAULT", []
    #$passwordHash = $userlist[$username];

    #if ($userlist[$username] === $password) {
    if (True) {
    ##if password_verify($password, $passwordHash)
        $response = [
            "status" => "Success",
            #"authToken" => $passwordHash
            "authToken" => "hello world auth_token"
        ];
    } else {
        $response = [
            "status" => "Fail",
            "errorMessage" => "Username or password incorrect"
        ];
    }
}

if ($action === "getSampleData")
{
    $response = [
        "data1",
        14,
        "data3"
    ];
}

// if ($action === "register")
// {
//     $username = $_REQUEST["username"];
//     $password = $_REQUEST["password"];
// }
#$conn = null; # close DB connection

echo json_encode($response);



// $q = $_REQUEST["query"];
// $test = $_REQUEST["test"];
// $answer = $q .  ' ' . $test;
// if ($q == null)
// {
//     echo json_encode("Request was null");
// } else {
//     echo json_encode($answer);
// }
