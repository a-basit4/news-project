<?php require_once "config.php"; 
include "header.php";
?>
<div id="admin-content">
  <div class="container">
    <div class="row">
      <div class="col-md-10">
        <h1 class="admin-heading">All Posts</h1>
      </div>
      <div class="col-md-2">
        <a class="add-new" href="add-post.php">add post</a>
      </div>
      <div class="col-md-12">
        <table class="content-table">
          <thead>
            <th>S.No.</th>
            <th>Title</th>
            <th>Category</th>
            <th>Date</th>
            <th>Author</th>
            <th>Edit</th>
            <th>Delete</th>
          </thead>
          <tbody>
            <?php
            $limit = 3;
            if (isset($_GET['page'])) {
              $page = $_GET['page'];
            }else{
              $page = 1;
            }
            $offset = ($page - 1) * $limit;
            if ($_SESSION['role'] == '1') {
              $sql = "SELECT p.postId,p.title,c.categoryName,p.category,p.postDate,u.userName from post p
              left join category c on p.category = c.categoryId
              left join user u on p.author = u.userId
              order by p.postId desc limit {$offset},{$limit}";
            }elseif($_SESSION['role'] == '0') {
              $sql = "SELECT p.postId,p.title,c.categoryName,p.category,p.postDate,u.userName from post p
              left join category c on p.category = c.categoryId
              left join user u on p.author = u.userId
              where p.author = {$_SESSION['userId']}
              order by p.postId desc limit {$offset},{$limit}";
            }
            $result = mysqli_query($conn,$sql);
            if (mysqli_num_rows($result) > 0 ) {
              $serial = $offset + 1;
              while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                  <td class='id'><?php echo $serial ;?></td>
                  <td><?php echo $row['title'] ?></td>
                  <td><?php echo $row['categoryName'] ?></td>
                  <td><?php echo $row['postDate'] ?></td>
                  <td><?php echo $row['userName'] ?></td>
                  <td class='edit'><a href='update-post.php?id=<?php echo $row['postId']?>'><i class='fa fa-edit'></i></a></td>
                  <td class='delete'><a href='delete-post.php?id=<?php echo $row['postId']?>&catId=<?php echo$row['category'] ?>'><i class='fa fa-trash-o'></i></a></td>
                </tr>
                <?php
                $serial++;
              }
            }
            ?>        
          </tbody>
        </table>
        <?php 
        if ($_SESSION['role'] == '1') {
        $postSql = "SELECT * from post";

        }elseif($_SESSION['role'] == '0'){
          $postSql = "SELECT * from post where author = {$_SESSION['userId']}";
        }
        $result = mysqli_query($conn,$postSql);
        if (mysqli_num_rows($result) > 0) {
          $totalRecords = mysqli_num_rows($result);
          $totalPage = ceil($totalRecords/$limit);
          echo "<ul class='pagination admin-pagination'>";
          if ($page > 1) {
            echo "<li><a href='post.php?page=".($page-1)."'>Prev</a></li>";
          }
          for ($i = 1; $i <= $totalPage; $i++) {
            if ($i == $page) {
              $active = 'active';                
            }else {
              $active = '';
            }
            echo '<li class='.$active.'><a href="post.php?page='.$i.'">'.$i.'</a></li>';
          }
          if ($page < $totalPage) {
            echo "<li><a href='post.php?page=".($page + 1)."'>Next</a></li>";
          }
          echo ' </ul>';
        }
        ?>


      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
