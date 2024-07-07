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
<title>Home</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="products.css">
</head>
<body>
<nav class="navbar">
  <ul> <li><a class="active" href="home.php">Home</a></li>
  <li><a href="products.php">All Products</a></li>
  <li><a href="porder.php">Place Order</a></li>
  <li><a href="myprofile.php">My Profile</a></li>
  <li><a href="chngpass.php">Change password</a></li>
  <li><a href="?sign=out">Logout</a></li>
   </ul></nav><br> 

<?php
  include("../connection.php");
  
	$sql="select * from product,store where product.product_id=store.product_id";
    $r=mysqli_query($con,$sql);
    echo "<table id= 'customers'>";
    
      while($row=mysqli_fetch_array($r))
      {
        $product_id=$row['product_id'];
        $image=$row['image'];
        $name=$row['name'];
        $ctype=$row['ctype'];
        $sprice=$row['sellingprice'];
      echo "<form action='products.php?action=add&id=$product_id' method='post'>";
      echo "<td><center><img src='../uploadedimage/$image' height='150px' width='150px'><br>
	  $name<br>
	  $ctype<br>$sprice tk
      <input type='hidden' value='$name' name='name'>
      <input type='hidden' value='$sprice' name='sprice'>
      </td>";
      echo "</form>";
      }
      echo "</table>";
  
?>
</body>
</html>
