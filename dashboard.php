<?php include ('navbar.php');
$ip = $_SERVER['REMOTE_ADDR'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Dashboard</title>
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
  <section id="hero" class="d-flex align-items-center">
    <div class="container text-center position-relative" data-aos="fade-in" data-aos-delay="200">
      <h1>Gate In/Out System </h1>
      <h2>A fully automated in-house developed system</h2>
    </div>
  </section>
  <nav class="navbar-nav fixed-bottom bg-dark">
 	  <a style="color:#ffffff;" href="#">Ver 1.0  &copy; Copyright <strong><span>Jagdish Lamba</span></strong>. All Rights Reserved. Your current IP Address is : <?php echo $ip ?>
  </a>
  </nav>
</body>
</html>
