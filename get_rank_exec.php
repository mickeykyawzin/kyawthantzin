<?php
  include 'includes/config.php';
  if(isset($_GET['book_type']))
  {
  	$type_id=$_GET['book_type'];
  	//$type_id=2;
  	$get_rank_result=$conn->query("select distinct rank.id,class from rank,book where (rank.id=book.rank) and book.type=$type_id");
  	$dom = new DOMDocument("1.0");
    $node = $dom->createElement("ranks");
    $parnode = $dom->appendChild($node);
    header("Content-type: text/xml");
    while ($row = $get_rank_result->fetch(PDO::FETCH_ASSOC))
    {
    	$node = $dom->createElement("rank");
    	$newnode = $parnode->appendChild($node);
    	$newnode->setAttribute("id",$row['id']);
    	$newnode->setAttribute("name",$row['class']);    	
    }
    echo $dom->saveXML();
  } 
?>