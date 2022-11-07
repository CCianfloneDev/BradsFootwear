<?php
    require("connect.php");
    require("admin.php");

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
    <h1>BELOW DATA IS ALL TABLES IN CMS</h1>
   <div id="all_footwear">
        <h1>Sneakers</h1>
        <?php foreach($sneakers as $sneaker): ?>
            <h2>Sneaker Name: <?=$sneaker['sneaker_name']?> ||
                Sneaker category: <?=$categories[$sneaker['sneaker_category_id']-1]['category_name']?> ||
                Sneaker Manufacturer: <?=$brands[$sneaker['sneaker_brand_id']-1]['sneaker_brand']?>
            </h2>
        <?php endforeach ?>
    </div>
   <div id="all_categories">
        <h1>Categories</h1>
        <h2><a href="create_category.php">Create category</a></h2>
        <?php foreach($categories as $category): ?>
            <h3>Category name: <?=$category['category_name']?> <small><a href="edit_category.php?id=<?=$category['category_id']?>">edit</a></small></h3>
        <?php endforeach ?>
    </div>
    <div id="all_brands">
        <h1>Manufacturers</h1>
        <?php foreach($brands as $brand): ?>
            <h2>Brand name: <?=$brand['sneaker_brand']?></h2>
        <?php endforeach ?>
    </div>
   </body>
</html>
