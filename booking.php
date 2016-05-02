<!--
* Author: Sheik Farid Abdul Basheer
* Purpose: This file is to make the customers book cabs 
* Created: 08 April 2015
* Last updated: 13 April 2015
*  
-->
<HTML XMLns="http://www.w3.org/1999/xHTML"> 
  <head> 
    <title>Booking</title> 
  </head> 
  <body>
  <H1>Booking a cab</H1>
  <p>Please fill the fields below to book a taxi</p>

  <form id="booking" action = "booking.php"  method="get">
  <table>
    <tr>
      <td>Passenger Name:</td>
      <td align="left"><input type="text" name="passname" required = "required" /></td>
    </tr>
    <tr>
      <td>Contact phone of the passenger:</td>
      <td align="left"><input type="text" name="contactphone" required = "required"/></td>
    </tr>
    <tr>
      <td>Pick up address:</td>
	  </tr>
	  <tr>
	  <td align="right">Unit Number</td>
      <td align="left"><input type="text" name="unitno" /></td>
	  </tr>
	  <tr>
	  <td align="right">Street Number</td>
      <td align="left"><input type="text" name="streetno" required = "required" /></td>
	  </tr>
	  <tr>
	  <td align="right">Street Name</td>
      <td align="left"><input type="text" name="streetname" required = "required" /></td>
	  </tr>
	  <tr>
	  <td align="right">Suburb</td>
      <td align="left"><input type="text" name="suburb" required = "required" /></td>
    </tr>
	<tr>
      <td>Destination Suburb:</td>
      <td align="left"><input type="text" name="dsuburb" required = "required" /></td>
    </tr>
	<tr>
      <td>Pickup date:</td>
      <td align="left"><input type="date" name="pudate" required = "required" /></td>
    </tr>
	<tr>
      <td>Pickup time:</td>
      <td align="left"><input type="time" name="putime" required = "required" /></td>
    </tr>
    <tr>
	<td><input type = "hidden" name = "email" value = "<?php echo $_GET['email']; ?>" /> 
	<tr> 
      <td><input type="submit" value="Book" /></td>
    </tr>
	
  </table>
  </body> 

