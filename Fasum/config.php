<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "1234"; // Replace with your MySQL password
$dbname = "fasum"; // Replace with your database name

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
