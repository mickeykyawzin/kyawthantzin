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

   $category=$_GET['cat'];
   //if($category=="Ref")
  // {
   //  $category="Ref";
  // }
   //$category='"'.$category.'"';
// query products
   $stmt = $book->byCategories($category, $from_record_num, $records_per_page);
   $num = $stmt->rowCount();
  // function countAll_byCategories($category);
// set page header
$page_title = "All Books List from category number:".$category;
include_once "layout_header.php";
if($num>0){
    
    echo "<table class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
    echo "<th>acc_no</th>";
    echo "<th>shelf_no</th>";
    echo "<th>call_no</th>";
    echo "<th>author</th>";
    echo "<th>title</th>";
    echo "<th>publisher</th>";
    echo "<th>released_year</th>";
    echo "<th>status</th>";
    //echo "<th>remark</th>";
    echo "</tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
        
        echo "<tr>";
        echo "<td>{$acc_no}</td>";
        echo "<td>{$shelf_no}</td>";
        echo "<td>{$call_no}</td>";
        echo "<td>{$author}</td>";
        echo "<td>{$title}</td>";
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
        
        //echo "<td>{$remark}</td>";        
        echo "</tr>";
        
    }
    
    echo "</table>";
    // the page where this paging is used
    $page_url = "books_by_cat.php?cat=".$category."&";
    
    // count all products in the database to calculate total pages
    $total_rows = $book->countAll_byCategories($category);
    
    // read_template.php controls how the product list will be rendered
    //include_once "read_template.php";
    
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