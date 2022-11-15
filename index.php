<?php
    require("connect.php");
    require("templates/header.php");

    if (isset($_GET['sort']) && $_GET['sort'] == 'name'){
        $query = "SELECT * FROM sneaker ORDER BY sneaker_name DESC";
    } else if(isset($_GET['sort']) && $_GET['sort'] == 'brand') {
        $query = "SELECT * FROM sneaker ORDER BY sneaker_brand_id DESC";
    } else if(isset($_GET['sort']) && $_GET['sort'] == 'price') {
        $query = "SELECT * FROM sneaker ORDER BY sneaker_value DESC";
    } else {
        $query = "SELECT * FROM sneaker";
    }

    /* SELECT ALL DATA FROM sneakers table */
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute(); // The query is now executed.
    $sneakers = $statement->fetchAll();

    if ($_POST && $_POST['command'] == 'Search')
    {
        $search_input = filter_input(INPUT_POST, 'search_input', FILTER_SANITIZE_STRING);
        $search = "%".$search_input."%";

        /* SELECT DATA FROM sneakers table */
        $query = "SELECT * FROM sneaker WHERE sneaker_name LIKE :search ORDER BY sneaker_name DESC";
        $statement = $db->prepare($query);
        // bind values to insert statement
        $statement->bindValue(":search", $search);
        $statement->execute();
        $searchResult = $statement->fetchAll();
    }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>HOME</title>
   </head>
   <body>
   <div class="container-fluid">
   </div>
   <div class="container" id="all_footwear">
        <h1>Sneakers</h1>
        <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['admin_is_on'] === 1):?>
        <h2><a href="create_sneaker.php">Create sneaker</a></h2>
        <?php endif ?>
        <div id="search_form">
            <form class="form-inline" action="index.php?searched=true" method="post">
               <fieldset>
                  <div class="search">
                  <h2>Search for sneakers!</h2>
                     <p>
                        <input class="form-control mr-sm-2" name="search_input" type="search" id="search_input" style="width:400px;" placeholder="Search by name of sneaker, value, or size of sneaker..." value=""/>
                     </p>
                     <p>
                        <input class="btn btn-primary" type="submit" name="command" value="Search" />
                     </p>
                  </div>
               </fieldset>
            </form>
         </div>
            <?php if(!isset($_GET['searched'])):?>
         <div class="row">
        <div class="col-sm">
         <h1><a href="index.php">Default sort</a></h1>
        </div>
        <div class="col-sm">
         <h1><a href="index.php?sort=name">Sort by name &#9660;</a></h1>
        </div>
         <div class="col-sm">
         <h1><a href="index.php?sort=brand">Sort by brand &#9660;</a></h1>
         </div>
         <div class="col-sm">
         <h1><a href="index.php?sort=price">Sort by price &#9660;</a></h1>
         </div>
        </div>
        <?php endif ?>
        <?php if($_POST) :?>
            <h2><a href="index.php?reset=true">View all sneakers</a></h2>
            <?php foreach($searchResult as $sneaker):?>
                <h2><?=$sneaker['sneaker_name']?> 
                 <small><a class="badge badge-primary" href="view_sneaker.php?id=<?=$sneaker['sneaker_id']?>">View Sneaker</a></small>
                <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['admin_is_on'] === 1):?>
                || <small><a class="badge badge-info" href="edit_sneaker.php?id=<?=$sneaker['sneaker_id']?>">edit</a></small>
                <?php endif ?>
            </h2>
            <?php endforeach ?>
        <?php elseif(!$_POST || $_GET['reset'] == true): ?>
        <?php foreach($sneakers as $sneaker): ?>
            <h2><?=$sneaker['sneaker_name']?> 
                 <small><a class="badge badge-primary" href="view_sneaker.php?id=<?=$sneaker['sneaker_id']?>">View Sneaker</a></small>
                <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['admin_is_on'] === 1):?>
                || <small><a href="edit_sneaker.php?id=<?=$sneaker['sneaker_id']?>" class="badge badge-info">edit</a></small>
                <?php endif ?>
            </h2>
        <?php endforeach ?>
        <?php endif ?>
    </div>
   </body>
</html>
