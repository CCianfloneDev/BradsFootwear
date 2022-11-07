<?php
/*
    Cole Cianflone
    Nov 7th, 2022
    Purpose: Script to process creating, updating, or deleting a category.
*/

// connect to db
require('connect.php');
echo filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if ($_POST['command'] == "Create") {
    if (strlen($_POST['category_name']) > 1) {
        // sanitize title and content
        $category_name   = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        // prepare insert statement
        $query     = "INSERT INTO sneaker_category (category_name) VALUES (:category_name)";
        $statement = $db->prepare($query);
        
        // bind values to insert statement
        $statement->bindValue(':category_name', $category_name);
        
        // send value to DB.
        if ($statement->execute()) {
            // Redirect after update.
            header("Location: index.php");
            
            exit;
        }
    } else {
        echo "<p>Category creation failed.</p>";
    }
} else if ($_POST['command'] == "Update") {
    if (strlen($_POST['category_name']) > 1) {
        // sanitize title and id
        $category_name   = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id              = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
        
        // prepare update statement
        $query     = "UPDATE sneaker_category SET category_name = :category_name WHERE category_id = :category_id";
        $statement = $db->prepare($query);
        
        // bind values to update statement
        $statement->bindValue(':category_name', $category_name);
        $statement->bindValue(':category_id', $id, PDO::PARAM_INT);
        
        // send value to DB.
        if ($statement->execute()) {
            // Redirect after update.
            header("Location: index.php");
            
            exit;
        }
    } else {
        echo "<p>category update failed.</p>";
    }
} else if ($_POST['command'] == "Delete") {
    // sanitze id
    $id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
    
    // prepare delete statement
    $query     = "DELETE FROM sneaker_category WHERE category_id = :category_id";
    $statement = $db->prepare($query);
    
    // bind values to delete statement
    $statement->bindValue(':category_id', $id, PDO::PARAM_INT);
    
    // send value to DB.
    if ($statement->execute()) {
        // Redirect after update.
        header("Location: index.php");
        
        exit;
    }
}