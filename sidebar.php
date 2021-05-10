<?php require_once("admin/config.php") ?>
<div id="sidebar" class="col-md-4">
    <!-- search box -->
    <div class="search-box-container">
        <h4>Search</h4>
        <form class="search-post" action="search.php" method ="GET">
            <div class="input-group">
                <input type="text" name="term" class="form-control" placeholder="Search .....">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /search box -->
    <!-- recent posts box -->
    <div class="recent-post-container">
        <h4>Recent Posts</h4>
        <?php 
        $limit = 3;
        $sql = "SELECT p.postId,p.title,c.categoryName,p.category,p.postDate,p.postImg from post p
        left join category c on p.category = c.categoryId
        order by p.postId desc limit {$limit}";
        $result = mysqli_query($conn,$sql);
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) { ?>
             <div class="recent-post">
                <a class="post-img" href="single.php?id=<?php echo $row['postId'] ?>">
                    <img src="admin/upload/<?php echo $row['postImg'] ?>" alt=""/>
                </a>
                <div class="post-content">
                    <h5><a href="single.php?id=<?php echo $row['postId'] ?>"><?php echo $row['title'] ?></a></h5>
                    <span>
                        <i class="fa fa-tags" aria-hidden="true"></i>
                        <a href='category.php?id=<?php echo $row['category'] ?>'><?php echo $row['categoryName'] ?></a>
                    </span>
                    <span>
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <?php echo $row['postDate'] ?>
                    </span>
                    <a class="read-more" href="single.php?id=<?php echo $row['postId'] ?>">read more</a>
                </div>
            </div>   
        <?php }
    }
    ?>    
</div>
<!-- /recent posts box -->
</div>
