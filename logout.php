<?php 
    session_start();

    $username = $_SESSION["username"];
    session_unset();
    session_destroy();

    echo "$username has been loggod out successful";
    header("Location: /opt/lampp/htdocs/php_programming/keshav/login.php");
    exit;

?>