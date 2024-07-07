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
  <title>Change password</title>
<link rel="stylesheet" href="style.css">
<style>
form {border: 3px solid #f1f1f1;}

input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}
label {
  padding: 12px 12px 12px 0;
  display: inline-block; 
  color:#FFFFFF;
}
button {
  background-color: white;
  color: black;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  font-size:25;
  font-weight:bold;
  cursor: pointer;
  width: 15%;
}

button:hover {
  opacity: 0.8;
}

.container {
  padding: 16px;
}
</style>
</head>
<body>
<ul>
  <li><a href="home.php">Home</a></li>
  <li><a href="addproducts.php">Add Products</a></li>
  <li><a href="store.php">Store</a></li>
  <li><a href="corders.php">Customer Orders</a></li>
  <li><a href="history.php">History</a></li>
  <li><a class="active" href="chngpass.php">Change password</a></li>
  <li><a href="?sign=out">Logout</a></li>
</ul><br>
<form action="chngpass.php" method="post">
  <div class="container">
    <label for="opassword"><b>Old Password</b></label>
    <input type="password" placeholder="" name="opassword" required>

    <label for="npassword"><b>New Password</b></label>
    <input type="password" placeholder="" name="npassword" required>
    
    <label for="cpassword"><b>Confirm Password</b></label>
    <input type="password" placeholder="" name="cpassword" required>
	
    <button type="submit" name="submit"><b>Change Password</b></button>
  </div>
</form>
<?php
if(isset($_POST['submit']))
{
  include("../connection.php");
  $username=$_SESSION['user_name'];
  $opassword=$_POST['opassword'];
  $npassword=$_POST['npassword'];
  $cpassword=$_POST['cpassword'];
  if($npassword==$cpassword)
  {
    $sql="select password from admin where password='$opassword' and username='$username'";
    $r=mysqli_query($con,$sql);
    if(mysqli_num_rows($r)>0)
      {
        $sql1="update admin set password='$npassword' where username='$username'";
        if(mysqli_query($con,$sql1))
          {
            echo "<p style='color: black;'>Password has been successfully updated!</p>";
          }
      }
    else
      {
        echo "<p style='color: black;'>The old password is incorrect!</p>";
      }
  }
  else
  {
    echo "<p style='color: black;'>New password doesn't match with Confirm password!</p>";
  }
}
?>
</body>
</html>


