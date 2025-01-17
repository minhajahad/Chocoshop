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
	<title>Store</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="store.css">
</head>
<body>

<ul>
  <li><a href="home.php">Home</a></li>
  <li><a href="addproducts.php">Add Products</a></li>
  <li><a class="active" href="store.php">Store</a></li>
  <li><a href="corders.php">Customer Orders</a></li>
  <li><a href="history.php">History</a></li>
  <li><a href="chngpass.php">Change password</a></li>
  <li><a href="?sign=out">Logout</a></li>
</ul><br>
<div class= "row">
	<div class= "container">
	
	<div class= "row">
	
		<form action="store.php" method="post">
		<input type="submit" class="button" style="border:solid gray;font-weight:bold;" value= "Show Product" name="show">
		</form><br><br><br>
		
		<?php
		include("../connection.php");
		if(isset($_POST['show']))
		{
			$sql="select * from product, store where product.product_id=store.product_id";
			$r=mysqli_query($con,$sql);
			echo "<table id= 'customers'>";
			echo "<tr>
			<th>Product Id</th>
			<th>Chocolate's Name</th>
			<th>Chocolate Type</th>
			<th>Buying Price</th>
			<th>Quantity</th>
			<th>Selling Price</th>
			</tr>";
				while($row=mysqli_fetch_array($r))
				{
					$id=$row['product_id'];
					$name=$row['name'];
					$type=$row['ctype'];
					$price=$row['bprice'];
					$sprice=$row['sellingprice'];
					$quantity=$row['quantity'];
					echo "<tr>
					<td>$id</td><td>$name</td><td>$type</td><td>$price</td><td>$quantity</td><td>$sprice</td>
					</tr>";
				}
				echo "</table>";
		}
		?>
		
	</div>
	
	<form action="store.php" method="post">
	
	<div class= "row">
	<hr/>
	<br><br>
	<div class="col-25">
	  <label for="product_id" style="color:white;"><b>Product Id: </b></label>
	</div>
	
	<div class="col-75">
      <select style="height:43px;width:990px;" name="product_id">
	  
	  <?php
		include("../connection.php");
		$sql="select product_id from product";
		$r=mysqli_query($con,$sql);
		
			while($row=mysqli_fetch_array($r))
			{
				$id=$row['product_id'];
				echo "<option value= '$id'>$id</option>";
			}
	  ?>
	  
	  </select>
    </div>
	
	</div>
	<div class="row">
		<div class="col-25">
			<label for="quantity" style="color:white;"><b>Quantity:</b></label>
		</div>
		<div class="col-75">
			<input type="text" id="quantity" name="quantity" value='0' placeholder="quantity...">
		</div>
	</div>
	<div class="row">
		<div class="col-25">
			<label for="sprice" style="color:white;"><b>Selling Price:</b></label>
		</div>
		<div class="col-75">
			<input type="text" id="sprice" name="sprice" value='0' placeholder="Insert selling price...">
		</div>
	</div>
	<div class="row">
		<input type="submit" class="button" style="border:solid gray;font-weight:bold;" value="Add" name="submit">
		<div class="row">
			<input type="submit" class="button" style="border:solid gray;font-weight:bold;" value="Update" name="update">
		</div>
	</div>
	</form>
	
	</div>
	
</div>
</body>
</html>

<?php
include("../connection.php");
if(isset($_POST['submit']))
{
  $product_id=$_POST['product_id'];
  $quantity=$_POST['quantity'];
  $sprice=$_POST['sprice'];
  
  $query="insert into store values('$product_id','$sprice','$quantity')";
  if(mysqli_query($con,$query))
  {
    echo "<b> <font color='#ffffff'>Successfully Inserted!</b></font>";
  }
  else
  {
    echo "error!".mysqli_error($con);
  }
}
if(isset($_POST['update']))
{
  $product_id=$_POST['product_id'];
  $quantity=$_POST['quantity'];
  $sprice=$_POST['sprice'];
  
  if($sprice==0)
  {
    $query="update store set quantity=quantity+$quantity where product_id='$product_id'";
  }
  else
  {
    $query="update store set quantity=quantity+$quantity, sellingprice=$sprice where product_id='$product_id'";
  }
  
  if(mysqli_query($con,$query))
  {
    echo "<b> <font color='#ffffff'>Successfully Inserted!</b></font>";
  }
  else
  {
    echo "error!".mysqli_error($con);
  }
}
?>