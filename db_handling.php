<?php

function connectToDB(){
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