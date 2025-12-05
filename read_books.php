<?php
// core.php holds pagination variables
include_once 'config/core.php';
// include database and object files
include_once 'config/database.php';
include_once 'objects/book.php';
include_once 'objects/category.php';

// instantiate database and objects
$database = new Database();
$db = $database->getConnection();

$book = new Book($db);
$category = new Category($db);

// query products
$stmt = $book->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();

// set page header
$page_title = "All Books List";
include_once "layout_header.php";

/*
echo "<div class='right-button-margin'>";
echo "<a href='create_product.php' class='btn btn-default pull-right'>Create Product</a>";
echo "</div>";
*/

// display the products if there are any
if($num>0){
    
    echo "<table class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
    echo "<th>Accession No</th>";
    echo "<th>Shelf No</th>";
    echo "<th>Call No</th>";
    echo "<th>Author</th>";
    echo "<th>Title</th>";
    echo "<th>Publisher</th>";
    echo "<th>Released year</th>";
    echo "<th>Status</th>";
    echo "<th>Booking</th>";
    //echo "<th>remark</th>";
    echo "</tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
        
        echo "<tr>";
        echo "<td>{$acc_no}</td>";
        echo "<td>{$shelf_no}</td>";
        echo "<td>{$call_no}</td>";
        echo "<td>{$author}</td>";
        echo "<td><a href=\"#\" data-toggle=\"popover\" title=\"Book Description\" data-content=\"{$description}\">{$title}</a></td>";
        echo "<td>{$publisher}</td>";
        echo "<td>{$released_year}</td>";
        if($status==1)
        {
            
            echo "<td style=\"color:green\";>Available</td>";
        }
        else
        {
            echo "<td style=\"color:red\";>Not available</td>";
            
        }
        echo "<td><a href=\"booking.php?call_no=".$call_no."&title=".$title."\">Book</a></td>";
       //echo "<td>{$remark}</td>";        
        echo "</tr>";
        
    }
    
    echo "</table>";
    // the page where this paging is used
    $page_url = "read_books.php?";
    
    // count all products in the database to calculate total pages
    $total_rows = $book->countAll();
    
    // read_template.php controls how the product list will be rendered
   // include_once "read_template.php";
    
    // paging buttons here
    include_once 'paging.php';
}

// tell the user there are no products
else{
    echo "<div class='alert alert-info'>No products found.</div>";
}

// set page footer
include_once "layout_footer.php";
?>
