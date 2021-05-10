<?php 
require_once "config.php";
$id = $_GET['id'];
$catId = $_GET['catId'];
$imageSql = "SELECT * from post where postId={$id}";
$result = mysqli_query($conn,$imageSql) or die("Query Failed.");
$row = mysqli_fetch_assoc($result);

unlink("upload/".$row['postImg']);

$sql = "DELETE from post where postId = {$id};";
$sql .= "UPDATE category set post = post-1 where categoryId = {$catId}";

if (mysqli_multi_query($conn,$sql)) {
  header("location: {$hostName}/admin/post.php");
}
 ?>