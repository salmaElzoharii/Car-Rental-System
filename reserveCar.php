<!DOCTYPE html>
<html>
<link rel="stylesheet" href="reserveCar.css">

<body>
  <form id="reserveForm" method="get" action="rentCar.php" onsubmit="return validate();">
    <?php

    include 'connectingDatabase.php';
    
    session_start();
    $plate_id = trim($_GET['id']);
    $_SESSION['plate_id']=$plate_id;
    $sql = "SELECT * FROM car where plate_id='$plate_id'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $img_path = $row['image_path'];

    
  //   if (isset($_POST['return'])  and isset($_POST['pick'])){
  //     echo("hii");
  //     $x = trim($_POST["return"]);
  //     $y = trim($_POST["pick"]);
  //     $x = date("Y-m-d", strtotime($x));  
  //     $y = date("Y-m-d", strtotime($y));  
  //     $sql =" SELECT pickup_date,return_date FROM car 
  //     join reservation 
  //     on reservation.plate_id = car.plate_id 
  //     where car.plate_id='$plate_id' 
  //     and (
  //     (return_date > '$x' and pickup_date < '$y')
  //     or pickup_date < '$y' 
  //     or return_date > '$x'
  //     );
  //     ";
  //     $result = $db->query($sql);
  //     if ($result->num_rows > 0){
  //       echo '<script>alert("Car is already rented in this interval");</script>';
  //       header('Location: reserveCar.php');
  //     }
  //     else{
  //       header('Location: rentCar.php');
  //     }
  // }

 
    ?>
    <div class="container">
      <div class="box">
        <img class=img src="car_images/<?php echo $img_path ?>">
      </div>
      <div>
      <?php
        $query = "SELECT availability_status FROM car WHERE image_path='$img_path'";
        $status = $db->query($query);
        if ($status->num_rows > 0) {
          $row = $status->fetch_assoc();
          if($row['availability_status']=='rented')
          {
          echo '<script>document.getElementById("reserveForm").onsubmit = function() { return false; };</script>';
          $_SESSION['alert']="alert";
          header("Location: HomePage.php");
          echo '<script>alert("Car is already rented. Choose another Car.");</script>';
          exit();
        }
        else{
          $_SESSION['alert']="avail";
        }
        }
        
        ?>
        <label for="pickupDate">Enter the pickup Date:</label>
        <input type="date" id="pickupDate" name="pickupDate">
      </div>
      <div>                     
        <label for="returnDate">Enter the return Date:</label>
        <input type="date" id="returnDate" name="returnDate">


      </div>

      <div class="form-btn">
        <input type="submit" class="btn btn-primary" value="Reserve" name="submit">
      </div>
  </form>
  <script>
    function validate() {
      const currentDate = new Date()
      console.log(formatDate(currentDate));
      var pickDate = new Date(document.getElementById('pickupDate').value);
      var returnDate = new Date(document.getElementById('returnDate').value);
      const diffTime = Math.abs(pickDate - returnDate);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      console.log(diffDays);
      if (!pickDate.getTime() || !returnDate.getTime()) {
        alert('Please fill all fields!!');
        return false;
      }
      else if(pickDate<currentDate)
      {
        alert('Enter a Correct pickup date');
        return false;
      }
      else if (returnDate < pickDate) {
        alert('Enter a Correct return date');
        return false;
      }
      
      else if (diffDays > 10) {
        alert('Maximum rental days is 10!!');
        return false;
      }
      // else{

      //   var hiddenField = document.createElement("input");
      //   hiddenField.type = "hidden";
      //   hiddenField.name = "pick";
      //   hiddenField.value = pickDate;

      //   var hiddenField2 = document.createElement("input");
      //   hiddenField2.type = "hidden";
      //   hiddenField2.name = "return";
      //   hiddenField2.value = returnDate;

      //   var form = document.getElementById("reserveForm");
      //   form.appendChild(hiddenField);
      //   form.appendChild(hiddenField2);
      //   form.action = "reserveCar.php";
      //   form.submit();
      // }
     
    }
    function padTo2Digits(num) {
      return num.toString().padStart(2, '0');
    }

    function formatDate(date = new Date()) {
      return [
        date.getFullYear(),
        padTo2Digits(date.getMonth() + 1),
        padTo2Digits(date.getDate()),
      ].join('-');
    }
  </script>
</body>

</html>