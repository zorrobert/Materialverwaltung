<?php

$action = $_REQUEST["action"];
if ($action === "login")
{
    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];

    //Password gehashed und mit passcheck auf richtigkeit geprüft
    $hashpassword = password_hash($password, PASSWORD_DEFAULT);

    //Passcheck gibt ein Wert aus ob True oder False
    $passcheck = password_verify($password, $hashpassword);

    #if (checkLogin($conn, $username, $password)) {
    //If Passcheck true dann mach success
    if ($passcheck === true) {
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
