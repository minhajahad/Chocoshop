<?php
session_start();
if($_SESSION['customer_login_status']!="logged in" and ! isset($_SESSION['user_name'])){
header("Location:../Login.php");}
//logout code
if(isset($_GET['sign']) and $_GET['sign']=="out"){
$_SESSION['customer_login_status']="logged out";
unset($_SESSION['user_name']);
header("Location:../Login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>My Profile</title>
<link rel="stylesheet" href="style.css">

</head>
<body>
<ul>
  <li><a href="home.php">Home</a></li>
  <li><a href="products.php">All Products</a></li>
  <li><a href="porder.php">Place Order</a></li>
  <li><a class="active" href="myprofile.php">My Profile</a></li>
  <li><a href="chngpass.php">Change password</a></li>
  <li><a href="?sign=out">Logout</a></li>
</ul><br> 
<?php
  include("../connection.php");
  $username=$_SESSION['user_name'];
  $sql="select name,dob,phone_number,address,username,image from customer where username='$username'";
  $r=mysqli_query($con,$sql);
  $row=mysqli_fetch_assoc($r);
  $name=$row['name'];
  $dob=$row['dob'];
  $phone_number=$row['phone_number'];
  $address=$row['address'];
  $username=$row['username'];
  $image=$row['image']; 
  echo "<div class='img'><img src='../uploadedimage/$image' height='250' width='500'></div>";
  echo "<p><b>Name:</b> $name</p><br>";
  echo "<p><b>Date Of Birth: </b>$dob</p><br>";
  echo "<p><b>Phone Number:</b> 0$phone_number</p><br>";
  echo "<p><b>Address: </b>$address</p><br>";
  echo "<p><b>Username: </b>$username</p><br>";
  
  
?>
</body>
</html>
