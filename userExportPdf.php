<?php
<<<<<<< HEAD
=======
require_once __DIR__ . '/vendor/autoload.php';
include 'includes/db_connect.php';
>>>>>>> 46751e5273b09569dade6bf779b8167a07a18782
session_start();
include 'includes/db_connect.php';

<<<<<<< HEAD
=======
use Dompdf\Dompdf;
use Dompdf\Options;

// Check session
>>>>>>> 46751e5273b09569dade6bf779b8167a07a18782
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    die("Unauthorized access.");
}

<<<<<<< HEAD
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
=======
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
>>>>>>> 46751e5273b09569dade6bf779b8167a07a18782

// Add table rows dynamically
$sn = 1;
while ($row = mysqli_fetch_assoc($res)) {
<<<<<<< HEAD
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
=======
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
>>>>>>> 46751e5273b09569dade6bf779b8167a07a18782
}
$html .= "</table></body></html>";

<<<<<<< HEAD
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
=======
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
>>>>>>> 46751e5273b09569dade6bf779b8167a07a18782
