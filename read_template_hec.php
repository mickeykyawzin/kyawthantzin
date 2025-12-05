<?php
// search form
echo "<form role='search' action='search_hec.php'>";
echo "<div class='input-group col-md-3 pull-left margin-right-1em'>";
$search_value=isset($search_term) ? "value='{$search_term}'" : "";
echo "<input type='text' class='form-control' placeholder='Search Book Name or Author Name...' name='s' id='srch-term' required {$search_value} />";
echo "<div class='input-group-btn'>";
echo "<button class='btn btn-primary' type='submit'><i class='glyphicon glyphicon-search'></i></button>";
echo "</div>";
echo "</div>";
echo "</form>";
echo "<br/>";
echo "<br/>";
echo "<br/>";

// display the products if there are any
if($total_rows>0){
    
    echo "<table class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
    echo "<th>Accession No</th>";
    echo "<th>Shelf No</th>";
    echo "<th>Call No</th>";
    echo "<th>Author</th>";
    echo "<th>Title</th>";
    echo "<th>Publisher</th>";
    echo "<th>Released year</th>";
    echo "</tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
        
        echo "<tr>";
        echo "<tr>";
        echo "<td>{$acc_no}</td>";
        echo "<td>{$shelf_no}</td>";
        echo "<td>{$call_no}</td>";
        echo "<td>{$author}</td>";
        echo "<td><a href=\"#\" data-toggle=\"popover\" title=\"Book Description\" data-content=\"{$description}\">{$title}</a></td>";
        echo "<td>{$publisher}</td>";
        echo "<td>{$released_year}</td>";        
        echo "</tr>";
        
    }
    
    echo "</table>";
    
    // paging buttons
    include_once 'paging.php';
}

// tell the user there are no products
else{
    echo "<div class='alert alert-danger'>No products found.</div>";
}
?>
