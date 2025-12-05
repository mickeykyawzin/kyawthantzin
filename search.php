<?php
// core.php holds pagination variables
include_once 'config/core.php';

// include database and object files
include_once 'config/database.php';
include_once 'objects/book.php';
include_once 'objects/category.php';

// instantiate database and product object
database = new Database();
db = $database->getConnection();

$book = new Book($db);
$category = new Category($db);

// normalize pagination variables (core.php may set these)
$from_record_num = isset($from_record_num) ? (int)$from_record_num : 0;
$records_per_page = isset($records_per_page) ? (int)$records_per_page : 10;

// get search term (raw for DB), preserve as empty string if missing
$search_term_raw = (string) (filter_input(INPUT_GET, 's', FILTER_UNSAFE_RAW) ?? '');
$search_term_raw = trim($search_term_raw);

// page title (escaped for HTML)
$page_title = "You searched for \"" . htmlspecialchars($search_term_raw, ENT_QUOTES, 'UTF-8') . "\"";
include_once "layout_header.php";

// query products (assumes Book->search uses prepared statements)
$stmt = $book->search($search_term_raw, $from_record_num, $records_per_page);
$num = $stmt ? $stmt->rowCount() : 0;

// build safe page_url for pagination (preserve search term safely)
$page_url = 'search.php?s=' . rawurlencode($search_term_raw) . '&';

// count total rows - used for pagination
total_rows = $book->countAll_BySearch($search_term_raw);

// expose $search_term for the template (template will escape it when rendering)
$search_term = $search_term_raw;

// read_template.php controls how the product list will be rendered
include_once "read_template.php";

// layout_footer.php holds our javascript and closing html tags
include_once "layout_footer.php";
?>