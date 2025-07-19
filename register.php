<?php
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require "db.php";
    $message = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = trim($_POST['username']);
        $password = password_hash($_POST['password'] , PASSWORD_BCRYPT);
        $email = trim($_POST['email']);

        $sql = $conn->prepare("INSERT INTO users(email , username , password) Values(?,?,?)");
        
        $sql->bind_param("sss" , $email , $username , $password);

        if($sql->execute()){
            $message = "Registered successfully , <a href='/php_programming/keshav/login.php'> Login</a>";
            // header("Location: login.php");
        }
        else{
            $message = "Email id already exists . Error : ".$sql->error;
        }

        $sql->close();
    }   
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="logout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


    <style>
        .login-form-wrapper {
            display: flex;
            flex-direction: column ;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            width: 350px;
            gap: 14px;
        }

        .login-form h2 {
            text-align: center;
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .login-form input[type="email"],
        .login-form input[type="password"] {
            padding: 10px 14px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
        }

        .login-form button {
            margin-top: 12px;
            padding: 10px 0;
            font-size: 16px;
            font-weight: 600;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-form button:hover {
            background-color: #45a049;
        }

          .login-form input[type="email"],
        .login-form input[type="password"] ,
        .login-form input[type="text"]:focus {
    border-color: #4CAF50; /* Highlight border on focus */
    }
    </style>






</head>







<body>
    <?php include("header.php"); ?>
    <!-- <div class="body">
        <div class="register">
            <form action="/keshav/register.php" method="post">
                <h2>Register Yourself</h2>
                <input type="email" name="email" id="email" placeholder="Enter your Email-id ">
                <input type="text" name="username" id="username" placeholder="Enter your name ">
                <input type="password" name="password" id="password" placeholder="Enter a password">
                <button type="submit" name="submit">Register</button>
            </form>
        </div>
        <div class="ans">
            <?php if($message): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
        </div>
    </div> -->

    <div class="login-form-wrapper">
            <form action="/php_programming/keshav/register.php" method="post" class="login-form">
                <h2>Register Yourself</h2>
                 
                <input type="email" name="email" id="email" placeholder="Enter your Email-id ">
                <input type="text" name="username" id="username" placeholder="Enter your name ">
                <input type="password" name="password" id="password" placeholder="Enter a password">
                <button type="submit" name="submit">Register</button>
            </form>
        
         

        <div class="ans">
            <?php if ($message): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
        </div>
        <!-- </div> -->
    </div>
    <?php include("footer.php"); ?>
</body>
</html>