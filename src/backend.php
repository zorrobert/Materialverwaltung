<?php
namespace Robert\Materialverwaltung;

# in devenv packen
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require dirname(__DIR__)."/vendor/autoload.php";

session_start(); # begin session to store values

$request = Request::fromSuperglobals();
$actionController = new Controller\ActionController($request);

$response = match($request->getAction()) {
    'test' => $actionController->test(),
    'login' => $actionController->login(),
    'listItems' => $actionController->listItems(),
    default => $actionController->listItems(),
    //default => new Response(["error" => "Unknown action"], 404)
};

echo json_encode([
    "data" => $response->getData(),
    "error" => $response->getErrorMessage(),
    "status" => $response->getStatus()
]);
http_response_code($response->getStatus());