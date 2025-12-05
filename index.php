<?php
// include database and object files
include_once 'config/database.php';
include_once 'objects/book.php';
include_once 'objects/category.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// pass connection to objects
$book = new Book($db);
$category = new Category($db);
$page_title = "Categories";
include_once "layout_header.php";


?>
<!-- PHP post code will be here -->
 
<!-- HTML form for creating a product -->

 
 <table  class='table table-hover table-responsive table-bordered'>
 <?php
            // read the product categories from the database
            $stmt = $category->read();
             while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
                 extract($row_category);
                 echo "<tr>";          
                 echo "<td align=\"center\"><a href=\"books_by_cat.php?cat={$id}\">{$class_name}</a></td>";
                 echo "</tr>";
                 
            }
 
?>
</table>
<?php
// footer
include_once "layout_footer.php";
?>