<?php
   /*
       Cole Cianflone
       Nov 7th, 2022
       Purpose: Script to create a category.
   */
   
   require("connect.php");
   require("templates/header.php");
   
   ?>
<div class="container" id="brand_to_create" style="padding-top: 40px;">
   <form action="process_brand_post.php" method="post">
      <fieldset>
         <div class="form-group">
            <p>
               <label for="sneaker_brand">Brand Name</label>
               <input class="form-control" style="max-width: 300px;" name="sneaker_brand" id="sneaker_brand" placeholder="Enter a brand name..." value=""/>
            </p>
         </div>
         <div class="form-group">
            <p>
               <input class="btn btn-primary" type="submit" name="command" value="Create" />
            </p>
         </div>
      </fieldset>
   </form>
</div>
</html>
