<?php

// Database configuration
$DB_HOST = 'localhost'; // Database host
$DB_USER = 'root'; // Database username
$DB_PASS = ''; // Database password
$DB_NAME = 'photo_gallery'; // Database name

try {
    // Create a new PDO instance to connect to the database
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);

    // Set the PDO error mode to exception for better error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $th) {
    // Handle connection errors and display an error message
    die("Connection failed : ". $th->getMessage());
}