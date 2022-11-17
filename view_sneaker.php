<?php
   /*
       Cole Cianflone
       Nov 7th, 2022
       Purpose: Script to view a sneaker, regular and admin users can view.
   */
   
   require("connect.php");
   require("templates/header.php");
   //session_start();
   
   // gets id of post
   $sneaker_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
   
   // prepare query
   $query = "SELECT * FROM sneaker WHERE sneaker_id = :sneaker_id";
   $statement = $db->prepare($query);
   
   // bind values to insert statement
   $statement->bindValue(":sneaker_id", $sneaker_id, PDO::PARAM_INT);
   $statement->execute();
   $sneaker = $statement->fetchAll();
   
   /* SELECT ALL DATA FROM sneaker_manufacturer table */
   $query = "SELECT * FROM sneaker_manufacturer";
   $statement = $db->prepare($query); // Returns a PDOStatement object.
   $statement->execute(); // The query is now executed.
   $brands = $statement->fetchAll();
   
   /* SELECT ALL DATA FROM sneaker_categorys table*/
   $query = "SELECT * FROM sneaker_category";
   $statement = $db->prepare($query); // Returns a PDOStatement object.
   $statement->execute(); // The query is now executed.
   $categories = $statement->fetchAll();
   
   /* SELECT ALL DATA FROM users table*/
   $query = "SELECT * FROM user";
   $statement = $db->prepare($query); // Returns a PDOStatement object.
   $statement->execute(); // The query is now executed.
   $users = $statement->fetchAll();
   
   /* SELECT ALL DATA FROM comment table*/
   $query = "SELECT * FROM comment WHERE sneaker_id = :sneaker_id ORDER BY comment_content DESC";
   $statement = $db->prepare($query); // Returns a PDOStatement object.
   $statement->bindValue(":sneaker_id", $sneaker_id, PDO::PARAM_INT);
   $statement->execute(); // The query is now executed.
   $comments = $statement->fetchAll();
   
   if (count($_POST) > 0 && strlen($_POST['comment_content']) > 0 && $_POST['command'] == "Comment") {
       // get user that posted comment to access the id.
       $user_name = $_SESSION['logged_in_user'];
       $query = "SELECT * FROM user WHERE user_name = :user_name";
       $statement = $db->prepare($query);
       // bind values to insert statement
       $statement->bindValue(":user_name", $user_name, PDO::PARAM_STR);
       $statement->execute();
       $commenting_user = $statement->fetchAll();
       // get the commenting users id to submit to db
       $commenting_user_id = $commenting_user[0]['user_id'];
       // get the comment
       $comment_content = filter_input(INPUT_POST, 'comment_content', FILTER_SANITIZE_STRING);
   
       $query = "INSERT INTO comment (comment_content, user_id, sneaker_id) VALUES (:comment_content, :user_id, :sneaker_id)";
       $statement = $db->prepare($query);
   
       // bind values to insert statement
       $statement->bindValue(':comment_content', $comment_content);
       $statement->bindValue(':user_id', $commenting_user_id);
       $statement->bindValue(':sneaker_id', $sneaker_id);
   
       // send value to DB.
       if ($statement->execute()) {
           // Redirect after update.
           echo '<script>alert("Comment posted succesfully...")</script>';
           header("Location: view_sneaker.php?id=".$sneaker_id);
           
       } else {
           echo '<script>alert("Comment post failed...")</script>';
       }
   }
   
   ?>
