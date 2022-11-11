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
      <title>User - moderation</title>
      <!-- <link rel="stylesheet" href="style.css" type="text/css"> -->
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
                <p><small>Has admin access <a href="change_access.php?admin=revoke&user_id=<?=$user['user_id']?>">Revoke admin access.</a></small></p>
                <?php else: ?>
                    <p><small>Does not have admin access <a href="change_access.php?admin=grant&user_id=<?=$user['user_id']?>">Grant admin access.</a></small></p>
            <?php endif ?>
            <br>
        </h2>
    <?php endforeach ?>
   </div>
   </body>
</html>