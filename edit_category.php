<?php
/*
    Cole Cianflone
    Nov 7th, 2022
    Purpose: Script to edit a category.
*/

require("connect.php");
require("admin.php");

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
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>category - Edit </title>
      <!-- <link rel="stylesheet" href="style.css" type="text/css"> -->
   </head>
   <body>

         <div id="category_to_edit">
            <form action="process_category_post.php" method="post">
               <fieldset>
                  <div class="blog_post">
                     <p>
                        <label for="category_name">Category Name</label>
                        <input name="category_name" id="category_name" value="<?=$category[0]['category_name']?>"/>
                     </p>
                     <p>
                        <input type="hidden" name="category_id" value="<?=$_GET['id']?>" />
                        <input type="submit" name="command" value="Update" />
                        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this category?')" />
                     </p>
                  </div>
               </fieldset>
            </form>
         </div>
   </body>
</html>
