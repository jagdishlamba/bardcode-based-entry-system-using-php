
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
  <title>Manual Entry</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="vendor/registration/bootstrap.min.css">
  <script src="vendor/registration/jquery.min.js"></script>
  <script src="vendor/registration/popper.min.js"></script>
  <script src="vendor/registration/bootstrap.min.js"></script>
</head>
<body>
	
	<div class="container-fluid">
    	<h2 align="center"><u>Manual Entry</u></h2>
		<form method="POST" enctype="multipart/form-data">
	  		<div class="form-row">
	  			<div class="form-group col-md-2">
	      			
	      			<input type="text" class="form-control" id="unique_id" autofocus="autofocus" placeholder="Enter unique ID" name="unique_id" required>
	      		</div>
	      		<div class="form-group col-md-0 ">
			       
			       <button type="submit" value ="submit" name="search" class="btn btn-primary btn-sm form-control">Search</button>
			    </div>
		</form>
	</div>
	<hr>
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
					echo 'alert("Person out!!!");';
					echo 'window.location.assign("manual_entry.php");';
					echo '</script>'; 	
				}
				else
				{
					echo '<script type="text/javascript">';
					echo 'alert("Error!!!");';
					echo 'window.location.assign("manual_entry.php");';
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
					echo 'alert("Person in!!!");';
					echo 'window.location.assign("manual_entry.php");';
					echo '</script>'; 	
				}
				else
				{
					echo '<script type="text/javascript">';
					echo 'alert("Error!!!");';
					echo 'window.location.assign("manual_entry.php");';
					echo '</script>';
				}
			}
		}
		else
		{
			$select="select * from user_detail where unique_id='$unique_id'";
	  
			$run_select=mysqli_query($conn,$select);
			if ($row_getq=mysqli_fetch_array($run_select))
	        {
	        	$unique_id=$row_getq['unique_id'];

	            $rank4=$row_getq['rank'];
	            $rank3= "select * from rank where id ='$rank4'";
				$rank2=mysqli_query($conn,$rank3);
				$rank=mysqli_fetch_array($rank2);


	            $name=$row_getq['name'];
	            $unit=$row_getq['unit'];
	            $user_type=$row_getq['user_type'];

	            $user_category4=$row_getq['user_category'];
	            $user_category3= "select * from user_category where id ='$user_category4'";
				$user_category2=mysqli_query($conn,$user_category3);
				$user_category=mysqli_fetch_array($user_category2);

	            $stay_loc=$row_getq['stay_loc'];
	                        
                $get="select * from user_type where id='$user_type'";
	            $run_get=mysqli_query($conn,$get);
	            $row_get=mysqli_fetch_array($run_get);
            ?>

	            <div class="container-fluid">
	               	<div class="form-row">
					    <div class="form-group col-md-2">
				            <label for="user_category">Unique Id</label>
					            <p class="form-control"><?php echo $unique_id ?></p>
						</div>

								    <div class="form-group col-md-2">
								      <label for="user_category">User Category</label>
								       <p class="form-control"><?php echo $user_category['category_name'] ?></p>
								    </div>
								 
								    
								    <div class="form-group col-md-2">
								      <label for="rank">Rank</label>
								      <p class="form-control"><?php echo $rank['rank'] ?></p>
								    </div>

								    <div class="form-group col-md-4">
								      <label for="name">Name</label>
								      <p class="form-control"><?php echo $name ?></p>
								    </div>

								    <div class="form-group col-md-2">
								      <label for="unit">Unit/ Place</label>
								       <p class="form-control"><?php echo $unit?></p>
								    </div>
						  		


							  	<div class="form-group col-md-2">
							      <label for="user_type">User Type</label>
							       <p class="form-control"><?php echo $row_get['usertype']?></p>
							    </div>
					     	
					  			
					  				

					  			
								  <div class="form-row">
								  <div class="form-group col-md-2">
								    <label for="stay_loc">Stay Loc</label>
								  	<input class="form-control" name="stay_loc" value=<?php echo $stay_loc?>></input>
								  </div>

								 
								  
								  	
								  <div class=" form-group col-md-3" id="div1">
								      <label for="user_type">Date</label>
								      <input type="text" class="form-control" id="date"  name="date" value=<?php echo date('d-m-Y') ?>>
							    </div>

								  <?php

								  if ($stay_loc=='INSIDE') {
								  	?>

								  	 <div class=" form-group col-md-3" id="div1">
								      <label for="user_type">Time Out</label>
								      <input type="time" class="form-control" id="timeout"  name="timeout" value=<?php echo date('H:i:s') ?>>
							    	</div>
								 <?php
								}
								elseif ($stay_loc=='OUTSIDE') {
								  	?>

								  	 <div class=" form-group col-md-3" id="div1">
								      <label for="user_type">Time In</label>
								      <input type="time" class="form-control" id="timein"  name="timein" value=<?php echo date('H:i:s') ?>>
							    	</div>
								<?php
								}
								else {
									// echo "nothing";
								}
								?>
							</div>
						</div>
								<form method="POST">
								<div class="form-row">
								<div class=" form-group col-md-2" id="div1">
									<input type="hidden" name="unique_id" value="<?php echo $unique_id;?>">
								    <label for="user_type">Purpose</label>
								    <input type="text" class="form-control" id="purpose"  name="purpose" placeholder="Enter purpose">
							    </div>

							    <div class=" form-group col-md-2">
									<label for="user_type">Addl Person</label>
								    <input type="tel" class="form-control" id="addl_person"  maxlength="2" name="addl_person" placeholder="Enter addl person">
							    </div>

							    <div class=" form-group col-md-2" id="div1">
									<label for="user_type">Veh No</label>
								    <input type="text" class="form-control" id="vehno"  name="vehno" placeholder="Enter Veh No">
							    </div>
								
							</div>
							<div class="form-row">
								<div class="form-group col-md-0 ">
									<button type="submit" value ="submit" name="submit" class="btn btn-primary btn-sm form-control">Submit</button>
							      
			   					</div>

			   					<div class=" form-group col-md-0 ">
									<button type="submit" class="btn btn-danger btn-sm form-control" onclick="window.location.assign('manual_entry.php')">Cancel</button>
			   					</div>

								</form>
							    
							</div>

					    
					  </div>
				</div>
					
	<?php
		}
	}
		
	}
	else
	  {
	    echo '<script type="text/javascript">';
	    echo 'alert("Data not found!!!");';
	    echo 'window.location.assign("manual_entry.php");';
	    echo '</script>';
	  }
}

