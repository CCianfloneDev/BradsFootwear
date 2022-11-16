<?php 
    require("connect.php");
    require("templates/header.php");

    /* SELECT ALL DATA FROM sneaker_manufacturer table */
    $query = "SELECT * FROM sneaker_manufacturer";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute(); // The query is now executed.
    $brands = $statement->fetchAll();
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
        <div id="all_brands">
            <h1>Brands</h1>
            <h2><a href="create_brand.php">Create brand</a></h2>
            <?php foreach($brands as $brand): ?>
                <h3><?=$brand['sneaker_brand']?> <small><a class="badge badge-info" href="edit_brand.php?id=<?=$brand['sneaker_brand_id']?>">edit</a></small></h3>
            <?php endforeach ?>
        </div>
    <?php endif ?>
    </div>
   </body>
</html>
