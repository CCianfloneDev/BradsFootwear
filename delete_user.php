<?php 
    require("connect.php");
    session_start();

    // sanitze id
    $user_id = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    
    // prepare delete statement
    $query     = "DELETE FROM user WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    
    // bind values to delete statement
    $statement->bindValue(':user_id', $user_id);

    echo $user_id;
    
    // send value to DB.
    if ($statement->execute()) {
        // wasnt the currently logged in admins account so return to account moderation page.
        if ($_GET['own_account'] == 'false') {
            header("Location: admin_user_moderation.php");
        } else { // admin chose to terminate their account so redirect to logout which redirects to home page.

            header("Location: logout.php");
        }
        exit;
    }
    
?>