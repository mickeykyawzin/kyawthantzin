<?php
// core.php holds pagination variables
include_once 'config/core.php';
// include database and object files
include_once 'config/database.php';
include_once 'objects/booking_order.php';
//include_once 'objects/category.php';

// instantiate database and objects
$database = new Database();
$db = $database->getConnection();

$booking= new BookingOrder($db);
//$category = new Category($db);

// query products
$stmt = $booking->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();

// set page header
$page_title = "Order List";
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
    echo "<th>ID</th>";
    echo "<th>ကိုယ်ပိုင်အမှတ်</th>";
    echo "<th>အဆင့်/အမည်</th>";
    echo "<th>ဌာန</th>";
    echo "<th>ဖုန်းနံပါတ်</th>";
    echo "<th>စာအုပ်အမည်</th>";
    echo "<th>မျိုးတူစုအမှတ်</th>";
    echo "<th>လုပ်ဆောင်ရန်</th>";

    echo "</tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
        
        echo "<tr>";
        echo "<td>{$id}</td>";
        echo "<td>{$user_id}</td>";
        echo "<td>{$name}</td>";
        echo "<td>{$department}</td>";
        echo "<td>{$phone_no}</td>";
        echo "<td>{$title}</td>";
        echo "<td>{$call_no}</td>";
        echo "<td>";
        echo "<a href=delete_booking_list.php?id=".$id." class='btn btn-danger delete-object'>";
        echo "<span class='glyphicon glyphicon-remove'></span> Delete";
        echo "</a>";
        echo "</td>";
    }
    
    echo "</table>";
    // the page where this paging is used
    //$page_url = "read_books.php?";
    
    // count all products in the database to calculate total pages
    $total_rows = $booking->countAll();
    
    // read_template.php controls how the product list will be rendered
    // include_once "read_template.php";
    
    // paging buttons here
    include_once 'paging.php';
}

// tell the user there are no products
else{
    echo "<div class='alert alert-info'>No Booking List found.</div>";
}

// set page footer
include_once "layout_footer.php";
?>