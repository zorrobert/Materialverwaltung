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
    # User actions
    'loginUser'         => $actionController->loginUser(),
    'logoutUser'        => $actionController->loginUser(),
    'registerUser'      => $actionController->loginUser(),
    'deleteUser'        => $actionController->loginUser(),
    'loadUser'          => $actionController->loginUser(),
    'adminCreateUser'   => $actionController->loginUser(),
    'adminDeleteUser'   => $actionController->loginUser(),
    # Permission Actions
    'hasPermission'     => $actionController->hasPermission(),
    # Item Actions
    'createItems'       => $actionController->createItems(),
    'deleteItems'       => $actionController->deleteItems(),
    'editItems'         => $actionController->editItems(),
    'getListItems'      => $actionController->getListItems(),
    # Loan Actions
    'createLoan'        => $actionController->createLoan(),
    'revertLoan'        => $actionController->revertLoan(),
    'approveLoan'       => $actionController->approveLoan(),
    'handedOutLoan'     => $actionController->handedOutLoan(),
    'handedInLoan'      => $actionController->handedInLoan(),
    # Error Case
    'test'              => $actionController->test(),
    default             => new Response([ "bide", "test"])
};

# return response object as json
echo json_encode([
    "data" => $response->getData(),
    "status" => $response->getStatus(),
    "error" => $response->getErrorMessage()
]);
http_response_code($response->getStatus());