<?php
$filedetails=[];
$message = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $filedetails = $_FILES;
   
    // print_r($_FILES);
     
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    // print_r($target_file);
    // print_r($_FILES);
    $flag = 0;

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $imageFileName = strtolower(pathinfo($target_file, PATHINFO_DIRNAME));
    // print_r($imageFileType);
    // print_r($imageFileName);

    if (isset($_POST["submit"])) { //returns false if not posted 
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]); //getImagesize return false if it is not an file , returns meta dtaa as height , weight , type if true
        // print_r($check);
        if ($check !== false) {
            $message .=  "File is an image - " . $check["mime"] . ".";
            $flag = 1;
        } else {
            $message .= "File is not an image kindly upload an image.";
            $flag = 0;
        }
    }

    //checks for weather file already exists in the target directory
    if (file_exists($target_file)) {
        $message .=  "Sorry , the file " . $target_file . " already exists in directory " . $target_dir;
        $flag = 0;
    }


    //check for the valid size of the image can have more constraints as well
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $message .= "Sorry , your file is too large to be uploaded , kindly reduce the size ";
        $flag = 0;
    }


    //check the file type as well
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $message .= "Sorry the file format is not correct, only JPG, JPEG, PNG & GIF are allowed.";
        $flag = 0;
    }

    //if it passes every condition then we must send it to uplaods folder to be stored
    if ($flag == 0) {
        $message .= "Sorry , Your file was not uplaoded . Kindly check the error ";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $message .= "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . "has been uploaded succesfully ";
        } else {
            $message .= "Sorry , there is an error uploading the file";
        }
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="logout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include("header.php"); ?>
    <div class="body">
        <div class="container">
            <h2>Upload an Image</h2>

            <form action="php_programming/keshav/upload.php" method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload" id="fileToUpload">
                <button type="submit" name="submit" class="upload"><i class="fas fa-cloud-upload-alt"></i>Upload</button>

            </form>
        </div>




        <div class="ans">

            <?php
            // print_r($filedetails);
            ?>
            <?php if ($message): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>

        </div>
    </div>
    

     


         <?php if (isset($_SESSION['userid'], $_SESSION['username'], $_SESSION['email'], $_SESSION['lastlogin'])) { ?>
    <script>
      document.getElementById("login")?.classList.add("hidden");
      document.getElementById("logout")?.classList.remove("hidden");
    // document.getElementById('login')?.classList.toggle("hidden");
    document.getElementById('register')?.classList.add("hidden");
    </script>
  <?php } ?>


    <?php include("footer.php"); ?>
</body>

</html>