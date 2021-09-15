<?php 
include "header.php"; 
if(isset($_POST['submit'])){
    include "config.php";

if(empty($_FILES['new-image']['name'])){
$f_name=$_POST["old-image"];
}
else{
 $errors=[];
  $f_name=$_FILES['new-image']['name'];
  $f_size=$_FILES['new-image']['size'];
  $f_tmp=$_FILES['new-image']['tmp_name'];
  $f_type=$_FILES['new-image']['type'];
  $f_extension=strtolower(end(explode(".",$f_name)));
  $extension=["jpeg","jpg","png"];
  if(in_array($f_extension, $extension)===false){
      $errors[]="ivalid image format.please upload jpeg,jpg,png files ";
      }
  if($f_size>2095172){
      $errors[]="file size must be 2mb or lower";
      }
  if(empty($errors)===true){
    move_uploaded_file($f_tmp,"upload/".$f_name);
  }else{
    foreach ($errors as $err) {
      echo  "<p style='color:red;text-align:center;margin:10px 0;'> {$err}</p>";
      die();
    }
  }
}

$p_id=mysqli_real_escape_string($conn,$_POST['post_id']);
$p_title=mysqli_real_escape_string($conn,$_POST['post_title']);
$p_desc=mysqli_real_escape_string($conn,$_POST['postdesc']);
$p_cat=mysqli_real_escape_string($conn,$_POST['category']);


$sql2="UPDATE post SET title='{$p_title}',description='{$p_desc}',category={$p_cat} ,post_img='{$f_name}' WHERE post_id={$p_id}";

if(mysqli_query($conn,$sql2)){
header("location: {$hostname}/admin/post.php");
 }  else{
   echo "<h3 style='color:red;text-align:center;margin:10px 0;'>query failed.</h3>";
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
                    include "config.php";
                    $p_id=$_GET["id"];
                   $sql= "SELECT p.post_id,p.title,p.description,p.category,p.author,p.post_img,u.username,c.category_name FROM post  p LEFT JOIN user  u 
                       ON p.author=u.user_id
                     LEFT JOIN category  c ON p.category=c.category_id
                     WHERE p.post_id={$p_id}";
                    $result= mysqli_query($conn, $sql) or die("query unsuccessful.");
                    if(mysqli_num_rows($result)>0){
                      while($row=mysqli_fetch_assoc($result)){
                  ?>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $row["post_id"]; ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $row["title"]; ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5">
                    <?php echo $row["description"]; ?>
                </textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <select class="form-control" name="category">
                     <?php 
                            
                                $sql1="SELECT * FROM category";
                                $result1=mysqli_query($conn,$sql1) or die("query failed!");
                                 if (mysqli_num_rows($result1)>0){
                                 while($row1=mysqli_fetch_assoc($result1)){
                                    if($row['category']==$row1['category_id']){
                                            $select='selected';
                                    }
                                    else{
                                            $select='';
                                    }
                                echo "<option {$select} value='{$row1['category_id']}' >
                                {$row1['category_name']} </option>";
                              
                            }
                          }
                          ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image">
                <img  src="upload/<?php echo $row["post_img"]; ?>" height="150px">
                <input type="hidden" name="old-image" value="<?php echo $row["post_img"]; ?>">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
    <?php 
            }
        }
        else{
            echo "<h3 style='color:red;text-align:center;margin:10px 0;'>Result not found.</h3>";
                }
                           
    ?>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
