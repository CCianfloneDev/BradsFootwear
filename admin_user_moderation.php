<?php 
    require("connect.php");
    require("templates/header.php");

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
   </head>
   <body>
   <div class="container" id="all_users">
    <h1>ALL USERS</h1>
    <?php foreach($users as $user):?>
        <h1>
            <?=$user['user_name']?>
            <?php if($user['user_id'] != $_SESSION['logged_in_user_id']):?> 
                <small><a class="badge badge-warning" onclick="return confirm('Are you sure you wish to delete this user?')" href="delete_user.php?own_account=false&user_id=<?=$user['user_id']?>">Delete This User</a></small>
                <?php else: ?>
                    <small><a class="badge badge-danger" onclick="return confirm('ARE YOU SURE YOU WISH TO TERMINATE YOUR ACCOUNT?')" href="delete_user.php?own_account=true&user_id=<?=$_SESSION['logged_in_user_id']?>">Terminate your account.</a></small>
            <?php endif ?>
        </h1>
        <h2>
            <?php if($user['admin_access'] == 1):?>
                <?php if($user['user_id'] != $_SESSION['logged_in_user_id']):?>
                <p><small>Has admin access <a class="badge badge-danger" onclick="return confirm('Are you sure you wish to revoke this users access?')" href="change_access.php?admin=revoke&user_id=<?=$user['user_id']?>">Revoke admin access.</a></small></p>
                <?php endif ?>
                <?php else: ?>
                    <p><small>Does not have admin access <a class="badge badge-success" onclick="return confirm('Are you sure you wish to grant this user admin access?')" href="change_access.php?admin=grant&user_id=<?=$user['user_id']?>">Grant admin access.</a></small></p>
            <?php endif ?>
            <br>
        </h2>
    <?php endforeach ?>
   </div>
   </body>
</html>
