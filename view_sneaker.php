<?php
/*
    Cole Cianflone
    Nov 7th, 2022
    Purpose: Script to view a sneaker, regular and admin users can view.
*/

require("connect.php");
session_start();

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
$query = "SELECT * FROM comment";
$statement = $db->prepare($query); // Returns a PDOStatement object.
$statement->execute(); // The query is now executed.
$comments = $statement->fetchAll();

if (count($_POST) > 0 && strlen($_POST['comment_content']) > 0) {
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
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>sneaker - View </title>
      <!-- <link rel="stylesheet" href="style.css" type="text/css"> -->
   </head>
   <body>
         <div id="sneaker_to_view">
            <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['admin_is_on'] === 1):?>
                <h2><a href="edit_sneaker.php?id=<?=$sneaker_id?>">Edit This Sneaker</a></h2>
            <?php endif ?>
            <h3>Sneaker Name: <?=$sneaker[0]['sneaker_name']?></h3>
            <h3>Sneaker Size: <?=$sneaker[0]['sneaker_size']?></h3>
            <h3>Sneaker Value: $<?=$sneaker[0]['sneaker_value']?></h3>
            <?php foreach($brands as $brand): ?>
                <?php if($sneaker[0]['sneaker_brand_id'] == $brand['sneaker_brand_id']):?>
                    <h3>Sneaker Brand: <?=$brand['sneaker_brand']?></h3>
                <?php endif ?>
            <?php endforeach ?>
            <?php foreach($categories as $category): ?>
                <?php if($sneaker[0]['sneaker_category_id'] == $category['category_id']):?>
                    <h3>Sneaker Category: <?=$category['category_name']?></h3>
                <?php endif ?>
            <?php endforeach ?>      
            <label for="description"><strong>Description: </strong></label>
            <br>
            <textarea id="description" readonly rows="5" cols="50">
                <?=$sneaker[0]['sneaker_description']?>
            </textarea>
            <br>
            <img src="<?=$sneaker[0]['sneaker_image_path']?>" alt="sneaker-image" width="350" height="250">
            <p>
                <small>
                    <?=$sneaker[0]['date_modify']?> - last modified
                </small>
                <br>
                <small>
                    <?=$sneaker[0]['date_insert']?> - initial creation
                </small>
                <br>
                <small>
                    last modified by: <?=$users[$sneaker[0]['user_id_modify']-1]['user_name']?>
                </small>
                <br>
                <small>
                    created by: <?=$users[$sneaker[0]['user_id_insert']-1]['user_name']?>
                </small>
            </p>
         </div>
         <div id="comments">
         <?php foreach($comments as $comment):?>
            <?php foreach($users as $user):?>
                <?php if($comment['user_id'] === $user['user_id']):?>
                    <h1>Comment posted by: <?=$user['user_name']?></h1>
                <?php endif ?>
            <?php endforeach ?>
            <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['logged_in_user_id'] == $comment['user_id']):?>
                <p><a href="edit_comment.php">Edit your comment</a></p>
            <?php endif ?>
            <small>
                <?=$comment['date_insert']?> - initial creation
            </small>
            <br>
            <small>
                <?=$comment['date_modify']?> - last modified
            </small>
            <br>
            <textarea id="comment_content" readonly rows="10" cols="70">
                <?=$comment['comment_content']?>
            </textarea>
            <br>
         <?php endforeach ?>
         </div>
        <?php if(isset($_SESSION['logged_in_user'])):?>
        <div id="comment_form">
        <h1>Leave a thought below!</h1>
         <form action="view_sneaker.php?id=<?=$sneaker_id?>" method="post">
               <fieldset>
                  <div class="comment">
                     <p>
                     <label for="comment_content">Type your thoughts below</label>
                        <br>
                        <textarea placeholder="Leave your thoughts here..."rows="5" cols="50" name="comment_content"></textarea>
                     </p>
                     <p>
                        <input type="submit" name="command" value="Comment" />
                     </p>
                  </div>
               </fieldset>
            </form>
         </div>
        <?php else:?>
            <h1>If you'd like to leave a comment on this sneaker post, follow the below links to sign in or register an account.</h1>
            <h1><a href="login.php?redirect=view_sneaker&id=<?=$sneaker_id?>">Sign in</a></h1>
            <h1><a href="register.php?redirect=view_sneaker&id=<?=$sneaker_id?>">Register</a></h1>
        <?php endif ?>
   </body>
</html>
