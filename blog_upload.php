<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);


require 'db.php';
//geting all the values from session stored
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_SESSION['userid'], $_SESSION['username'], $_SESSION['email'], $_SESSION['lastlogin'])) {
        $user_id = $_SESSION['userid'];
        $username = $_SESSION['username'];
        $email = $_SESSION['email'];
        $lastlogin = $_SESSION['lastlogin'];
    } else {
        // User is not logged in properly, redirect or show error
        die("You must be logged in to upload a blog.");
    }

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES['image']['name']);
    //can also be done using pathinfo_filename

    //collecting values from form
    $blogtitle = $_POST["title"];
    $blogcontent = $_POST["content"];
    // $image = pathinfo($target_file, PATHINFO_FILENAME);
    $image = !empty($_FILES['image']['name']) ? pathinfo($target_file, PATHINFO_FILENAME) : null;


    //if blog id exist update it else insert new
    if (isset($_POST['blog_id']) && is_numeric($_POST['blog_id'])) {
        $blog_id = $_POST['blog_id'];
        $sql = "update blogs set title = ? , content = ? , image = ? where blog_id = ? and user_id = ?";
        $pre = $conn->prepare($sql);
        $pre->bind_param("sssii", $blogtitle, $blogcontent, $image, $blog_id, $user_id);

        if ($pre->execute()) {
            $msg =  "Blog updated successfully. <a href=''/php_programming/keshav/blogs.php'>View Blog</a>";
        } else {
            $msg = "Failed to update blog.";
        }
    } else {
        $sql = "insert into blogs(user_id , title , content , image) values(? , ? , ? , ?)";
        $pre = $conn->prepare($sql);
        $pre->bind_param("isss", $user_id, $blogtitle, $blogcontent, $image);

        if ($pre->execute()) {
            $msg = "The uploading is completed and the Database has also been updated ,<a href ='#'>Dashboard</a> or wants to upload more . ";
        } else {
            $msg = "Updation to database was not successful , kindly look into the error. ";
        }
    }



    $pre->close();


    // uploading the image file to uploads folder with perfect name for it


    $flag = 0;
    // if (isset($_POST["submit"])) { //returns false if not posted 
    $check = getimagesize($_FILES["image"]["tmp_name"]); //getImagesize return false if it is not an file , returns meta dtaa as height , weight , type if true
    // print_r($check);
    if ($check !== false) {
        $msg .=  "File is an image - " . $check["mime"] . ".";
        $flag = 1;
    } else {
        $msg .= "File is not an image kindly upload an image.";
        $flag = 0;
    }
    // }

    $fileType = pathinfo($target_file, PATHINFO_EXTENSION);
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
        $msg .= "Sorry the file format is not correct, only JPG, JPEG, PNG & GIF are allowed.";
        $flag = 0;
    }

    if ($_FILES["image"]["size"] > 5000000) {
        $msg = "Sorry , your file is too large to be uploaded. ";
        $flag = 0;
    }

    if (file_exists($target_file)) {
        $msg = "Sorry , The file $target_file already exist in $target_dir .";
        $flag = 0;
    }

    if ($flag == 0) {
        $msg .= "Sorry , your file was not uploaded kinldy check for error. ";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $t = time() . " ";
            $date = date('y-m-d', $t);

            $msg .= "The file " . pathinfo($target_file, PATHINFO_FILENAME) . " has been succesfully uploaded by " . $username . " at $t $date";
            header("Location: /php_programming/keshav/blogs.php");
            exit;
        }
    }
}
// /opt/lampp/htdocs/php_programming/keshav/blogs.php

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog_upload</title>
    <link rel="stylesheet" href="blog.css">
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="logout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        .exist {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 200px;
        }

        .btn-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            text-decoration: none;
            border-radius: 8px;
            box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-link:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }
    </style>

</head>

<body>
    <?php include('header.php'); ?>
    <div class="body">
        <form action="/php_programming/keshav/blog_upload.php" method="POST" enctype="multipart/form-data" class="blog-form">
            <h2 class="head-name">Write a New Blog</h2>

            <label for="title">Title</label>
            <input type="text" name="title" id="title" placeholder="Blog title" required>

            <label for="content">Content</label>
            <textarea name="content" id="content" placeholder="Blog content..." required></textarea>

            <label for="image" class="img-upload">Upload Image</label>
            <input type="file" name="image" class="img-upload" id="image">

            <button type="submit" class="publish">Publish</button>
        </form>
        <div class="exist">
            <a href="./tableview/list.php" class="btn-link">📝 Update Existing Form</a>
        </div>


        <?php if (isset($msg)) : ?>
            <p><?php echo $msg; ?></p>
        <?php endif; ?>
    </div>

    <?php if (isset($_SESSION['userid'], $_SESSION['username'], $_SESSION['email'], $_SESSION['lastlogin'])) { ?>
        <script>
            document.getElementById("login")?.classList.add("hidden");
            document.getElementById("logout")?.classList.remove("hidden");
            document.getElementById('register')?.classList.add("hidden");
        </script>
    <?php } ?>




    <?php include('footer.php') ?>
    <!-- <script type="module" src="./tableview/update.js"></script> -->
</body>

</html>