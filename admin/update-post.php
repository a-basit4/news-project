<?php require_once "config.php";
include "header.php"; 
if ($_SESSION['role'] == 0) {
    $post = $_GET['id'];
    $postSql = "SELECT author from post where postId = {$post}";
    $postReuslt = mysqli_query($conn,$postSql) or die("Query Failed.");
    $postRow = mysqli_fetch_assoc($postReuslt);
    if($postRow['author'] != $_SESSION['userId']) {
        header("location: {$hostName}/admin/post.php");
    }
}
?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
        <?php 
        $id = $_GET['id'];
        $sql = "SELECT p.postId,p.title,p.description,p.postImg,p.category,c.categoryName from post p
              left join category c on p.category = c.categoryId
              left join user u on p.author = u.userId
              where postId = {$id}";
        $result = mysqli_query($conn,$sql) or die("Query Failed.");
        if (mysqli_num_rows($result) > 0 ) {
            while ($row = mysqli_fetch_assoc($result)) {?>
                <form action="save-update-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $row['postId'] ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $row['title'] ?>">
            </div>
            <div class="form-group">
            <label for="description"> Description</label>
            <textarea name="postdesc" class="form-control"  required rows="5"><?php echo $row['description'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <select class="form-control" name="category">
                    <?php 
                    $catSql = "SELECT * from category";
                    $catResult = mysqli_query($conn,$catSql);
                    if (mysqli_num_rows($catResult) > 0) {
                        while ($catRow = mysqli_fetch_assoc($catResult)) {
                            if ($row['category'] == $catRow['categoryId']) {
                                $selected = 'selected';
                            }else {
                                $selected = '';
                            }
                            echo "<option {$selected} value='{$catRow['categoryId']}'>{$catRow['categoryName']}</option>";
                        }
                    }
                     ?>
                </select>
                <input type="hidden" name="oldCategory" value="<?php echo $row['category'] ?>">
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image">
                <img  src="upload/<?php echo $row['postImg'] ?>" height="150px">
                <input type="hidden" name="old-image" value="<?php echo $row['postImg'] ?>">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
          <?php  }
        }else {
           echo "Result Not Found";
        }
         ?>
        
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
