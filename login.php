<?php
// login.php
session_start();
if ($_SERVER['REQUEST_METHOD']==='POST') {
  require 'db_connect.php';
  $sid = $_POST['student_id'];
  $stmt = $pdo->prepare("SELECT DISTINCT Class FROM Results WHERE StudentID = ?");
  $stmt->execute([$sid]);
  $row = $stmt->fetch();
  if ($row) {
    $_SESSION['student_id'] = $sid;
    $_SESSION['class']      = $row['Class'];
    header('Location: result.php');
    exit;
  } else {
    $error = "StudentID not found.";
  }
}
?>
<!doctype html>
<html>
<body>
  <h1>Student Login</h1>
  <?php if(!empty($error)): ?><p style="color:red"><?=$error?></p><?php endif;?>
  <form method="post">
    <label>Your StudentID: <input name="student_id" required></label>
    <button type="submit">Login</button>
  </form>
</body>
</html>
