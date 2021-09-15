<?php
if($_SESSION["user_role"]==0){
 header("location: {$hostname}/admin/post.php");
}
$p_id=$_GET['id'];
$c_id=$_GET['cat_id'];
include "config.php";
$sql1= "SELECT * FROM post WHERE post_id={$p_id}";
$result1= mysqli_query($conn, $sql1) or die("query unsuccessful.");
$row=mysqli_fetch_assoc($result1);
unlink("upload/".$row['post_img']);
$sql= "UPDATE category SET post=post-1 WHERE category_id={$c_id};";
$sql.= "DELETE FROM post WHERE post_id= {$p_id}";
$result= mysqli_multi_query($conn, $sql) or die("query unsuccessful.");
header("location: {$hostname}/admin/post.php");
mysql_close($conn);
?>