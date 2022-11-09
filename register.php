<?php
/*
    Cole Cianflone
    Nov 9th, 2022
    Purpose: Script to register a user.
*/

require("connect.php");

if (count($_POST) > 0) {

    $user_name = $_POST['user_name'];
    $user_pass = $_POST['user_pass'];
    $query = "INSERT INTO user (user_name, user_pass) VALUES (:user_name, :user_pass)";
    $statement = $db->prepare($query);

    // bind values to insert statement
    $statement->bindValue(':user_name', $user_name);
    $statement->bindValue(':user_pass', $user_pass);

    // send value to DB.
    if ($statement->execute()) {
        // Redirect after update.
        header("Location: index.php");
        
        exit;
    } else {
        echo "<p>Sneaker creation failed.</p>";
    }
}

?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>brand - create </title>
      <link rel="stylesheet" href="style.css" type="text/css">
   </head>
   <body>
    <h1>NOTE: This account gives you the ability to comment on sneaker posts.</h1>
         <div id="login_form">
            <form action="" method="post">
               <fieldset>
                  <div class="signin">
                     <p>
                        <label for="user_name">User Name:</label>
                        <input name="user_name" id="user_name" placeholder="Enter a username..." value="" required/>
                     </p>
                     <p>
                        <label for="user_pass">Password:</label>
                        <input name="user_pass" id="user_pass" placeholder="Enter a password..." value="" required/>
                     </p>
                     <p>
                        <input type="submit" name="command" value="Create account" />
                     </p>
                  </div>
               </fieldset>
            </form>
         </div>
   </body>
   <footer>
    <small>If you wish to have admin access please reach out to the site owner.</small>
   </footer>
</html>