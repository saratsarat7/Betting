<?php
$servername = "localhost";
$username = "id8692792_user_app";
$password = "user#123";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>