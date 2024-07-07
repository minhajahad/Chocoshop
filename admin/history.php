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
<title>History</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="corders.css">
</head>
<body>
<ul>
  <li><a href="home.php">Home</a></li>
  <li><a href="addproducts.php">Add Products</a></li>
  <li><a href="store.php">Store</a></li>
  <li><a href="corders.php">Customer Orders</a></li>
  <li><a class="active" href="history.php">History</a></li>
  <li><a href="chngpass.php">Change password</a></li>
  <li><a href="?sign=out">Logout</a></li>
</ul><br>
<div class="container">
<div class="row">
<?php
include("../connection.php");
$sql="select * from customer_order where status=1 order by order_date desc";
$sql1="select * from customer_order where status=0 order by order_date desc";
$r=mysqli_query($con,$sql);
$r1=mysqli_query($con,$sql1);
echo"<table id='customers'>";
echo"<tr>
		<th>Order id</th>
		<th>Order date</th>
		<th>Username</th>
		<th>Status</th>
	 </tr>";
    while($row=mysqli_fetch_array($r1))
    {
      $oid=$row['order_id'];
      $odate=$row['order_date'];
      $username=$row['username'];
      echo "<tr>
      <td>$oid</td><td>$odate</td><td>$username</td><td>Pending</td>
      </tr>";
    }
	while($row=mysqli_fetch_array($r))
    {
      $oid=$row['order_id'];
      $odate=$row['order_date'];
      $username=$row['username'];
      echo "<tr>
      <td>$oid</td><td>$odate</td><td>$username</td><td>Confirmed</td>
      </tr>";
    }
echo"</table>";
?>
</div>
</div>
</body>
</html>
