<?php
session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    session_write_close();
} 
else {
    session_unset();
    session_write_close();
    $url = "./index.php";
    header("Location: $url");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="vendor/bootstrap.min.css">
  <link href="assets/img/1.jpg" rel="icon">
  <script src="vendor/jquery.min.js"></script>
  <script src="vendor/popper.min.js"></script>
  <script src="vendor/bootstrap.min.js"></script>
  </head>

<body>

<nav class="nav navbar-nav navbar-expand-sm bg-dark navbar-dark">
  <!-- User Name -->
  <a class="navbar-brand" href="change_password.php">Welcome <?php echo strtoupper($username);?></a>
   
  <!-- Links -->
  <ul class="nav navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="dashboard.php">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="registration.php">Registration</a>
    </li>
    
    <li class="nav-item">
      <a class="nav-link" href="manual_entry.php">Entry</a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" href="auto_entry.php">AutoEntry</a>
    </li> -->
    <li class="nav-item">
      <a class="nav-link" href="reports.php">Reports</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="create_pass.php">Pass</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="veh.php">Vehicle</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="backup.php">Backup</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="contact.php">Contacts</a>
    </li>
    
    <?php 
      if( $_SESSION["username"] == "it2") {
    ?>
      <li class="nav-item">
        <a class="nav-link" href="delete_entry.php">Delete</a>
      </li>
    <?php
      }
    ?>
    <li class="nav-item">
      <a class="nav-link" href="logout.php">Logout</a>
    </li>
 
    
  </ul>

  
</nav>

</body>
</html>
