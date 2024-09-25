<?php

$action = $_REQUEST["action"];
if ($action === "login")
{
    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];
    password_hash($password, PASSWORD_DEFAULT);
    console.log($password);

    #if (checkLogin($conn, $username, $password)) {
    if ($username === $password) {
        $response = [
            "status" => "Success",
            "errorMessage" => NULL,
            "authToken" => "hello $username"
        ];
    } else {
        $response = [
            "status" => "Fail",
            "errorMessage" => "Username or password $password is incorrect",
            "authToken" => NULL
        ];
    }
}
echo json_encode($response);
