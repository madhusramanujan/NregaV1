<?php
session_start();
include '../includes/db_connect.php';

// Get POST values safely
$districtID = $_POST['districtID'] ?? '';
$talukID    = $_POST['talukID'] ?? '';
$username   = trim($_POST['username'] ?? '');
$password   = $_POST['password'] ?? '';

if (empty($districtID) || empty($talukID) || empty($username) || empty($password)) {
    die("All fields are required.");
}

// Prepare and execute user lookup
$stmt = $conn->prepare("SELECT * FROM User_Table WHERE username = ? AND districtID = ? AND talukID = ? AND role = 'user' AND status = 1");
$stmt->bind_param("sii", $username, $districtID, $talukID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // Valid user → start session
        $_SESSION['user_id']     = $user['userID'];
        $_SESSION['username']    = $user['username'];
        $_SESSION['district_id'] = $user['districtID'];
        $_SESSION['taluk_id']    = $user['talukID'];
        $_SESSION['role']        = 'user';

        // Redirect to user dashboard
        header("Location: ../userDashboard.php");
        exit;
    } else {
        echo "❌ Invalid password.";
    }
} else {
    echo "❌ User not found or inactive.";
}
?>
