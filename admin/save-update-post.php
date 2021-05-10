<?php 
  require_once 'config.php';
  if (empty($_FILES['new-image']['name'])) {
    $fileName = $_POST['old-image'];
  } else {
    $errors = array();

  $name = $_FILES["new-image"]["name"];
  $fileArray= pathinfo($name);
  $fileName = $fileArray['filename'].mt_rand(1,200).'.'.$fileArray['extension'];
  $fileSize = $_FILES['new-image']['size'];
  $fileTmp = $_FILES['new-image']['tmp_name'];
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

$sql = "UPDATE post set title='{$_POST['post_title']}',description='{$_POST['postdesc']}',category={$_POST['category']},postImg='{$fileName}'
        where postId={$_POST['post_id']};";
if ($_POST['category'] != $_POST['oldCategory']) {
  $sql .= "UPDATE category set post = post-1 where categoryId = {$_POST['oldCategory']};";
  $sql .= "UPDATE category set post = post+1 where categoryId = {$_POST['category']};";
}
if ($_POST['new-image'] != $_POST['old-image']) {
  unlink("upload/".$_POST['old-image']);
}
$result = mysqli_multi_query($conn,$sql) or die ('Query Failed.');

if ($result) {
  header("location: {$hostName}/admin/post.php");
}else {
  echo "Query Failed.";
}

 ?>