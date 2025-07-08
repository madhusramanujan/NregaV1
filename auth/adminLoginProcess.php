<?php

session_start();
include '../includes/db_connect.php';

// Get POST values safely
$districtID = $_POST['districtID'] ?? '';
$username   = trim($_POST['username'] ?? '');
$password   = $_POST['password'] ?? '';
$talukID    = $_POST['talukID'] ?? '';


if (empty($districtID) || empty($username) || empty($password) || empty($talukID)) {
    die("All fields are required.");
}

// Prepare and execute admin lookup
$stmt = $conn->prepare("SELECT * FROM User_Table WHERE username = ? AND districtID = ?  AND role = 'admin' AND status = 1");
$stmt->bind_param("si", $username, $districtID);
$stmt->execute();
$result = $stmt->get_result();

var_dump($result);


if ($result->num_rows === 1) {
    $admin = $result->fetch_assoc();

    if ($password == $admin['password']) {
        // Valid admin → start session
        $_SESSION['user_id']     =  $admin['userID'];
        $_SESSION['username']     = $admin['userName'];
        $_SESSION['district_id']  = $admin['districtID'];
        $_SESSION['taluk_id']    =  $talukID ; // Store talukID from the form
        $_SESSION['role']      = 'admin';

        // Redirect to admin dashboard
        header("Location: ../adminDashboard.php");
        exit;
    } else {
        echo "❌ Invalid password.";
    }
} else {
    echo "❌ Admin not found or inactive.";
}
?>