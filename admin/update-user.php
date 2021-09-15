<?php 
include "header.php"; 
if($_SESSION["user_role"]==0){
 header("location: {$hostname}/admin/post.php");
}
if(isset($_POST['submit'])){
include "config.php";
$u_id=mysqli_real_escape_string($conn,$_POST['user_id']);
$u_fname=mysqli_real_escape_string($conn,$_POST['f_name']);
$u_lname=mysqli_real_escape_string($conn,$_POST['l_name']);
$u_user=mysqli_real_escape_string($conn,$_POST['username']);

$u_role=mysqli_real_escape_string($conn,$_POST['role']);
$sql="UPDATE user SET first_name='{$u_fname}',last_name='{$u_lname}',username='{$u_user}',role='{$u_role}' WHERE user_id={$u_id}";

if(mysqli_query($conn,$sql)){
header("location: {$hostname}/admin/users.php");
 }   
}
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
                  <!-- Form Start -->
                  <?php
                    include "config.php";
                    $u_id=$_GET["id"];
                    $sql1= "SELECT * FROM user WHERE user_id= '{$u_id}'";
                    $result1= mysqli_query($conn, $sql1) or die("query unsuccessful.");
                    if(mysqli_num_rows($result1)>0){
                      while($row=mysqli_fetch_assoc($result1)){
                  ?>
                  <form  action="<?php $_SERVER['PHP_SELF'] ?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value="<?php echo $row["user_id"]; ?>" placeholder="" >
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $row["first_name"]; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $row["last_name"]; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $row["username"]; ?>" placeholder="" required>
                      </div>

                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" value="">
                              <?php if($row["role"]==1){
                                echo "<option value='0'>Normal user</option>
                                <option value='1' selected>Admin</option>";
                              }
                                  else {
                                    echo "<option value='0' selected>Normal user</option>
                                       <option value='1'>Admin</option>";
                                     } 
                              ?>
                              
                            
                          </select>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                <?php }
                    }
                  ?>
                  <!-- /Form -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
