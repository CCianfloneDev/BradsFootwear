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

    if ($_POST && $_POST['command'] == 'Search')
    {
        $search_input = filter_input(INPUT_POST, 'search_input', FILTER_SANITIZE_STRING);
        $search = "%".$search_input."%";

        /* SELECT DATA FROM sneakers table */
        $query = "SELECT * FROM sneaker WHERE sneaker_name LIKE :search ORDER BY sneaker_name DESC";
        $statement = $db->prepare($query);
        // bind values to insert statement
        $statement->bindValue(":search", $search);
        $statement->execute();
        $searchResult = $statement->fetchAll();
    }
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
        <div id="search_form">
            <form action="index.php" method="post">
               <fieldset>
                  <div class="search">
                  <h2>Search for sneakers!</h2>
                     <p>
                        <input name="search_input" type="text" id="search_input" style="width:330px;" placeholder="Search by name of sneaker, value, or size of sneaker..." value=""/>
                     </p>
                     <p>
                        <input type="submit" name="command" value="Search" />
                     </p>
                  </div>
               </fieldset>
            </form>
         </div>
        <?php if($_POST) :?>
            <h2><a href="index.php?reset=true">View all sneakers</a></h2>
            <?php foreach($searchResult as $sneaker):?>
                <h2>Sneaker Name: <?=$sneaker['sneaker_name']?> 
                || <small><a href="view_sneaker.php?id=<?=$sneaker['sneaker_id']?>">View Sneaker</a></small>
                <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['admin_is_on'] === 1):?>
                || <small><a href="edit_sneaker.php?id=<?=$sneaker['sneaker_id']?>">edit</a></small>
                <?php endif ?>
            </h2>
            <?php endforeach ?>
        <?php elseif(!$_POST || $_GET['reset'] == true): ?>
        <?php foreach($sneakers as $sneaker): ?>
            <h2>Sneaker Name: <?=$sneaker['sneaker_name']?> 
                || <small><a href="view_sneaker.php?id=<?=$sneaker['sneaker_id']?>">View Sneaker</a></small>
                <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['admin_is_on'] === 1):?>
                || <small><a href="edit_sneaker.php?id=<?=$sneaker['sneaker_id']?>">edit</a></small>
                <?php endif ?>
            </h2>
        <?php endforeach ?>
        <?php endif ?>
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
