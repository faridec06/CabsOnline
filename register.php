<!--
* Author: Sheik Farid Abdul Basheer
* Purpose: This file is to register CabsOnline customers
* Created: 08 April 2015
* Last updated: 13 April 2015
*  
-->
<HTML XMLns="http://www.w3.org/1999/xHTML"> 
  <head> 
  <title>Registration</title> 
  </head> 
  <body>
  <H1>Register to CabsOnline</H1>
  <p>Please fill the fields below to complete your registration</p>

  
  <form id="register" method="post"> 
  <table>
    <tr>
      <td>Name:</td>
      <td align="left"><input type="text" name="pname" required = "required" /></td>
    </tr>
    <tr>
      <td>Password:</td>
      <td align="left"><input type="password" name="pwd" required = "required"/></td>
    </tr>
    <tr>
      <td>Confirm Password:</td>
      <td align="left"><input type="password" name="cpwd" required = "required" /></td>
    </tr>
	<tr>
      <td>Email:</td>
      <td align="left"><input type="email" name="email" required = "required" /></td>
    </tr>
	<tr>
      <td>Phone:</td>
      <td align="left"><input type="text" name="phone" required = "required" /></td>
    </tr>
	<tr>
      <td><input type="submit" value="Register" /></td>
    </tr>
  </table>
  </form>
 <p><h3>Already registered? <a href="login.php">Login Here</a></h3>
  
<?php 

	 $host = "mysql.ict.swin.edu.au";
	 $user = "s4969030"; //  user name
	 $pwd = "060190"; //  password 
	 
	 $sql_db = "s4969030_db"; // database 
	 
	 $dbConnect = @mysqli_connect($host, $user, $pwd, $sql_db) // database connect
	 Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ". 
	 mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";



	// checks whether the CUSTOMER table exists or not
	$tableExist = "SELECT * FROM CUSTOMER"; 
	$queryExist = @mysqli_query($dbConnect, $tableExist);
	$numRows = @mysqli_num_rows($queryExist);  // returns no of rows 
	if ($numRows == 0) {
	// CUSTOMER create table SQL statement
	$sqlString = "CREATE TABLE CUSTOMER (
	ID INT(10) NOT NULL AUTO_INCREMENT,
	name VARCHAR(25) , password VARCHAR(25),
	email VARCHAR(50), Primary Key (ID,email),
	 phoneNo INT(50))";
	$queryResult = @mysqli_query($dbConnect, $sqlString);
	echo "<p>Successfully created the table.</p>";
	echo "hi";
	}

    // checks whether the input fields are set
	
	if(isset($_POST['pname']) && isset($_POST['pwd']) && isset($_POST['cpwd']) && isset($_POST['email']) && isset($_POST['phone'])) {
	
	$name =  $_POST['pname'];
	$password =  $_POST['pwd'];
	$cpassword = $_POST['cpwd'];
	$email =  $_POST['email'];
	$phone=  $_POST['phone'];

		// checks whether both the entered passwords match
		if(!($password == $cpassword)) {
		echo "Passwords don't match. Please type it again.";
		} else {
		// checks whether email ID is already registered
		$queryEmail = "SELECT * FROM CUSTOMER WHERE email = '$email'";
		$resultEmail = @mysqli_query($dbConnect, $queryEmail);
		$numRows = @mysqli_num_rows($resultEmail);
			if ( $numRows >= 1) {
			echo "Email Id already registered. Please enter a different Email ID";
			} else {
			// entered values are inserted into the CUSTOMER table using the insert statement
			$sqlString = "INSERT INTO CUSTOMER (name,password,email,phoneNo) VALUES ('$name','$password','$email','$phone')";
			$queryResult = @mysqli_query($dbConnect, $sqlString)
			or die("<p>Unable to execute the query.</p>"
			. "<p>Error code " . mysqli_errno($dbConnect)
			. ": " . mysqli_error($dbConnect)) . "</p>";
			echo "<p>Successfully inserted into the table.</p>";
			header("Location: booking.php? email=".$email);  // redirects to booking page and carries forward the email value
			}
		}
	mysqli_close($dbConnect); // database closed
	}
	?>
	</body>
	</html>