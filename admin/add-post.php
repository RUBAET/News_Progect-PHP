<?php 
include "header.php"; 
include "config.php";
if(isset($_FILES['fileToUpload'])){
  $errors=[];
  $f_name=$_FILES['fileToUpload']['name'];
  $f_size=$_FILES['fileToUpload']['size'];
  $f_tmp=$_FILES['fileToUpload']['tmp_name'];
  $f_type=$_FILES['fileToUpload']['type'];
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




$p_title=mysqli_real_escape_string($conn,$_POST["post_title"]);
$p_desc=mysqli_real_escape_string($conn,$_POST["postdesc"]);
$p_category=mysqli_real_escape_string($conn,$_POST["category"]);
$p_date=mysqli_real_escape_string($conn,date('d-m-y'));
$p_author=mysqli_real_escape_string($conn,$_SESSION['user_id']);

$sql="INSERT INTO post(title,description,category,post_date,author,post_img) VALUES('{$p_title}','{$p_desc}','{$p_category}','{$p_date}','{$p_author}','{$f_name}');";
$sql.="UPDATE category SET post=post+1 WHERE category_id={$p_category}";

 if(mysqli_multi_query($conn,$sql)){
 header("location:{$hostname}/admin/post.php");
 }
 else{
  echo "<div class='alert alert-danger'>query failed.</div>";
 }

}
?>
  <div id="admin-content">
      <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <h1 class="admin-heading">Add New Post</h1>
             </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form -->
                 
                  <form  action="<?php $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="post_title">Title</label>
                          <input type="text" name="post_title" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="postdesc" class="form-control" rows="5"  required></textarea>
                      </div>
                      <div class="form-group">
                      

                          <label for="exampleInputPassword1">Category</label>
                          
                          <select name="category" class="form-control">
                            <?php 
                            
                                $sql1="SELECT * FROM category";
                                $result1=mysqli_query($conn,$sql1) or die("query failed!");
                                 if (mysqli_num_rows($result1)>0){
                                 while($row=mysqli_fetch_assoc($result1)){
                                echo "<option value='{$row['category_id']}'>
                                {$row['category_name']} </option>";
                              
                            }
                          }
                          ?> 
                              
                         
                          </select>
                        
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Post image</label>
                          <input type="file" name="fileToUpload" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                  </form>
                  <!--/Form -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
