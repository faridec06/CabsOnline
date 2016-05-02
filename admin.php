<!--
* Author: Sheik Farid Abdul Basheer
* Purpose: This file is for the administrators of CabsOnline to find a booking and assign taxi
* Created: 08 April 2015
* Last updated: 13 April 2015
*  
-->
<HTML XMLns="http://www.w3.org/1999/xHTML"> 
	  <head> 
	  <title>Admin</title> 
	  </head> 
	  <body>
	  <H1>Admin page of CabsOnline</H1>
	  <p>1.Click below button to search for all unassigned booking request with a pick up time within 2 hours.</p>
	  <form action ="" method ="post">
	  <input type="submit" name ="submit1" value="List all" />
	  </form>
	  </body>
	  
	  <?php 
	  
	  // checks whether the submit button is clicked
	  if(isset($_POST['submit1'])) {
	    $host = "mysql.ict.swin.edu.au";
	    $user = "s4969030"; // user name
		$pwd = "060190"; // password 
		 
		$sql_db = "s4969030_db"; //  database 
		 
		$dbConnect = @mysqli_connect($host,$user,$pwd,$sql_db)
		Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ".
		mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";
		
		$curTime = date("H:i");
		$curDate = date("Y-m-d");
		$checkTime = date("H:i", strtotime('+2 hour')); // current time plus two
		// SQL statement to list the rows with pick up time within 2 hours
		$sqlList = "SELECT b.bookingId, c.name, b.passname, b.contactphone, b.unitno, b.streetno, b.streetname, b.suburb, b.dsuburb, b.pudate, b.putime FROM BOOKING b INNER JOIN CUSTOMER c ON b.email = c.email WHERE ((b.putime <= '$checkTime') && (pudate = '$curDate'))" ; 
		$queryList = @mysqli_query($dbConnect, $sqlList)
		or die("<p>Unable to execute the query.</p>"
		. "<p>Error code " . mysqli_errno($dbConnect)
		. ": " . mysqli_error($dbConnect)) . "</p>";
		echo "<table border=\"1\">";  // table to display the values
		 echo "<tr>" 
		 ."<th scope=\"col\">reference #</th>" 
		 ."<th scope=\"col\">customer name</th>" 
		 ."<th scope=\"col\">passenger name</th>" 
		 ."<th scope=\"col\">passenger contact phone</th>" 
		 ."<th scope=\"col\">pick-up address</th>" 
		 ."<th scope=\"col\">destination suburb </th>" 
		 ."<th scope=\"col\">pick-time </th>" 
		 ."</tr>";
		 
		$row = @mysqli_fetch_row($queryList);
		
		while($row) {
		 echo "<tr>"; 
		 echo "<td>",$row[0],"</td>"; 
		 echo "<td>",$row[1],"</td>"; 
		 echo "<td>",$row[2],"</td>"; 
		 echo "<td>",$row[3],"</td>";
		 echo "<td>",$row[4]."/".$row[5].",".$row[6]." ".$row[7],"</td>"; // concatenation
		 echo "<td>",$row[8],"</td>";
		 echo "<td>",$row[9],"</td>";
		 echo "</tr>"; 
		 $row = @mysqli_fetch_row($queryList);
		 }

		 echo "</table>";
		 
		 mysqli_close($dbConnect); // database closed
		}
		?>

		  <p>2.Input a reference number below and click "update" button to assign a taxi to that request.</p>
		  <form action ="" method ="post">Reference Number:<input type="text" name="refNo" required = "required" /></label>
		  <input type="submit" name ="submit2" value="Update" />
		  </form>
		  
		<?php 
		
		// checks whether the submit button is clicked
		if(isset($_POST['submit2'])) {
		$host = "mysql.ict.swin.edu.au";
		$user = "s4969030"; // user name
		$pwd = "060190"; // password 
		 
		$sql_db = "s4969030_db"; // database 
		 
		$dbConnect = @mysqli_connect($host,$user,$pwd,$sql_db)
		Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ".
		mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";
		
		$bookingRef = $_POST['refNo'];
		// SQL statement to list all the values from BOOKING
		$queryCheck = "SELECT * FROM BOOKING WHERE bookingId = '$bookingRef'";
		$resultCheck = @mysqli_query($dbConnect, $queryCheck);
		$numRows = @mysqli_num_rows($resultCheck);
			if ( $numRows >= 1) {
			// update statement to update the status
			$sqlList1 = "UPDATE BOOKING SET bookingstatus = 'assigned' WHERE bookingId = '$bookingRef'" ; 
			$queryList1 = @mysqli_query($dbConnect, $sqlList1)
			or die("<p>Unable to execute the query.</p>"
			. "<p>Error code " . mysqli_errno($dbConnect)
			. ": " . mysqli_error($dbConnect)) . "</p>";
			echo "The booking request $bookingRef has been properly assigned";
			} else {
			echo "Booking Reference Number does not exist";
			}
		mysqli_close($dbConnect); // database closed
		}
		?>


</html>