<?php
require "Entity/User.php";
#require "Entity/Item.php";
use User;
#use Item;

$DBservername = "127.0.0.1";
$DBusername = "material";
$DBpassword = "material";
$DBname = "material";

try {
    $conn = new PDO("mysql:host=$DBservername;dbname=$DBname", $DBusername, $DBpassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    #echo "Connected successfully";

    // $sql = "SELECT id, username, password FROM Users WHERE username='$username'";
    // $result = $conn->query($sql);
    //

    // if ($result->num_rows > 0) {
    //     while ($row = $result->fetch_assoc()) {
    //         $test = $row["username"]
    //     }
    // }
} catch(PDOException $e) {
    #echo "Connection failed: " . $e->getMessage();
    $response = [
        "status" => "Fail",
        "errorMessage" => "Unable to connect to database: " . $e->getMessage(),
    ];
    echo json_encode($response);
}

function checkLogin($conn, $username, $password) {
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username='$username'");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return ($password === $result[0]["password"]);
}

function getAuthToken() {
    return "Auth Token";
        #$passwordHash = password_hash($password, PASSWORD_DEFAULT); # , "PASSWORD_DEFAULT", []
    #$passwordHash = $userlist[$username];
}

function listItems($conn) {
    $username = $_REQUEST["sortBy"];
    $password = $_REQUEST["entries"];
    return True;
}

$action = $_REQUEST["action"];
#$authToken = $_REQUEST["authToken"]; # generate from cookie

if ($action === "login")
{
    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];
    if (checkLogin($conn, $username, $password)) {
        $response = [
            "status" => "Success",
            "errorMessage" => NULL,
            "authToken" => "hello"
        ];
    } else {
        $response = [
            "status" => "Fail",
            "errorMessage" => "Username or password incorrect",
            "authToken" => NULL
        ];
    }
}

if ($action === "listItems") { $response = listItems($conn); }

$conn = null; # close DB connection
echo json_encode($response);
