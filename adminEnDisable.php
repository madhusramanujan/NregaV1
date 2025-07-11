<?php
include 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $userID = intval($_POST['userID'] ?? 0);
  $status = intval($_POST['status'] ?? 0);

  if ($userID) {
    $query = "UPDATE user_table SET status = $status WHERE userID = $userID";
    mysqli_query($conn, $query);
    header("Location: adminDashboard.php?msg=User status updated");
    exit;
  }
}
?>
