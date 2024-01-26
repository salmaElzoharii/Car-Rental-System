<html>
<style>
    table,
    th,
    td {
        border: 1px solid black;
    }
</style>

<body>

    <form method="post" action="searchByCar.php">
        <div>
            <label for="plate_id">Enter the Car ID:</label>
            <input type="text" id="plate_id" name="plate_id">
        </div>
        <div>
            <label for="startDate">Enter the start Date:</label>
            <input type="date" id="startDate" name="startDate">
        </div>
        <div>
            <label for="endDate">Enter the end Date:</label>
            <input type="date" id="endDate" name="endDate">
        </div>
        <button id="displayCar" name="displayCar">display</button>
    </form>
    <?php
    include 'connectingDatabase.php';
    if (isset($_POST['displayCar'])) {
        $car_id = $_POST['plate_id'];
        $start = $_POST['startDate'];
        $end = $_POST['endDate'];
        $query ="SELECT r.reservation_id, r.reservation_date, r.return_date, r.pickup_date, r.totalPrice, r.numOfDays, car.plate_id,car.price, car.Car_year, car.model, car.availability_status, car.brand, car.location, car.image_path 
        FROM car INNER JOIN reservation AS r ON car.plate_id = r.plate_id WHERE return_date<='$end'and pickup_date>='$start' and car.plate_id='$car_id' ;";
        $result = $db->query($query);
        if ($result->num_rows > 0) {
            ?>

            <table style="width:100%">
                <tr>
                <th>reservation_id</th>
                        <th>reservation_date</th>
                        <th>return_date</th>
                        <th>pickup_date</th>
                        <th>totalPrice</th>
                        <th>numOfDays</th>
                        <th>plate_id</th>
                        <th>car_year</th>
                        <th>model</th>
                        <th>availability_status</th>
                        <th>price</th>
                        <th>brand</th>
                        <th>location</th>   
                </tr>
                <?php
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                    <td>
                            <?php echo $row['reservation_id']; ?>
                        </td>
                        <td>
                            <?php echo $row['reservation_date']; ?>
                        </td>
                        <td>
                            <?php echo $row['return_date']; ?>
                        </td>
                        <td>
                            <?php echo $row['pickup_date']; ?>
                        </td>
                        <td>
                            <?php echo $row['totalPrice']; ?>
                        </td>
                        <td>
                            <?php echo $row['numOfDays']; ?>
                        </td>
                        <td>
                            <?php echo $row['plate_id']; ?>
                        </td>
                        <td>
                            <?php echo $row['Car_year']; ?>
                        </td>
                       
                        <td>
                            <?php echo $row['model']; ?>
                        </td>
                        <td>
                            <?php echo $row['availability_status']; ?>
                        </td>
                        <td>
                            <?php echo $row['price']; ?>
                        </td>
                        <td>
                            <?php echo $row['brand']; ?>
                        </td>
                        <td>
                            <?php echo $row['location']; ?>
                        </td>
                        
                       
                       
                    </tr>
                    <?php
                }
                
                ?>
            </table>
           
            <?php
        } else {
            echo "no available information";  
        }
    }
    ?>
</body>

</html>