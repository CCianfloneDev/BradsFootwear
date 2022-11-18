<?php
   /*
       Cole Cianflone
       Nov 7th, 2022
       Purpose: Script to edit a category.
   */
   
   require("connect.php");
   require("templates/header.php");
   
   // gets id of post
   $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
   
   // prepare query
   $query = "SELECT * FROM sneaker_category WHERE category_id = :id";
   $statement = $db->prepare($query);
   
   // bind values to insert statement
   $statement->bindValue(":id", $id, PDO::PARAM_INT);
   $statement->execute();
   $category = $statement->fetchAll();
   
   ?>
<div class="container" id="category_to_edit" style="padding-top: 40px;">
   <form action="process_category_post.php" method="post">
      <fieldset>
         <div class="form-group">
            <p>
               <label for="category_name">Category Name</label>
               <input class="form-control" name="category_name" style="max-width: 300px;" id="category_name" value="<?=$category[0]['category_name']?>"/>
            </p>
         </div>
         <div class="form-group">
            <p>
               <input type="hidden" name="category_id" value="<?=$_GET['id']?>" />
               <input class="btn btn-success" type="submit" name="command" value="Update" />
               <input class="btn btn-danger" type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this category? It will delete any sneakers associated with it.')" />
            </p>
         </div>
      </fieldset>
   </form>
</div>
</html>
