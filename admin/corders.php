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
  <title>Customer Orders</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="corders.css">

</head>
<body>
<ul>
    <li><a href="home.php">Home</a></li>
  <li><a href="addproducts.php">Add Products</a></li>
  <li><a href="store.php">Store</a></li>
  <li><a class="active" href="corders.php">Customer Orders</a></li>
  <li><a href="history.php">History</a></li>
  <li><a href="chngpass.php">Change password</a></li>
  <li><a href="?sign=out">Logout</a></li>
</ul><br>
<div class="container">
<div class="row">
<?php
include("../connection.php");
$sql="select * from customer_order where status=0 order by order_date desc";
$r=mysqli_query($con,$sql);
echo "<table id='customers'>";
echo "<tr>
    <th>Order Id</th>
    <th>Username</th>
    <th>Order Date</th>
    <th>Action</th>
    </tr>";
    while($row=mysqli_fetch_array($r))
    {
      $oid=$row['order_id'];
      $username=$row['username'];
      $odate=$row['order_date'];
      echo "<tr>
      <td>$oid</td><td>$username</td><td>$odate</td><td><a href='corders.php?action=show&id=$oid'>Show details</a></td>
      </tr>";
    }
    echo "</table>";
?>
</div>
</div>

<div class="container" style="color:white;">
<?php
include("../connection.php");
echo "<hr/>";
echo "<h2><u>Order Details</u></h2>";
if(isset($_GET['action']) and $_GET['action'] == 'show')
{
  $oid=$_GET['id'];
  $_SESSION['order_id']=$oid;
  $sql="select * from orderline where order_id='$oid'";
  $r=mysqli_query($con,$sql);
  echo "<table id='customers'>";
  echo "<tr>
      <th>Product id</th>
      <th>Quantity</th>
      <th>Total price</th>
      </tr>";
      $gtotal=0;
      while($row=mysqli_fetch_array($r))
      {
        $product_id=$row['product_id'];
        $q=$row['quantity'];
        $total=$row['total'];
        echo "<tr>
        <td>$product_id</td><td>$q</td><td>$total</td>
        </tr>";
        $gtotal=$gtotal+$total;
      }
      echo "<tr><td colspan='2' align='right'>Grand total</td>
      <td>$gtotal</td></tr>";
  echo "</table>";
}
?>
</div>
<form action='corders.php' method='post'>
<div class="row">
  <input type="submit" class="button" value="Confirm Order" name="corder">
</div>
</form>
<?php
include("../connection.php");
if(isset($_POST['corder']))
{
  $oid=$_SESSION['order_id'];
  $sql="select * from orderline where order_id='$oid'";
  $r=mysqli_query($con,$sql);
  while($row=mysqli_fetch_array($r))
    {
      $product_id=$row['product_id'];
      $q=$row['quantity'];
      $sqlupdate="update store set quantity=quantity-$q where product_id='$product_id'";
      mysqli_query($con,$sqlupdate);
    }
    $sqlorderupdate="update customer_order set status=1 where order_id='$oid'";
    mysqli_query($con,$sqlorderupdate);
    //echo "Order confirmed";
    header("Location:corders.php");
}
?>
</body>
</html>