<?php
function checkEmailExists($email)
{
    //Get Record that Contain The Email From user Table
    include 'connectingDatabase.php';
    $checkQuery = "SELECT * FROM customer WHERE email = ?";
    $checkEmailQueryExec = $db->prepare($checkQuery); 
    $checkEmailQueryExec->bind_param("s", $email);
    $checkEmailQueryExec->execute();
    $checkEmailExists = $checkEmailQueryExec->get_result();
    
    // IF There Is an Record in Database that Contain current email
    if ($checkEmailExists->num_rows > 0) {
        echo ('Email Already in Use Please Check your email');
        return true;
    } else {
        return false; 
    }
}

function registerUser(array $data) {
    include 'connectingDatabase.php'; 
    if (checkEmailExists($data["email"])) { //Check Existence of Email Function is Up
        return; 
    }
    $hashedPassword = md5($data["C_password"]);
    // $hashedPassword = password_hash($data["C_password"], PASSWORD_BCRYPT); // Encrypt Password in Database for Security
    $query = "INSERT INTO customer (lname,fname, C_password, email,phoneNumber,address,DOB) VALUES (?, ?, ?,?,?,?,?)"; //Query of Inserting Data in User Table

    $stmt = $db->prepare($query);
    $stmt->bind_param("sssssss", $data["lname"],$data["fname"],$hashedPassword, $data["email"],$data["phoneNumber"],$data["address"],$data["DOB"]); 

    if ($stmt->execute()) { //Execute The Query
        return true;
    } else { // Handle If Any Unexpected Error Occur
        echo('Something went Wrong');
        return false; 
    }

    $stmt->close();
}
if (isset($_POST['register'])) {
    $data['fname'] =  $_POST['fname'];
    $data['lname'] =  $_POST['lname'];
    $data['email'] = $_POST['email'];
    $data['C_password'] =  $_POST['C_password'];
    $data['phoneNumber'] = $_POST['phoneNumber'];
    $data['address'] = $_POST['address'];
    $data['DOB'] = $_POST['DOB'];
     
    $registered = registerUser($data);

    if ($registered) {
       echo("Registered Successfully");
       header('Location: login.html');
       exit;
    } 
}
?>
