<?php
session_start();
?>
<!DOCTYPE html> 
<html>
<head>
<title> Login </title>
<link rel="stylesheet" href="LogIn.css">
  </head>
  <body> 
  <br><br><br>
  <center> <h1> Login </h1> </center> 
  <br>
  <form action="Login.php" method="post" > 
  <center>
  <div class="container">
  <br>
  <label> Username : </label>
    <input type="text" placeholder="Enter Username" name="username" required>
            </div> 
			<div class="container">
			<label>Password : </label> 
            <input type="password" placeholder="Enter Password" name="password" required>
            </div>
			<div class="container">
			<button type="submit" name="login">Login</button>
			</div> 
			<div class="container">
            <input type="checkbox" checked="checked"> Remember me 
             </div>
             <div class="container">			 
            Forgot <a href="#"> password? </a> 
        </div> 
		<div class="container">
		<p>New User? Please<a href="Sign-up.php">Sign-up</a></p>
		<p>Return to <a href="Index.php">home</a> page.</p>
		</div> 
		</center>
    </form> 
</body>
</html> 
<?php
include("connection.php");
if(isset($_POST['login']))
{
$username=$_POST['username'];
$password=$_POST['password'];

$sql="select username,password from admin where username='$username' and password='$password'";
$sql1="select username,password from customer where username='$username' and password='$password'";
$r=mysqli_query($con,$sql);
$r1=mysqli_query($con,$sql1);
if(mysqli_num_rows($r)>0)
{
$_SESSION['user_name']=$username;
$_SESSION['admin_login_status']="logged in";
header("Location:admin/home.php");
}

else if (mysqli_num_rows($r1)>0)
{
$_SESSION['user_name']=$username;
$_SESSION['customer_login_status']="logged in";
header("Location:customer/home.php");
}
else
{
echo "<p>Incorrect Username or Password</p>";
}
}
?>

