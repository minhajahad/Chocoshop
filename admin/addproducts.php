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
<title>Add Products</title>
<link rel="stylesheet" href="style.css">
<style>
input[type=text], input[type=password] {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block; 
  color:#FFFFFF;
}

.container {
  border-radius: 5px;
  padding: 20px;
}

.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

@media screen and (max-width: 600px) {
  .col-25, .col-75 {
    width: 100%;
    margin-top: 0;
  }
}

.button {
  background-color: white;
  border: solid gray;
  color: black;
  padding: 15px 32px;
  float: right;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  font-weight:bold;
  margin: 4px 2px;
  cursor: pointer;
}
</style>
</head>
<body>
<ul>
  <li><a href="home.php">Home</a></li>
  <li><a class="active" href="addproducts.php">Add Products</a></li>
  <li><a href="store.php">Store</a></li>
  <li><a href="corders.php">Customer Orders</a></li>
  <li><a href="history.php">History</a></li>
  <li><a href="chngpass.php">Change password</a></li>
  <li><a href="?sign=out">Logout</a></li>
</ul><br>


<div class="container">
  <form action="addproducts.php" method="post" enctype="multipart/form-data">
  <div class="row">
    <div class="col-25">
      <label for="product_id"><b>Product Id:</b></label>
    </div>
    <div class="col-75">
      <input type="text" id="product_id" name="product_id" placeholder="Insert id...">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="name"><b>Chocolate's Name:</b></label>
    </div>
    <div class="col-75">
      <input type="text" id="name" name="name" placeholder="" required>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="ctype"><b>Chocolate Type</b></label>
    </div>
    <div class="col-75">
      <select style="height:43px;width:990px;" id="ctype" name="ctype">
    <option value="Others">Others</option>
    <option value="Caramel">Caramel</option>
    <option value="Dry Fruits">Dry fruits</option>
    <option value="Bar">Bar</option>
    <option value="White Chocolate">White Chocolate</option>
    <option value="Dark Chocolate">Dark Chocolate</option>
    <option value="Milk Chocolate">Milk Chocolate</option>
    <option value="Bittersweet Chocolate">Bittersweet Chocolate</option>
  </select>
    </div>
  </div>
 
  <div class="row">
    <div class="col-25">
    <label for="bprice" ><b>Buying Price: </b></label>
  </div>
  <div class="col-75">
      <input type="text" id="bprice" placeholder="Insert buying price..." name="bprice" required>
    </div>
  </div>
  
  <div class="row">
    <div class="col-25">
      <label for="picture"><b>Chocolate's picture: </b></label>
    </div>
    <div class="col-75">
      <input type="file" name="pic" id="image">
    </div>
  </div>
  <div class="row">
    <br>
  <input type="submit" class="button" value="ADD" name="submit">
  </div>
  </form>
</div>

</body>
</html>



<?php

include("../connection.php");
if(isset($_POST['submit']))
{
  // to receive value from the input fields
  $product_id=$_POST['product_id'];
  $name=$_POST['name'];
  $ctype=$_POST['ctype'];
  $bprice=$_POST['bprice'];
  
  //image upload code
  $ext= explode(".",$_FILES['pic']['name']);
  $c=count($ext);
  $ext=$ext[$c-1];
  //echo $ext;
  $date=date("D:M:Y");
  //echo $date;
  $image_name=md5($date.$product_id);
  $image=$image_name.".".$ext;
  //echo $image
  
  $query="insert into product values('$product_id','$name','$ctype','$bprice','$image')";
  if(mysqli_query($con,$query))
  {
    echo "<b> <font color='#ffffff'>Successfully Inserted!</b></font>";
    if($image !=null){
      move_uploaded_file($_FILES['pic']['tmp_name'],"../uploadedimage/$image");
    }
  }
  else
  {
    echo "error!".mysqli_error($con);
  }
}
?>

