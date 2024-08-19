<?php

$serverName = 'localhost:3306';
$userName = 'root';
$password = '';
$dbName = 'p_001';

$dbConnect = mysqli_connect($serverName, $userName, $password, $dbName) or die("Unable to connect!");
?>