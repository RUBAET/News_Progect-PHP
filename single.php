<?php include 'header.php'; ?>

    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                  <!-- post-container -->

                    <div class="post-container">
            <?php 
            
            include "config.php";
            $p_id=$_GET['id'];
            $sql= "SELECT p.post_id,p.title,p.description,p.category,p.post_date,p.author,p.post_img,u.username,c.category_name FROM post  p JOIN user  u 
            ON P.author=u.user_id
            JOIN category  c ON p.category=c.category_id WHERE p.post_id={$p_id}";
            $result=mysqli_query($conn,$sql) or die("query failed!");
            if(mysqli_num_rows($result)>0){
                        while($row=mysqli_fetch_assoc($result)){
              ?>
                        <div class="post-content single-post">
                            
                            <h3><?php echo $row["title"];?></h3>
                            <div class="post-information">
                                <span>
                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                    <a href='category.php?c_id=<?php echo $row["category"];?>'><?php echo $row["category_name"];?></a>
                                </span>
                                <span>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <a href='author.php?u_id=<?php echo $row["author"];?>'><?php echo $row["username"];?></a>
                                </span>
                                <span>
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <?php echo $row["post_date"];?>
                                </span>
                            </div>
                            <img class="single-feature-image" src="admin/upload/<?php echo $row["post_img"];?>" alt=""/>
                            <p class="description">
                                <?php echo $row["description"];?>
                            </p>
                            
                        </div>
                         <?php 
                        }
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
