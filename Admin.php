<html>
<link rel="stylesheet" href="admin.css">
<?php
include 'connectingDatabase.php';
function checkPlateExists($plate_id)
{
    //Get Record that Contain The plate_id From car Table
    include 'connectingDatabase.php';
    $checkQuery = "SELECT * FROM car WHERE plate_id = ?";
    $checkplateQueryExec = $db->prepare($checkQuery); 
    $checkplateQueryExec->bind_param("s", $plate_id);
    $checkplateQueryExec->execute();
    $checkplateExists = $checkplateQueryExec->get_result();
    if ($checkplateExists->num_rows > 0) {
        echo ('PLate_id Already in Use Please Check your plate_id');
        return true;
    } else {
        return false; 
    }
}

function addCar(array $data) {
    include 'connectingDatabase.php'; 

    if (checkPlateExists($data['plate_id'])) { 
        return; 
    }
    $query = "INSERT INTO car (plate_id,Car_year,model,availability_status,price,brand,`location`,image_path) VALUES (?, ?, ?,?,?,?,?,?)"; //Query of Inserting Data in User Table
    $stmt = $db->prepare($query);
    if (!$stmt) {
        // echo "Prepare failed: (" . $db->errno . ") " . $db->error;
        return false;
    }
    $stmt->bind_param("ssssssss", $data['plate_id'],$data['Car_year'],$data['model'],$data['availability_status'],$data['price'],$data['brand'],$data['location'],$data['image_path']); 
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        return false; 
    }
    return true;
    
}
if (isset($_POST['add'])) {
    $data['plate_id'] =  $_POST['plate'];
    $data['Car_year'] =  $_POST['year'];
    $data['availability_status'] = $_POST['status'];
    $data['model'] =  $_POST['model'];
    $data['price'] = $_POST['price'];
    $data['brand'] = $_POST['brand'];
    $data['location'] = $_POST['location'];
    $data['image_path'] = $_POST['image'];
    $added = addCar($data);
    
    if ($added) {
       echo("Added Successfully");
       header('Location: AdminPage.html'); 
       exit;
    } 
}
function validate($plate_id)
{
    //Get Record that Contain The Email From user Table
    include 'connectingDatabase.php';
    $checkQuery = "SELECT * FROM car WHERE plate_id = ?";
    $checkplateQueryExec = $db->prepare($checkQuery); 
    $checkplateQueryExec->bind_param("s", $plate_id);
    $checkplateQueryExec->execute();
    $checkplateExists = $checkplateQueryExec->get_result();
    
    if ($checkplateExists->num_rows == 0) {
        echo ("car not found");
        return true;
    } else {
        return false; 
    }
}

function updateCar(array $data) {
    include 'connectingDatabase.php'; 
    if (validate($data['plate_id'])) { 
        return; 
    }
    $query = "UPDATE car SET availability_status = ? WHERE plate_id = ?";
    $stmt = $db->prepare($query);
    if (!$stmt) {
       // echo "Prepare failed: (" . $db->errno . ") " . $db->error;
        return false;
    }
    $stmt->bind_param("ss", $data['availability_status'], $data['plate_id']);
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        return false; 
    }
    return true;
   
}
function displayForCustomer(string $query)
{
    include 'connectingDatabase.php';
    $result = $db->query($query);
    if ($result->num_rows > 0) {
        ?>
      <h1>Search Results</h1>
        <table style="width:100%">
            <tr>
                <th>customer_id</th>
                <th>fname</th>
                <th>lname</th>
                <th>email</th>
                <th>date of birth</th>
                <th>phoneNumber</th>
                <th>address</th>
               
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
                    
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }
    else {
        echo "no available information";  
    }
}
function displayInterval($query)
{
    include 'connectingDatabase.php';
    $result = $db->query($query);
    if ($result->num_rows > 0) {
        ?>
        <h1>Search Results</h1>
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
        <?php
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row['reservation_id']; ?></td>
                <td><?php echo $row['customer_id']; ?></td>
                <td><?php echo $row['fname']; ?></td>
                <td><?php echo $row['lname']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['DOB']; ?></td>
                <td><?php echo $row['phoneNumber']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['plate_id']; ?></td>
                <td><?php echo $row['Car_year']; ?></td>
                <td><?php echo $row['model']; ?></td>
                <td><?php echo $row['availability_status']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['brand']; ?></td>
                <td><?php echo $row['location']; ?></td>
            </tr>
            <?php
        }
        ?>
        </table>
        <?php
    }
    else{
        echo "no available information";  
    }

}


