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
include('includes/nav.php');
?>
<div id="content">
<div id="searchform">
<form method="post">
  <select name="selecttype">
  <option value="1" >စာအုပ်အမည်</option>
  <option value="2" >စာရေးဆရာအမည်</option>
  </select>
  <input name="txtSearch" type="text" id="search_text"/>
  <input type="submit" name="btmSearch" id="button" value="ရှာပါ" />
</form>
</div>
<br />
<div id="result">
<?php
$num_pages=1;
$limit_count=10;
if(isset($_POST['btmSearch']) && $_POST['txtSearch']!="")
{
  $searchword='%'.$_POST['txtSearch'].'%';   
  $searchtype=$_POST['selecttype'];
  switch($searchtype)
  {
	  case 1:
	  $checktyped="title";
	  break;
	  case 2:
	  $checktyped="author";
	  break;
  }
  $start=0;
  include 'includes/config.php';
  switch($checktyped)
  {
   case "author":
   $search_query="select * from book where author LIKE :searchword order by id desc";
   break;
   case "title":
   $search_query="select * from book where name LIKE :searchword order by id desc";
   break;
  }
  $stmt=$conn->prepare($search_query);
  $stmt->execute(array(
   ':searchword'=>"$searchword"
  ));
  $count_rows=$stmt->rowCount();
  if($count_rows>$limit_count)
  {
   $num_pages=ceil($count_rows/$limit_count);
  }
  if($count_rows<1)
  {
  	echo "<h2>Result Not Found</h2>";
  }
switch($checktyped)
{
	case "author":
	$search_main_query="select * from book where author LIKE :searchword  order by id desc LIMIT $start,$limit_count";
	break;
	case "title":
	$search_main_query="select * from book where name LIKE :searchword  order by id desc LIMIT $start,$limit_count";
	break;
}

$stmt=$conn->prepare($search_main_query);
$stmt->execute(array(	
':searchword'=>"$searchword"
));
echo "<table>"; 
while ($result_row=$stmt->fetch(PDO::FETCH_ASSOC))
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
}
elseif(isset($_GET['search'])&&isset($_GET['page_num'])&&isset($_GET['start'])&&isset($_GET['type']))
{  
	include 'includes/config.php';  
	$searchword=$_GET['search'];
	$num_pages=$_GET['page_num'];
	$start=$_GET['start'];
	$checktyped=$_GET['type'];
	switch($checktyped)
	{
		case "author":
		$search_main_query="select * from book where author LIKE :searchword order by id desc LIMIT $start,$limit_count";
		break;
		case "title":
		$search_main_query="select * from book where name LIKE :searchword order by id desc LIMIT $start,$limit_count";
		break;
	}
	
	$stmt=$conn->prepare($search_main_query);
	$stmt->execute(array(		 
	':searchword'=>"$searchword"
	));
	echo "<table>"; 
	while ($result_row=$stmt->fetch(PDO::FETCH_ASSOC))
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
}
if($num_pages>1)
{
 $current_page=($start/$limit_count)+1;
 if($current_page!=1)
 {
  echo '<a href="search.php?start='.($start - $limit_count). '&page_num='.$num_pages.'&search='.$searchword.'&type='.$checktyped.'"> Previous</a> ';
 }
 for($i=1;$i<=$num_pages;$i++)
 {
   if($i !=$current_page)
   {
	 echo '<a href="search.php?start='.($limit_count * ($i - 1)). '&page_num='.$num_pages.'&search='.$searchword.'&type='.$checktyped.'">'.$i.'</a>  ';
   }
   else
   {
	 echo $i."   ";
   }
  }
} 
?>
</div>
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
