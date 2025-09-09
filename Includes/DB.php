<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intertoysoms_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  echo "<script>console.error('Connection failed: " . addslashes($conn->connect_error) . "');</script>";
  exit();
}
echo "<script>console.log('Connected successfully');</script>";
?>