function displaystatus($query)
{
    include 'connectingDatabase.php';
    $result = $db->query($query);
    if ($result->num_rows > 0) {
        ?>
        <h1>Search Results</h1>
        <table style="width:100%">
            <tr>
                <th>plate_id</th>
                <th>availability_status</th>  
            </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row['plate_id']; ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
            <?php
        }
        ?>
        </table>
        <?php
    }
    else{
        echo "no available information";  
    }

}
function displayForCar(string $query)
{
    include 'connectingDatabase.php';
    $result = $db->query($query);
    if ($result->num_rows > 0) {
        ?>
   <h1>Search Results</h1>
        <table style="width:100%">
            <tr>
                <th>plate_id</th>
                <th>car_year</th>
                <th>model</th>
                <th>brand</th>
                <th>location</th>
                <th>price</th>
                <th>status</th>
               
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
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
                        <?php echo $row['brand']; ?>
                    </td>
                    <td>
                        <?php echo $row['location']; ?>
                    </td>
                    <td>
                        <?php echo $row['price']; ?>
                    </td>
                    <td>
                        <?php echo $row['availability_status']; ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }
    else {
        echo "no available information";  
    }
}
function reservationInfo($query)
{
    include 'connectingDatabase.php';
    $result = $db->query($query);
    if ($result->num_rows > 0) {
        ?>
        <h1>Search Results</h1>
        <table style="width:100%">
            <tr>
           
                <th>reservation_id</th>
                <th>reservation_date</th>
                <th>return_date</th>
                <th>pickup_date</th>
                <th>totalPrice</th>
                <th>numOfDays</th>
                
            </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row['reservation_id']; ?></td>
                <td><?php echo $row['reservation_date']; ?></td>
                <td><?php echo $row['return_date']; ?></td>
                <td><?php echo $row['pickup_date']; ?></td>
                <td><?php echo $row['totalPrice']; ?></td>
                <td><?php echo $row['numOfDays']; ?></td>
                
            </tr>
            <?php
        }
        ?>
        </table>
        <?php
    }

}
function displayPayment($query)
{
    include 'connectingDatabase.php';
    $result = $db->query($query);
    if ($result->num_rows > 0) {
        ?>
        <h1>Search Results</h1>
        <table style="width:100%">
            <tr>
           
                <th>rent_id</th>
                <th>Payment date</th>
                <th>reservation Id</th>
                <th>totalPrice</th>
                
                
            </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row['Rent_id']; ?></td>
                <td><?php echo $row['paymentDate']; ?></td>
                <td><?php echo $row['reservation_id']; ?></td>
                <td><?php echo $row['totalprice']; ?></td>
                
            </tr>
            <?php
        }
        ?>
        </table>
        <?php
    }

}
if (isset($_POST['update'])) {
    $data['plate_id'] =  $_POST['plate_id'];
    $data['availability_status'] = $_POST['updated_status'];
    $updated = updateCar($data);

    if ($updated) {
       echo("Updated Successfully");
       header('Location: AdminPage.html'); 
       exit;
    } 
}
if (isset($_POST['displayByid'])) {
    $id=$_POST['customer_id'];
    $query = "select customer_id,fname,lname,email,DOB,phoneNumber,address from customer where customer_id='$id'";
    displayForCustomer($query);     
   }

if (isset($_POST['displayByName'])) {
 $fname=$_POST['customer_fname'];
 $lname=$_POST['customer_lname'];
 $query = "select customer.customer_id,fname,lname,email,DOB,phoneNumber,address from customer where customer.lname='$lname' and customer.fname='$fname'";
 displayForCustomer($query);  
      
}

if (isset($_POST['displayByAddress'])) {
    $Address=$_POST['customer_address'];
    $query = "select customer_id,fname,lname,email,DOB,phoneNumber,address from customer where address ='$Address'";
    displayForCustomer($query);        
   }

if (isset($_POST['displayByEmail'])) {
    $email=$_POST['customer_email'];
    $query = "select customer_id,fname,lname,email,DOB,phoneNumber,address from customer where email ='$email'";
    displayForCustomer($query);        
   }

if (isset($_POST['displayByPhone'])) {
    $phone=$_POST['customer_phone'];
    $query = "select customer_id,fname,lname,email,DOB,phoneNumber,address from customer where phoneNumber ='$phone'";
    displayForCustomer($query);        
   }
   if (isset($_POST['displayByPlate'])) {
    $plate=$_POST['car_plate'];
    $query = "select plate_id,Car_year,model,brand,location,price,availability_status from car where plate_id ='$plate'";
    displayForCar($query);        
   }
   if (isset($_POST['displayByPrice'])) {
    $price=$_POST['car_price'];
    $query = "select plate_id,Car_year,model,brand,location,price,availability_status from car where price ='$price'";
    displayForCar($query);        
   }
   if (isset($_POST['displayByLocation'])) {
    $location=$_POST['car_location'];
    $query = "select plate_id,Car_year,model,brand,location,price,availability_status from car where location ='$location'";
    displayForCar($query);        
   }
   if (isset($_POST['displayByModel'])) {
    $model=$_POST['car_model'];
    $query = "select plate_id,Car_year,model,brand,location,price,availability_status from car where Car_year='$model'";
    displayForCar($query);        
   }
   if (isset($_POST['displayByBrand'])) {
    $brand=$_POST['car_brand'];
    $query = "select plate_id,Car_year,model,brand,location,price,availability_status from car where brand='$brand'";
    displayForCar($query);        
   }
   if (isset($_POST['displayByStatus'])) {
    $status=$_POST['car_status'];
    $query = "select plate_id,Car_year,model,brand,location,price,availability_status from car where availability_status ='$status'";
    displayForCar($query);        
   }



if (isset($_POST['intervalButton'])) {
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $query = "select * from reservation inner join car on car.plate_id=reservation.plate_id inner join customer on customer.customer_id=reservation.customer_id where return_date<='$end'and pickup_date>='$start' ";
    displayInterval($query);
}
if (isset($_POST['reservationDay']))
{
    $day=$_POST['reserveday'];
    $query="select * from reservation where reservation_date='$day'";
    reservationInfo($query);
}
if (isset($_POST['DailyPayments']))
{
    $start=$_POST['startPayment'];
    $end=$_POST['endPayment'];
    $query="select * from rent where paymentDate>='$start' and paymentDate<='$end'";
    displayPayment($query);
}

if (isset($_POST['statusdayy']))
{
    $date=$_POST['statusday'];
    $query="select distinct c.plate_id,
    case when c.availability_status = 'not active' then 'not active' 
    when exists (
        select 1
        from reservation as r
        where r.plate_id = c.plate_id
            and r.pickup_date <= '$date' 
            and r.return_date >= '$date'
    ) then 'rented'
    else 'active'
    end as status
from car as c";
    displaystatus($query);
}

?>
<html>
