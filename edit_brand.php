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
<!DOCTYPE html>
<html>
   <head>
   <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Brand - Edit</title>
   </head>
   <body>
         <div id="brand_to_edit">
            <form action="process_brand_post.php" method="post">
               <fieldset>
                  <div class="sneaker_edit">
                     <p>
                        <label for="sneaker_brand">Brand Name</label>
                        <input name="sneaker_brand" id="sneaker_brand" value="<?=$brands[0]['sneaker_brand']?>"/>
                     </p>
                     <p>
                        <input type="hidden" name="sneaker_brand_id" value="<?=$_GET['id']?>" />
                        <input type="submit" name="command" value="Update" />
                        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this brand?')" />
                     </p>
                  </div>
               </fieldset>
            </form>
         </div>
   </body>
</html>
