<?php
/*
    Cole Cianflone
    Nov 7th, 2022
    Purpose: Script to process creating, updating, or deleting a category.
*/

// connect to db
require('connect.php');

// if ($_POST['command'] == "Create") {
//     if (strlen($_POST['category_name']) > 1) {
//         // sanitize category name
//         $category_name   = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
//         // prepare insert statement
//         $query     = "INSERT INTO sneaker_category (category_name) VALUES (:category_name)";
//         $statement = $db->prepare($query);
        
//         // bind values to insert statement
//         $statement->bindValue(':category_name', $category_name);
        
//         // send value to DB.
//         if ($statement->execute()) {
//             // Redirect after update.
//             header("Location: index.php");
            
//             exit;
//         }
//     } else {
//         echo "<p>Category creation failed.</p>";
//     }
// } else 
if ($_POST['command'] == "Update") {
    if (strlen($_POST['sneaker_brand']) > 1) {
        // sanitize category name and id
        $sneaker_brand   = filter_input(INPUT_POST, 'sneaker_brand', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id              = filter_input(INPUT_POST, 'sneaker_brand_id', FILTER_SANITIZE_NUMBER_INT);
        
        // prepare update statement
        $query     = "UPDATE sneaker_manufacturer SET sneaker_brand = :sneaker_brand WHERE sneaker_brand_id = :sneaker_brand_id";
        $statement = $db->prepare($query);
        
        // bind values to update statement
        $statement->bindValue(':sneaker_brand', $sneaker_brand);
        $statement->bindValue(':sneaker_brand_id', $id, PDO::PARAM_INT);
        
        // send value to DB.
        if ($statement->execute()) {
            // Redirect after update.
            header("Location: index.php");
            
            exit;
        }
    } else {
        echo "<p>Brand update failed.</p>";
    }
} else if ($_POST['command'] == "Delete") {
    // sanitze id
    $id = filter_input(INPUT_POST, 'sneaker_brand_id', FILTER_SANITIZE_NUMBER_INT);
    
    // prepare delete statement
    $query     = "DELETE FROM sneaker_manufacturer WHERE sneaker_brand_id = :sneaker_brand_id";
    $statement = $db->prepare($query);
    
    // bind values to delete statement
    $statement->bindValue(':sneaker_brand_id', $id, PDO::PARAM_INT);
    
    // send value to DB.
    if ($statement->execute()) {
        // Redirect after update.
        header("Location: index.php");
        
        exit;
    }
}