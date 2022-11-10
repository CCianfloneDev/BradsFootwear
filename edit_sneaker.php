<?php
/*
    Cole Cianflone
    Nov 7th, 2022
    Purpose: Script to edit a sneaker.
*/
require("connect.php");
session_start();

// gets id of post
$sneaker_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

// prepare query
$query = "SELECT * FROM sneaker WHERE sneaker_id = :sneaker_id";
$statement = $db->prepare($query);

// bind values to insert statement
$statement->bindValue(":sneaker_id", $sneaker_id, PDO::PARAM_INT);
$statement->execute();
$sneaker = $statement->fetchAll();

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

/* SELECT ALL DATA FROM users table */
$query = "SELECT * FROM user";
$statement = $db->prepare($query); // Returns a PDOStatement object.
$statement->execute(); // The query is now executed.
$users = $statement->fetchAll();

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
      <title>sneaker - Edit </title>
      <!-- <link rel="stylesheet" href="style.css" type="text/css"> -->
   </head>
   <h1><a href="index.php">Home</a></h1>
   <?php if(isset($_GET['redirect']) && $_GET['redirect'] == 'view_sneaker'):?>
      <h2><a href="view_sneaker.php?id=<?=$_GET['id']?>"><-- Return</a></h2>
   <?php endif ?>
   <body>
         <div id="sneaker_to_edit">
            <form action="process_sneaker_post.php" method="post" enctype='multipart/form-data'>
               <fieldset>
                  <div class="sneaker_edit">
                     <p>
                        <label for="sneaker_name">Sneaker Name</label>
                        <input name="sneaker_name" id="sneaker_name" value="<?=$sneaker[0]['sneaker_name']?>"/>
                     </p>
                     <p>
                        <label for="sneaker_size">Sneaker Size</label>
                        <select name="sneaker_size" id="sneaker_size">
                            <option value="<?=$sneaker[0]['sneaker_size']?>" selected hidden><?=$sneaker[0]['sneaker_size']?></option>
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
                        <label for="sneaker_value">Sneaker Value</label>
                        <input name="sneaker_value" id="sneaker_value" value="<?=$sneaker[0]['sneaker_value']?>"/>
                     </p>
                     <p>
                        <label for="sneaker_description">Sneaker Description</label>
                        <br>
                        <textarea rows="5" cols="50" name="sneaker_description"><?=$sneaker[0]['sneaker_description']?></textarea>
                     </p>
                     
                     <p>
                        <label for='sneaker_image_path'>Sneaker Image</label>
                        <input type='file' name='sneaker_image_path' id='sneaker_image_path'>

                     </p>
                     <img src="<?=$sneaker[0]['sneaker_image_path']?>" alt="sneaker-image" width="350" height="250">
                     <p>
                        <label for="sneaker_brand_id">Sneaker Brand</label>
                        <select name="sneaker_brand_id" id="sneaker_brand_id">
                            <?php
                            foreach($brands as $brand): ?>
                            <?php if($sneaker[0]['sneaker_brand_id'] == $brand['sneaker_brand_id']):?>
                              <option value="<?=$brand['sneaker_brand_id']?>" selected hidden><?=$brand['sneaker_brand']?></option>
                            <?php endif ?>
                            <option value="<?=$brand['sneaker_brand_id']?>"><?=$brand['sneaker_brand']?></option>
                            <?php endforeach ?>
                        </select>
                     </p>
                     <p>
                        <label for="sneaker_category_id">Sneaker Category</label>
                        <select name="sneaker_category_id" id="sneaker_category_id">
                            <?php
                            foreach($categories as $category): ?>
                            <?php if($sneaker[0]['sneaker_category_id'] == $category['category_id']):?>
                              <option value="<?=$category['category_id']?>" selected hidden><?=$category['category_name']?></option>
                            <?php endif ?>
                            <option value="<?=$category['category_id']?>"><?=$category['category_name']?></option>
                            <?php endforeach ?>
                        </select>
                     </p>
                     <p>
                        <small>
                            <?=$sneaker[0]['date_modify']?> - last modified
                        </small>
                        <br>
                        <small>
                            <?=$sneaker[0]['date_insert']?> - initial creation
                        </small>
                        <br>
                        <small>
                            last modified by: <?=$users[$sneaker[0]['user_id_modify']-1]['user_name']?>
                        </small>
                        <br>
                        <small>
                            created by: <?=$users[$sneaker[0]['user_id_insert']-1]['user_name']?>
                        </small>
                    </p>
                    </p>
                     <p>
                        <input type="hidden" name="sneaker_id" value="<?=$_GET['id']?>"/>
                        <input type="hidden" name="user_id_modify" value="<?=$userEditing[0]['user_id']?>"/>
                        <input type="hidden" name="user_id_insert" value="<?=$sneaker[0]['user_id_insert']?>"/>
                        <input type="submit" name="command" value="Update" />
                        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this sneaker?')" />
                     </p>
                  </div>
               </fieldset>
            </form>
         </div>
   </body>
</html>
