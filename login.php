<?php
session_start();
    function loginUser($email, $password)
    {
        include 'connectingDatabase.php';
        $user = '';
        $checkEmailQuery = "SELECT * FROM customer WHERE email = ?";
        $checkEmailQueryExec = $db->prepare($checkEmailQuery);
        $checkEmailQueryExec->bind_param("s", $email);
        $checkEmailQueryExec->execute();
        $result = $checkEmailQueryExec->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (md5($password)== $user['C_password']) {
                return $user;
            } else {
                echo "Password verification failed";
                return false; // Password verification failed
            }
        } else {
            echo "Email not found";
            return false; // Email not found
        }
    } 
    if (isset($_POST['u_login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = loginUser($email, $password);
    
        if ($user) {
            $_SESSION['email'] = $user['email'];
            header('Location: HomePage.php'); 
        } 
    }

    function loginAdmin($email, $password)
    {
        include 'connectingDatabase.php';
        $user = '';
        $checkEmailQuery = "SELECT * FROM admin WHERE email = ?";
        $checkEmailQueryExec = $db->prepare($checkEmailQuery);
        $checkEmailQueryExec->bind_param("s", $email);
        $checkEmailQueryExec->execute();
        $result = $checkEmailQueryExec->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (md5($password)== $user['AdminPassword']) {
                return $user;
            } else {
                echo "Password verification failed";
                return false; // Password verification failed
            }
        } else {
            echo "Email not found";
            return false; // Email not found
        }
    }
    
    if (isset($_POST['a_login'])) {
        $email = $_POST['email2'];
        $password = $_POST['password2'];
        $user = loginAdmin($email, $password);
    
        if ($user) {
            header('Location: AdminPage.html'); 
        } 
    }


?>