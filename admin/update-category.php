<?php 
require_once "config.php";
include "header.php";
if ($_SESSION['role'] == '0') {
  header("location: {$hostName}/admin/post.php");
} ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                <?php 
                $id = $_GET['id'];
                $sql = "SELECT * from category where categoryId = {$id}";
                $result = mysqli_query($conn,$sql) or die("Query Failed.");
                if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)){
                 ?>
                  <form action="<?php $_SERVER['PHP_SELF'] ?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="cat_id"  class="form-control" value="<?php echo $row['categoryId'] ?>" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo $row['categoryName'] ?>"  placeholder="" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <?php   
                }
              }else {
                  echo "Something went Wrong.";
                   mysqli_close($conn);
                }                 
                  if (isset($_POST['submit'])) {
                    $id = mysqli_real_escape_string($conn,$_POST['cat_id']);
                    $cat = mysqli_real_escape_string($conn,$_POST['cat_name']);
                    $updateSql = "UPDATE category set categoryName = '{$cat}' where categoryId = {$id}";
                    if (mysqli_query($conn,$updateSql)) {
                      header("location: {$hostName}/admin/category.php");
                    mysqli_close($conn);}
                  }
                   ?>
                </div>
              </div>
            </div>
          </div>
<?php include "footer.php"; ?>
