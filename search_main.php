<?php
// core.php holds pagination variables
include_once 'config/coremain.php';
 
// include database and object files
include_once 'config/databasemain.php';
include_once 'objects/bookMain.php';
include_once 'objects/categoryMain.php';
 
// instantiate database and product object
$database = new databaseMain();
$db = $database->getConnection();

$book = new bookMain($db);


$category = new categoryMain($db);
// get search term
$search_term=isset($_GET['s']) ? $_GET['s'] : '';
 
$page_title = "You searched for \"{$search_term}\"";

include_once "layout_header.php";

$total_rows=$book->countAll_BySearch($search_term);

//echo $total_rows;

echo $book->countAll();
// query products
$stmt = $book->search($search_term, $from_record_num, $records_per_page);
 
// specify the page where paging is used
$page_url="search_main.php?s={$search_term}&";
 
// count total rows - used for pagination
$total_rows=$book->countAll_BySearch($search_term);

// read_template.php controls how the product list will be rendered
include_once "read_template_main.php";
 
// layout_footer.php holds our javascript and closing html tags
include_once "layout_footer.php";

?>