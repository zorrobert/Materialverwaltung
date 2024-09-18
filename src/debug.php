<?php

$DBservername = "127.0.0.1";
$DBusername = "material";
$DBpassword = "material";
$DBname = "material";

try {
    $conn = new PDO("mysql:host=$DBservername;dbname=$DBname", $DBusername, $DBpassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    #echo "Connected successfully";
} catch(PDOException $e) {
    #echo "Connection failed: " . $e->getMessage();
    $response = [
        "status" => "Fail",
        "errorMessage" => "Unable to connect to database: " . $e->getMessage(),
    ];
    echo json_encode($response);
}

$sql = "INSERT INTO Users (username, password)
  VALUES ('test', 'test')";
$conn->exec($sql);


echo "Init DB";
try {
  // sql to create table
  // $sql = "CREATE TABLE MyGuests (
  // id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  // firstname VARCHAR(30) NOT NULL,
  // lastname VARCHAR(30) NOT NULL,
  // email VARCHAR(50),
  // reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  // )";
  $sql = "CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL
  )";
  // use exec() because no results are returned
  $conn->exec($sql);
  echo "Table Users created successfully";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

echo "Create Table items";
try {
  // sql to create table
  // $sql = "CREATE TABLE MyGuests (
  // id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  // firstname VARCHAR(30) NOT NULL,
  // lastname VARCHAR(30) NOT NULL,
  // email VARCHAR(50),
  // reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  // )";
  $sql = "CREATE TABLE items (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    type VARCHAR(30) NOT NULL,
    status VARCHAR(30) NOT NULL,
    amount INT(6) UNSIGNED
  )";
  // use exec() because no results are returned
  $conn->exec($sql);
  echo "Table items created successfully";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
