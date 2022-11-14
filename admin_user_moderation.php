<?php 
    require("connect.php");
    session_start();

    /* SELECT ALL DATA FROM users table*/
    $query = "SELECT * FROM user";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute(); // The query is now executed.
    $users = $statement->fetchAll();

?>
<!DOCTYPE html>
<html>
   <head>
   <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>User Moderation</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   </head>
   <body>
   <h1><a href="index.php">Home</a></h1>
        <h1><a href="logout.php">Log Out</a></h1>
   <div id="all_users">
    <h1>ALL USERS</h1>
    <?php foreach($users as $user):?>
        <h1>
            <?=$user['user_name']?>
            <?php if($user['user_id'] != $_SESSION['logged_in_user_id']):?> 
                <small><a onclick="return confirm('Are you sure you wish to delete this user?')" href="delete_user.php?own_account=false&user_id=<?=$user['user_id']?>">Delete This User</a></small>
                <?php else: ?>
                    <small><a onclick="return confirm('ARE YOU SURE YOU WISH TO TERMINATE YOUR ACCOUNT?')" href="delete_user.php?own_account=true&user_id=<?=$_SESSION['logged_in_user_id']?>">Terminate your account.</a></small>
            <?php endif ?>
        </h1>
        <h2>
            <?php if($user['admin_access'] == 1):?>
                <?php if($user['user_id'] != $_SESSION['logged_in_user_id']):?>
                <p><small>Has admin access <a onclick="return confirm('Are you sure you wish to revoke this users access?')" href="change_access.php?admin=revoke&user_id=<?=$user['user_id']?>">Revoke admin access.</a></small></p>
                <?php endif ?>
                <?php else: ?>
                    <p><small>Does not have admin access <a onclick="return confirm('Are you sure you wish to grant this user admin access?')" href="change_access.php?admin=grant&user_id=<?=$user['user_id']?>">Grant admin access.</a></small></p>
            <?php endif ?>
            <br>
        </h2>
    <?php endforeach ?>
   </div>
   </body>
</html>
