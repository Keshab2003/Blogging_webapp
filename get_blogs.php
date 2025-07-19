<?php
 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "db.php";
header('Content-Type: application/json');//tells client that the server is sending JSON data not html

$blogs = [];

$sql = "SELECT blogs.*, users.username 
        FROM blogs 
        JOIN users ON blogs.user_id = users.id 
        ORDER BY blogs.updated_at DESC";

$res = $conn->query($sql);

if (!$res) {
    echo json_encode(["error" => "SQL error", "message" => $conn->error]);
    exit;
}

while ($row = $res->fetch_assoc()) {
    $blogs[] = $row;
}

echo json_encode($blogs, JSON_PRETTY_PRINT);


?>
