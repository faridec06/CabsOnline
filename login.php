<!--
* Author: Sheik Farid Abdul Basheer
* Purpose: This file is for the existing CabsOnline customers to login 
* Created: 08 April 2015
* Last updated: 13 April 2015
*  
-->
<HTML XMLns="http://www.w3.org/1999/xHTML"> 
  <head> 
  <title>Login</title> 
  </head> 
  <body>
  <H1>Login to CabsOnline</H1>
  

  <form id="login" method="post">
  <table>
    <tr>
      <td>Email:</td>
      <td align="left"><input type="email" name="email" required = "required" /></td>
    </tr>
    <tr>
      <td>Password:</td>
      <td align="left"><input type="password" name="pwd" required = "required"/></td>
    </tr>
	<tr>
      <td><input type="submit" value="Log in" /></td>
    </tr>	
  </table>
  </form>
  <p><h3>New Member? <a href="register.php">Register Now</a></h3>
  </body> 

<?php 

	if(isset($_POST['email'])&&isset($_POST['pwd'])) {
	
	$email =  $_POST['email'];
	$password =  $_POST['pwd'];
	
	$host = "mysql.ict.swin.edu.au";
	$user = "s4969030"; // user name
	$pwd = "060190"; // password 
	 
	$sql_db = "s4969030_db"; //  database 
	 
	$dbConnect = @mysqli_connect($host,$user,$pwd,$sql_db)
	Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ".
	mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";
	
	// checks whether the email Id matches the password from the CUSTOMER table
	$queryLogin = "SELECT * FROM CUSTOMER WHERE email = '$email' and password = '$password'";
	$resultLogin = @mysqli_query($dbConnect, $queryLogin);
	$numRows = @mysqli_num_rows($resultLogin);
		if (!( $numRows >= 1)) {
		echo "Login Failed. Please enter again.";
		} else {
		header("Location: booking.php? email=".$email);  // redirects to booking page and carries forward the email value
		}

	mysqli_close($dbConnect); // database closed
	}
?>
</html>