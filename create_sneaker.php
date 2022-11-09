<?php
/*
    Cole Cianflone
    Nov 7th, 2022
    Purpose: Script to create a sneaker.
*/

require("connect.php");
session_start();

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
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>sneaker - create </title>
      <!-- <link rel="stylesheet" href="style.css" type="text/css"> -->
   </head>
   <body>

         <div id="sneaker_to_create">
            <form action="process_sneaker_post.php" method="post" enctype='multipart/form-data'>
               <fieldset>
                  <div class="sneaker">
                    <p>
                        <label for="sneaker_name">Sneaker Name</label>
                        <input name="sneaker_name" id="sneaker_name" placeholder="Enter a sneaker name..." value="" required/>
                     </p>
                     <label for="sneaker_size">Sneaker Size</label>
                        <select name="sneaker_size" id="sneaker_size" required>
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
                     </p>
                     <p>
                        <label for="sneaker_brand_id">Sneaker Brand</label>
                        <select name="sneaker_brand_id" id="sneaker_brand_id" required>
                        <option value="" selected hidden disabled>Select a brand</option>
                            <?php
                            foreach($brands as $brand): ?>
                            <option value="<?=$brand['sneaker_brand_id']?>"><?=$brand['sneaker_brand']?></option>
                            <?php endforeach ?>
                        </select>
                     </p>
                     <p>
                        <label for="sneaker_category_id">Sneaker Category</label>
                        <select name="sneaker_category_id" id="sneaker_category_id" required>
                        <option value="" selected hidden disabled>Select a category</option>
                            <?php
                            foreach($categories as $category): ?>
                            <option value="<?=$category['category_id']?>"><?=$category['category_name']?></option>
                            <?php endforeach ?>
                        </select>
                     </p>

                     <p>
                        <label for="sneaker_value">Sneaker Value</label>
                        <input name="sneaker_value" id="sneaker_value" placeholder="Enter the estimated value..."value=""/>
                     </p>
                     <p>
                        <label for="sneaker_description">Sneaker Description</label>
                        <br>
                        <textarea rows="5" cols="50" name="sneaker_description" placeholder="Enter a description of the footwear..."></textarea>
                     </p>
                     
                     <p>
                        <label for='sneaker_image_path'>Upload an image</label>
                        <input type='file' name='sneaker_image_path' id='sneaker_image_path'>

                     </p>
                     <p>
                        <input type="hidden" name="user_id_modify" value="<?=$userEditing[0]['user_id']?>"/>
                        <input type="hidden" name="user_id_insert" value="<?=$userEditing[0]['user_id']?>"/>
                        <input type="submit" name="command" value="Create" />
                     </p>
                  </div>
               </fieldset>
            </form>
         </div>
   </body>
</html>
