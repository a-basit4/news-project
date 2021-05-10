<?php require_once'config.php'; 
include "header.php";
if ($_SESSION['role'] == '0') {
  header("location: {$hostName}/admin/post.php");
}
if(isset($_POST['submit'])) {
  // Validate Input Feild
  function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
// fname
  if (empty($_POST["fname"])) {
    $nameErr = "First Name is required";
  } else {
    $fname = validate($_POST["fname"]);
  }
// lname
  if (empty($_POST["lname"])) {
    $lnameErr = "Last Name is required";
  } else {
    $lname = validate($_POST["lname"]);
  } 
// user
  if (empty($_POST["user"])) {
    $userErr = "User Name is required";
  } else {
    $user = validate($_POST["user"]);
  } 
 
// Role
  $role = validate($_POST["role"]);
  $id = validate($_POST["user_id"]);

  $sqlUpdate = "UPDATE user SET firstName = '{$fname}', lastName='{$lname}', userName='{$user}', role = '{$role}' where userId = {$id}";

  if(mysqli_query($conn,$sqlUpdate)) {
    header("Location: {$hostName}/admin/users.php");
    }
  mysqli_close($conn);
 
}
?>
<div id="admin-content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="admin-heading">Modify User Details</h1>
      </div>
      <div class="col-md-offset-4 col-md-4">
        <!-- Form Start -->
        <?php 
        $id = $_GET['id'];
        $sql = "SELECT * from user where userId = '{$id}'";
        $result = mysqli_query($conn,$sql) or die('Query failed');
        if(mysqli_num_rows($result) > 0 ){
         while($row = mysqli_fetch_assoc($result)){
           ?>
           <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
            <div class="form-group">
              <input type="hidden" name="user_id"  class="form-control" value="<?php echo $row['userId'] ?>" placeholder="" >
            </div>
            <div class="form-group">
              <label>First Name</label>
              <input type="text" name="fname" class="form-control" value="<?php echo $row['firstName'] ?>" placeholder="" required>
            </div>
            <div class="form-group">
              <label>Last Name</label>
              <input type="text" name="lname" class="form-control" value="<?php echo $row['lastName'] ?>" placeholder="" required>
            </div>
            <div class="form-group">
              <label>User Name</label>
              <input type="text" name="user" class="form-control" value="<?php echo $row['userName'] ?>" placeholder="" required>
            </div>
            <div class="form-group">
              <label>User Role</label>
              <select class="form-control" name="role" value="<?php echo $row['role']; ?>">
                <?php 
                if($row['role'] == 1){ 
                echo '<option value="0">normal User</option>
                <option value="1" selected>Admin</option>';
              }else{
                echo '<option value="0" selected>normal User</option>
                <option value="1">Admin</option>';
              }

                ?>
              </select>
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
          </form>
        <?php }
      } ?>
      <!-- /Form -->
    </div>
  </div>
</div>
</div>
<?php include "footer.php"; ?>
