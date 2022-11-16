<?php 
    require("connect.php");
    require("templates/header.php");

        /* SELECT ALL DATA FROM sneaker_categorys table*/
        $query = "SELECT * FROM sneaker_category";
        $statement = $db->prepare($query); // Returns a PDOStatement object.
        $statement->execute(); // The query is now executed.
        $categories = $statement->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Category - Administration</title>
   </head>
   <body>
   <div class="container" id="all_categories">
    <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['admin_is_on'] === 1): ?>
            <div id="all_categories">
            <h1>Categories</h1>
            <h2><a href="create_category.php">Create category</a></h2>
            <?php foreach($categories as $category): ?>
                <h3><?=$category['category_name']?> <small><a class="badge badge-info" href="edit_category.php?id=<?=$category['category_id']?>">edit</a></small></h3>
            <?php endforeach ?>
        </div>
    <?php endif ?>
    </div>
   </body>
</html>
