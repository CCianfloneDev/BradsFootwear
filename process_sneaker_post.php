<?php
/*
    Cole Cianflone
    Nov 7th, 2022
    Purpose: Script to process creating a sneaker.
*/

// connect to db
require('connect.php');

// code moves the uploaded image to uploads folder.

$filename = basename($_FILES['sneaker_image_path']['name']); 
$newname = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR. $filename;

move_uploaded_file($_FILES['sneaker_image_path']['tmp_name'], $newname);


if ($_POST['command'] == "Create") {
    if (strlen($_POST['sneaker_name']) > 1) {
        $sneaker_name   = filter_input(INPUT_POST, 'sneaker_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sneaker_size   = filter_input(INPUT_POST, 'sneaker_size', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $sneaker_value  = filter_input(INPUT_POST, 'sneaker_value', FILTER_SANITIZE_NUMBER_INT);
        $sneaker_description = filter_input(INPUT_POST, 'sneaker_description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sneaker_image_path = 'uploads/'.$filename;
        $sneaker_brand_id = filter_input(INPUT_POST, 'sneaker_brand_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sneaker_category_id = filter_input(INPUT_POST, 'sneaker_category_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user_id_modify = filter_input(INPUT_POST, 'user_id_modify', FILTER_SANITIZE_NUMBER_INT);
        $user_id_insert = filter_input(INPUT_POST, 'user_id_insert', FILTER_SANITIZE_NUMBER_INT);

        // prepare update statement
        $query     = "INSERT INTO sneaker (sneaker_name, sneaker_size, sneaker_value, sneaker_description,
                                           sneaker_image_path, sneaker_brand_id, sneaker_category_id, user_id_modify, user_id_insert) 
                      VALUES (:sneaker_name, :sneaker_size, :sneaker_value, :sneaker_description, :sneaker_image_path, :sneaker_brand_id, :sneaker_category_id, :user_id_modify, :user_id_insert)";
        $statement = $db->prepare($query);
        
        // bind values to update statement
        $statement->bindValue(':sneaker_name', $sneaker_name);
        $statement->bindValue(':sneaker_size', $sneaker_size);
        $statement->bindValue(':sneaker_value', $sneaker_value);
        $statement->bindValue(':sneaker_description', $sneaker_description);
        $statement->bindValue(':sneaker_image_path', $sneaker_image_path);
        $statement->bindValue(':sneaker_brand_id', $sneaker_brand_id);
        $statement->bindValue(':sneaker_category_id', $sneaker_category_id);
        $statement->bindValue(':user_id_modify', $user_id_modify);    
        $statement->bindValue(':user_id_insert', $user_id_insert);         
        
        // send value to DB.
        if ($statement->execute()) {
            // Redirect after update.
            header("Location: index.php");
            
            exit;
        }
    } else {
        echo "<p>Sneaker creation failed.</p>";
    }
} else if ($_POST['command'] == "Update") {
    if (strlen($_POST['sneaker_name']) > 1 && strlen($_POST['sneaker_value']) > 1 && strlen($_POST['sneaker_description']) > 1) {
        // sanitize all form fields
        $sneaker_id     = filter_input(INPUT_POST, 'sneaker_id', FILTER_SANITIZE_NUMBER_INT);
        $sneaker_name   = filter_input(INPUT_POST, 'sneaker_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sneaker_size   = filter_input(INPUT_POST, 'sneaker_size', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $sneaker_value  = filter_input(INPUT_POST, 'sneaker_value', FILTER_SANITIZE_NUMBER_INT);
        $sneaker_description = filter_input(INPUT_POST, 'sneaker_description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // if no file was submitted set it to the value currently found in database.
        if ($_FILES['sneaker_image_path']['tmp_name'] == null)
        {
            $query = "SELECT * FROM sneaker WHERE sneaker_id = :sneaker_id";
            $statement = $db->prepare($query);
            // bind values to insert statement
            $statement->bindValue(":sneaker_id", $sneaker_id, PDO::PARAM_INT);
            $statement->execute();
            $sneaker = $statement->fetchAll();

            $sneaker_image_path = $sneaker[0]['sneaker_image_path'];
        } else
        {
            $sneaker_image_path = 'uploads/'.$filename;
        }

        $sneaker_brand_id = filter_input(INPUT_POST, 'sneaker_brand_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sneaker_category_id = filter_input(INPUT_POST, 'sneaker_category_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $date_modify = date('Y-m-d H:i:s');
        $user_id_modify = filter_input(INPUT_POST, 'user_id_modify', FILTER_SANITIZE_NUMBER_INT);

        // prepare update statement
        $query     = "UPDATE sneaker SET sneaker_name = :sneaker_name, sneaker_size = :sneaker_size, sneaker_value = :sneaker_value,
                                         sneaker_description = :sneaker_description, sneaker_image_path = :sneaker_image_path,
                                         sneaker_brand_id = :sneaker_brand_id, sneaker_category_id = :sneaker_category_id,
                                         date_modify = :date_modify, user_id_modify = :user_id_modify
                      WHERE sneaker_id = :sneaker_id";
        $statement = $db->prepare($query);
        
        // bind values to update statement
        $statement->bindValue(':sneaker_id', $sneaker_id, PDO::PARAM_INT);
        $statement->bindValue(':sneaker_name', $sneaker_name);
        $statement->bindValue(':sneaker_size', $sneaker_size);
        $statement->bindValue(':sneaker_value', $sneaker_value);
        $statement->bindValue(':sneaker_description', $sneaker_description);
        $statement->bindValue(':sneaker_image_path', $sneaker_image_path);
        $statement->bindValue(':sneaker_brand_id', $sneaker_brand_id);
        $statement->bindValue(':sneaker_category_id', $sneaker_category_id);       
        $statement->bindValue(':date_modify', $date_modify);
        $statement->bindValue(':user_id_modify', $user_id_modify);  
        
        // send value to DB.
        if ($statement->execute()) {
            // Redirect after update.
            header("Location: index.php");
            
            exit;
        }
    } else {
        echo "<p>sneaker update failed.</p>";
    }
} else if ($_POST['command'] == "Delete") {
    // sanitze id
    $sneaker_id = filter_input(INPUT_POST, 'sneaker_id', FILTER_SANITIZE_NUMBER_INT);
    
    // prepare delete statement
    $query     = "DELETE FROM sneaker WHERE sneaker_id = :sneaker_id";
    $statement = $db->prepare($query);
    
    // bind values to delete statement
    $statement->bindValue(':sneaker_id', $sneaker_id, PDO::PARAM_INT);
    
    // send value to DB.
    if ($statement->execute()) {
        // Redirect after update.
        header("Location: index.php");
        
        exit;
    }
}
