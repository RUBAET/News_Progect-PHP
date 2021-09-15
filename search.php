<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                  <?php 
                     include "config.php";

                        if(isset($_GET['search'])){
                        $search=$_GET['search'];
                        if(empty($search)){
                            echo "<h4 style='color:red;text-align:center;margin:10px 0;'>please input search keywords.</h4>";
                        }else{
                     ?>         
                   
                 <h2 class="page-heading">search:<?php echo $search;?></h2>
             
        <?php 
       
        $limit=2;
        if(isset($_GET['page'])){
        $page=$_GET['page'];
         }   
         else{
        $page=1;
         }
        $offset=($page-1)*$limit;
       
        $sql= "SELECT p.post_id,p.title,p.description,p.category,p.post_date,p.author,p.post_img,u.username,c.category_name FROM post  p JOIN user  u 
            ON P.author=u.user_id
            JOIN category  c ON p.category=c.category_id WHERE p.title LIKE '%{$search}%'
            OR p.description LIKE '%{$search}%' OR u.username LIKE '%{$search}%'
             ORDER BY post_date LIMIT {$offset},{$limit}";
            $result=mysqli_query($conn,$sql) or die("query failed!");
            if(mysqli_num_rows($result)>0){
                
              
            while($row=mysqli_fetch_assoc($result)){
        ?>    
                    <div class="post-content">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="post-img" href="single.php?id=<?php echo $row["post_id"];?>"><img src="admin/upload/<?php echo $row["post_img"];?>" alt=""/></a>
                            </div>
                            <div class="col-md-8">
                                <div class="inner-content clearfix">
                                    <h3><a href='single.php'><?php echo $row["title"];?></a></h3>
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
                                    <p class="description">
                                         <?php echo substr($row["description"],0,120)."......";?>
                                    </p>
                                    <a class='read-more pull-right' href='single.php?id=<?php echo $row["post_id"];?>'>read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        }
                      }else{
                        echo "<h2>No Record Found.</h>";
                      }
                       $sql1= "SELECT * FROM post JOIN user ON post.author=user.user_id
                    WHERE post.title LIKE '%{$search}%'OR post.description LIKE '%{$search}%' OR user.username LIKE '%{$search}%'";
                    $result1=mysqli_query($conn,$sql1) or die("query failed!");
                   
                    
                      if(mysqli_num_rows($result1)>0){
                      $tot_record=mysqli_num_rows($result1);
                      
                      $tot_page=ceil($tot_record/$limit);
                      echo "<ul class='pagination admin-pagination'>";
                      if($page>1){
                        echo "<li><a href='search.php?page=".($page-1)."& search=".$search."'> Prev</a></li>";
                      }
                      for($i=1;$i<=$tot_page;$i++){
                        if($i==$page){
                          $active="active";
                        }else{
                          $active="";
                        }
                         echo "<li class='".$active."'><a href='search.php?page=".$i." & search=".$search."'> ".$i." </a></li>";
                        }
                         if($tot_page>$page){
                        echo "<li><a href='search.php? page=".($page+1)."& search=".$search."'> Next</a></li>";
                      }
                     echo "</ul>";
                      }
                    }
                  }
                    ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
