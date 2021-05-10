<?php
require_once('admin/config.php');
$urlName = basename(($_SERVER['PHP_SELF']));
switch ($urlName) {
    case "single.php":
    if (isset($_GET['id'])) {
        $titleSql = "SELECT title from post WHERE postId = {$_GET['id']}";
        $titleResult = mysqli_query($conn,$titleSql) or die("title Qeury Failed.");
        $titleRow = mysqli_fetch_assoc($titleResult);
        $title = $titleRow['title'];
    }else {
        $title = "No Post Found";
    }
    break;
    case "category.php":
    if (isset($_GET['id'])) {
        $titleSql = "SELECT categoryName from category WHERE categoryId = {$_GET['id']}";
        $titleResult = mysqli_query($conn,$titleSql) or die("title Qeury Failed.");
        $titleRow = mysqli_fetch_assoc($titleResult);
        $title = $titleRow['categoryName'];
    }else {
        $title = "No Post Found";
    }
    break;
    case "author.php":
    if (isset($_GET['aid'])) {
        $titleSql = "SELECT firstName,lastName from user WHERE userId = {$_GET['aid']}";
        $titleResult = mysqli_query($conn,$titleSql) or die("title Qeury Failed.");
        $titleRow = mysqli_fetch_assoc($titleResult);
        $title = $titleRow['firstName']." ".$titleRow['lastName'];
    }else {
        $title = "No Post Found";
    }
    break;
    case "search.php":
    if (isset($_GET['term'])) {
       $title = $_GET['term'];
    }else {
       $title = "No Search Result Found";
    }
    break;
    default:
        $title = "News site";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $title; ?></title>
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="dist/index.css">
</head>
<body>
    <!-- HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class=" col-md-offset-4 col-md-4">
                    <a href="index.php" id="logo"><img src="images/news.jpg"></a>
                </div>
                <!-- /LOGO -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <?php 
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
    $catSql = "SELECT * FROM category where post > 0";
    $catResult = mysqli_query($conn,$catSql) or die("Query Failed : Category");
    $active = '';
    ?>
    <div id="menu-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class='menu'>
                        <?php 
                        if ($urlName == 'index.php') {
                            $homeActive = 'active';
                        }else {
                            $homeActive = '';
                        }
                         ?>
                        <li class="<?php echo $homeActive;?>"><a href="<?php echo $hostName?>">Home</a></li>
                        <?php if (mysqli_num_rows($catResult) > 0) {
                            
                            while ($row = mysqli_fetch_assoc($catResult)) { 
                               if (isset($_GET['id'])) {
                                if ($id == $row['categoryId']) {
                                    $active = 'active';
                                }else {
                                    $active = '';
                                }
                            }
                            ?>
                            <li class="<?php echo $active; ?>"><a href="category.php?id=<?php echo $row['categoryId']?>"><?php echo $row['categoryName'] ?></a></li>
                        <?php }
                    } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /Menu Bar -->
