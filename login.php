<?php
/*
    Cole Cianflone
    Nov 9th, 2022
    Purpose: Script to login a user either admin or regular user.
*/

require("connect.php");
require("templates/header.php");

if (count($_POST) > 0) {
    $isSuccess = false;
    $user_name = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $user_pass = filter_input(INPUT_POST, 'user_pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "SELECT * FROM user WHERE user_name = :user_name";
    $statement = $db->prepare($query);
    // bind values to insert statement
    $statement->bindValue(":user_name", $user_name, PDO::PARAM_STR);
    $statement->execute();
    $users = $statement->fetchAll();
    
    foreach($users as $user)
    {
        if ($user_name == $user['user_name'] &&
            $user_pass == $user['user_pass']){
                echo $user_name . " logged in.";
                $isSuccess = true;

                // sets a session with value of the username for current logged in user.
                if(!isset($_SESSION['logged_in_user']))
                {
                  session_start();
                  $_SESSION['logged_in_user'] = $user_name;
                  $_SESSION['logged_in_user_id'] = $user['user_id'];
                  $_SESSION['admin_is_on'] = 0;

                  // if the admin_access field is 1 start admin session
                  if($user['admin_access'] == 1){
                     $_SESSION['admin_is_on'] = 1;
                  // else start regular user session
                  } else {
                     $_SESSION['admin_is_on'] = 0;
                  }
                  // Redirect after login.
                  if ($_GET['redirect'] == "view_sneaker")
                  {
                     header("Location: view_sneaker.php?id=".$_GET['id']);
                  } else 
                  {
                     header("Location: index.php");
                  }
                  exit;
                }
         } else {
            $isSuccess = false;
      }
   }
}

?>

<!DOCTYPE html>
<html>
   <head>
   <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Login</title>
   </head>
   <body>
   <?php if(isset($_GET['redirect']) && $_GET['redirect'] == 'view_sneaker'):?>
      <h2><a href="view_sneaker.php?id=<?=$_GET['id']?>">&#8592; Return</a></h2>
   <?php endif ?>
         <div id="login_form">
            <?php if($_POST && $isSuccess === true):?>
               <h1>Log in succesful.</h1>
               <h1><?=$_SESSION['logged_in_user']?></h1>
               <h1><?=$_SESSION['admin_is_on']?></h1>
               <?php elseif($_POST && $isSuccess === false) :?>
                  <h1>Log in failed.</h1>
            <?php endif ?>
            <div class="container">
            <form action="" method="post">
               <fieldset>
                     <div class="form-group">
                        <label for="user_name">User Name</label>
                        <input class="form-control" name="user_name" id="user_name" placeholder="Enter a username..." value="" required/>
                     </div>
                     <div class="form-group">
                        <label for="user_pass">Password:</label>
                        <input class="form-control" name="user_pass" id="user_pass" type="password" placeholder="Enter a password..." value="" required/>
                     </div>
                     <input class="btn btn-primary" type="submit" name="command" value="Log-in" />
               </fieldset>
            </form>
            <small>If you wish to have admin access please reach out to the site owner.</small>
   </div>
   </body>
</html>
