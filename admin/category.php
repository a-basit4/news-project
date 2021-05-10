<?php 
require_once 'config.php';
include "header.php"; 
if ($_SESSION['role'] == '0') {
  header("location: {$hostName}/admin/post.php");
}?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                       <?php 
                       $limit = 5;
                       if (isset($_GET['page'])) {
                           $page = $_GET['page'];
                       }else {
                        $page = 1;
                       }
                       
                       $offset = ($page - 1) * $limit;
                       $sql = "SELECT * from category order by categoryId DESC LIMIT {$offset},{$limit}";
                       $result = mysqli_query($conn, $sql) or die("Query Failed.");
                       if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)){
                            ?>
                            <tr>
                                <td class='id'><?php echo $row['categoryId'] ?></td>
                                <td><?php echo $row['categoryName'] ?></td>
                                <td><?php echo $row['post'] ?></td>
                                <td class='edit'><a href='update-category.php?id=<?php echo $row['categoryId'] ;?>'><i class='fa fa-edit'></i></a></td>
                                <td class='delete'><a href='delete-category.php?id=<?php echo $row['categoryId'] ?>'><i class='fa fa-trash-o'></i></a></td>
                            </tr>
                        <?php     }
                    } ?>
                </tbody>
            </table>
            <?php 
            $pageSql = "SELECT * from category";
            $pageResult = mysqli_query($conn,$pageSql) or die("Query Failed");
            if (mysqli_num_rows($pageResult) > 0) {
                $totalRecords = mysqli_num_rows($pageResult);
                $totalPage = ceil($totalRecords/$limit);
                echo "<ul class='pagination admin-pagination'>";
                if ($page > 1) {
                    echo "<li><a href='category.php?page=".($page - 1)."'>Prev</a></li>";
                }
                for($i=1; $i<=$totalPage; $i++){
                    if ($i == $page) {
                        $active = 'active';
                    }else {
                        $active = '';
                    }
                    echo '<li class='.$active.'><a href="category.php?page='.$i.'">'.$i.'</a></li>';
                }
                if ($totalPage > $page) {
                    echo "<li><a href='category.php?page=".($page+1)."'>Next</a></li>"; 
                }
                
                echo"</ul>";
            }
             ?>
        </div>
    </div>
</div>
</div>
<?php include "footer.php"; ?>
