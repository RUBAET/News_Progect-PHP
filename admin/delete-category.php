<?php
if($_SESSION["user_role"] == 0){
 header("location: {$hostname}/admin/post.php");
}
$c_id=$_GET['id'];

include "config.php";
$sql= "DELETE FROM category WHERE category_id= {$c_id}";
$result= mysqli_query($conn, $sql) or die("query unsuccessful.");
header("location: {$hostname}/admin/category.php");
mysql_close($conn);
?>