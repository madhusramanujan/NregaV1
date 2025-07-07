<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$userID     = $_SESSION['user_id'];
$districtID = $_SESSION['district_id'];
$talukID    = $_SESSION['taluk_id'];

$fromLoc     = $_POST['fromLocation'];
$fromDate    = $_POST['FromDateAndTime'];
$toLoc       = $_POST['toLoc'];
$toDate      = $_POST['toDateAndTime'];
$activity    = $_POST['activityDone'];
$activityID  = $_POST['activityID'] ?? null;

$imagePath = null;

// If file is uploaded
if (!empty($_FILES['activityImage']['name'])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["activityImage"]["name"]);
    $uniqueName = time() . "_" . $fileName;
    $targetFile = $targetDir . $uniqueName;

    if (move_uploaded_file($_FILES["activityImage"]["tmp_name"], $targetFile)) {
        $imagePath = $uniqueName;
    }
}

if ($activityID) {
    // 🔁 UPDATE existing activity
    if ($imagePath) {
        // if new image is uploaded
        $stmt = $conn->prepare("UPDATE activity_table 
            SET fromLocation=?, FromDateAndTime=?, toLoc=?, toDateAndTime=?, activityDone=?, activityImage=? 
            WHERE activityID=? AND userID=?");
        $stmt->bind_param("ssssssii", $fromLoc, $fromDate, $toLoc, $toDate, $activity, $imagePath, $activityID, $userID);
    } else {
        // if image not changed
        $stmt = $conn->prepare("UPDATE activity_table 
            SET fromLocation=?, FromDateAndTime=?, toLoc=?, toDateAndTime=?, activityDone=? 
            WHERE activityID=? AND userID=?");
        $stmt->bind_param("ssssssi", $fromLoc, $fromDate, $toLoc, $toDate, $activity, $activityID, $userID);
    }

    if ($stmt->execute()) {
        header("Location: userDashboard.php");
        exit;
    } else {
        echo "Update Error: " . $stmt->error;
    }

} else {
    // ➕ INSERT new activity
    $stmt = $conn->prepare("INSERT INTO activity_table 
        (userID, districtID, talukID, fromLocation, FromDateAndTime, toLoc, toDateAndTime, activityDone, activityImage)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiissssss", $userID, $districtID, $talukID, $fromLoc, $fromDate, $toLoc, $toDate, $activity, $imagePath);

    if ($stmt->execute()) {
        header("Location: userDashboard.php");
        exit;
    } else {
        echo "Insert Error: " . $stmt->error;
    }
}
?>
