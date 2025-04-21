<?php
// logout.php
session_start();
session_destroy();
header('Location: login.php');
exit;
<?php
// result.php
session_start();
if (empty($_SESSION['student_id'])) {
  header('Location: login.php');
  exit;
}
require 'db_connect.php';

// Semester filter
$sem = isset($_GET['semester']) ? (int)$_GET['semester'] : null;
$params = [$_SESSION['student_id']];
$sql = "SELECT * FROM Results WHERE StudentID = ?";
if ($sem) {
  $sql .= " AND Semester = ?";
  $params[] = $sem;
}

$stmt     = $pdo->prepare($sql);
$stmt->execute($params);
$results  = $stmt->fetchAll();

// Fetch distinct semesters for dropdown
$semStmt  = $pdo->prepare("SELECT DISTINCT Semester FROM Results WHERE StudentID = ?");
$semStmt->execute([$_SESSION['student_id']]);
$semesters = $semStmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!doctype html>
<html>
<head><title>Your Results</title></head>
<body>
  <a href="logout.php">Logout</a>
  <h1>Your Results</h1>
  <form>
    <label>Semester:
      <select name="semester" onchange="this.form.submit()">
        <option value="">All</option>
        <?php foreach($semesters as $s): ?>
          <option <?=($s==$sem?'selected':'')?> value="<?=$s?>"><?=$s?></option>
        <?php endforeach;?>
      </select>
    </label>
  </form>

  <?php if(!$results): ?>
    <p>No results found.</p>
  <?php else: ?>
    <table border="1" cellpadding="5">
      <tr>
        <th>Sem</th><th>Sub1</th><th>Sub2</th><th>Sub3</th><th>Sub4</th>
        <th>Total</th><th>%</th>
        <th>Download PDF</th>
      </tr>
      <?php foreach($results as $r): ?>
      <tr>
        <td><?=$r['Semester']?></td>
        <td><?=$r['Subject1']?></td>
        <td><?=$r['Subject2']?></td>
        <td><?=$r['Subject3']?></td>
        <td><?=$r['Subject4']?></td>
        <td><?=$r['TotalMarks']?></td>
        <td><?=$r['Percentage']?></td>
        <td>
          <a href="download_result.php?student_id=<?=$r['StudentID']?>&semester=<?=$r['Semester']?>">PDF</a>
        </td>
      </tr>
      <?php endforeach;?>
    </table>
  <?php endif; ?>
</body>
</html>
