<?php
require_once __DIR__ . '/vendor/autoload.php';
include 'includes/db_connect.php';
session_start();

use Dompdf\Dompdf;
use Dompdf\Options;

// Check session
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    die("Unauthorized access.");
}

// Get user details
$userID = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Handle optional date filters from GET
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';

$whereClause = "userID = $userID";
if (!empty($from) && !empty($to)) {
    $fromDate = $from . " 00:00:00";
    $toDate   = $to . " 23:59:59";
    $whereClause .= " AND FromDateAndTime BETWEEN '$fromDate' AND '$toDate'";
}

// Fetch data from the database
$res = mysqli_query($conn, "SELECT * FROM activity_table WHERE $whereClause ORDER BY FromDateAndTime DESC");

// Configure Dompdf options
$options = new Options();
$options->set('isRemoteEnabled', true); // Enable loading of remote images
$options->set('defaultFont', 'NotoSansKannada'); // Set default font to Noto Sans Kannada

// Create a new Dompdf instance
$dompdf = new Dompdf($options);

// Start building the HTML content
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        @font-face {
            font-family: "NotoSansKannada";
            src: url("fonts/NotoSansKannada-Regular.ttf") format("truetype");
        }
        body {
            font-family: "NotoSansKannada", Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">User Activity Report</h2>
    <p><strong>Username:</strong> ' . htmlspecialchars($username) . '</p>
    <p><strong>Date Range:</strong> ' . (!empty($from) ? htmlspecialchars($from) : 'N/A') . ' to ' . (!empty($to) ? htmlspecialchars($to) : 'N/A') . '</p>
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

// Add table rows dynamically
$sn = 1;
while ($row = mysqli_fetch_assoc($res)) {
    $html .= '<tr>';
    $html .= '<td>' . $sn++ . '</td>';
    $html .= '<td>' . htmlspecialchars($row['FromDateAndTime']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['fromLocation']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['toLoc']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['toDateAndTime']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['activityDone']) . '</td>';
    if (!empty($row['activityImage']) && file_exists("uploads/{$row['activityImage']}")) {
        // Convert the image to Base64
        $imagePath = "uploads/" . htmlspecialchars($row['activityImage']);
        $imageData = base64_encode(file_get_contents($imagePath));
        $src = 'data:image/jpeg;base64,' . $imageData;

        // Embed the image in the table
        $html .= '<td><img src="' . $src . '" alt="Activity Image"></td>';
    } else {
        $html .= '<td>No Image</td>';
    }
    $html .= '</tr>';
}

$html .= '
        </tbody>
    </table>
</body>
</html>';

// Load the HTML content
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the PDF
$dompdf->render();

// Output the PDF for download
$dompdf->stream('UserActivityReport.pdf', ['Attachment' => true]);
?>