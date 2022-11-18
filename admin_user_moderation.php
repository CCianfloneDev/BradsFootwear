<?php 
   require("connect.php");
   require("templates/header.php");
   
   /* SELECT ALL DATA FROM users table*/
   $query = "SELECT * FROM user";
   $statement = $db->prepare($query); // Returns a PDOStatement object.
   $statement->execute(); // The query is now executed.
   $users = $statement->fetchAll();
   
   ?>
<div class="container" id="all_users">
   <h1>Users</h1>
   <div class="card-columns">
      <?php foreach($users as $user):?>
      <div class="card">
         <div class="card-body">
            <h5 class="card-title"><strong><?=$user['user_name']?></strong></h5>
            <?php if($user['admin_access'] == 1):?>
            <?php if($user['user_id'] != $_SESSION['logged_in_user_id']):?>
            <p class="card-text"> Has admin access </p>
            <a class="btn btn-warning" onclick="return confirm('Are you sure you wish to revoke this users access?')" href="change_access.php?admin=revoke&user_id=<?=$user['user_id']?>">Revoke admin access</a>
            <?php endif ?>
            <?php else: ?>
            <p class="card-text"> Does not have admin access </p>
            <a class="btn btn-success" onclick="return confirm('Are you sure you wish to grant this user admin access?')" href="change_access.php?admin=grant&user_id=<?=$user['user_id']?>">Grant admin access</a>
            <?php endif ?>
            <?php if($user['user_id'] != $_SESSION['logged_in_user_id']):?> 
            <a class="btn btn-warning" onclick="return confirm('Are you sure you wish to delete this user?')" href="delete_user.php?own_account=false&user_id=<?=$user['user_id']?>">Delete This User</a>
            <?php else: ?>
            <a class="btn btn-danger" onclick="return confirm('ARE YOU SURE YOU WISH TO TERMINATE YOUR ACCOUNT?')" href="delete_user.php?own_account=true&user_id=<?=$_SESSION['logged_in_user_id']?>">Terminate your account</a>
            <?php endif ?>
            <br>
         </div>
      </div>
      <?php endforeach ?>
   </div>
</div>
</html>
