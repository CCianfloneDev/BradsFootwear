<?php
/*
    Cole Cianflone
    Nov 7th, 2022
    Purpose: Script to view a sneaker, regular and admin users can view.
*/

require("connect.php");

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
            <h3>Sneaker Name: <?=$sneaker[0]['sneaker_name']?></h3>
            <h3>Sneaker Size: <?=$sneaker[0]['sneaker_size']?></h3>
            <h3>Sneaker Value: <?=$sneaker[0]['sneaker_value']?></h3>
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
   </body>
</html>