<?php

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

// eeee

//
// $userlist = [ new User("me", "test"), new User("1", "newtest") ]

//$test = [ new User("Robert", "test") ];

$userlist = [ "me" => "pwd"];


$action = $_REQUEST["action"];
#$authToken = $_REQUEST["authToken"]; # generate from cookie

if ($action === "login")
{
    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT); # , "PASSWORD_DEFAULT", []
    #$passwordHash = $userlist[$username];

    if ($userlist[$username] === $password) {
    ##if password_verify($password, $passwordHash)
        $response = [
            "status" => "Success",
            "authToken" => $passwordHash
            #"authToken" => "hello world auth_token"
        ];
    } else {
        $response = [
            "status" => "Fail",
            "errorMessage" => "Username or password incorrect"
        ];
    }


}

if ($action === "register")
{
    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];
}

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
