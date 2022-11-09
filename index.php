<?php
    require("connect.php");
    session_start();

    /* SELECT ALL DATA FROM sneaker_categorys table*/
    $query = "SELECT * FROM sneaker_category";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute(); // The query is now executed.
    $categories = $statement->fetchAll();

    /* SELECT ALL DATA FROM sneakers table */
    $query = "SELECT * FROM sneaker";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute(); // The query is now executed.
    $sneakers = $statement->fetchAll();

    /* SELECT ALL DATA FROM sneaker_manufacturer table */
    $query = "SELECT * FROM sneaker_manufacturer";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute(); // The query is now executed.
    $brands = $statement->fetchAll();


?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>HOME</title>
      <!-- <link rel="stylesheet" href="style.css" type="text/css"> -->
   </head>
   <body>
    <?php if(isset($_SESSION['logged_in_user'])):?>
        <h1>Thanks for logging in <em><?=$_SESSION['logged_in_user']?></em></h1>
    <?php endif ?>
    <?php if(isset($_SESSION['logged_in_user'])):?>
        <h1><a href="logout.php">Log Out</a></h1>
        <?php else:?>
            <h1><a href="login.php">Sign in</a></h1>
            <h1><a href="register.php">Register</a></h1>
    <?php endif ?>
   <div id="all_footwear">
        <h1>Sneakers</h1>
        <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['admin_is_on'] === 1):?>
        <h2><a href="create_sneaker.php">Create sneaker</a></h2>
        <?php endif ?>
        <?php foreach($sneakers as $sneaker): ?>
            <h2>Sneaker Name: <?=$sneaker['sneaker_name']?> 
                || <small><a href="view_sneaker.php?id=<?=$sneaker['sneaker_id']?>">View Sneaker</a></small>
                <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['admin_is_on'] === 1):?>
                || <small><a href="edit_sneaker.php?id=<?=$sneaker['sneaker_id']?>">edit</a></small>
                <?php endif ?>
            </h2>
        <?php endforeach ?>
    </div>
    <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['admin_is_on'] === 1): ?>
        <div id="all_categories">
        <h1>Categories</h1>
        <h2><a href="create_category.php">Create category</a></h2>
        <?php foreach($categories as $category): ?>
            <h3>Category name: <?=$category['category_name']?> <small><a href="edit_category.php?id=<?=$category['category_id']?>">edit</a></small></h3>
        <?php endforeach ?>
    </div>
    <div id="all_brands">
        <h1>Manufacturers</h1>
        <h2><a href="create_brand.php">Create brand</a></h2>
        <?php foreach($brands as $brand): ?>
            <h3>Brand name: <?=$brand['sneaker_brand']?> <small><a href="edit_brand.php?id=<?=$brand['sneaker_brand_id']?>">edit</a></small></h3>
        <?php endforeach ?>
    </div>
    <?php endif ?>
   </body>
</html>
