<?php
/*
    Cole Cianflone
    Nov 7th, 2022
    Purpose: Script to authenticate users to site.
*/

$query = "SELECT * FROM user WHERE admin_access = 1";
$statement = $db->prepare($query); // Returns a PDOStatement object.
$statement->execute(); // The query is now executed.
$users = $statement->fetchAll();

define("ADMIN_LOGIN", $users[0]['user_name']);
define("ADMIN_PASSWORD", $users[0]['user_pass']);

if (
    !isset($_SERVER["PHP_AUTH_USER"]) ||
    !isset($_SERVER["PHP_AUTH_PW"]) ||
    $_SERVER["PHP_AUTH_USER"] != ADMIN_LOGIN ||
    $_SERVER["PHP_AUTH_PW"] != ADMIN_PASSWORD
) {
    header("HTTP/1.1 401 Unauthorized");
    header('WWW-Authenticate: Basic realm="Our Blog"');
    exit("Access Denied: Username and password required.");
}

?>
