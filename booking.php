<?php
// include database and object files
if(isset($_GET['call_no']) && isset($_GET['title']))
{
$call_no = isset($_GET['call_no']) ? $_GET['call_no'] : die('ERROR: missing Caller Number.');
$title = isset($_GET['title']) ? $_GET['title'] : die('ERROR: missing Book Title.');
}
include_once 'config/database.php';
include_once 'objects/book.php';
//include_once 'objects/category.php';
include_once 'objects/booking_order.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// pass connection to objects
$Booking_order = new BookingOrder($db);
//$category = new Category($db);
$page_title = "ကြိုတင်စာရင်းပေးခြင်း";
include_once "layout_header.php";
?>
<!-- PHP post code will be here -->
<?php 
if($_POST){
    $Booking_order->user_id = $_POST['id'];
    $Booking_order->name = $_POST['name'];
    $Booking_order->title = $_POST['title'];
    $Booking_order->call_no = $_POST['caller_no'];
    //echo $_POST['caller_no'];
    if($Booking_order->create()){
        //header('Location:search.php');
        echo "<script>alert('Already Booked'); window.location.href='search.php';</script>";
       // echo "<div class='alert alert-success'>Product was created.</div>";
    }
    
    // if unable to create the product, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create product.</div>";
    }
    
    
     // header('Location:search.php');
  }
?>
 
<!-- HTML form for creating a product -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
 
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>ကိုယ်ပိုင်အမှတ်</td>
            <td><input type='text' name='id'  class='form-control' /></td>
        </tr>
 
        <tr>
            <td>အဆင့်/အမည်</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>
        <tr>
            <td>အကြောင်းအရာ</td>
            <td><textarea name='title' class='form-control'><?php echo $title ;?></textarea></td>
        </tr>
 		<tr>
            <td>မျိုးတူစုအမှတ်</td>
            <td><input type='text' name='caller_no' value="<?php echo $_GET['call_no'] ;?>" class='form-control'/></td>
        </tr>
 		
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">ထည့်သွင်းမည်</button>
            </td>
        </tr>
 
    </table>
</form>
<?php
// footer
include_once "layout_footer.php";
?>