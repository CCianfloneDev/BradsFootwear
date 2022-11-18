<?php
   /*
       Cole Cianflone
       Nov 7th, 2022
       Purpose: Script to edit a brand.
   */
   
   require("connect.php");
   require("templates/header.php");
   
   // gets id of post
   $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
   
   // prepare query
   $query = "SELECT * FROM sneaker_manufacturer WHERE sneaker_brand_id = :id";
   $statement = $db->prepare($query);
   
   // bind values to insert statement
   $statement->bindValue(":id", $id, PDO::PARAM_INT);
   $statement->execute();
   $brands = $statement->fetchAll();
   
   ?>
<div class="container" id="brand_to_edit" style="padding-top: 40px;">
   <form action="process_brand_post.php" method="post">
      <fieldset>
         <div class="form-group">
            <p>
               <label for="sneaker_brand">Brand Name</label>
               <input class="form-control" name="sneaker_brand" style="max-width: 300px;" id="sneaker_brand" value="<?=$brands[0]['sneaker_brand']?>"/>
            </p>
         </div>
         <div class="form-group">
            <p>
               <input type="hidden" name="sneaker_brand_id" value="<?=$_GET['id']?>" />
               <input class="btn btn-success" type="submit" name="command" value="Update" />
               <input class="btn btn-danger" type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this brand? It will delete any sneakers associated with it.')" />
            </p>
         </div>
      </fieldset>
   </form>
</div>
</html>
