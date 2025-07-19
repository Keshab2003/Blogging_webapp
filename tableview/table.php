<?php 
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

 
require "../db.php";

$tableInfo = [];

if (isset($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];
    $user_name = $_SESSION['username'];
    $user_status = $_SESSION['status'];
    $user_email = $_SESSION['email'];

    $sql = "SELECT blog_id ,title, content, image, updated_at FROM blogs WHERE user_id = ?";
    $smtp = $conn->prepare($sql);
    $smtp->bind_param('i', $user_id);
    $smtp->execute();
    $smtp->store_result();

    if ($smtp->num_rows() > 0) {
        $smtp->bind_result($blog_id,$blog_title, $blog_content, $blog_image, $blog_last_updated);
        while ($smtp->fetch()) {
            $tableInfo[] = [
                'blog_id' => $blog_id,
                'title' => $blog_title,
                'content' => $blog_content,
                'image' => $blog_image,
                'last_update_at' => $blog_last_updated
            ];
        }
        echo json_encode($tableInfo);  
    } else {
        echo json_encode(["message" => "$user_name has not published any task"]);
    }
} else {
    echo json_encode(["error" => "User is not logged in."]);
}
?>