<?php 

	$host = "mysql.ict.swin.edu.au";
	$user = "s4969030"; // user name
	$pwd = "060190"; // password 
	 
	$sql_db = "s4969030_db"; // database 
	 
	$dbConnect = @mysqli_connect($host,$user,$pwd,$sql_db)
	Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ".
	mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";
	
	// Checks whether the BOOKING table exists
	$tableExist = "SELECT * FROM BOOKING";
	$queryExist = @mysqli_query($dbConnect, $tableExist);
	$numRows = @mysqli_num_rows($queryExist);
	if ($numRows == 0) {
	// BOOKING table create statement
	$sqlString = "CREATE TABLE BOOKING (
	bookingId INT(10) NOT NULL AUTO_INCREMENT,
	email VARCHAR(50) NOT NULL, passname VARCHAR(50) NOT NULL, contactphone INT(20) NOT NULL, unitno INT(20), streetno INT(20) NOT NULL, streetname VARCHAR(50) NOT NULL, suburb VARCHAR(50) NOT NULL, dsuburb VARCHAR(50) NOT NULL, pudate DATE, putime TIME, bookingdatetime VARCHAR(50) NOT NULL, bookingstatus VARCHAR(50) NOT NULL, PRIMARY KEY (bookingId), FOREIGN KEY (email) REFERENCES CUSTOMER(email))";
	$queryResult = @mysqli_query($dbConnect, $sqlString);
	echo "<p>Successfully created the table.</p>";
	}

	// checks whether the input fields are set
	if(isset($_GET['passname'])&&isset($_GET['contactphone'])&&isset($_GET['unitno'])&&isset($_GET['streetno'])&&isset($_GET['streetname'])&&isset($_GET['suburb'])&&isset($_GET['dsuburb'])&&isset($_GET['pudate'])&&isset($_GET['putime'])) {
	$passname =  $_GET['passname'];
	$contactphone =  $_GET['contactphone'];
	$unitno = $_GET['unitno'];
	$streetno =  $_GET['streetno'];
	$streetname=  $_GET['streetname'];
	$suburb=  $_GET['suburb'];
	$dsuburb=  $_GET['dsuburb'];
	$pudate=  $_GET['pudate'];
	$putime=  $_GET['putime'];
	$email = $_GET['email'];

	$today = date("D M j G:i:s T Y"); // sets today's date to the variable
	$curDate = date("Y-m-d"); // sets current date
	$curTime = date("H:i"); // sets current time
	$checkTime = date("H:i", strtotime('+1 hour')); // adds current time plus one
	
		// checks whether the pick up time is after one hour from the current time"
		if(($pudate < $curDate) || (($pudate = $curDate) && ($putime <= $checkTime))) {
		echo "Invalid pick up date/time. Please enter pick up date/time correctly";
		echo "Please enter booking time alteast one hour after the current time";
		} else {
		// SQL insert statement for the BOOKING table
		$sqlString = "INSERT INTO BOOKING (email,passname,contactphone,unitno,streetno,streetname,suburb,dsuburb,pudate,putime,bookingdatetime,bookingstatus) VALUES ('$email','$passname','$contactphone','$unitno','$streetno','$streetname','$suburb','$dsuburb','$pudate','$putime','$today','unassigned')";
		$queryResult = @mysqli_query($dbConnect, $sqlString)
		or die("<p>Unable to execute the query.</p>"
		. "<p>Error code " . mysqli_errno($dbConnect)
		. ": " . mysqli_error($dbConnect)) . "</p>";
		$lastBookingId = @mysqli_insert_id($dbConnect);  // gets the last inserted row's bookingId
		// SQL statement to get the customer name from the CUSTOMER table
		$sqlCustomer = "SELECT c.name FROM CUSTOMER c INNER JOIN BOOKING b ON b.email = c.email WHERE c.email = '$email'" ;
		$queryResultCustomer = @mysqli_query($dbConnect, $sqlCustomer)
		or die("<p>Unable to execute the query.</p>"
		. "<p>Error code " . mysqli_errno($dbConnect)
		. ": " . mysqli_error($dbConnect)) . "</p>";
		$row = @mysqli_fetch_row($queryResultCustomer);
		$customerName = $row[0]; 
		// SQL statements to select the row last inserted
		$sqlBookingId = "SELECT * FROM BOOKING WHERE bookingId = '$lastBookingId'";
		$queryResultBookingId = @mysqli_query($dbConnect, $sqlBookingId)
		or die("<p>Unable to execute the query.</p>"
		. "<p>Error code " . mysqli_errno($dbConnect)
		. ": " . mysqli_error($dbConnect)) . "</p>";
		$row = @mysqli_fetch_row($queryResultBookingId); // fetches the last row inserted
		$refNo = $row[0];  
		$pickUpTime = $row[10];
		$pickUpDate = $row[9];
		// confirmation about the booking
		echo "<p>Thank you $customerName. Your Booking Reference Number is {$row[0]}. We will pick up the
		passengers in front of your provided address at {$row[10]} on {$row[9]}.” A
		confirmation email including the following information is also sent to your mail.</p>"; 
		// php mail to function
		$to = $email;
		$subject = "Your booking request with CabsOnline!";
		$text = "Dear $customerName, Thanks for booking with CabsOnline!. Your Booking Reference Number is $refNo . We will pick up the passengers in front of your provided address at $pickUpTime on $pickUpDate.";
		$headers = "From: booking@cabsonline.com.au";

		mail($to, $subject, $text, $headers, "-r 4969030@student.swin.edu.au");

	}

	@mysqli_close($dbConnect); // database closed
	}
	?>
</html>