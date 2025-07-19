<?php

session_start();
require "../db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if (isset($_POST['blog_id']) && is_numeric($_POST['blog_id'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $blog_id = $_POST['blog_id'];

        // You should also handle the image if necessary
        $stmt = $conn->prepare("UPDATE blogs SET title = ?, content = ? WHERE blog_id = ?");
        $stmt->bind_param("ssi", $title, $content, $blog_id);

        if ($stmt->execute()) {
            // Redirect to blog list page after successful update
            header("Location: /keshav/tableview/list.php");
            exit();
        } else {
            echo "Update failed: " . $stmt->error;
        }
    } else {
        echo "Invalid blog ID.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog_upload</title>
    <link rel="stylesheet" href="update.css">
    <link rel="stylesheet" href="../blog.css">
    <link rel="stylesheet" href="../register.css">
    <link rel="stylesheet" href="../header.css">
    <link rel="stylesheet" href="../logout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include('../header.php'); ?>
    <div class="body">
        <form action="/keshav/tableview/update.php" method="POST" enctype="multipart/form-data" class="blog-update-form">
            <h2 class="head-name">Update Your Blog</h2>

            <label for="title">Title</label>
            <input type="text" name="title" id="titleToUpdate" placeholder="Blog title" required>

            <label for="content">Content</label>
            <textarea name="content" id="contentToUpdate" placeholder="Blog content..." required></textarea>

            <label for="image" class="img-upload">Upload Image</label>
            <input type="file" name="image" class="img-upload" id="image">

            <button type="submit" class="publish">Update</button>
        </form>


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



    <?php include('../footer.php') ?>
    <script type="module" src="./update.js"></script>
</body>

</html>