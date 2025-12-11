<?php
// core.php holds pagination variables
include_once 'config/core.php';
// include database and object files
include_once 'config/database.php';
include_once 'objects/borrow_cart.php';

// instantiate database and objects
$database = new Database();
$db = $database->getConnection();

$borrow_list = new Borrow_cart($db);


// query products
$stmt = $borrow_list->readAll_list($from_record_num, $records_per_page);
$num = $stmt->rowCount();

// set page header
$page_title = "စာအုပ်ငှားထားသည့်သူများ စာရင်း";
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
    echo "<th>စဉ်</th>";
    echo "<th>ငှားသူအမှတ်</th>";
    echo "<th>ငှားသူအမျိုးအစား</th>";
    echo "<th>စာအုပ်အမည်</th>";
    echo "<th>ငှားသည့်ရက်စွဲ</th>";
    echo "<th>ပြန်အပ်သည့်ရက်စွဲ</th>";
    echo "<th>ရှိ / မရှိ</th>";
    echo "<th>မှတ်ချက်</th>";
    echo "<th>ကြည့်ရန်</th>";
    echo "</tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
        
        echo "<tr>";
        echo "<td>{$id_record}</td>";
        echo "<td>{$user_id}</td>";
        echo "<td>{$user_type_name}</td>";
        echo "<td>{$title}</td>";
        echo "<td>{$borrow_date}</td>";
        echo "<td>{$return_date}</td>";
       // echo "<td>{$status}</td>";
        if($status==1)
        {
          echo "<td style=\"color:red\";>မအပ်ရသေး</td>";
        }
        else
        {
          echo "<td style=\"color:green\";>အပ်ပြီး</td>";
        }
        echo "<td>{$remark}</td>";
        echo "<td>";
        echo "<a href=view_borrow_list.php?usertype={$user_type}&user_id={$user_id}  class='btn btn-info left-margin'>";
        echo "<span class='glyphicon glyphicon-edit'></span>စာရင်းကြည့်မည် ";
        echo "</td>";
        echo "</tr>";
        
    }
    
    echo "</table>";
    // the page where this paging is used
    $page_url = "borrow_list.php?";
    
    // count all products in the database to calculate total pages
    $total_rows = $borrow_list->countAll_list();
    
    // read_template.php controls how the product list will be rendered
    // include_once "read_template.php";
    
    // paging buttons here
    include_once 'paging.php';
}

// tell the user there are no products
else{
    echo "<div class='alert alert-info'>No Borrow List found.</div>";
}

// set page footer
include_once "layout_footer.php";
?>