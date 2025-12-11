<?php
class Category{
    
    // database connection and table name
    private $conn;
    private $table_name = "book_class";
    
    // object properties
    public $id;
    public $class_name;
    public function __construct($db){
        $this->conn = $db;
    }
    
    // create new book_class
    function create(){
        
        
        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    id=:id, class_name=:class_name";
        
        $stmt = $this->conn->prepare($query);
        
        // posted values
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->class_name=htmlspecialchars(strip_tags($this->class_name));
      
        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":class_name", $this->class_name);
        
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
        
    }
    //// End create new book_class
    
    // used by main menu
    function read(){
        //select all data
        $query = "SELECT
                    id, class_name
                FROM
                    " . $this->table_name . "
                ORDER BY
                    id";
        
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        
        return $stmt;
    }
   // End Read module
   
}
 ?>