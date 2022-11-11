<?php 
    require("connect.php");
    session_start();

    // sanitize category name and id
    $user_id   = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    //$change_access = filter_input(INPUT_GET, 'admin', FILTER_SANITIZE_STRING);

    // prepare update statement
    if ($_GET['admin'] == "grant") {
        $query     = "UPDATE user SET admin_access = 1 WHERE user_id = :user_id";
        $statement = $db->prepare($query);
        // bind values to update statement
        $statement->bindValue(':user_id', $user_id);   
    } else if ($_GET['admin'] == "revoke") {
        $query     = "UPDATE user SET admin_access = 0 WHERE user_id = :user_id";
        $statement = $db->prepare($query);
        // bind values to update statement
        $statement->bindValue(':user_id', $user_id);  
    }
    // send value to DB.
    if ($statement->execute()) {
        // Redirect after update.
        header("Location: admin_user_moderation.php");
        
        exit;
    }
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>change access</title>
      <!-- <link rel="stylesheet" href="style.css" type="text/css"> -->
   </head>
   <body>
   </body>
</html>