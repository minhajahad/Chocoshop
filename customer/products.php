<?php
  session_start();
  if(isset($_POST['add']))
  {
    if(isset($_SESSION['cart']))
    {
      $item_array_id=array_column($_SESSION['cart'],'item_id');
      if(!in_array($_GET['id'],$item_array_id))
      {
        $count=count($_SESSION['cart']);
        $item_array=array (
          'item_id' => $_GET['id'],
          'item_name' => $_POST['name'],
          'item_price' => $_POST['sprice'],
          'item_q' => $_POST['quantity']
        );
        $_SESSION['cart'][$count]=$item_array;
      }
      else
      {
        echo "<script>alert('Item already added')</script>";
        echo "<script>window.location='products.php'</script>";
      }
    }
	else
    {
      $item_array=array (
        'item_id' => $_GET['id'],
        'item_name' => $_POST['name'],
        'item_price' => $_POST['sprice'],
        'item_q' => $_POST['quantity']
      );
      $_SESSION['cart'][0]=$item_array;
    }
  }
 
  if(isset($_GET['action']) and $_GET['action'] == 'delete' )
  {
    foreach($_SESSION['cart'] as $keys => $values)
    {
      if($values['item_id'] == $_GET['id'])
      {
        unset($_SESSION['cart'][$keys]);
      }
    }
  }

  if($_SESSION['customer_login_status']!="logged in" and ! isset($_SESSION['user_name'])){
  header("Location:../Login.php");}
  if(isset($_GET['sign']) and $_GET['sign']=="out"){
    $_SESSION['customer_login_status']="logged out";
    unset($_SESSION['user_name']);
  header("Location:../Login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>All Products</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="products.css">

</head>
<body>
<ul>
   <li><a href="home.php">Home</a></li>
  <li><a class="active" href="products.php">All Products</a></li>
  <li><a href="porder.php">Place Order</a></li>
  <li><a href="myprofile.php">My Profile</a></li>
  <li><a href="chngpass.php">Change password</a></li>
  <li><a href="?sign=out">Logout</a></li>
</ul><br>

<div class="row">
  <div class="container">
    <form action="products.php" method="post">
    <div class="row">
      <div class="col-25">
        
      </div>
      <div class="col-75">
        <label for="category"><b>Select a category: </b></label>
        <select style="height:43px;width:990px;" id="category" name="category">
        
<?php
  include("../connection.php");
  $sql="select distinct ctype from product";
  $r=mysqli_query($con,$sql);
  
  while($row=mysqli_fetch_array($r))
  {
    $ctype=$row['ctype'];
    echo "<option value= '$ctype'>$ctype</option>";
  }
?>
</select>
      </div>
    </div>
    <div class="row">
      <input type="submit" class="button" value="Run" name="run">
    </div>
    </form>
  </div>
</div>
<div>
<?php
  include("../connection.php");
  if(isset($_POST['run']))
  {
    $c=$_POST['category'];
    
    $sql="select * from product,store where product.product_id=store.product_id and product.ctype='$c'";
    $r=mysqli_query($con,$sql);
    echo "<table id= 'customers'>";
    echo "<tr>
    <th>Chocolate's Name</th>
    <th>Chocolate type</th>
    <th>Price</th>
    <th>Cover page</th>
    <th>Add quantity</th>
    <th>Action</th>
    </tr>";
      while($row=mysqli_fetch_array($r))
      {
        $product_id=$row['product_id'];
        $image=$row['image'];
        $name=$row['name'];
        $ctype=$row['ctype'];
        $sprice=$row['sellingprice'];
      echo "<form action='products.php?action=add&id=$product_id' method='post'>";
      echo "<tr>
      <td>$name</td><td>$ctype</td><td>$sprice</td>
      <td><img src='../uploadedimage/$image' height='50px' width='50px'></td>
      <td><input type='text' value='1' name='quantity'>
      <input type='hidden' value='$name' name='name'>
      <input type='hidden' value='$sprice' name='sprice'>
      </td>
      <td><input type='submit' class='button' value='Add to cart' name='add'></td>
      </tr>";
      echo "</form>";
      }
      echo "</table>";
  }
?>
</div>
<div>
<br><br>
<table id ='customers'>
<tr>
  <th>Chocolate's Name</th>
  <th>Quantity</th>
  <th>Price</th>
  <th>Total</th>
  <th>Action</th>
</tr>
<?php
if(!empty($_SESSION['cart']))
{
  $total=0;
  foreach ($_SESSION['cart'] as $keys => $values)
  {
    echo "<tr>";
?>
    <td><?php echo $values['item_name']; ?></td>
    <td><?php echo $values['item_q']; ?></td>
    <td><?php echo $values['item_price']; ?></td>
    <td><?php echo number_format($values['item_q']*$values['item_price'],2); ?></td>
    <td><a href='products.php?action=delete&id=<?php echo $values['item_id']; ?>'>Remove</a></td>
    </tr>
<?php
    $total=$total+($values['item_q']*$values['item_price']);
  }
  echo "<tr>";
  echo "<td colspan='3' align='right'>Total</td>";
?>
  <td><?php echo number_format($total,2); ?></td>
  <td></td>
<?php
}
?>
</table>
<div>
<form action='products.php' method='post'>
<div>
  <input type="submit" class="button" value="Place your order" name="corder">
</div>
</form>
<?php

if(isset($_POST['corder']))
{
  include("../connection.php");
  $num=rand(10,1000);
  $order_id="O - ".$num;
  $order_date=date("Y/m/d");
  $username=$_SESSION['user_name'];
  $sqlorder="insert into customer_order values('$order_id','$username','$order_date',0)";
  mysqli_query($con,$sqlorder);
  foreach($_SESSION['cart'] as $keys => $values)
  {
    $total=0;
    $product_id=$values['item_id'];
    $quantity=$values['item_q'];
    $total=$values['item_q']*$values['item_price'];
    $sql="insert into orderline values('$order_id', '$product_id', '$quantity', '$total')";
    mysqli_query($con,$sql);
  }
  echo "Your order has been successfully submitted.";
  unset($_SESSION['cart']);
}
?>
</div>
</div>
</body>
</html>