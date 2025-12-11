<?php
class BookHec{
    
    // database connection and table name
    private $conn;
    private $table_name = "book";
    
    // object properties
    public $acc_no;
    public $shelf_no;
    public $call_no;
    public $author;
    public $title;
    public $description;	
    public $publisher;
    public $released_year;
    public $status;
    public $remark;
    
    public function __construct($db){
        $this->conn = $db;
    }
    
    // create product method
    function create(){
        
        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    acc_no=:acc_no, shelf_no=:shelf_no, call_no=:call_no, author=:author, title=:title, description=:description, publisher=:publisher, released_year=:released_year, status=:status, remark=:remark";
        
        $stmt = $this->conn->prepare($query);
        
        // posted values
        $this->acc_no=htmlspecialchars(strip_tags($this->acc_no));
        $this->shelf_no=htmlspecialchars(strip_tags($this->shelf_no));
        $this->call_no=htmlspecialchars(strip_tags($this->call_no));
        $this->author=htmlspecialchars(strip_tags($this->author));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->publisher=htmlspecialchars(strip_tags($this->publisher));
        $this->released_year=htmlspecialchars(strip_tags($this->released_year));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->remark=htmlspecialchars(strip_tags($this->remark));
        
        // to get time-stamp for 'created' field
        //$this->timestamp = date('Y-m-d H:i:s');
        
        // bind values
        $stmt->bindParam(":acc_no", $this->acc_no);
        $stmt->bindParam(":shelf_no", $this->shelf_no);
        $stmt->bindParam(":call_no", $this->call_no);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":title", $this->title);
	$stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":publisher", $this->publisher);
        $stmt->bindParam(":released_year", $this->released_year);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":remark", $this->remark);
        
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
        
    }
    
    function readAll($from_record_num, $records_per_page){
        
        $query = "SELECT
                acc_no, shelf_no, call_no, author, title, description,  publisher, released_year, status, remark
            FROM
                " . $this->table_name . "
            ORDER BY
                acc_no DESC
            LIMIT
                {$from_record_num}, {$records_per_page}";
                
                $stmt = $this->conn->prepare( $query );
                $stmt->execute();
                
                return $stmt;
    }
    
    // used for paging products
    public function countAll(){
        
        $query = "SELECT acc_no FROM " . $this->table_name . "";
        
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        
        $num = $stmt->rowCount();
        
        return $num;
    }
    
    // read books by categories with paging
    function byCategories($category, $from_record_num, $records_per_page){

    
                $query = "SELECT
                 acc_no, shelf_no, call_no, author, title, description, publisher, released_year, status, remark
                  FROM
                     " . $this->table_name . ",book_class where (book.remark=book_class.id) and book_class.id=?
                 ORDER BY
                acc_no ASC
                 LIMIT
                  ?, ?";
                
                // prepare query statement
                $stmt = $this->conn->prepare( $query );
                
                // bind variable values
                $search_term = "%{$category}%";
                $stmt->bindParam(1, $category);
                $stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);
                $stmt->bindParam(3, $records_per_page, PDO::PARAM_INT);
                
                // execute query
                $stmt->execute();
                
                // return values from database
                return $stmt;
                
                
                
                
    }
    ///////
    //read bools by categories
    function countAll_byCategories($category){
       
        // select query
        $query = "SELECT
                COUNT(*) as total_rows
            FROM
                " . $this->table_name . ",book_class where (book.remark=book_class.id) and book_class.id=?";
        
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        
        // bind variable values
        $search_term = "%{$category}%";
        $stmt->bindParam(1,$category);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_rows'];
    
    }
    
    // read products by search term
    public function search($search_term, $from_record_num, $records_per_page){
        
        // select query
        $query = "SELECT
                 acc_no, shelf_no, call_no, author, title,  publisher, released_year, status, remark
            FROM
                " . $this->table_name . "
            WHERE
                author LIKE ? OR title LIKE ?  OR released_year LIKE ?
            ORDER BY
                acc_no ASC
            LIMIT
                ?, ?";
        
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        
        // bind variable values
        $search_term = "%{$search_term}%";
        $stmt->bindParam(1, $search_term);
        $stmt->bindParam(2, $search_term);
	$stmt->bindParam(3, $search_term);
        $stmt->bindParam(4, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(5, $records_per_page, PDO::PARAM_INT);
        
        // execute query
        $stmt->execute();
        
        // return values from database
        return $stmt;
    }
    
    public function countAll_BySearch($search_term){
        
        // select query
        $query = "SELECT
                COUNT(*) as total_rows
            FROM
                " . $this->table_name . " 
            WHERE
                author LIKE ? OR title LIKE ? OR released_year LIKE ?";
        
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        
        // bind variable values
        $search_term = "%{$search_term}%";
        $stmt->bindParam(1, $search_term);
        $stmt->bindParam(2, $search_term);
	$stmt->bindParam(3, $search_term);
        
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['total_rows'];
    }
    /* ############### End Method create 8  ###########################*/
}
?>
