<?php require_once 'config.php'; 
if (isset($_SESSION['username'])) {
    header("Location: {$hostName}/admin/post.php");
}?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ADMIN | Login</title>

    <link rel="stylesheet" href="../dist/index.css">
</head>

<body>
    <div id="wrapper-admin" class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-4 col-md-4">
                    <img class="logo" src="images/news.jpg">
                    <h3 class="heading">Admin</h3>
                    <!-- Form Start -->
                    <form  action="<?php $_SERVER['PHP_SELF'] ?>" method ="POST">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="" required>
                        </div>
                        <input type="submit" name="login" class="btn btn-primary" value="login" />
                    </form>
                    <!-- /Form  End -->
                    <?php 
                    if (isset($_POST['login'])) {
                     $username = mysqli_real_escape_string($conn, $_POST['username']);
                     $password = md5($_POST['password']);
                     $sql = "SELECT userId,userName,role from user where userName='{$username}' and password = '{$password}'";

                     $result = mysqli_query($conn, $sql) or die("Query Failed"); 
                     if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                         $_SESSION['username'] = $row['userName'];
                         $_SESSION['userId'] = $row['userId'];
                         $_SESSION['role'] = $row['role'];
                         header("Location: {$hostName}/admin/post.php");
                     }   
                 }else {
                    echo '<div class="alert">Username and Password not matched.</div>';
                }
            } 

            ?>
        </div>
    </div>
</div>
</div>
</body>
</html>
