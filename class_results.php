<?php
// class_results.php
session_start();
if (empty($_SESSION['student_id'])) {
  header('Location: login.php');
  exit;
}
require 'vendor/autoload.php';
require 'db_connect.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Semester filter
$sem = isset($_GET['semester']) ? (int)$_GET['semester'] : null;

// Fetch data
$sql = "SELECT * FROM Results WHERE Class = ?";
$params = [$_SESSION['class']];
if ($sem) {
  $sql .= " AND Semester = ?";
  $params[] = $sem;
}
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$data = $stmt->fetchAll();

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
// Header row
$headers = array_keys($data[0] ?? []);
$sheet->fromArray($headers, NULL, 'A1');
// Data rows
$rowNum = 2;
foreach ($data as $row) {
  $sheet->fromArray(array_values($row), NULL, "A{$rowNum}");
  $rowNum++;
}

// Output to browser
$filename = "ClassResults_{$_SESSION['class']}" . ($sem?"_Sem{$sem}":"") . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"{$filename}\"");
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
