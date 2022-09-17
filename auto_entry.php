
<?php 
include ('navbar.php'); 
include ('connection.php');
if ($conn===false) {
	die("Error: Could not connect. " . mysqli_connect_error());
}
date_default_timezone_set('asia/kolkata');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Auto Entry</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="vendor/registration/bootstrap.min.css">
  <script src="vendor/registration/jquery.min.js"></script>
  <script src="vendor/registration/popper.min.js"></script>
  <script src="vendor/registration/bootstrap.min.js"></script>
</head>
<body>
	<style>
		.hide{
		display:none;
		}
	</style>
	<div class="container-fluid">
    	<h2 align="center"><u>Auto Entry</u></h2>
		<form method="POST" enctype="multipart/form-data">
	  		<div class="form-row">
	  			<div class="form-group col-md-2">
	      			
	      			<input type="text" class="form-control" id="unique_id" autofocus="autofocus" placeholder="Show your ID Card" name="unique_id" required>
	      		</div>
	      		<div class="form-group col-md-0 ">
			       
			       <button type="submit" value ="submit" name="search" class="btn btn-primary btn-sm form-control">Search</button>
   				</div>
		</form>
	</div>
	<hr>
	

             
<?php
if(isset($_POST['search']))
{
	$unique_id=$_POST['unique_id'];
  	$unique_id=mysqli_real_escape_string($conn,$unique_id);

  	$select = "select id,stay_loc from user_detail where unique_id='$unique_id'";

  	$run_select=mysqli_query($conn,$select);
  	if ($row_getq=mysqli_fetch_array($run_select))
    {
    	$userid=$row_getq['id'];
    	$stay_loc = $row_getq['stay_loc'];
    	
    	if ($stay_loc == 'INSIDE') 
	  	{	
		  	$dateout= date('Y-m-d');
		  	$timeout=date('H:i:s');
		  	$datein ="";
		  	$timein = "";
	    }
	    elseif ($stay_loc == 'OUTSIDE')
  	 	{
		  	$datein= date('Y-m-d');
		  	$timein=date('H:i:s');;
		  	$dateout="";	
		  	$timeout="";
		}
  	 	else
  	 	{

  		}
  	
	  	$filter = "select * from manual_entry where userid='$userid' and (timein = '00:00:00' or timeout='00:00:00')";
	  	$run_filter=mysqli_query($conn,$filter);
	  	$row_getq=mysqli_fetch_array($run_filter);
	  	
	  	if ($row_getq)
	  	{
  	
		    if ($row_getq['timeout'] == "00:00:00") 
		    {
		    	$time = date('H:i:s');
		    	$date = date('Y-m-d');
				$insert="update manual_entry set timeout='$time', dateout='$date' where (userid='$userid' and timeout='00:00:00' and dateout='0000-00-00')";
				$run_insert=mysqli_query($conn,$insert);
				if($run_insert)
				{
					echo '<script type="text/javascript">';
					// echo 'alert("Person out!!!");';
					echo 'window.location.assign("auto_entry.php");';
					echo '</script>'; 	
				}
				else
				{
					echo '<script type="text/javascript">';
					echo 'alert("Error!!!");';
					echo 'window.location.assign("auto_entry.php");';
					echo '</script>';
				}
			}
			elseif ($row_getq['timein'] =="00:00:00")
			{
				$time = date('H:i:s');
				$date = date('Y-m-d');
				$insert="update manual_entry set timein='$time', datein='$date' where (userid='$userid' and timein='00:00:00' and datein='0000-00-00')";
				$run_insert=mysqli_query($conn,$insert);
				if($run_insert)
				{
					echo '<script type="text/javascript">';
					// echo 'alert("Person in!!!");';
					echo 'window.location.assign("auto_entry.php");';
					echo '</script>'; 	
				}
				else
				{
					echo '<script type="text/javascript">';
					echo 'alert("Error!!!");';
					echo 'window.location.assign("auto_entry.php");';
					echo '</script>';
				}
			}
	    
			else 
		  	{
		  		$insert="insert into manual_entry (datein,timein,dateout,timeout,userid) values('$datein','$timein','$dateout','$timeout','$userid')";
		  		$run_insert=mysqli_query($conn,$insert);
		  		
				if($run_insert)
				{
					echo '<script type="text/javascript">';
					// echo 'alert("Entry Successfully Added!!!");';
					echo 'window.location.assign("auto_entry.php");';
					echo '</script>'; 	
				}
				else
				{
					echo '<script type="text/javascript">';
					echo 'alert("Error in adding entry!!!");';
					echo 'window.location.assign("auto_entry.php");';
					echo '</script>';
				}	
			}
		}
		else
		{
			$insert="insert into manual_entry (datein,timein,dateout,timeout,userid) values('$datein','$timein','$dateout','$timeout','$userid')";
		  		$run_insert=mysqli_query($conn,$insert);
		  		
				if($run_insert)
				{
					echo '<script type="text/javascript">';
					// echo 'alert("Entry Successfully Added!!!");';
					echo 'added';
					echo 'window.location.assign("auto_entry.php");';
					echo '</script>';
				}
				else
				{
					echo '<script type="text/javascript">';
					echo 'alert("Error in adding entry!!!");';
					echo 'window.location.assign("auto_entry.php");';
					echo '</script>';
				}
		}
	}
	else
	{
		echo '<script type="text/javascript">';
		echo 'alert("User not found!!!");';
		echo 'window.location.assign("auto_entry.php");';
		echo '</script>';
	}

}
?>
</body>
</html>