<?php 
   require("connect.php");
   require("templates/header.php");
   
       /* SELECT ALL DATA FROM sneaker_categorys table*/
       $query = "SELECT * FROM sneaker_category";
       $statement = $db->prepare($query); // Returns a PDOStatement object.
       $statement->execute(); // The query is now executed.
       $categories = $statement->fetchAll();
   ?>
<div class="container" id="all_categories">
   <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['admin_is_on'] === 1): ?>
   <h1>Categories</h1>
   <h2><a href="create_category.php">Create category</a></h2>
   <div class="card-columns">
      <?php foreach($categories as $category): ?>
      <div class="card">
         <div class="card-body">
            <h5 class="card-title"><?=$category['category_name']?></h5>
            <a href="edit_category.php?id=<?=$category['category_id']?>" class="btn btn-primary">Edit Or Delete</a>
         </div>
      </div>
      <?php endforeach ?>
   </div>
   <?php endif ?>
</div>
</html>
