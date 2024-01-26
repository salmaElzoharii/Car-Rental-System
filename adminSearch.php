<html>
<style>
    body {
       
        align-items: center;
    }

    
    .btn-group button {
  background-color: #04AA6D; 
  border: 1px solid green; 
  color: white; 
  padding: 10px 24px; 
  cursor: pointer;
  width: 50%; 
  display: block; 
  border-radius: 5px;
  margin: 20px;
}

</style>

<body>
    <?php
    if (isset($_POST['allReservations'])) {
        header("Location: reservationperiods.php");
        exit();
    } else if (isset($_POST['searchByDate'])) {
        header("Location: searchByDate.php");
        exit();
    } else if (isset($_POST['searchByCustomer'])) {
        header("Location: searchByCustomer.php");
        exit();
    } else if (isset($_POST['searchByCar'])) {
        header("Location: searchByCar.php");
        exit();
    }
    ?>
    <form name="search" method="post">
        <div class="btn-group">
        <button  name="allReservations">All Reservations periods</button>
        <button  name="searchByDate">Daily payments</button>
        <button  name="searchByCustomer">Search By Customer Information</button>
        <button  name="searchByCar">Search By Car Information</button>
        </div>
    </form>
</body>

</html>