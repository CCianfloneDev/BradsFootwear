<?php
/*
    Cole Cianflone
    Nov 9th, 2022
    Purpose: Script to edit a comment.
*/

require("connect.php");
session_start();

$comment_id = filter_input(INPUT_GET, "comment_id", FILTER_SANITIZE_NUMBER_INT);
$sneaker_id = filter_input(INPUT_GET, "sneaker_id", FILTER_SANITIZE_NUMBER_INT);

// prepare query
$query = "SELECT * FROM comment WHERE comment_id = :comment_id";
$statement1 = $db->prepare($query); // Returns a PDOStatement object.
$statement1->bindValue(':comment_id', $comment_id);
$statement1->execute(); // The query is now executed.
$comment = $statement1->fetchAll();

if ($_POST || isset($_GET['delete'])){
    if(strlen($_POST['comment_content']) > 0 && $_POST['command'] == "Edit"){
        // sanitize all form fields if they arent already pulled from db
        $comment_content     = filter_input(INPUT_POST, 'comment_content', FILTER_SANITIZE_STRING);
        $user_id = $_SESSION['logged_in_user_id'];
        $date_modify = date('Y-m-d H:i:s');
    
        // prepare update statement
        $query     = "UPDATE comment SET comment_content = :comment_content, user_id = :user_id, sneaker_id = :sneaker_id, date_modify = :date_modify
                      WHERE comment_id = :comment_id";
        $statement = $db->prepare($query);
        
        // bind values to update statement
        $statement->bindValue(':comment_id', $comment_id);
        $statement->bindValue(':comment_content', $comment_content);
        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':sneaker_id', $sneaker_id);
        $statement->bindValue(':date_modify', $date_modify);
        // send value to DB.
        if ($statement->execute()) {
            // Redirect after update.
            header("Location: view_sneaker.php?id=".$sneaker_id);
            
            exit;
        } else {
        echo "<p>sneaker update failed.</p>";
        }
    } else if($_POST['command'] == "Delete" || $_GET['delete'] == true) {
        // prepare delete statement
        $query     = "DELETE FROM comment WHERE comment_id = :comment_id";
        $statement = $db->prepare($query);
        
        // bind values to delete statement
        $statement->bindValue(':comment_id', $comment_id);
        
        // send value to DB.
        if ($statement->execute()) {
            // Redirect after update.
            header("Location: view_sneaker.php?id=".$sneaker_id);
            
            exit;
        }
    } 
}

?>
<!DOCTYPE html>
<html>
   <head>
   <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Comment - Edit</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   </head>
   <body>
   <?php if(isset($_GET['redirect']) && $_GET['redirect'] == 'view_sneaker'):?>
      <h2><a href="view_sneaker.php?id=<?=$_GET['sneaker_id']?>"><-- Return</a></h2>
   <?php endif ?>
         <div id="comment_to_edit">
         <form action="" method="post">
               <fieldset>
                  <div class="comment">
                  <small>
                    <?=$comment[0]['date_insert']?> - initial creation
                    </small>
                    <br>
                    <small>
                        <?=$comment[0]['date_modify']?> - last modified
                    </small>
                    <br>
                     <p>
                     <label for="comment_content">Type your thoughts below</label>
                        <br>
                        <textarea placeholder="Leave your thoughts here..."rows="5" cols="50" name="comment_content">
                            <?=$comment[0]['comment_content']?>
                        </textarea>
                     </p>
                     <p>
                        <input type="submit" name="command" value="Edit" />
                        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this sneaker?')" />
                     </p>
                  </div>
               </fieldset>
            </form>
         </div>
   </body>
</html>
