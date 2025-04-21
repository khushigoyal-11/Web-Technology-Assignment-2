<?php
// db_connect.php
$host = 'localhost';
$db   = 'ResultManagement';
$user = 'your_db_user';
$pass = 'your_db_pass';
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  die("Database connection failed: " . $e->getMessage());
}
