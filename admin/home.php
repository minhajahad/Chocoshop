<?php
session_start();
if($_SESSION['admin_login_status']!="logged in" and ! isset($_SESSION['user_name'])){
header("Location:../Login.php");}
//logout code
if(isset($_GET['sign']) and $_GET['sign']=="out"){
$_SESSION['admin_login_status']="logged out";
unset($_SESSION['user_name']);
header("Location:../Login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Home</title>
<link rel="stylesheet" href="style.css">

</head>
<body>
<ul>
  <li><a class="active" href="home.php">Home</a></li>
  <li><a href="addproducts.php">Add Products</a></li>
  <li><a href="store.php">Store</a></li>
  <li><a href="corders.php">Customer Orders</a></li>
  <li><a href="history.php">History</a></li>
  <li><a href="chngpass.php">Change password</a></li>
  <li><a href="?sign=out">Logout</a></li>
</ul><br>
</body>
</html>
