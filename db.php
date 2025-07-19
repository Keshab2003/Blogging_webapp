<?php
    $servername = "localhost";
    $username = "Keshab";
    $password = "Keshab";
    $db = "Blogging";
    

    $conn = new mysqli($servername,$username, $password , $db);

    if($conn->connect_error){
        die("Connection Failed : please try again" . $conn->connect_error);
    }
    else{
        $message =  "Connected Succesfully";
    }
?>