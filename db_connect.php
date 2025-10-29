<?php
// Database connection settings
$servername = "localhost";   // XAMPP runs MySQL on localhost
$username = "root";          // Default username for XAMPP
$password = "";              // Leave empty (unless you set one)
$dbname = "librarydb";       // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
} 
?>