<link rel="stylesheet" type="text/css" href="styles.css">
<div class="container" id="sneaker_to_view">
   <div class="card" style="width: 30rem;">
      <?php if(strlen($sneaker[0]['sneaker_image_path']) > 0):?>
      <img src="<?=$sneaker[0]['sneaker_image_path']?>" alt="sneaker-image">
      <?php endif ?>
      <div class="card-body">
         <h5 class="card-title"><?=$sneaker[0]['sneaker_name']?></h5>
         <p class="card-text"><?=$sneaker[0]['sneaker_description']?></p>
      </div>
      <ul class="list-group list-group-flush">
         <li class="list-group-item">Size: <?=$sneaker[0]['sneaker_size']?></li>
         <li class="list-group-item">Valued at: $<?=$sneaker[0]['sneaker_value']?></li>
         <?php foreach($brands as $brand): ?>
         <?php if($sneaker[0]['sneaker_brand_id'] == $brand['sneaker_brand_id']):?>
         <li class="list-group-item">Brand: <?=$brand['sneaker_brand']?></li>
         <?php endif ?>
         <?php endforeach ?>
         <?php foreach($categories as $category): ?>
         <?php if($sneaker[0]['sneaker_category_id'] == $category['category_id']):?>
         <li class="list-group-item">Category: <?=$category['category_name']?></li>
         <?php endif ?>
         <?php endforeach ?> 
      </ul>
      <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['admin_is_on'] === 1):?>
      <div class="card-body">
         <a href="edit_sneaker.php?redirect=view_sneaker&id=<?=$sneaker_id?>" class="card-link">Edit This Sneaker</a>
      </div>
      <?php endif ?>
      <small>
      <?=$sneaker[0]['date_modify']?> - last modified
      </small>
      <small>
      <?=$sneaker[0]['date_insert']?> - initial creation
      </small>
      <small>
      last modified by: <?=$users[$sneaker[0]['user_id_modify']-1]['user_name']?>
      </small>
      <small>
      created by: <?=$users[$sneaker[0]['user_id_insert']-1]['user_name']?>
      </small>
   </div>
   <br>
</div>
<?php if(!isset($_SESSION['logged_in_user'])):?>
<div class="card fluid alert alert-info alert-dismissible fade show" role="alert" style="max-width: 550px;">
   If you wish to add or view a comment on this page please login..
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
   <span aria-hidden="true">&times;</span>
   </button>
</div>
<div class="blur-content">
   <?php endif ?>
   <div class="container">
      <h2 style="text-align: center;">User submitted comments</h2>
      <div class="toast-container position-static">
         <?php foreach($comments as $comment):?>
         <div class="card toast fade show" role="alert" aria-live="assertive" aria-atomic="true" style="max-width: 400px; padding: 6px;">
            <div class="toast-header">
               <?php foreach($users as $user):?>
               <?php if($comment['user_id'] === $user['user_id']):?>
               <strong class="me-auto"><?=$user['user_name']?></strong>
               <small class="text-muted"><?=$comment['date_modify']?></small>
            </div>
            <div class="toast-body">
               <?=$comment['comment_content']?>
               <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['logged_in_user_id'] == $comment['user_id']):?>
               <a class="badge badge-info" href="edit_comment.php?redirect=view_sneaker&comment_id=<?=$comment['comment_id']?>&sneaker_id=<?=$sneaker_id?>">Edit your comment</a>
               <?php endif ?>
               <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['admin_is_on'] === 1):?>
               <small><a class="badge badge-danger" onclick="return confirm('Are you sure you wish to delete this comment?')" href="edit_comment.php?delete=true&comment_id=<?=$comment['comment_id']?>&sneaker_id=<?=$sneaker_id?>">Delete this comment.</a></small>
               <?php endif ?>
            </div>
            <?php endif ?>
            <?php endforeach ?>
         </div>
         <?php endforeach ?>
      </div>
      <br>
      <?php if(!isset($_SESSION['logged_in_user'])):?>
   </div>
   <?php endif ?>
   <?php if(isset($_SESSION['logged_in_user'])):?>
   <div class="container"  style="max-width: 400px;" id="comment_form">
      <h1>Leave a thought below!</h1>
      <form action="view_sneaker.php?id=<?=$sneaker_id?>" method="post">
         <fieldset>
            <div class="comment">
               <p>
                  <label for="comment_content">Type your thoughts below</label>
                  <br>
                  <textarea placeholder="Leave your thoughts here..." rows="5" cols="40" name="comment_content" id="comment_content"></textarea>
               </p>
               <p>
                  <input type="submit" name="command" value="Comment" />
               </p>
            </div>
         </fieldset>
      </form>
   </div>
   <?php endif ?>
</div>
</html>
