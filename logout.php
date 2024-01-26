<?php
session_start();
include 'connectingDatabase.php';
session_unset();
session_destroy();
header("Location: Login.html");
die;
?>