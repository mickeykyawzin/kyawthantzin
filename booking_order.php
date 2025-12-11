<?php
class BookingOrder{
    
    // database connection and table name
    private $conn;
    private $table_name = "booking_system";
    
    // object properties
    public $user_id;
    public $name;
    public $title;
    public $call_no;
    public $department;
    public $phone_no;
    
    public function __construct($db){
        $this->conn = $db;
    }
    
    // create product method
    function create(){
        
        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    user_id=:user_id, name=:name, department=:department, phone_no=:phone_no, title=:title, call_no=:call_no";
        
        $stmt = $this->conn->prepare($query);
        
        // posted values
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->department=htmlspecialchars(strip_tags($this->department));
        $this->phone_no=htmlspecialchars(strip_tags($this->phone_no));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->call_no=htmlspecialchars(strip_tags($this->call_no));

        // bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":department", $this->department);
        $stmt->bindParam(":phone_no", $this->phone_no);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":call_no", $this->call_no);        
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
        
    }
}
?>