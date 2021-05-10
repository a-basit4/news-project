<?php 
require_once 'config.php';
if (!isset($_SESSION['username'])) {
    header("Location: {$hostName}/admin/");
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ADMIN Panel</title>
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="../dist/index.css">
</head>
<body>
    <!-- HEADER -->
    <div id="header-admin">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row justify-content-between">
                <!-- LOGO -->
                <div class="col-md-2">
                    <a href="post.php"><img class="logo" src="images/news.jpg"></a>
                </div>
                <!-- /LOGO -->
                <!-- LOGO-Out -->
                <div class="col-md-3">
                    <h2 class="d-inline mr-3">Hello <?php echo $_SESSION['username']; ?></h2><a href="logout.php" class="admin-logout" >logout</a>
                </div>
                <!-- /LOGO-Out -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="admin-menubar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                 <ul class="admin-menu">
                    <li>
                        <a href="post.php">Post</a>
                    </li>
                    <?php if ($_SESSION['role'] == 1 ){ ?> 
                    <li>
                        <a href="category.php">Category</a>
                    </li>
                    <li>
                        <a href="users.php">Users</a>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /Menu Bar -->
