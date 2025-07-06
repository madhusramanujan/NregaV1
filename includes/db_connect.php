<?php
$server_name = "localhost";
$username = "root"; // Database username
$password = ""; // Database password
$databse_name = "nrega"; // Database name

// Create connection
$conn = new mysqli($server_name, $username, $password, $databse_name);  
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// else {
//     echo "Connected successfully"; // Uncomment for debugging
// }
?>