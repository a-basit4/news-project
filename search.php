<?php 
require_once("admin/config.php");
include 'header.php'; ?>
<div id="main-content">
  <div class="container">
    <div class="row">
        <div class="col-md-8">
            <!-- post-container -->
            <div class="post-container">
              <h2 class="page-heading">Search : <?php echo mysqli_real_escape_string($conn,$_GET['term']) ?></h2>
              <?php
              $term = mysqli_real_escape_string($conn,$_GET['term']); 
              $limit = 2;
              if (isset($_GET['page'])) {
                  $page = $_GET['page'];
              }else{
                  $page = 1;
              }
              $offset = ($page - 1) * $limit;
              $sql = "SELECT p.postId,p.title,p.description,c.categoryName,p.category,p.author,p.postDate,p.postImg,u.userName from post p
              left join category c on p.category = c.categoryId
              left join user u on p.author = u.userId
              where p.title like '%{$term}%' or p.description like '%{$term}%'
              order by p.postId desc limit {$offset},{$limit}";
              $result = mysqli_query($conn,$sql) or die('Query Failed.');
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="post-content">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="post-img" href="single.php?id=<?php echo $row['postId'] ?>"><img src="admin/upload/<?php echo $row['postImg'] ?>" alt=""/></a>
                            </div>
                            <div class="col-md-8">
                                <div class="inner-content clearfix">
                                    <h3><a href='single.php?id=<?php echo $row['postId'] ?>'><?php echo $row['title'] ?></a></h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href='category.php?id=<?php echo $row['category'] ?>'><?php echo $row['categoryName'] ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <a href='author.php?aid=<?php echo $row['author'];?>'><?php echo $row['userName'] ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo $row['postDate'] ?>
                                        </span>
                                    </div>
                                    <p class="description">
                                        <?php echo substr($row['description'], 0,150). ' ...' ?>
                                    </p>
                                    <a class='read-more pull-right' href='single.php?id=<?php echo $row['postId'] ?>'>read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } else {
                echo "No Record Found.";
            }
            $pageSql = "SELECT * FROM post where post.title like '%{$term}%'";
            $pageResult = mysqli_query($conn,$pageSql) or die('Query Failed. second');
            if (mysqli_num_rows($pageResult) > 0) {
                $totalRecords = mysqli_num_rows($pageResult);
                $totalPage = ceil($totalRecords/$limit);
                echo "<ul class='pagination'>";
                if ($page > 1) {
                    echo '<li><a href="search.php?page='.($page-1).'&term='.$term.'">Prev</a></li>';
                }
                for ($i = 1; $i <= $totalPage; $i++) {
                    if ($i == $page) {
                        $active = 'active';
                    }else {
                        $active = '';
                    }
                    echo '<li class='.$active.'><a href="search.php?page='.$i.'&term='.$term.'">'.$i.'</a></li>';
                }
                if ($page < $totalPage) {
                    echo '<li><a href="search.php?page='.($page+1).'&term='.$term.'">Next</a></li>';
                }
                echo "</ul>";
            }
            ?>


        </div><!-- /post-container -->
    </div>
    <?php include 'sidebar.php'; ?>
</div>
</div>
</div>
<?php include 'footer.php'; ?>
