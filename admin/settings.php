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
    move_uploaded_file($f_tmp,"images/".$f_name);
  }else{
    foreach ($errors as $err) {
      echo  "<p style='color:red;text-align:center;margin:10px 0;'> {$err}</p>";
      die();
    }
  }
}

$web_name=mysqli_real_escape_string($conn,$_POST['website_name']);

$foot_desc=mysqli_real_escape_string($conn,$_POST['foot_desc']);



$sql2="UPDATE settings SET website_name='{$web_name}',logo='{$f_name}',footer_desc='{$foot_desc}'";

if(mysqli_query($conn,$sql2)){
header("location: {$hostname}/admin/settings.php");  
 }  else{
   echo "<h3 style='color:red;text-align:center;margin:10px 0;'>query failed.</h3>";
 } 
}
?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Website Settings</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
       <?php
                    include "config.php";
                   
                   $sql= "SELECT * FROM settings";
                    $result= mysqli_query($conn, $sql) or die("query unsuccessful.");
                    if(mysqli_num_rows($result)>0){
                      while($row=mysqli_fetch_assoc($result)){
                  ?>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
            
            <div class="form-group">
                <label for="exampleInputTile">Website Name</label>
                <input type="text" name="website_name"  class="form-control" id="exampleInputUsername" value="<?php echo $row["website_name"]; ?>">
            </div>
             <div class="form-group">
                <label for="">Website Logo</label>
                <input type="file" name="new-image">
                <img  src="images/<?php echo $row["logo"]; ?>" height="150px">
                <input type="hidden" name="old-image" value="<?php echo $row["logo"]; ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Footer Description</label>
                <textarea name="foot_desc" class="form-control"  required rows="5">
                   <?php echo $row["footer_desc"]; ?>
                </textarea>
            </div>
            
           
            <input type="submit" name="submit" class="btn btn-primary" value="save" />
        </form>
        <?php 
    }
}
        ?>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>