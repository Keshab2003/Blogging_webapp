<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="get_blogs.css">
  <link rel="stylesheet" href="register.css">
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="logout.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <style>
    .pagination {
      display: inline-block;
      margin: 20px auto;
    }

    .pagination a {
      color: black;
      /* float: left; */
      padding: 8px 16px;
      text-decoration: none;
      transition: background-color .3s;
      border: 1px solid #ddd;
      margin: 0 4px;
    }

    .pagination a.active {
      background-color: #4CAF50;
      color: white;
      border: 1px solid #4CAF50;
    }

    .pagination a:hover:not(.active) {
      background-color: #ddd;
    }

    .pagination-wrapper {
      display: flex;
      justify-content: center;
    }

    .container-new .img{
      /* height: 100%; */
      /* width: 100%; */
      /* max-height: 140px;
      max-width: 140px; */
      height:190px;
      width: 190px;
    }

    #search-input:focus {
    border-color: #4CAF50; /* Highlight border on focus */
    }

     
  </style>
</head>

<body>
  <?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  include("header.php");
  ?>


  <!-- searching -->
  
<form id="search-form" style="display: flex ;flex-direction : row ;justify-content : center ;gap: 10px; width: 100%; max-width: 800px;margin: 20px auto;">
  <input
    type="text"
    id="search-input"
    placeholder="Search by Title or Author..."
    style="width:600px ; padding: 10px; font-size: 16px;outline: none;transition: border-color 0.3s ease; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
  />
  <button type="submit" style="border : 1px solid  black ; border-radius:10px; font-weight:bold"><i class="fas fa-search" style="display: flex;align-items:center; font-weight:bold;"></i> </button></button>
</form>



  <div class="container-new" id="blog-container"></div>


  <div class="pagination-wrapper">
    <div class="pagination">
      <a href="#">&laquo;</a>

      <?php
      $totalPages = 5; //this has to be done dynamacially not statically


      for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == 1) {
          echo "<a href = '#' class='active'>$i </a>";
        } else {
          echo "<a href = '#' >$i </a>";
        }
      }
      ?>

      <a href="#">&raquo;</a>
    </div>
  </div>

  <?php include("footer.php"); ?>

  <!-- Handle logout button toggle -->
  <?php if (isset($_SESSION['userid'], $_SESSION['username'], $_SESSION['email'], $_SESSION['lastlogin'])) { ?>
    <script>
      document.getElementById("login")?.classList.add("hidden");
      document.getElementById("logout")?.classList.remove("hidden");
      document.getElementById('register')?.classList.add("hidden");
    </script>
  <?php } ?>

<script src="./get_blogs.js"></script>
</body>

</html>