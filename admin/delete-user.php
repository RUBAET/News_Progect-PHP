<?php
if($_SESSION["user_role"]==0){
 header("location: {$hostname}/admin/post.php");
}
$u_id=$_GET['id'];

include "config.php";
$sql= "DELETE FROM user WHERE user_id= {$u_id}";
$result= mysqli_query($conn, $sql) or die("query unsuccessful.");
header("location: {$hostname}/admin/users.php");
mysql_close($conn);
?>