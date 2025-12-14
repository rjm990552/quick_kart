<?php
// quick_kart/common/config.php

// Define DB Connection details
define('DB_HOST', '127.0.0.1');
//define('DB_USER', 'u341849674_rjm990552');
//define('DB_PASS', 'Rjm99@552');
//define('DB_NAME', 'u341849674_quickkart_db');

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'u341849674_rjm990551');
define('DB_PASS', 'Rjm99@552');
define('DB_NAME', 'u341849674_14Dec');

// Connect to MySQL
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    // If the DB doesn't exist, redirect to install script
    if (strpos($conn->connect_error, 'Unknown database') !== false) {
        if (basename($_SERVER['PHP_SELF']) !== 'install.php') {
            header('Location: install.php');
            exit();
        }
    }
    // Else, show normal error
    die("Connection failed: " . $conn->connect_error);
}
?>