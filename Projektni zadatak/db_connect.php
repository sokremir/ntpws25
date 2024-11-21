<?php
// Database connection parameters
$servername = "localhost";
$username = "klovric";
$password = "lozinka";
$dbname = "localdb";

# Connect to MySQL database
$MySQL = mysqli_connect($servername, $username, $password, $dbname) or die('Error connecting to MySQL server.');

?>
