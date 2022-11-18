<?php
   /*
       Cole Cianflone
       Nov 7th, 2022
       Purpose: Script to create a category.
   */
   
   require("connect.php");
   require("templates/header.php");
   
   ?>
<div class="container" id="category_to_create" style="padding-top: 40px;">
   <form action="process_category_post.php" method="post">
      <fieldset>
         <div class="form-group">
            <p>
               <label for="category_name">Category Name</label>
               <input class="form-control" name="category_name" style="max-width: 300px;" id="category_name" placeholder="Enter category name..." value=""/>
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
