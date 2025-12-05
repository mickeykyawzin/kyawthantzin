<?php
// core.php holds pagination variables
include_once 'config/corehec.php';
 
// include database and object files
include_once 'config/databasehec.php';
include_once 'objects/bookHec.php';
include_once 'objects/categoryHec.php';
 
// instantiate database and product object
$database = new DatabaseHec();
$db = $database->getConnection();

$book = new BookHec($db);

$category = new CategoryHec($db);
// get search term
$search_term=isset($_GET['s']) ? $_GET['s'] : '';
 
$page_title = "You searched for \"{$search_term}\"";
include_once "layout_header.php";
 
// query products
$stmt = $book->search($search_term, $from_record_num, $records_per_page);
 
// specify the page where paging is used
$page_url="search_hec.php?s={$search_term}&";
 
// count total rows - used for pagination
$total_rows=$book->countAll_BySearch($search_term);

// read_template.php controls how the product list will be rendered
include_once "read_template_hec.php";
 
// layout_footer.php holds our javascript and closing html tags
include_once "layout_footer.php";
?>