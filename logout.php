<?php
/*
    Cole Cianflone
    Nov 9th, 2022
    Purpose: Script to logout a user.
*/

require("connect.php");
session_start();
session_destroy();

//Redirect after logout.
header("Location: index.php");
exit;
?>