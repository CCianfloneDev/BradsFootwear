<?php
/*
    Cole Cianflone
    Nov 9th, 2022
    Purpose: Script to logout a user.
*/

require("connect.php");
session_start();
session_destroy();

// Redirect after logout.
if ($_GET['redirect'] == "view_sneaker")
{
    header("Location: view_sneaker.php?id=".$_GET['id']);
} else 
{
    header("Location: index.php");
}
exit;
?>
