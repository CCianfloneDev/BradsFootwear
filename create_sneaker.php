<?php
   /*
       Cole Cianflone
       Nov 7th, 2022
       Purpose: Script to create a sneaker.
   */
   
   require("connect.php");
   require("templates/header.php");
   //session_start();
   
   /* SELECT ALL DATA FROM sneaker_manufacturer table */
   $query = "SELECT * FROM sneaker_manufacturer";
   $statement = $db->prepare($query); // Returns a PDOStatement object.
   $statement->execute(); // The query is now executed.
   $brands = $statement->fetchAll();
   
   /* SELECT ALL DATA FROM sneaker_categorys table*/
   $query = "SELECT * FROM sneaker_category";
   $statement = $db->prepare($query); // Returns a PDOStatement object.
   $statement->execute(); // The query is now executed.
   $categories = $statement->fetchAll();
   
   /* SELECT USER CURRENTLY EDITING PAGE */
   $user_name = $_SESSION['logged_in_user'];
   $query = "SELECT * FROM user WHERE user_name = :user_name";
   $statement = $db->prepare($query);
   // bind values to insert statement
   $statement->bindValue(":user_name", $user_name, PDO::PARAM_STR);
   $statement->execute();
   $userEditing = $statement->fetchAll();
   
   ?>
<div id="sneaker_to_create">
   <form action="process_sneaker_post.php?processType=create" method="post" enctype='multipart/form-data'>
      <div class="container">
         <div class="form-group">
            <label for="sneaker_name">Sneaker Name</label>
            <input class="form-control" name="sneaker_name" id="sneaker_name" placeholder="Enter a sneaker name..." required>
         </div>
         <div class="form-group">
            <label for="sneaker_size">Sneaker Size</label>
            <select class="form-control" id="sneaker_size" name="sneaker_size" required>
               <option value="" selected hidden disabled>Select a size</option>
               <option value="7.5">7.5</option>
               <option value="8">8</option>
               <option value="8.5">8.5</option>
               <option value="9">9</option>
               <option value="9.5">9.5</option>
               <option value="10">10</option>
               <option value="10.5">10.5</option>
               <option value="11">11</option>
               <option value="11.5">11.5</option>
               <option value="12">12</option>
               <option value="12.5">12.5</option>
               <option value="13">13</option>
               <option value="13.5">13.5</option>
            </select>
         </div>
         <div class="form-group">
            <label for="sneaker_brand_id">Sneaker Brand</label>
            <select class="form-control" name="sneaker_brand_id" id="sneaker_brand_id" required>
               <option value="" selected hidden disabled>Select a brand</option>
               <?php
                  foreach($brands as $brand): ?>
               <option value="<?=$brand['sneaker_brand_id']?>"><?=$brand['sneaker_brand']?></option>
               <?php endforeach ?>
            </select>
         </div>
         <div class="form-group">
            <label for="sneaker_category_id">Sneaker Category</label>
            <select class="form-control" name="sneaker_category_id" id="sneaker_category_id" required>
               <option value="" selected hidden disabled>Select a category</option>
               <?php
                  foreach($categories as $category): ?>
               <option value="<?=$category['category_id']?>"><?=$category['category_name']?></option>
               <?php endforeach ?>
            </select>
         </div>
         <div class="form-group">
            <label for="sneaker_value">Sneaker Value</label>
            <input class="form-control" name="sneaker_value" id="sneaker_value" placeholder="Enter the estimated value...">
         </div>
         <div class="form-group">
            <label for="sneaker_description">Sneaker Description</label>
            <textarea class="form-control" name="sneaker_description" id="sneaker_description" placeholder="Enter a description of the footwear..." rows="3"></textarea>
         </div>
         <?php if(isset($_GET['message']) && $_GET['message'] == 'invalid'):?>
         <div class="fluid alert alert-danger alert-dismissible fade show" role="alert" style="width: 400px;">
            The image you tried to upload was invalid..
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <?php endif ?>
         <div class="form-group">
            <label for="sneaker_image_path">Submit an image</label>
            <input type="file" class="form-control-file" name="sneaker_image_path" id="sneaker_image_path">
         </div>
         <p>
            <input type="hidden" name="user_id_modify" value="<?=$userEditing[0]['user_id']?>"/>
            <input type="hidden" name="user_id_insert" value="<?=$userEditing[0]['user_id']?>"/>
            <input class="btn btn-primary" type="submit" name="command" value="Create" />
         </p>
      </div>
   </form>
</div>
</html>
