


﻿<?php
echo "<h1>PHP Test Page</h1>";
echo "<p>If you can see this, PHP is working correctly!</p>";
echo "<p>Current date and time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>PHP version: " . phpversion() . "</p>";

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'mydata';
try {
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        echo "<p style='color: red;'>Database connection failed: " . $conn->connect_error . "</p>";
    } else {
        echo "<p style='color: green;'>Database connection successful!</p>";
        $conn->close();
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

