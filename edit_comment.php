<?php
   /*
       Cole Cianflone
       Nov 9th, 2022
       Purpose: Script to edit a comment.
   */
   
   require("connect.php");
   require("templates/header.php");
   
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
<div class="container"  style="max-width: 400px;" id="comment_form">
   <?php if(isset($_GET['redirect']) && $_GET['redirect'] == 'view_sneaker'):?>
   <h2><a href="view_sneaker.php?id=<?=$_GET['sneaker_id']?>">&larr; Return</a></h2>
   <?php endif ?>
   <form method="post">
      <div class="form-group">
         <label for="comment_content"><strong>Edit your comment</strong></label>
         <textarea placeholder="Leave your thoughts here..." class="form-control" name="comment_content" id="comment_content" rows="3"><?=$comment[0]['comment_content']?></textarea>
      </div>
      <p>
         <input class="btn btn-success" type="submit" name="command" value="Edit" />
         <input class="btn btn-danger" type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this comment?')" />
      </p>
   </form>
</div>
</html>
