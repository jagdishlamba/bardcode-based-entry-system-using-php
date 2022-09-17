<?php

// include ('navbar.php'); 
include ('connection.php');

if ($conn===false) {
  die("Error: Could not connect. " . mysqli_connect_error());
}

?>
<style>
div.b128{
 border-left: 1px black solid;
 height: 30px;
} 
</style>

<?php
global $char128asc,$char128charWidth;
$char128asc=' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~'; 
$char128wid = array(
 '212222','222122','222221','121223','121322','131222','122213','122312','132212','221213', // 0-9 
 '221312','231212','112232','122132','122231','113222','123122','123221','223211','221132', // 10-19 
 '221231','213212','223112','312131','311222','321122','321221','312212','322112','322211', // 20-29 
 '212123','212321','232121','111323','131123','131321','112313','132113','132311','211313', // 30-39 
 '231113','231311','112133','112331','132131','113123','113321','133121','313121','211331', // 40-49 
 '231131','213113','213311','213131','311123','311321','331121','312113','312311','332111', // 50-59 
 '314111','221411','431111','111224','111422','121124','121421','141122','141221','112214', // 60-69 
 '112412','122114','122411','142112','142211','241211','221114','413111','241112','134111', // 70-79 
 '111242','121142','121241','114212','124112','124211','411212','421112','421211','212141', // 80-89 
 '214121','412121','111143','111341','131141','114113','114311','411113','411311','113141', // 90-99
 '114131','311141','411131','211412','211214','211232','23311120' ); // 100-106

////Define Function
function bar128($text) { // Part 1, make list of widths
 global $char128asc,$char128wid; 
 $w = $char128wid[$sum = 104]; // START symbol
 $onChar=1;
 for($x=0;$x<strlen($text);$x++) // GO THRU TEXT GET LETTERS
 if (!( ($pos = strpos($char128asc,$text[$x])) === false )){ // SKIP NOT FOUND CHARS
 $w.= $char128wid[$pos];
 $sum += $onChar++ * $pos;
 } 
 $w.= $char128wid[ $sum % 103 ].$char128wid[106]; //Check Code, then END
 //Part 2, Write rows
 $html="<table cellpadding=0 cellspacing=0><tr>"; 
 for($x=0;$x<strlen($w);$x+=2) // code 128 widths: black border, then white space
 $html .= "<td><div class=\"b128\" style=\"border-left-width:{$w[$x]};width:{$w[$x+1]}\"></div></td>"; 
 return "$html<tr><td colspan=".strlen($w)."</td></tr></table>"; 
}
?>


<!DOCTYPE html>
<html>
<head>
  <head>
  <title>Generate Pass</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
 </head>
<style>

    body {
      background: lavender;
    }
    
    div.background {
    height: 300px;
    width: 220px;
    position: center;
    margin-top: 30px;
    border: 1px solid #000000;
    }   

    div.heading {
    margin-top: -300px;
    margin-left: auto;
    margin-right: auto;
    width: auto;
    height: 20px;
    } 

    div.img {
      position: relative;
      display:block;
      margin-top: 10px;
      margin-left: auto;
      margin-right: auto;
    }
    
    #photo {
      border-radius: 50%;
    }

    div.detail {
    position: relative;
    margin-left: auto;
    margin-right: auto;
    margin-top: 7px;
    width: 200px;
    text-align:left;
    } 

    div.sdetail {
    position: relative;
    margin-left: auto;
    margin-right: auto;
    margin-top: 3px;
    width: 200px;
    text-align:left;
    } 

    div.footer {
    position: relative;
    display:block;
    width: 215px;
    height: 20px;
    margin-top: 3px;
    border: 3px solid #000000;
    text-align:center;
    }

    div.barcode {
    padding: 2px;
    background: white;
    position: relative;
    margin-left: auto;
    margin-right: auto;
    width: 215px;
    height: 30px;
    margin-top: 5px;
    } 
    
   

    div.button {
    position: relative;
    margin-left: auto;
    margin-right: auto;
    margin-top: 10px;
    text-align:center;
    }

    

    @media print {
      .button {
        visibility: hidden;
      }
      div.card {
        visibility: visible;
        background-image: url('assets/img/back.jpg') !important;
       
        -webkit-print-color-adjust : exact;
        
      }
        
    }



</style>
</head>
<?php
   if(isset($_POST['g_submit']))
  {
  $unique_id=$_POST['unique_id'];
  $unique_id=mysqli_real_escape_string($conn,strtoupper($unique_id));
  
  $get_detail= "select * from user_detail where unique_id ='$unique_id'";
    
  $run_detail=mysqli_query($conn, $get_detail);
    
  while ($row_detail=mysqli_fetch_array($run_detail)){
      
      
      $unique_id = $row_detail['unique_id'];
      $img = $row_detail['photo'];

      $rank4=$row_detail['rank'];
      $rank3= "select * from rank where id ='$rank4'";
      $rank2=mysqli_query($conn,$rank3);
      $rank=mysqli_fetch_array($rank2);

      $name = $row_detail['name'];
      $unit = $row_detail['unit'];
      
    
   ?>
<body>
  <center>
<div class="card" id="card">
  <div class="background">
    <img src="assets/img/back.jpg">
  </div>
	<div class="heading"><u><b>IDENTITY CARD</b></u> </div>
  
  <div class="img">
    <img class="image" id="photo" src="images/<?php echo $img; ?>"width="80px"height="100px"style="border:1px solid black;">
  </div>
   <?php
   if(strlen($name) > 17) {

    ?>
    <div class="sdetail"><b>ID: <?php echo $unique_id; ?></b></div>
    <div class="sdetail"><b>RANK: <?php echo $rank['rank']; ?></b></div>
    <div class="sdetail"><b>NAME: <?php echo $name; ?></b></div>
    <div class="sdetail"><b>UNIT: <?php echo $unit; ?></b></div>
    <?php 
   }
   else {
    ?>
    <div class="detail"><b>ID: <?php echo $unique_id; ?></b></div>
    <div class="detail"><b>RANK: <?php echo $rank['rank']; ?></b></div>
    <div class="detail"><b>NAME: <?php echo $name; ?></b></div>
    <div class="detail"><b>UNIT: <?php echo $unit; ?></b></div>
  <?php
  }
  
  ?>
  <div class="barcode"><b><?php echo bar128($unique_id); ?></b></div>
  <div class="footer"><u><b>TEEVRA CHAUKAS</b></u> </div>

</div>
<div class="button">
  <button onclick="window.print()">Print</button>
  <button onclick="window.location.assign('create_pass.php')">Back</button>
</div>
	<?php
}
}
?>
</center>
</body>
</html>