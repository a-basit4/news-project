<?php 
require_once "config.php";
$id = $_GET['id'];
$sql = "DELETE from category where categoryId = {$id}";
if (mysqli_query($conn, $sql)) {
  header("location: {$hostName}/admin/category.php");
  mysqli_close($conn);
}
 ?>