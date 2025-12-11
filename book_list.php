<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
<title>
DSA e-Library
</title>
</head>
<body>

<div id="wrapper">
<?php
include('includes/header.php');
?>
<?php
/*
  This is Navigation Section  
*/
include('includes/nav.php');
?>
<div id="content">
<table>
<tr><th colspan="2" align="center">Books Result</th></tr>
<?php
include 'includes/config.php';
$limit_count=10;
  if(isset($_GET['page_num']))
  {
 	 $num_pages=$_GET['page_num'];
  }
  else 
  { 
    $result=$conn->query("select * from book order by id desc");
    /* Get count rows from PDO rowCount() function */
    $count_rows=$result->rowCount();
    /*Devide Number of pages from count rows result */
    if($count_rows>$limit_count)
    {
   	 $num_pages=ceil($count_rows/$limit_count);
    }
    else 
    {
   	  $num_pages=1;
    }
   }
  if(isset($_GET['start']))
  {
   $start=$_GET['start'];
  }
  else 
  {
   $start=0;
  }
    /* For Start and End Function */
$result=$conn->query("select * from book order by id desc LIMIT $start,$limit_count");
while ($result_row=$result->fetch(PDO::FETCH_ASSOC))
{
 echo "<tr>";
 echo "<td><img src='".substr($result_row['img_url'],3)."' //></td>";
 echo "<td>Book Name :<b>".$result_row['name']."</b><br/>";
 echo "Book Description :".$result_row['description']."<br/>";
 echo "Book Author :".$result_row['author']."<br/>";
 echo "Book Publisher :".$result_row['publisher']."<br/>";
 echo "<a href='".substr($result_row['file_url'],3)."' target='_blank'>"."Read Book"."</a>";
 echo "</td>";
 echo "</tr>";
}
echo "</table>"; 
 if($num_pages>1)
 {
   $current_page=($start/$limit_count)+1;
   if($current_page!=1)
   {
  	 echo '<a href="book_list.php?start='.($start - $limit_count). '&page_num='.$num_pages.'"> Previous</a> ';
   }
   for($i=1;$i<=$num_pages;$i++)
   {
	if($i !=$current_page)
	 {
	  echo '<a href="book_list.php?start='.($limit_count * ($i - 1)). '&page_num='.$num_pages.'">'.$i.'</a>  ';
	 }
   else
   {
	 echo $i."   ";
   }
   }
 }
?>
</div><!-- #End #content -->
<?php
/* This is sidebar Section*/
include('includes/sidebar.php');
?>
<?php
/*This is Footer Section*/
include('includes/footer.php');
?>
</div><!-- End #wrapper -->
</body>
</html>
