<?php
//specify the server name and here it is localhost
$server_name = "localhost";

//specify the username - here it is root
$user_name = "root";

//specify the password - it is empty
$password = "";

// Creating the connection by specifying the connection details
$conn = mysqli_connect($server_name, $user_name, $password, 'materialien');

// Checking the  connection
if (!$conn) {
  die("Failed ". mysqli_connect_error());
}
echo "Connection established successfully";


$sql = "SELECT * FROM materialien.materialien";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        // echo "id: " . $row["ID"]. " - Name: " .$row["Materialname"]. "";
        echo "name: " . $row["Materialname"];
    }
}
else {
    echo "0 results";
}

mysqli_close($conn);
?>
