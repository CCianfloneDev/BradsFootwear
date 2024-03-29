<?php 
   require("connect.php");
   require("templates/header.php");
   
   /* SELECT ALL DATA FROM sneaker_manufacturer table */
   $query = "SELECT * FROM sneaker_manufacturer";
   $statement = $db->prepare($query); // Returns a PDOStatement object.
   $statement->execute(); // The query is now executed.
   $brands = $statement->fetchAll();
   $counter = 0;
   ?>
<div class="container">
   <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['admin_is_on'] === 1): ?>
   <div id="all_brands">
      <h1>Brands</h1>
      <h2><a href="create_brand.php">Create brand</a></h2>
      <div class="card-columns">
         <?php foreach($brands as $brand):?>
         <div class="card">
            <div class="card-body">
               <h5 class="card-title"><?=$brand['sneaker_brand']?></h5>
               <a href="edit_brand.php?id=<?=$brand['sneaker_brand_id']?>" class="btn btn-primary">Edit Or Delete</a>
            </div>
         </div>
         <!-- <h3><?=$brand['sneaker_brand']?> <small><a class="badge badge-info" href="edit_brand.php?id=<?=$brand['sneaker_brand_id']?>">edit</a></small></h3> -->
         <?php endforeach ?>
      </div>
   </div>
   <?php endif ?>
</div>
</html>
