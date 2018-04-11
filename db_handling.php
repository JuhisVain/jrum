<?php

function connectToDB(){
    //Change these to whatever they need to be for your mysql to work:
	 $servername = "localhost";
	 $username = "root";
	 $password = "1234";
	 $dbname = "jrumDB";

	 //create connection
	 $conn = new mysqli($servername, $username, $password, $dbname);

	 // check connection
	 if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	 } else {
	   return $conn;
	 }
}

?>
