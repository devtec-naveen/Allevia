<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "covid";


//live server database detail

$servername = 'vpc-rds-mysql-5-6.c1xncwazlxba.us-east-2.rds.amazonaws.com';
$username = "jchen";
$password = "TsgyRR5jTEUZKUtznK6G";
$dbname = "allevia";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
?>