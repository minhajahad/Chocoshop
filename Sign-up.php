<!DOCTYPE html>
<html>
<head> 
<title>
Sign-up
</title> 
<link rel="stylesheet" href="SignUp.css">
</head>  
<body>
<center>
<h1> CREATE ACCOUNT</h1>
<br>  
<div class="bordered">
  <div class="container"> 
    <form  action="Sign-up.php" method="post" enctype="multipart/form-data"> 
       <br> 
        
<label for="fname" style="min-height:30px;margin-right:80px;">   Name: </label>
        <input type="text" id="name" name="name" required>
<br>  
<label for="dateofbirth" style="margin-right:52px;">Date Of Birth: </label>
              <input type="date" id="dob" name="dateofbirth">
   <br>
<label for="phone" style="margin-right:10px;">Phone number: </label>
        <input type="text" id="phone" name="phonenumber" placeholder="">
<br>
<label for="Address" style="margin-right:85px;">Address: </label>
    <textarea id="address" name="address"  cols="30" rows="2" value="address" ></textarea>
     <br> 
<label style="margin-right:65px;">Username: </label> 
            <input type="text" placeholder="" name="username" required>
			<br>
			
<label style="margin-right:65px;">Password: </label> 
            <input type="password" placeholder="At least 8 characters" name="password" required> 
<br>
<label for="picture" style="margin-right:40px;"><b>Upload photo: </b></label>
      <input type="file" name="fileupl_photo" id="fileupl_photo">
<div > 

			 <br>By creating an account you agree to our <a href="#">Terms & Privacy.</a>
    <button type="submit" class="registerbtn" name="ok">Sign-up</button>
</div>
<p style="font-size: 100%">Already have an account? Please <a href="Login.php">Login.</a></p> 
<p>Return to <a href="Index.php">home</a> page.</p>
 </div> 
 </div> 
</center> 
</form>
</body>
</html> 
<?php
include("connection.php");
if(isset($_POST['ok']))                              
{
	$name=$_POST['name']; 
	$dob=$_POST['dateofbirth'];
	$phone_number=$_POST['phonenumber'];
	$address=$_POST['address'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	  
	 //image upload code
	$ext= explode(".",$_FILES['fileupl_photo']['name']);
	$c=count($ext);
	$ext=$ext[$c-1];
	//echo $ext;
	$date=date("D:M:Y");
	//echo $date;
	$image_name=md5($date);
	$image=$image_name.".".$ext;
	//echo $image 
	
	$query="insert into customer values('$name','$dob',$phone_number,'$address','$username','$password','$image')";
	
	if(mysqli_query($con,$query))
	{
		echo "Successfully inserted!";
		if($image !=null){
			move_uploaded_file($_FILES['fileupl_photo']['tmp_name'],"uploadedimage/$image");
    }
    
    }
	else
	{
		echo "error!".mysqli_error($con);
	}
}
?>