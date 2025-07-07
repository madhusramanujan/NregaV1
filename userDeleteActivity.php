<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    die("Unauthorized access.");
}

$userID     = $_SESSION['user_id'];
$activityID = $_GET['id'] ?? null;

if (!$activityID) {
    die("No activity specified.");
}

// Optional: delete the uploaded image too
// Get the filename first
$res = mysqli_query($conn, "SELECT activityImage FROM activity_table WHERE activityID = $activityID AND userID = $userID");
$row = mysqli_fetch_assoc($res);
if ($row && !empty($row['activityImage'])) {
    $imagePath = "uploads/" . $row['activityImage'];
    if (file_exists($imagePath)) {
        unlink($imagePath); // delete the file from disk
    }
}

// Delete the row from DB
$stmt = $conn->prepare("DELETE FROM activity_table WHERE activityID = ? AND userID = ?");
$stmt->bind_param("ii", $activityID, $userID);
if ($stmt->execute()) {
    header("Location: userDashboard.php");
    exit;
} else {
    echo "Error deleting activity: " . $stmt->error;
}
?>
