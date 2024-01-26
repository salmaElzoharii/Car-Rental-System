<html>
<style>
    table,
    th,
    td {
        border: 1px solid black;
    }
</style>
<style>
    .f {
        display: none;
    }
</style>

<body>
    <form  class="f" id="id_form" method="post" action="searchByCustomer.php">
        <div>
            <label for="customer_id">Enter the customer ID:</label>
            <input type="text" id="customer_id" name="customer_id">
        </div>
        <button id="display" name="display">display</button>
    </form>
    
    <form class="f" id="name_form"method="post" action="searchByCustomer.php">
        <div>
            <input type="text" id="customer_fname" name="customer_fname" placeholder="Enter first name">
            <input type="text" id="customer_lname" name="customer_lname" placeholder="Enter last name">
        </div>
        <button id="display" name="display">display</button>
    </form>

    <?php
    include 'connectingDatabase.php';
    if (isset($_POST['display'])) {
        $C_id = $_POST['customer_id'];
        $query = "select customer.customer_id,fname,lname,email,DOB,phoneNumber,address,car.model,car.plate_id from customer inner join reservation on customer.customer_id=reservation.customer_id inner join car on car.plate_id=reservation.plate_id where customer.customer_id=$C_id";
        $result = $db->query($query);
        if ($result->num_rows > 0) {
            ?>

            <table style="width:100%">
                <tr>
                    <th>customer_id</th>
                    <th>fname</th>
                    <th>lname</th>
                    <th>email</th>
                    <th>date of birth</th>
                    <th>phoneNumber</th>
                    <th>address</th>
                    <th>model</th>
                    <th>plate_id</th>
                </tr>
                <?php
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
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
                            <?php echo $row['model']; ?>
                        </td>
                        <td>
                            <?php echo $row['plate_id']; ?>
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
<script type="text/javascript">
        function toggleVisibility(id) {
            var forms = document.querySelectorAll('.f');
            forms.forEach(form => {
                if (form.id === id) {
                    form.style.display = 'block';
                } else {
                    form.style.display = 'none';
                }
            });

        }
        </script>

</html>