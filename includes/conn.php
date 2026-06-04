<?php
// Database connection credentials
$server = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";
$port = "3307";

// Open MySQL connection using the credentials above
$conn = new mysqli($server, $username, $password, $dbname, $port);
?>