<?php
/*
    Cole Cianflone
    Nov 7th, 2022
    Purpose: Script to create a category.
*/

require("connect.php");
require("admin.php");


?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>brand - create </title>
      <!-- <link rel="stylesheet" href="style.css" type="text/css"> -->
   </head>
   <body>

         <div id="brand_to_create">
            <form action="process_brand_post.php" method="post">
               <fieldset>
                  <div class="brand">
                     <p>
                        <label for="sneaker_brand">Brand Name</label>
                        <input name="sneaker_brand" id="sneaker_brand" value=""/>
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