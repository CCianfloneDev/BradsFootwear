<?php
/*
    Cole Cianflone
    Nov 9th, 2022
    Purpose: Script to register a user.
*/
require("connect.php");

if (count($_POST) > 0) {
   $user_name = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $user_pass = filter_input(INPUT_POST, 'user_pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $user_pass_confirm = filter_input(INPUT_POST, 'user_pass_confirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

   if ($user_pass === $user_pass_confirm) {
      $query = "INSERT INTO user (user_name, user_pass) VALUES (:user_name, :user_pass)";
      $statement = $db->prepare($query);
   
      // bind values to insert statement
      $statement->bindValue(':user_name', $user_name);
      $statement->bindValue(':user_pass', $user_pass);
   
      // send value to DB.
      if ($statement->execute()) {
         // Redirect after login.
         if ($_GET['redirect'] == "view_sneaker")
         {
            header("Location: view_sneaker.php?id=".$_GET['id']);
         } else 
         {
            header("Location: index.php");
         }
         exit;
      } else {
         echo '<script>alert("Account registration failed.")</script>';
      }
   } else {
      echo '<script>alert("Passwords MUST match.")</script>';
   }
}
?>
<!DOCTYPE html>
<html>
   <head>
   <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Register</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   </head>
   <body>
    <h1>NOTE: This account gives you the ability to comment on sneaker posts.</h1>
    <h1><a href="index.php">Home</a></h1>
    <?php if(isset($_GET['redirect']) && $_GET['redirect'] == 'view_sneaker'):?>
      <h2><a href="view_sneaker.php?id=<?=$_GET['id']?>">&#8592; Return</a></h2>
   <?php endif ?>
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
                        <input name="user_pass" id="user_pass" type="password" placeholder="Enter a password..." value="" required/>
                     </p>
                     <p>
                        <label for="user_pass_confirm">Confirm Password:</label>
                        <input name="user_pass_confirm" id="user_pass_confirm" type="password" placeholder="Confirm the password..." value="" required/>
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
