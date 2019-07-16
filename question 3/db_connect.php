<?php
// This file contains the database access information.

// Set the database access information as constants:
define('DB_USER', 'tdfqeetpcc');
define('DB_PASSWORD', '9CnkZ4cy8Y');
define('DB_HOST', 'localhost');
define('DB_NAME', 'tdfqeetpcc');

// Make the connection:
$mysqli = new MySQLi(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Verify the connection:
if ($mysqli->connect_error) {
	echo $mysqli->connect_error;
	unset($mysqli);
} else { // Establish the encoding.
	$mysqli->set_charset('utf8');
}