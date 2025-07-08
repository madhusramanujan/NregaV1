<?php
require('fpdf/fpdf.php');
include 'includes/db_connect.php';
session_start();

// Check session
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    die("Unauthorized access.");
}

// ✅ Now assign values safely
$userID = $_SESSION['user_id'];
$username = $_SESSION['username'];

// ✅ Handle optional date filters from GET
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';

$filterClause = "userID = $userID";
if (!empty($from) && !empty($to)) {
    $fromDate = $from . " 00:00:00";
    $toDate   = $to . " 23:59:59";
    $filterClause .= " AND FromDateAndTime BETWEEN '$fromDate' AND '$toDate'";
}

// ✅ Custom class extending FPDF
class PDF extends FPDF {
    // Calculate approximate height of MultiCell content
    function getMultiCellHeight($w, $h, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n") $nb--;
        $sep = -1;
        $i = 0; $j = 0; $l = 0; $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++; $sep = -1; $j = $i; $l = 0; $nl++;
                continue;
            }
            if ($c == ' ') $sep = $i;
            $l += $cw[$c] ?? 0;
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) $i++;
                } else {
                    $i = $sep + 1;
                }
                $sep = -1; $j = $i; $l = 0; $nl++;
            } else {
                $i++;
            }
        }
        return $nl * $h;
    }
}

define('FPDF_FONTPATH', __DIR__ . '/fpdf/font/');

// ✅ Create PDF
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->AddFont('NotoSansKannada', '', 'NotoSansKannada.php');
$pdf->SetFont('NotoSansKannada', '', 11);
$pdf->Cell(0, 10, 'NREGA User Activity Report', 0, 1, 'C');

// ✅ Column setup
$widths = [10, 35, 25, 25, 35, 100, 40];
$headers = ['Sl', 'From DateTime', 'From', 'To', 'To DateTime', 'Activity', 'Image'];

$pdf->SetFont('Arial', 'B', 10);
foreach ($headers as $i => $text) {
    $pdf->Cell($widths[$i], 10, $text, 1);
}
$pdf->Ln();

// ✅ Fetch Data
// $userID = $_SESSION['user_id'];
$res = mysqli_query($conn, "SELECT * FROM activity_table WHERE $filterClause ORDER BY FromDateAndTime DESC");

// $rowCount = mysqli_num_rows($res);
// echo $rowCount;
// exit;


$sn = 1;
$pdf->SetFont('NotoSansKannada', '', 10);

while ($row = mysqli_fetch_assoc($res)) {
    $activityText = $row['activityDone'];
    $activityHeight = $pdf->getMultiCellHeight($widths[5], 5, $activityText);
    $rowHeight = max($activityHeight, 20);

    $imageExists = (!empty($row['activityImage']) && file_exists("uploads/{$row['activityImage']}"));
    if ($imageExists) $rowHeight = max($rowHeight, 22);

    // Store Y to align row
    $yStart = $pdf->GetY();

    // Print cells
    $pdf->Cell($widths[0], $rowHeight, $sn++, 1);
    $pdf->Cell($widths[1], $rowHeight, $row['FromDateAndTime'], 1);
    $pdf->Cell($widths[2], $rowHeight, $row['fromLocation'], 1);
    $pdf->Cell($widths[3], $rowHeight, $row['toLoc'], 1);
    $pdf->Cell($widths[4], $rowHeight, $row['toDateAndTime'], 1);

    // Activity (wrapped)
    $xAct = $pdf->GetX();
    $yAct = $pdf->GetY();
    $pdf->Rect($xAct, $yAct, $widths[5], $rowHeight);
    $pdf->SetXY($xAct + 1, $yAct + 1);

    $wrappedText = explode("\n", wordwrap($activityText, 55));
    foreach ($wrappedText as $i => $line) {
        $pdf->Cell($widths[5] - 2, 5, $line, 0);
        $pdf->Ln();
        $pdf->SetX($xAct + 1);
    }
    $pdf->SetXY($xAct + $widths[5], $yAct);


    // Image cell
    if ($imageExists) {
        $pdf->Cell($widths[6], $rowHeight, '', 1);
        $pdf->Image("uploads/{$row['activityImage']}", $pdf->GetX() - $widths[6] + 10, $pdf->GetY() + 2, 20, 16);
    } else {
        $pdf->Cell($widths[6], $rowHeight, 'No Image', 1);
    }

    // Move to next row
    $pdf->SetY($yStart + $rowHeight);
}

// ✅ Output
$pdf->Output('D', 'UserActivityReport.pdf');
?>
