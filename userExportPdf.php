<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    die("Unauthorized access.");
}

mysqli_set_charset($conn, "utf8mb4");

$userID = $_SESSION['user_id'];
$username = $_SESSION['username'];

$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$filterClause = "userID = $userID";

if (!empty($from) && !empty($to)) {
    $fromDate = $from . " 00:00:00";
    $toDate = $to . " 23:59:59";
    $filterClause .= " AND FromDateAndTime BETWEEN '$fromDate' AND '$toDate'";
}

$res = mysqli_query($conn, "SELECT * FROM activity_table WHERE $filterClause ORDER BY FromDateAndTime DESC");

// 🧾 HTML Template
$html = "<!DOCTYPE html>
<html lang='kn'>
<head>
<meta charset='UTF-8'>
<style>
  body {
    font-family: 'Noto Sans Kannada', 'Segoe UI', sans-serif;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Noto Sans Kannada', 'Segoe UI', sans-serif;
  }
  th, td {
    border: 1px solid black;
    padding: 5px;
    text-align: center;
  }
</style>

</head>
<body>
<h2 style='text-align:center;'>NREGA Activity Report for $username</h2>
<table>
<tr>
  <th>Sl No</th>
  <th>From Date & Time</th>
  <th>From Location</th>
  <th>To Location</th>
  <th>To Date & Time</th>
  <th>Activity Done</th>
  <th>Image</th>
</tr>";

$sn = 1;
while ($row = mysqli_fetch_assoc($res)) {
    $html .= "<tr>";
    $html .= "<td>$sn</td>";
    $html .= "<td>{$row['FromDateAndTime']}</td>";
    $html .= "<td>{$row['fromLocation']}</td>";
    $html .= "<td>{$row['toLoc']}</td>";
    $html .= "<td>{$row['toDateAndTime']}</td>";

    $activity = htmlspecialchars($row['activityDone'], ENT_QUOTES, 'UTF-8');
    $html .= "<td style='font-family: Noto Sans Kannada;'>$activity</td>";

    if (!empty($row['activityImage'])) {
        $imageURL = "http://localhost/Nrega/NregaV1/uploads/" . $row['activityImage'];
        $html .= "<td><img src='$imageURL' width='100'/></td>";
    } else {
        $html .= "<td>No Image</td>";
    }

    $html .= "</tr>";
    $sn++;
}
$html .= "</table></body></html>";

// 📂 Save to temp file
$tempHtmlFile = __DIR__ . '/temp_activity_report.html';
file_put_contents($tempHtmlFile, $html);

// 🖨 Generate PDF
$outputPdf = __DIR__ . '/UserActivityReport.pdf';
$wkhtmltopdfPath = '"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe"'; // Adjust if needed

$cmd = "$wkhtmltopdfPath \"$tempHtmlFile\" \"$outputPdf\"";
exec($cmd, $output, $resultCode);

// 🧹 Delete temp HTML after PDF generation
unlink($tempHtmlFile);

if ($resultCode === 0 && file_exists($outputPdf)) {
    // Serve PDF securely
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="UserActivityReport.pdf"');
    readfile($outputPdf);
    unlink($outputPdf); // optional cleanup
    exit;
} else {
    echo "❌ Failed to generate PDF. Please check wkhtmltopdf and paths.<br>";
    echo "Command: $cmd<br>";
    echo "Return code: $resultCode<br>";
    echo "Output:<br><pre>" . print_r($output, true) . "</pre>";
}
?>
