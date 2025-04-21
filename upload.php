<?php
// upload.php
session_start();
// TODO: protect this page with admin auth

require 'vendor/autoload.php';
require 'db_connect.php';

use Smalot\PdfParser\Parser;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['result_pdf']) || $_FILES['result_pdf']['error'] !== UPLOAD_ERR_OK) {
        $error = "Upload failed.";
    } else {
        $file = $_FILES['result_pdf']['tmp_name'];
        $parser = new Parser();
        $pdf    = $parser->parseFile($file);
        $text   = $pdf->getText();
        $lines  = preg_split("/\r\n|\n|\r/", trim($text));

        $stmt = $pdo->prepare(
          "INSERT INTO Results
            (StudentID, Name, Semester, Subject1, Subject2, Subject3, Subject4, TotalMarks, Percentage, Class)
           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        foreach ($lines as $line) {
            // Example line: "35314813122 Yaagik Goel 2 85 90 78 88 341 85.25 6AIML-IV"
            $parts = preg_split('/\s+/', trim($line));
            if (count($parts) === 10) {
                list($sid, $fname, $lname, $sem, $s1, $s2, $s3, $s4, $total, $pct, $cls) 
                  = array_merge([$parts[0]], [ $parts[1].' '.$parts[2] ], array_slice($parts,3));
                $stmt->execute([
                  $sid, $fname, $sem, $s1, $s2, $s3, $s4, $total, $pct, $cls
                ]);
            }
        }
        $success = "Results imported successfully.";
    }
}
?>
<!doctype html>
<html>
<head><title>Upload Results PDF</title></head>
<body>
  <h1>Admin: Upload Results PDF</h1>
  <?php if (!empty($error)): ?>
    <p style="color:red"><?=htmlspecialchars($error)?></p>
  <?php elseif (!empty($success)): ?>
    <p style="color:green"><?=htmlspecialchars($success)?></p>
  <?php endif; ?>
  <form method="post" enctype="multipart/form-data">
    <input type="file" name="result_pdf" accept="application/pdf" required>
    <button type="submit">Upload & Import</button>
  </form>
</body>
</html>
