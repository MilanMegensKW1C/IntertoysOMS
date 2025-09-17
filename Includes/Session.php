<?php
// Start of hervat session
session_start();

require_once __DIR__ . '/DB.php';

// Check 'remember me' cookie
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $userId = $_COOKIE['user_id'];
    
    $stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
    $stmt->bind_param("i", $userId); 
    $stmt->execute();              
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email']   = $user['email'];
        $_SESSION['rol']     = $user['rol'];
    }
}

// Echo rol naar console
if (isset($_SESSION['rol'])) {
    echo "<script>console.log('Ingelogd als rol: " . $_SESSION['rol'] . "');</script>";
}
?>
