<?php

session_start();
include '../includes/db_connect.php';

// Get POST values safely
$districtID = $_POST['districtID'] ?? '';
$username   = trim($_POST['username'] ?? '');
$password   = $_POST['password'] ?? '';

if (empty($districtID) || empty($username) || empty($password)) {
    die("All fields are required.");
}

// Prepare and execute admin lookup
$stmt = $conn->prepare("SELECT * FROM User_Table WHERE username = ? AND districtID = ?");
$stmt->bind_param("si", $username, $districtID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $admin = $result->fetch_assoc();

    if ($password == $admin['password']) {
        // Valid admin → start session
        $_SESSION['admin_id']     = $admin['userID'];
        $_SESSION['username']     = $admin['userName'];
        $_SESSION['district_id']  = $admin['districtID'];
        $_SESSION['isAdmin']      = true;

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