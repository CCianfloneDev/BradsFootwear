<?php
    require("connect.php");
    require("templates/header.php");

    if (isset($_GET['sort']) && $_GET['sort'] == 'nameASC'){
        $query = "SELECT * FROM sneaker ORDER BY sneaker_name ASC";
    } else if(isset($_GET['sort']) && $_GET['sort'] == 'nameDESC') {
        $query = "SELECT * FROM sneaker ORDER BY sneaker_name DESC";
    } 

    else if(isset($_GET['sort']) && $_GET['sort'] == 'priceASC') {
        $query = "SELECT * FROM sneaker ORDER BY sneaker_value ASC";
    } else if(isset($_GET['sort']) && $_GET['sort'] == 'priceDESC') {
        $query = "SELECT * FROM sneaker ORDER BY sneaker_value DESC";
    }
    
    else if(isset($_GET['sort']) && $_GET['sort'] == 'brandASC') {
        $query = "SELECT * FROM sneaker ORDER BY sneaker_brand_id ASC";
    } else if(isset($_GET['sort']) && $_GET['sort'] == 'brandDESC') {
        $query = "SELECT * FROM sneaker ORDER BY sneaker_brand_id DESC";
    }
    
    else if(isset($_GET['sort']) && $_GET['sort'] == 'categoryASC') {
        $query = "SELECT * FROM sneaker ORDER BY sneaker_category_id ASC";
    } else if(isset($_GET['sort']) && $_GET['sort'] == 'categoryDESC') {
        $query = "SELECT * FROM sneaker ORDER BY sneaker_category_id DESC";
    }
    
    else if(isset($_GET['sort']) && $_GET['sort'] == 'sizeASC') {
        $query = "SELECT * FROM sneaker ORDER BY sneaker_size ASC";
    } else if(isset($_GET['sort']) && $_GET['sort'] == 'sizeDESC') {
        $query = "SELECT * FROM sneaker ORDER BY sneaker_size DESC";
    }
    
    else {
        $query = "SELECT * FROM sneaker";
    }

    /* SELECT ALL DATA FROM sneakers table */
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute(); // The query is now executed.
    $sneakers = $statement->fetchAll();

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
                        <input class="form-control mr-sm-2" name="search_input" type="search" id="search_input" style="width:230px;" placeholder="Search by name of sneaker..." value=""/>
                     </p>
                     <p>
                        <input class="btn btn-primary" type="submit" name="command" value="Search" />
                     </p>
                  </div>
               </fieldset>
            </form>
         </div>
        <?php if($_POST) :?>
            <h2><a href="index.php?reset=true">View all sneakers</a></h2>
                <div class="container">
                <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">Sneaker Name</th>
                    <th scope="col">Sneaker Value</th>
                    <th scope="col">Sneaker Brand</th>
                    <th scope="col">Sneaker Category</th>
                    <th scope="col">Sneaker Size</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($searchResult as $sneaker):?>
                    <tr>
                    <td><a href="view_sneaker.php?id=<?=$sneaker['sneaker_id']?>"><?=$sneaker['sneaker_name']?></a></td>
                    <td>$<?=$sneaker['sneaker_value']?></td>
                    <?php foreach($brands as $brand):?>
                        <?php if($brand['sneaker_brand_id'] == $sneaker['sneaker_brand_id']):?>
                            <td><?=$brand['sneaker_brand']?></td>
                        <?php endif ?>
                    <?php endforeach ?>
                    <?php foreach($categories as $category):?>
                        <?php if($category['category_id'] == $sneaker['sneaker_category_id']):?>
                            <td><?=$category['category_name']?></td>
                        <?php endif ?>
                    <?php endforeach ?>
                    <td><?=$sneaker['sneaker_size']?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
                </table>
            </div>
        <?php elseif(!$_POST || $_GET['reset'] == true): ?>
            <div class="container">
                <table class="table table-hover">
                <thead>
                    <tr>
                    <?php if(isset($_GET['sort']) && $_GET['sort'] == 'nameDESC'):?>
                        <th scope="col">Sneaker Name<a href="index.php?sort=nameASC">&#9650;</a></th>
                        <?php else: ?>
                            <th scope="col">Sneaker Name<a href="index.php?sort=nameDESC">&#9660;</a></th>
                    <?php endif ?>
                    <?php if(isset($_GET['sort']) && $_GET['sort'] == 'priceDESC'):?>
                        <th scope="col">Sneaker Value<a href="index.php?sort=priceASC">&#9650;</a></th>
                        <?php else: ?>
                            <th scope="col">Sneaker Value<a href="index.php?sort=priceDESC">&#9660;</a></th>
                    <?php endif ?>
                    <?php if(isset($_GET['sort']) && $_GET['sort'] == 'brandDESC'):?>
                        <th scope="col">Sneaker Brand<a href="index.php?sort=brandASC">&#9650;</a></th>
                        <?php else: ?>
                            <th scope="col">Sneaker Brand<a href="index.php?sort=brandDESC">&#9660;</a></th>
                    <?php endif ?>
                    <?php if(isset($_GET['sort']) && $_GET['sort'] == 'categoryDESC'):?>
                        <th scope="col">Sneaker Category<a href="index.php?sort=categoryASC">&#9650;</a></th>
                        <?php else: ?>
                            <th scope="col">Sneaker Category<a href="index.php?sort=categoryDESC">&#9660;</a></th>
                    <?php endif ?>
                    <?php if(isset($_GET['sort']) && $_GET['sort'] == 'sizeDESC'):?>
                        <th scope="col">Sneaker Size<a href="index.php?sort=sizeASC">&#9650;</a></th>
                        <?php else: ?>
                            <th scope="col">Sneaker Size<a href="index.php?sort=sizeDESC">&#9660;</a></th>
                    <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($sneakers as $sneaker):?>
                    <tr>
                    <td>
                        <a href="view_sneaker.php?id=<?=$sneaker['sneaker_id']?>"><?=$sneaker['sneaker_name']?></a>
                        <?php if(isset($_SESSION['logged_in_user']) && $_SESSION['admin_is_on'] === 1):?>
                            <small><a href="edit_sneaker.php?id=<?=$sneaker['sneaker_id']?>" class="badge badge-info">edit</a></small>
                        <?php endif ?>
                    </td>
                    <td>$<?=$sneaker['sneaker_value']?></td>
                    <?php foreach($brands as $brand):?>
                        <?php if($brand['sneaker_brand_id'] == $sneaker['sneaker_brand_id']):?>
                            <td><?=$brand['sneaker_brand']?></td>
                        <?php endif ?>
                    <?php endforeach ?>
                    <?php foreach($categories as $category):?>
                        <?php if($category['category_id'] == $sneaker['sneaker_category_id']):?>
                            <td><?=$category['category_name']?></td>
                        <?php endif ?>
                    <?php endforeach ?>
                    <td><?=$sneaker['sneaker_size']?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
                </table>
            </div>
        <?php endif ?>
    </div>
   </body>
</html>
