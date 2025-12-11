<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
<title>
DSA e-Library
</title>
<script type="text/javascript">
function get_book_cat(catval)
{
	var searchUrl = 'get_rank_exec.php?book_type=' + catval;
	downloadUrl(searchUrl, function(data) {
		document.getElementById("user_type").innerHTML = "";
		var obj=document.getElementById('user_type');
		var xml = data.responseXML;
	    var ranks = xml.documentElement.getElementsByTagName("rank");
	    for (var i = 0; i < ranks.length; i++) {		 
			 opt = document.createElement("option");
             opt.value =ranks[i].getAttribute("id");
             opt.text=ranks[i].getAttribute("name");
             obj.appendChild(opt);
	    }
	});
	function downloadUrl(url, callback) {
	      var request = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;
	      request.onreadystatechange = function() {
	        if (request.readyState == 4) {
	          request.onreadystatechange = doNothing;
	          callback(request, request.status);
	        }
	      };
	   request.open('GET', url, true);
	   request.send(null);
	}
	function doNothing()
	{
	}
}
</script>
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
<h2>ကဏ္ဍအလိုက်စာအုပ်အမျိုးအစားရှာရန်</h2>
<?php
include 'includes/config.php';
?>
<form action="" method="post">
<label>စာအုပ်အမျိုးအစား</label>
<select name="book_type" onchange="get_book_cat(this.value)">
<option>--Select One--</option>
<?php
$query_book_cat="select * from type";
$query_book_cat_result=$conn->query($query_book_cat); 
while ($show_row=$query_book_cat_result->fetch(PDO::FETCH_ASSOC))
{
 $id=$show_row['id'];
 $name=$show_row['name'];
 echo "<option value='$id'>$name</option>";
}
?>
</select>
<br/>
<br/>
<label>Filter</label>
<select name="user_type" id="user_type">
select Student type
<option>Select One</option>
</select>
<input type="submit" name="book_cat_show" value="ရှာပါ" />
</form>
<?php
$limit_count=10;
$num_pages=1;
if(isset($_POST['book_cat_show']) && isset($_POST['user_type'])!="")
{
  $type_book=(int)$_POST['book_type'];
 $student_type=(int)$_POST['user_type'];
 $start=0;
 include 'includes/config.php';
 $query="select * from book where rank=:stu_rank and type=:book_type";
 $stmt=$conn->prepare($query);
 $stmt->execute(array(
 ':stu_rank'=>"$student_type",
 ':book_type'=>"$type_book"
 ));
 $count_rows=$stmt->rowCount();
 if($count_rows>$limit_count)
  {
    $num_pages=ceil($count_rows/$limit_count);
   }
 else 
  {
 	  $num_pages=1;
   }
    $search_main_query="select * from book where rank=:stu_rank and type=:book_type order by id desc LIMIT $start,$limit_count";
	$stmt=$conn->prepare($search_main_query);
	$stmt->execute(array(
	':stu_rank'=>"$student_type",
	':book_type'=>"$type_book"
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
elseif(isset($_GET['page_num'])&&isset($_GET['start'])&&isset($_GET['book_type'])&&isset($_GET['student_type']))
{
	include 'includes/config.php';  
	$num_pages=(int)$_GET['page_num'];
	$start=(int)$_GET['start'];
	$student_type=(int)$_GET['student_type'];
	$type_book=(int)$_GET['book_type'];
	$search_main_query="select * from book where rank=:stu_rank and type=:book_type order by id desc LIMIT $start,$limit_count";
	$stmt=$conn->prepare($search_main_query);
	$stmt->execute(array(
	':stu_rank'=>"$student_type",
	':book_type'=>"$type_book"
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
   echo '<a href="book_cat.php?start='.($start - $limit_count). '&page_num='.$num_pages.'&student_type='.$student_type.'&book_type='.$type_book.'"> Previous</a> ';
  }
  for($i=1;$i<=$num_pages;$i++)
  {
    if($i !=$current_page)
    {
	  echo '<a href="book_cat.php?start='.($limit_count * ($i - 1)). '&page_num='.$num_pages.'&student_type='.$student_type.'&book_type='.$type_book.'">'.$i.'</a>  ';
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
