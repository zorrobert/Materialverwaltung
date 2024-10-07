<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$action = $_REQUEST["action"];
if ($action === "login")
{
    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];

    //Passwort gehashed und mit passcheck auf richtigkeit geprüft
    $hashpassword = password_hash($password, PASSWORD_DEFAULT);

    //Passcheck gibt ein Wert aus ob True oder False
    $passcheck = password_verify($password, $hashpassword);

    #if (checkLogin($conn, $username, $password)) {

    //If Passcheck true dann mach success
    if ($password === $username) {
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
