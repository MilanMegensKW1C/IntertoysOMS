<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intertoysoms_db";

// connectie aanmaken
$conn = new mysqli($servername, $username, $password, $dbname);

// connectie checken
if ($conn->connect_error) {
  echo "<script>console.error('Connectie gefaald: " . addslashes($conn->connect_error) . "');</script>";
  exit();
}
echo "<script>console.log('Database succesvol geconnect!');</script>";
?>