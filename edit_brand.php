<?php
/*
    Cole Cianflone
    Nov 7th, 2022
    Purpose: Script to edit a brand.
*/

require("connect.php");

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
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   </head>
   <body>
   <h1><a href="index.php">Home</a></h1>
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
