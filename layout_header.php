<!DOCTYPE html>
<html lang="en">
<head>
 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <title><?php echo $page_title; ?></title>
 
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap-3.3.7/css/bootstrap.min.css" />
  
    <!-- our custom CSS -->
    <link rel="stylesheet" href="libs/css/custom.css" />
    <!-- JavaScript Bundle with Popper -->
    <script src="jquery-3.5.1.js"></script>
  	

  
</head>
<body>
     <!-- include the navigation bar -->
    <?php include_once 'navigation.php'; ?>
<div class="container">
<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();
});
</script>

<?php
 // show page header
echo "<div class='page-header'> <h1>{$page_title}</h1></div>";
?>
