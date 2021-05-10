<?php
require_once'config.php'; 
require_once "header.php";
if ($_SESSION['role'] == '0') {
  header("location: {$hostName}/admin/post.php");
}
 ?>
<div id="admin-content">
  <div class="container">
    <div class="row">
      <div class="col-md-10">
        <h1 class="admin-heading">All Users</h1>
      </div>
      <div class="col-md-2">
        <a class="add-new" href="add-user.php">add user</a>
      </div>
      <div class="col-md-12">
        <?php
        $limit = 3;
        if(isset($_GET['page'])) {
          $page = $_GET['page'];
        }else {
          $page = 1;
        }
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * from user order by userId DESC limit {$offset},{$limit}";
        $result = mysqli_query($conn, $sql) or die('Query Faild.');
        if(mysqli_num_rows($result) > 0){
         ?>
        <table class="content-table">
          <thead>
            <th>S.No.</th>
            <th>Full Name</th>
            <th>User Name</th>
            <th>Role</th>
            <th>Edit</th>
            <th>Delete</th>
          </thead>
          <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td class='id'><?php echo $row['userId'] ?></td>
              <td><?php echo $row['firstName'] ." ". $row['lastName'];?></td>
              <td><?php echo $row['userName']; ?></td>
              <td><?php if($row['role'] == 1){
                echo 'Admin';
              }else{
                echo 'Modirator User';
              } ?></td>
              <td class='edit'><a href='update-user.php?id=<?php echo $row['userId'] ?>'><i class='fa fa-edit'></i></a></td>
              <td class='delete'><a href='delete-user.php?id=<?php echo $row['userId'] ?>'><i class='fa fa-trash-o'></i></a></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      <?php } 
      $pageSql = "SELECT * FROM USER";
      $result = mysqli_query($conn, $pageSql) or die("Query Failed.");
      if(mysqli_num_rows($result) > 0) {
        $totalRecords = mysqli_num_rows($result);
        $totalPage = ceil($totalRecords / $limit);
        echo"<ul class='pagination admin-pagination'>";
        if($page > 1) {
          echo '<li><a href="users.php?page='.($page -1).'">Prev</a></li>';
        }
        for($i = 1; $i<=$totalPage; $i++) {
          if($i == $page){
            $active = 'active';
          }else {
            $active = '';  
          }
        echo '<li class="'.$active.'"><a href="users.php?page='.$i.'">'.$i.'</a></li>';
        }
        if($totalPage > $page){
          echo '<li><a href="users.php?page='.($page + 1).'">Next</a></li>';
        }
        
        echo '</ul>';
      }
      ?>
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
