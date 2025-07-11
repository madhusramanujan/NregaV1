<?php
session_start();
include 'includes/db_connect.php';

// Session check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    die("Unauthorized access.");
}

$userID = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Date filters
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';

$whereClause = "userID = $userID";
if (!empty($from) && !empty($to)) {
    $fromDate = $from . " 00:00:00";
    $toDate   = $to . " 23:59:59";
    $whereClause .= " AND FromDateAndTime BETWEEN '$fromDate' AND '$toDate'";
}

// Fetch data
$res = mysqli_query($conn, "SELECT * FROM activity_table WHERE $whereClause ORDER BY FromDateAndTime DESC");

// Build HTML
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">User Activity Report</h2>
    <p><strong>Username:</strong> ' . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . '</p>
    <p><strong>Date Range:</strong> ' . (!empty($from) ? htmlspecialchars($from, ENT_QUOTES, 'UTF-8') : 'N/A') . ' to ' . (!empty($to) ? htmlspecialchars($to, ENT_QUOTES, 'UTF-8') : 'N/A') . '</p>

    <table>
        <thead>
            <tr>
                <th>Sl No</th>
                <th>From Date & Time</th>
                <th>From Location</th>
                <th>To Location</th>
                <th>To Date & Time</th>
                <th>Activity Done</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>';

$sn = 1;
while ($row = mysqli_fetch_assoc($res)) {
    $html .= '<tr>';
    $html .= '<td>' . $sn++ . '</td>';
    $html .= '<td>' . htmlspecialchars($row['FromDateAndTime'], ENT_QUOTES, 'UTF-8') . '</td>';
    $html .= '<td>' . htmlspecialchars($row['fromLocation'], ENT_QUOTES, 'UTF-8') . '</td>';
    $html .= '<td>' . htmlspecialchars($row['toLoc'], ENT_QUOTES, 'UTF-8') . '</td>';
    $html .= '<td>' . htmlspecialchars($row['toDateAndTime'], ENT_QUOTES, 'UTF-8') . '</td>';
    $html .= '<td>' . nl2br(htmlspecialchars($row['activityDone'], ENT_QUOTES, 'UTF-8')) . '</td>';

    if (!empty($row['activityImage']) && file_exists("uploads/{$row['activityImage']}")) {
        $imagePath = "uploads/" . htmlspecialchars($row['activityImage'], ENT_QUOTES, 'UTF-8');
        $imageData = base64_encode(file_get_contents($imagePath));
        $src = 'data:image/jpeg;base64,' . $imageData;

        // ✅ Inline width ensures MS Word respects it
        $html .= '<td><img src="' . $src . '" width="100" alt="Activity Image"></td>';
    } else {
        $html .= '<td>No Image</td>';
    }

    $html .= '</tr>';
}

$html .= '</tbody></table></body></html>';

// Output as Word
header("Content-type: application/vnd.ms-word; charset=UTF-8");
header("Content-Disposition: attachment; filename=UserActivityReport.doc");
header("Pragma: no-cache");
header("Expires: 0");

echo $html;
?>
