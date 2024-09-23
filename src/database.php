<?php

$DBservername = "127.0.0.1";
$DBusername = "material";
$DBpassword = "material";
$DBname = "material";

try {
    $conn = new PDO("mysql:host=$DBservername;dbname=$DBname", $DBusername, $DBpassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "DB Connection success";
    initDatabase($conn);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    // $response = [
    //     "status" => "Fail",
    //     "errorMessage" => "Unable to connect to database: " . $e->getMessage(),
    // ];
    // echo json_encode($response);
}

function initDatabase($conn) {
    echo "<p>Delete Databases</p>";
    $conn->exec("DROP TABLE users");
    $conn->exec("DROP TABLE items");
    // $stmt = $conn->prepare("DROP TABLE *");
    // $stmt->execute();
    // $stmt->bind_param("s", $table);
    // try {
    //     //$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username='$username'");
    //     $table = "users"; $stmt->execute();
    //     $table = "items"; $stmt->execute();
    // } catch(PDOException $e) {
    //     echo "<p>Failed to delete Databases</p>";
    // }
    echo "<p>Deleted Databases</p>";

    // $stmt = $conn->prepare("CREATE TABLE (name) VALUES (?)");
    // $stmt->bind_param("s", $table)

    echo "Create Tables";
    $sql = "CREATE TABLE users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30),
        password VARCHAR(30)
    )";
    $conn->exec($sql); // use exec() because no results are returned

    $sql = "CREATE TABLE items (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        status VARCHAR(30),
        amount INT(6) UNSIGNED
    )";
    $conn->exec($sql); // use exec() because no results are returned
    echo "<p>Created Tables</p>";


    echo "<p>Create sample data</p>";
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $username = "bitte";
    $password = "test";
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO items (name, status, amount) VALUES (:name, :status, :amount)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':amount', $amount);
    $name = "Topf";
    $status = "Auf Lager";
    $amount = 2;
    $stmt->execute();
    echo "<p>Created sample data</p>";


    //Beispiels ausgabe .json Datei
    $array = json_decode(file_get_contents("../beispieldaten.json"), true);
    echo '<pre>';
    print_r($array);
    echo '<pre>';
  }
