<?php 
require_once 'config.php';
if (isset($_FILES['fileToUpload'])) {
  $errors = array();

  $name = $_FILES["fileToUpload"]["name"];
  $fileArray= pathinfo($name);
  $fileName = $fileArray['filename'].mt_rand(1,200).'.'.$fileArray['extension'];
  $fileSize = $_FILES['fileToUpload']['size'];
  $fileTmp = $_FILES['fileToUpload']['tmp_name'];
  $fileExt = strtolower($fileArray['extension']);
  $extenions = ['jpeg','jpg','png'];
  if(in_array($fileExt,$extenions) === false){
    $errors[] = 'This extention file is not allowed, Please choose a JPG or PNG file';
  }
  if($fileSize > 2097152){
    $errors[] = "File size must be 2MB or lower";
  }

if (empty($errors) == true) {
  move_uploaded_file($fileTmp,'upload/'.$fileName);
}else{
  print_r($errors);
  die();
}

}
$title = mysqli_real_escape_string($conn,$_POST['post_title']);
$description = mysqli_real_escape_string($conn,$_POST['postdesc']);
$category = mysqli_real_escape_string($conn,$_POST['category']);
$date = date('d M, Y');
$author = $_SESSION['userId'];

$sql = "INSERT INTO post(title,description,category,postDate,author,postImg) values('{$title}','{$description}','{$category}','{$date}','{$author}','{$fileName}');";
$sql .= "UPDATE category set post = post + 1 where categoryId = {$category}";
if (mysqli_multi_query($conn,$sql)) {
  header("location: {$hostName}/admin/post.php");
}else{
  echo "<div class='alert alert-danger'>Query Failed.</div>";
}
 ?>
