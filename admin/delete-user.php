<?php 
require_once'config.php';
if ($_SESSION['role'] == '0') {
  header("location: {$hostName}/admin/post.php");
}
$id = $_GET['id'];
$sql = "DELETE from user where userId = {$id}";
if(mysqli_query($conn, $sql)) {
  header("Location: {$hostName}/admin/users.php");
}else{
  echo "<p style='color:red; margin:10px 0;'>Can\'t delete the User Record.</p>";
}
mysqli_close($conn);
 ?>