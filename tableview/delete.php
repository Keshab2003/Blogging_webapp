<?php 
    require "../db.php";
    header('content-Type: application/json');

    if(!isset($_GET['blog_id'])){
        echo json_encode(["success" => false , "message" => "Blog_id is missing"]);
        exit;
    }

    $blog_id = $_GET['blog_id'];
    $sql = "delete from blogs where blog_id = $blog_id";

    if($conn->query($sql)){
        echo json_encode(["success" => true , "message" => "The blog has been deleted"]);
    }
    else{
        echo json_encode(["success" => false, "message" => $conn->error]);
    }

?>