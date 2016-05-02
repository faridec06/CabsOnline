# CabsOnline
A full stack application for booking cabs developed using PHP and SQL database


Readme


Files: 

1.	register.php
2.	login.php 
3.	booking.php
4.	admin.php


How to use the system:

Register Page:

	The register page takes the inputs from the customer like the Customer name, Password, Confirm Password, Email and Phone Number. Both the password fields should be the same. The submit button posts the values entered into the CUSTOMER table in the database and redirects to the booking page.

Login Page:

	The login page gets the customer email id and password and allows access to the booking page. 




Booking Page:

	This page allows the user to enter the booking details like the passenger name, contact number, source address, destination, pick up date and time. The pick up time should be atleast one hour after the current time.The submit button posts the values into the BOOKING table and the booking confirmation is displayed and mailed to the respective mail id.

Admin Page:

	This page allows the administrator to view the bookings and assign cabs by the reference number. 

