<html>
<style>
table, th, td {
  border:1px solid black;
}
</style>
<body>

    <form id="periods" method="post" action="reservationperiods.php">
        <div>
            <label for="startDate">Enter the start Date:</label>
            <input type="date" id="startDate" name="startDate">
        </div>
        <div>
            <label for="endDate">Enter the end Date:</label>
            <input type="date" id="endDate" name="endDate">
        </div>
        <button id="display" name="display">display</button>
    </form>
    <?php
    include 'connectingDatabase.php';
    if (isset($_POST['display'])) {
        $start = $_POST['startDate'];
        $end = $_POST['endDate'];
        $endDate=date("Y-m-d", strtotime($end));
        $query = "select * from reservation inner join car on car.plate_id=reservation.plate_id inner join customer on customer.customer_id=reservation.customer_id where return_date<='$end'and pickup_date>='$start' ";
        $result = $db->query($query);
        if ($result->num_rows > 0) {
            ?>
            <?php
            while ($row = $result->fetch_assoc()) {

                ?>
                
                <table style="width:100%">
                    <tr>
                        <th>reservation_id</th>
                        <th>customer_id</th>
                        <th>fname</th>
                        <th>lname</th>
                        <th>email</th>
                        <th>date of birth</th>
                        <th>phoneNumber</th>
                        <th>address</th>
                        <th>plate_id</th>
                        <th>car_year</th>
                        <th>model</th>
                        <th>availability_status</th>
                        <th>price</th>
                        <th>brand</th>
                        <th>location</th>   
                    </tr>
                    <tr>
                    <td>
                        <?php echo $row['reservation_id']; ?>
                    </td>
                    <td>
                        <?php echo $row['customer_id']; ?>
                    </td>
                    <td>
                        <?php echo $row['fname']; ?>
                    </td>
                    <td>
                        <?php echo $row['lname']; ?>
                    </td>
                    <td>
                        <?php echo $row['email']; ?>
                    </td>
                    <td>
                        <?php echo $row['DOB']; ?>
                    </td>
                    <td>
                        <?php echo $row['phoneNumber']; ?>
                    </td>
                    <td>
                        <?php echo $row['address']; ?>
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
                        <?php echo  $row['location']; ?>
                    </td>

                </tr>
                </table>



            <?php
            }
        }
        else{
            echo "Query Error: " . mysqli_error($db);
        }
    }
    ?>
</body>

</html>