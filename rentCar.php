<!DOCTYPE html>
<html>
<link rel="stylesheet" href="rentCar.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
<body>
<div class="content">
<form name="rent"  method="post" >
    <div class="col-50">
        <h1>Payment</h1>
        <div class = "container">
        <label for="fname">Accepted Cards</label>
        <div class="icon-container">
            <i class="fa fa-cc-visa" style="color:navy;"></i>
            <i class="fa fa-cc-amex" style="color:blue;"></i>
            <i class="fa fa-cc-mastercard" style="color:red;"></i>
            <i class="fa fa-cc-discover" style="color:orange;"></i>
        </div>
        <div class="row">
            <div class="col-50">
                <label for="ccnum">Credit card number</label>
                <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444" required>
                </div>
        </div>
        <!-- <label for="ccnum">Credit card number</label> -->
        <!-- <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444"> -->
        <div class="row">
            <div class="col-50">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="352" required>
            </div>
            
        </div>
        <div class="button">
           
            <input type="submit" value="PayNow" name="PayNow" id="PayNow" class="btn btn-primary">
   
             
                <br>
            </div>
    </div>

    </div>
</form>
</div>
</div>
    <?php
    include 'connectingDatabase.php';
    session_start();
    $reserveDate = date("Y-m-d");
    $userEmail = $_SESSION['email'];
    $car_id = $_SESSION['plate_id'];
    $customer_info = "SELECT customer_id FROM customer where email='$userEmail'";
    $retreivedId = $db->query($customer_info);
    $row = $retreivedId->fetch_assoc();
    $customer_id = $row['customer_id'];
    $sql = "SELECT * FROM car where plate_id='$car_id'";
    $result = $db->query($sql);
    $carInfo = $result->fetch_assoc();
    $car_price = $carInfo['price'];
    $returnD = trim($_GET['returnDate']);
    $pickD = trim($_GET['pickupDate']);
    $pickupDa = new DateTime($pickD);
    $returnDateTime = new DateTime($returnD);
    $interval = $pickupDa->diff($returnDateTime);
    $days = $interval->days;
    $converted_return = date("Y-m-d", strtotime($returnD));
    $converted_pick = date("Y-m-d", strtotime($pickD));
    $totalPrice = $days * $car_price;
    
    if(isset($_POST['PayNow'])) {
        $reserveQuery = "insert into reservation (reservation_date,return_date,pickup_date,customer_id,plate_id,totalPrice,numOfDays) values ('$reserveDate','$converted_return','$converted_pick','$customer_id','$car_id','$totalPrice','$days')";
        $queryResult = mysqli_query($db, $reserveQuery);
        if ($queryResult) {
            $reservation_id = mysqli_insert_id($db);
            $_SESSION['reserve_id']=$reservation_id;
            echo "Inserted. Reservation ID: " . $reservation_id;
        } else {
            echo "Query Error: " . mysqli_error($db);
        }
        $cardNumber = $_POST['cardnumber'];
        $CVV = $_POST['cvv'];
        $paymentDate = date("Y-m-d");
        $getPrice= "SELECT * FROM reservation where reservation_id= '$reservation_id'";
        $price = $db->query($getPrice);
        $totalPrice = mysqli_fetch_assoc($price);
        $total = $totalPrice['totalPrice'];
    
    
        $sql = "INSERT INTO rent (paymentDate,reservation_id,totalprice,cardNumber,cvv)
                     VALUES ('$paymentDate','$reservation_id','$total','$cardNumber', '$CVV')";
        $result = $db->query($sql);
        if ($result) {
           
            echo "payment successful";
        } else {
            echo "Query Error: " . mysqli_error($db);
        } 
        header("Location: successfulPayment.php");
        exit();
    }

    ?>
  

</body>

</html>