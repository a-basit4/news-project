<?php require_once 'config.php';
require_once "header.php";
if ($_SESSION['role'] == '0') {
  header("location: {$hostName}/admin/post.php");
}

if(isset($_POST['save'])) {
  // Validate Input Feild
  function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $loginError = array();
// fname
  if (empty($_POST["fname"])) {
    $nameErr = "First Name is required";
    $loginError[] = $nameErr;
  } else {
    $fname = validate($_POST["fname"]);
  }
// lname
  if (empty($_POST["lname"])) {
    $lnameErr = "Last Name is required";
    $loginError[] = $lnameErr;
  } else {
    $lname = validate($_POST["lname"]);
  } 
// user
  if (empty($_POST["user"])) {
    $userErr = "User Name is required";
    $loginError[] = $userErr;
  } else {
    $user = validate($_POST["user"]);
  } 
// password
  if (empty($_POST["password"])) {
    $passErr = "Password is required";
    $loginError[] = $passErr;
  } else {
    $pass = validate(md5($_POST["password"]));
  }  
// Role
    $role = validate($_POST["role"]);

  if (count($loginError) == 0) {
  $sql = "SELECT userName from user where userName = '{$user}'";
    $result = mysqli_query($conn, $sql) or die('Query Failed.');

    if (mysqli_num_rows($result) > 0) {
      echo '<p style ="color:red;text-align:center;margin:10px 0;">User Name already Exist</p>';
    }else {
      $sqlInsert = "INSERT into user(firstName,lastName,userName,password,role) values('{$fname}','{$lname}','{$user}','{$pass}','{$role}')";

      if(mysqli_query($conn,$sqlInsert)) {
        header("Location: {$hostName}/admin/users.php");
      }
    }

  }
}
?>

<div id="admin-content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="admin-heading">Add User</h1>
      </div>
      <div class="col-md-offset-3 col-md-6">
        <!-- Form Start -->
        <form  action="<?php $_SERVER['PHP_SELF'] ?>" method ="POST" autocomplete="off">
          <div class="form-group">
            <label>First Name</label>
            <input type="text" name="fname" class="form-control"placeholder="First Name" Required>
            <?php 
            if(isset($nameErr)){ ?>
              <div class="alert alert-danger mt-1" role="alert">
                <?php echo $nameErr ?>
              </div>
            <?php } ?>
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="lname" class="form-control" placeholder="Last Name" Required>
            <?php 
            if(isset($lnameErr)){ ?>
              <div class="alert alert-danger mt-1" role="alert">
                <?php echo $lnameErr ?>
              </div>
            <?php } ?>
          </div>
          <div class="form-group">
            <label>User Name</label>
            <input type="text" name="user" class="form-control" placeholder="Username" Required>
            <?php 
            if(isset($userErr)){ ?>
              <div class="alert alert-danger mt-1" role="alert">
                <?php echo $userErr ?>
              </div>
            <?php } ?>
          </div>

          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" Required>
            <?php 
            if(isset($passErr)){ ?>
              <div class="alert alert-danger mt-1" role="alert">
                <?php echo $passErr ?>
              </div>
            <?php } ?>
          </div>
          <div class="form-group">
            <label>User Role</label>
            <select class="form-control" name="role" >
              <option value="0" selected>Normal User</option>
              <option value="1">Admin</option>
            </select>
            <?php 
            if(isset($roleErr)){ ?>
              <div class="alert alert-danger mt-1" role="alert">
                <?php echo $roleErr ?>
              </div>
            <?php } ?>
          </div>
          <input type="submit"  name="save" class="btn btn-primary" value="Save"  />
        </form>
        <!-- Form End-->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
