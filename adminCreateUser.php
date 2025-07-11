<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$userID     = $_SESSION['user_id'];
$districtID = $_SESSION['district_id'];

$talukID     = $_POST['talukID'];
$username    = $_POST['username'];
$password    = $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Check if the user already exists
$sql = "SELECT * FROM user_table WHERE userName = ? AND districtID = ? AND talukID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $username, $districtID, $talukID);
$stmt->execute();
$result = $stmt->get_result();

// echo $username . " " . $districtID . " " . $talukID; // Debugging line to check input values
// echo $result->num_rows; // Debugging line to check how many users match

if ($result->num_rows > 0) {
    // Redirect with error message
    $_SESSION['error'] = "User already exists.";
    header("Location: adminDashboard.php");
    exit;
} else {
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO user_table (userName, password, districtID, talukID, role, status) VALUES (?, ?, ?, ?, 'user', 1)");
    $stmt->bind_param("ssii", $username, $hashedPassword, $districtID, $talukID);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "User created successfully.";
    } else {
        $_SESSION['error'] = "Error creating user.";
    }
    header("Location: adminDashboard.php");
    exit;
}
?>