if(isset($_POST['submit']))
{

  
  $unique_id=$_POST['unique_id'];
  $unique_id=mysqli_real_escape_string($conn,$unique_id);

  $purpose=$_POST['purpose'];
  $purpose=mysqli_real_escape_string($conn,strtoupper($purpose));

  $addl_person=$_POST['addl_person'];

  $vehno=$_POST['vehno'];
  $vehno=mysqli_real_escape_string($conn,strtoupper($vehno));
  

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
				$insert="update manual_entry set timeout='$time', dateout='$date' where (userid='$userid' and timeout='00:00:00' and dateout='0000-00-00";
				$run_insert=mysqli_query($conn,$insert);
				if($run_insert)
				{
					echo '<script type="text/javascript">';
					echo 'alert("Person out!!!");';
					echo 'window.location.assign("manual_entry.php");';
					echo '</script>'; 	
				}
				else
				{
					echo '<script type="text/javascript">';
					echo 'alert("Error!!!");';
					echo 'window.location.assign("manual_entry.php");';
					echo '</script>';
				}
			}
			elseif ($row_getq['timein'] =="00:00:00")
			{
				$time = date('H:i:s');
				$date = date('Y-m-d');
				$insert="update manual_entry set timein='$time', datein='$date' where (userid='$userid' and timein='00:00:00' and datein='0000-00-00";
				$run_insert=mysqli_query($conn,$insert);
				if($run_insert)
				{
					echo '<script type="text/javascript">';
					echo 'alert("Person in!!!");';
					echo 'window.location.assign("manual_entry.php");';
					echo '</script>'; 	
				}
				else
				{
					echo '<script type="text/javascript">';
					echo 'alert("Error!!!");';
					echo 'window.location.assign("manual_entry.php");';
					echo '</script>';
				}
			}
	    
			else 
		  	{
		  		$insert="insert into manual_entry (datein,timein,dateout,timeout,purpose,addl_person,vehno,userid) values('$datein','$timein','$dateout','$timeout','$purpose','$addl_person','$vehno','$userid')";
		  		
		  		$run_insert=mysqli_query($conn,$insert);
		  		
				if($run_insert)
				{
					echo '<script type="text/javascript">';
					echo 'alert("Entry Successfully Added!!!");';
					echo 'window.location.assign("manual_entry.php");';
					echo '</script>'; 	
				}
				else
				{
					echo '<script type="text/javascript">';
					echo 'alert("Error in adding entry!!!");';
					echo 'window.location.assign("manual_entry.php");';
					echo '</script>';
				}	
			}
		}
		else
		{
			$insert="insert into manual_entry (datein,timein,dateout,timeout,purpose,addl_person,vehno,userid) values('$datein','$timein','$dateout','$timeout','$purpose','$addl_person','$vehno','$userid')";
			
		  		$run_insert=mysqli_query($conn,$insert);
		  		
				if($run_insert)
				{
					echo '<script type="text/javascript">';
					echo 'alert("Entry Successfully Added!!!");';
					echo 'window.location.assign("manual_entry.php");';
					echo '</script>'; 	
				}
				else
				{
					echo '<script type="text/javascript">';
					echo 'alert("Error in adding entry!!!");';
					echo 'window.location.assign("manual_entry.php");';
					echo '</script>';
				}
		}
	}
	else
	{
		echo '<script type="text/javascript">';
		echo 'alert("User not found!!!");';
		echo 'window.location.assign("manual_entry.php");';
		echo '</script>';
	}
}

?>


</body>
</html>