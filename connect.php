<?php
/*
    Cole Cianflone
    Nov 7th, 2022
    Purpose: Script to connect to db.
*/
define("DB_DSN", "mysql:host=localhost;dbname=webdevproject;charset=utf8");
define("DB_USER", "serveruser");
define("DB_PASS", "gorgonzola7!");

try {
    // Try creating new PDO connection to MySQL.
    $db = new PDO(DB_DSN, DB_USER, DB_PASS);
} catch (PDOException $e) {
    print "Error: " . $e->getMessage();
    die(); // Force execution to stop on errors.
}
?>
