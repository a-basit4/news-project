<?php 
require_once('admin/config.php');
include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
              <!-- post-container -->
              <div class="post-container">
                <?php 
                $id = $_GET['id'];
                $sql = "SELECT p.postId,p.title,p.description,p.category,c.categoryName,p.author,p.postDate,p.postImg,u.userName from post p
                left join category c on p.category = c.categoryId
                left join user u on p.author = u.userId where postId = {$id}";
                $result = mysqli_query($conn,$sql) or die ("Query Failed.");
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                       <div class="post-content single-post">
                    <h3><?php echo $row['title'] ?></h3>
                    <div class="post-information">
                        <span>
                            <i class="fa fa-tags" aria-hidden="true"></i>
                            <a href="category.php?id=<?php echo $row['category'] ?>"><?php echo $row['categoryName'] ?></a>
                        </span>
                        <span>
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <a href='author.php?aid=<?php echo $row['author'] ?>'><?php echo $row['userName'] ?></a>
                        </span>
                        <span>
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            <?php echo $row['postDate'] ?>
                        </span>
                    </div>
                    <img class="single-feature-image" src="admin/upload/<?php echo $row['postImg'] ?>" alt=""/>
                    <p class="description">
                        <?php echo $row['description'] ?>
                    </p>
                </div> 
                    <?php }
                } 
                else {
                 echo "No Record Found.";   
                }
                ?>
                
            </div>
            <!-- /post-container -->
        </div>
        <?php include 'sidebar.php'; ?>
    </div>
</div>
</div>
<?php include 'footer.php'; ?>
