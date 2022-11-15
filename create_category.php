<?php
/*
    Cole Cianflone
    Nov 7th, 2022
    Purpose: Script to create a category.
*/

require("connect.php");
require("templates/header.php");

?>
<!DOCTYPE html>
<html>
   <head>
   <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Category - Create</title>
   </head>
   <body>
         <div id="category_to_create">
            <form action="process_category_post.php" method="post">
               <fieldset>
                  <div class="category">
                     <p>
                        <label for="category_name">Category Name</label>
                        <input name="category_name" id="category_name" placeholder="Enter category name..." value=""/>
                     </p>
                     <p>
                        <input type="submit" name="command" value="Create" />
                     </p>
                  </div>
               </fieldset>
            </form>
         </div>
   </body>
</html>
