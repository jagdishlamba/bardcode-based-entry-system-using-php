<?php
include ('navbar.php');
include ('connection.php');
date_default_timezone_set('asia/kolkata');
if ($conn===false) {
	die("Error: Could not connect. " . mysqli_connect_error());
}

if(isset($_POST['submit']))
{
	
	$veh_no=$_POST['veh_no'];
	$veh_no=mysqli_real_escape_string($conn,strtoupper($veh_no));
	
	$driver=$_POST['driver'];
	$driver=mysqli_real_escape_string($conn,strtoupper($driver));

	
	$co_driver=$_POST['co_driver'];
	$co_driver=mysqli_real_escape_string($conn,strtoupper($co_driver));

	$dandaman=$_POST['dandaman'];
	$dandaman=mysqli_real_escape_string($conn,strtoupper($dandaman));

	$purpose=$_POST['purpose'];
	$purpose=mysqli_real_escape_string($conn,strtoupper($purpose));

	$misc_detail=$_POST['misc_detail'];
	$misc_detail=mysqli_real_escape_string($conn,strtoupper($misc_detail));

	$in_out=$_POST['in_out'];
	$in_out=mysqli_real_escape_string($conn,strtoupper($in_out));

	$km_out=$_POST['km_out'];
	$time_out = date('H:i:s');
	$date_out = date('Y-m-d');

	$km_in=$_POST['km_in'];
	$time_in = date('H:i:s');
	$date_in = date('Y-m-d');
	
	if ($in_out == "VEH_OUT") {
	
		$insert="insert into veh_entry (veh_no,driver,co_driver,dandaman,purpose,misc_detail,km_out,date_out,time_out) 
			values('$veh_no','$driver','$co_driver','$dandaman','$purpose','$misc_detail','$km_out', '$date_out','$time_out')";

		$run_insert=mysqli_query($conn,$insert);
		if($run_insert)
		{
			echo '<script type="text/javascript">';
			echo 'alert("Entry Successfully Added!!!");';
			echo 'window.location.assign("veh.php");';
			echo '</script>'; 	
		}
		else
		{
			echo '<script type="text/javascript">';
			echo 'alert("Error in Entry!!!");';
			echo 'window.location.assign("veh.php");';
			echo '</script>';
		}
	}
	else 
	{
		$insert="insert into veh_entry (veh_no,driver,co_driver,dandaman,purpose,misc_detail,km_in,date_in,time_in) 
			values('$veh_no','$driver','$co_driver','$dandaman','$purpose','$misc_detail','$km_in', '$date_in','$time_in')";

		$run_insert=mysqli_query($conn,$insert);
		if($run_insert)
		{
			echo '<script type="text/javascript">';
			echo 'alert("Entry Successfully Added!!!");';
			echo 'window.location.assign("veh.php");';
			echo '</script>'; 	
		}
		else
		{
			echo '<script type="text/javascript">';
			echo 'alert("Error in Entry!!!");';
			echo 'window.location.assign("veh.php");';
			echo '</script>';
		}
	}
}


if(isset($_POST['in']))
{
	$sno=$_POST['sno'];

	?>
	<div id="contact-popup">
		        <form class="contact-form" action="" id="contact-form"
		            method="post" enctype="multipart/form-data">
		            <h4><u><center>Veh In Time Detail</center></u></h4>
		            <div>
		            	<input type="hidden" id="sno" name="sno" value="<?php echo $sno; ?>" class="inputBox" />
		            </div>

		                	            
		            <div>
		                <div>
		                    <label>KM In: </label><span id="km-info"
		                        class="info"></span>
		                </div>
		                <div>
		                    <input type="tel" id="km_in" name="km_in"
		                        class="inputBox" required />
		                </div>
		            </div>
		            <div>
		                <div>
		                    <label>Remarks </label><span id="remarks-info"
		                        class="info"></span>
		                </div>
		                <div>
		                    <input type="text" id="remarks" name="remarks"
		                        class="inputBox" />
		                </div>
		            </div>
		            <div>
		                <input type="submit" id="send" name="send_in" value="Send" />

		            </div>
		            <br>
		            <div>
		            	<button type="submit" id="cancel" onclick="window.location.assign('veh.php')">Cancel</button>
		            </div>
		        </form>
		    </div>
<?php
}

if(isset($_POST['out']))
{
	$sno=$_POST['sno'];

	?>
	<div id="contact-popup">
		        <form class="contact-form" action="" id="contact-form"
		            method="post" enctype="multipart/form-data">
		            <h4><u><center>Veh Out Time Detail</center></u></h4>
		            <div>
		            	<input type="hidden" id="sno" name="sno" value="<?php echo $sno; ?>" class="inputBox" />
		            </div>

		                	            
		            <div>
		                <div>
		                    <label>KM Out: </label><span id="km-info"
		                        class="info"></span>
		                </div>
		                <div>
		                    <input type="tel" id="km_out" name="km_out"
		                        class="inputBox" required />
		                </div>
		            </div>
		            <div>
		                <div>
		                    <label>Remarks </label><span id="remarks-info"
		                        class="info"></span>
		                </div>
		                <div>
		                    <input type="text" id="remarks" name="remarks"
		                        class="inputBox" />
		                </div>
		            </div>
		            <div>
		                <input type="submit" id="send" name="send_out" value="Send" />

		            </div>
		            <br>
		            <div>
		            	<button type="submit" id="cancel" onclick="window.location.assign('veh.php')">Cancel</button>
		            </div>
		        </form>
		    </div>
<?php
}


if(isset($_POST['send_in']))
{
	$sno=$_POST['sno'];
	$km_in = $_POST["km_in"];
	$remarks = $_POST["remarks"];
	$select="select * from veh_entry where sno='$sno'";
	$run_select=mysqli_query($conn,$select);
	if($run_select) 
	{
		if(mysqli_num_rows($run_select)!=0)
		{
			$time_in = date('H:i:s');
			$date_in = date('Y-m-d');
			$update= "update veh_entry set date_in ='$date_in',time_in = '$time_in', km_in='$km_in', remarks='$remarks' where sno='$sno'";
	
			$run_insert=mysqli_query($conn,$update);
			if($run_insert)
				{
					echo '<script type="text/javascript">';
					echo 'alert("Time In successfully!!!");';
					echo 'window.location.assign("veh.php");';
					echo '</script>'; 	
				}
			else
			{
				echo '<script type="text/javascript">';
				echo 'alert("Error in Time In!!!");';
				echo 'window.location.assign("veh.php");';
				echo '</script>';
			}

		}
	}
}
if(isset($_POST['send_out']))
{   
	
	$sno=$_POST['sno'];
	$km_out = $_POST["km_out"];
	$remarks = $_POST["remarks"];
	$select="select * from veh_entry where sno='$sno'";
	
	$run_select=mysqli_query($conn,$select);
	if($run_select) 
	{
		if(mysqli_num_rows($run_select)!=0)
		{
			$time_out = date('H:i:s');
			$date_out = date('Y-m-d');
			$update= "update veh_entry set date_out ='$date_out',time_out = '$time_out', km_out='$km_out', remarks='$remarks' where sno='$sno'";
	
			$run_insert=mysqli_query($conn,$update);
			if($run_insert)
				{
					echo '<script type="text/javascript">';
					echo 'alert("Time out successfully!!!");';
					echo 'window.location.assign("veh.php");';
					echo '</script>'; 	
				}
			else
			{
				echo '<script type="text/javascript">';
				echo 'alert("Error in Time In!!!");';
				echo 'window.location.assign("veh.php");';
				echo '</script>';
			}
		}

	}
}

?>




<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
  <title>Veh Detail</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="vendor/registration/bootstrap.min.css">
  <script src="vendor/registration/jquery.min.js"></script>
  <script src="vendor/registration/popper.min.js"></script>
  <script src="vendor/registration/bootstrap.min.js"></script>
  <script src="vendor/jquery-3.2.1.min.js"></script>
  <link rel="stylesheet" href="assets/css/modal_popup.css" />
</head>
<style>
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
</head>
<body>

<h2 align="center"><u>Veh Entry</u></h2>


<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'Entry')">Entry</button>
  <button class="tablinks" onclick="openCity(event, 'Pending')">Pending</button>
  <button class="tablinks" onclick="openCity(event, 'Report')">Report</button>
</div>

<div id="Entry" class="tabcontent">
  <form method="POST" enctype="multipart/form-data">
			<div class="form-row">
			    <div class="form-group col-md-3">
				    <label>Veh No</label>
				     <input type="text" class="form-control" id="veh_no" placeholder="Enter veh no" name="veh_no" required>
		    	</div>
		    	
		    	<div class="form-group col-md-3">
				    <label>Driver</label>
				     <input type="text" class="form-control" id="driver" placeholder="Enter driver name" name="driver" required>
		    	</div>

		    	<div class="form-group col-md-3">
				    <label>Co-Driver</label>
				     <input type="text" class="form-control" id="co_driver" placeholder="Enter co-driver name" name="co_driver" required>
		    	</div>

		    	<div class="form-group col-md-3">
				    <label>Dandaman</label>
				     <input type="text" class="form-control" id="dandaman" placeholder="Enter dandaman name" name="dandaman" >
		    	</div>

		    	<div class="form-group col-md-4">
				    <label>Purpose</label>
				     <input type="text" class="form-control" id="purpose" placeholder="Enter purpose" name="purpose" required>
		    	</div>

		    	<div class="form-group col-md-4">
				    <label>Misc Detail</label>
				     <input type="text" class="form-control" id="misc_detail" placeholder="Enter Misc Detail" name="misc_detail">
		    	</div>

		    	<div class="form-group col-md-4">
				    <input type="radio" onchange="hideA(this)" name="in_out" value="veh_in" id="veh_in">Veh In
				    <input type="radio" onchange="hideB(this)" name="in_out" value="veh_out" id="veh_out">Veh Out
				 </div>

				<div class="form-row" id="A" style="visibility: hidden;">
			    	<div class="form-group col-md-4">
					    <label>KM Out</label>
					     <input type="text" class="form-control" id="km_out" placeholder="Enter KM Out" name="km_out">
			    	</div>
			    	
			    	<div class="form-group col-md-4">
					    <label>Date Out</label>
					     <input type="text" class="form-control" id="date_out" name="date_out" value="<?php echo date('Y-m-d');?>">
			    	</div>

			    	<div class="form-group col-md-4">
					    <label>Time Out</label>
					     <input type="text" class="form-control" id="time_out" name="time_out" value="<?php echo date('H:i:s');?>">
			    	</div>
		    	</div>

		    	<div class="form-row" id="B" style="visibility: hidden;">
			    	<div class="form-group col-md-4">
					    <label>KM In</label>
					     <input type="text" class="form-control" id="km_in" placeholder="Enter KM In" name="km_in">
			    	</div>
			    	
			    	<div class="form-group col-md-4">
					    <label>Date In</label>
					     <input type="text" class="form-control" id="date_in" name="date_in" value="<?php echo date('Y-m-d');?>">
			    	</div>

			    	<div class="form-group col-md-4">
					    <label>Time In</label>
					     <input type="text" class="form-control" id="time_in" name="time_in" value="<?php echo date('H:i:s');?>">
			    	</div>
		    	</div>

		    	<div class="form-row">
				    <div class="form-group col-md-6">
				       	<label></label>
				        <button type="submit" value ="submit" name="submit" class="btn btn-primary btn-sm form-control">Submit</button>
				    </div>
				    <div class="form-group col-md-6">
				       	<label></label>
				        <button type="reset" value ="reset" name="reset" class="btn btn-danger btn-sm form-control">Reset</button>
				    </div>
				</div>
  			</div>
  		</form>
</div>

<div id="Pending" class="tabcontent">
 <div class="row" id="entry_table">
		<div class="col-md-12">
			<div class="table-responsive">
						<table class="display table table-striped table-hover" >
							<thead>
								<tr>
									<th>Veh No</th>
									<th>Driver</th>
									<th>Co-Driver</th>
									<th>Dandaman</th>
									<th>Purpose</th>
									<th>Misc_detail</th>
									<th>KM Out</th>
									<th>KM In</th>
									<th>Date Out</th>
									<th>Time Out</th>
									<th>Date In</th>
									<th>Time In</th>
								</tr>
							</thead>
							<tbody>
	<?php
		$select="select * from veh_entry where (date_in ='0000-00-00' and time_in = '00:00:00' or date_out ='0000-00-00' and time_out = '00:00:00')";
		$run_select=mysqli_query($conn,$select);
		if($run_select) 
		{
			if(mysqli_num_rows($run_select)!=0)
			{
				while($row_select=mysqli_fetch_array($run_select))
				{
					
					$veh_no = $row_select['veh_no'];
					$driver=$row_select['driver'];
					$co_driver=$row_select['co_driver'];
					$dandaman=$row_select['dandaman'];
					$purpose=$row_select['purpose'];
					$misc_detail=$row_select['misc_detail'];
					$km_out=$row_select['km_out'];
					$km_in=$row_select['km_in'];
					$dateout=$row_select['date_out'];
					$timeout=$row_select['time_out'];
					$datein=$row_select['date_in'];
					$timein=$row_select['time_in'];
	?>

										
			<tr>
				
				<td><?php echo $veh_no?></td>
				<td><?php echo $driver ?></td>
				<td><?php echo $co_driver ?></td>
				<td> <?php echo $dandaman ?></td>
				<td> <?php echo $purpose ?></td>
				<td> <?php echo $misc_detail ?></td>
				<td> <?php echo $km_out ?></td>
				<td> <?php echo $km_in ?></td>
				<td><?php echo $dateout ?></td>
				<td> <?php echo $timeout ?></td>
				<td><?php echo $datein ?></td>
				<td> <?php echo $timein ?></td>
				<?php
				if ($km_in == 0) {
				?>
					<td>
						<form method="POST" enctype="multipart/form-data">
							<input type="hidden" name="sno" value="<?php echo $row_select['sno']; ?>">
							<button class='btn btn-danger' type="submit"  value="in" name='in'>In&nbsp;</button>
						</form>
					</td>
				<?php
				}
				else {
				?>
					<td>
						<form method="POST" enctype="multipart/form-data">
								<input type="hidden" name="sno" value="<?php echo $row_select['sno']; ?>">
								<button class='btn btn-danger' type="submit"  value="out" name='out'>Out</button>
						</form>
					</td>
				<?php
				}
			
			?>
			</tr>
<?php
		}
	}
?>
			
					
			
												</tbody>
											</table>

											</div>
										</div>
									</div>
								</div>
<?php
		
 		
 		}		
?>


<div id="Report" class="tabcontent">
  <div class="row" id="entry_table">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<button class="btn btn-primary btn-sm" onclick="exportTables()">Export To Excel</button>
					
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="basic-datatables" class="display table table-striped table-hover" >
							<thead>
								<tr>
									<th>Veh No</th>
									<th>Driver</th>
									<th>Co-Driver</th>
									<th>Dandaman</th>
									<th>Purpose</th>
									<th>Misc_detail</th>
									<th>KM Out</th>
									<th>KM In</th>
									<th>Date Out</th>
									<th>Time Out</th>
									<th>Date In</th>
									<th>Time In</th>
									<th>Remarks</th>
								</tr>
							</thead>
							<tbody>
	<?php
		$select="select * from veh_entry where (date_in !='0000-00-00' and time_in != '00:00:00' and date_out !='0000-00-00' and time_out != '00:00:00')";
		$run_select=mysqli_query($conn,$select);
		if($run_select) 
		{
			if(mysqli_num_rows($run_select)!=0)
			{
				while($row_select=mysqli_fetch_array($run_select))
				{
					
					$veh_no = $row_select['veh_no'];
					$driver=$row_select['driver'];
					$co_driver=$row_select['co_driver'];
					$dandaman=$row_select['dandaman'];
					$purpose=$row_select['purpose'];
					$misc_detail=$row_select['misc_detail'];
					$km_out=$row_select['km_out'];
					$km_in=$row_select['km_in'];
					$dateout=$row_select['date_out'];
					$timeout=$row_select['time_out'];
					$datein=$row_select['date_in'];
					$timein=$row_select['time_in'];
					$remarks=$row_select['remarks'];
	?>

										
			<tr>
				
				<td><?php echo $veh_no?></td>
				<td><?php echo $driver ?></td>
				<td><?php echo $co_driver ?></td>
				<td> <?php echo $dandaman ?></td>
				<td> <?php echo $purpose ?></td>
				<td> <?php echo $misc_detail ?></td>
				<td> <?php echo $km_out ?></td>
				<td> <?php echo $km_in ?></td>
				<td><?php echo $dateout ?></td>
				<td> <?php echo $timeout ?></td>
				<td><?php echo $datein ?></td>
				<td> <?php echo $timein ?></td>
				<td> <?php echo $remarks ?></td>
			</tr>
										
					
			<?php
			}
		}
			
		}

	
	?>
												</tbody>
											</table>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
	
	
	<!--   Core JS Files   -->
	<script src="vendor/jquery.3.2.1.min.js"></script>
	<script src="vendor/popper.min.js"></script>
	<script src="vendor/bootstrap.min.js"></script>
	
	
	<!-- jQuery Scrollbar -->
	<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
	<script src="vendor/datatables/datatables.min.js"></script>
	
		<script >
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
			});

			$('#multi-filter-select').DataTable( {
				"pageLength": 5,
				initComplete: function () {
					this.api().columns().every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value=""></option></select>')
						.appendTo( $(column.footer()).empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
								);

							column
							.search( val ? '^'+val+'$' : '', true, false )
							.draw();
						} );

						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
				}
			});

			// Add Row
			$('#add-row').DataTable({
				"pageLength": 5,
			});

			var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

			$('#addRowButton').click(function() {
				$('#add-row').dataTable().fnAddData([
					$("#addName").val(),
					$("#addPosition").val(),
					$("#addOffice").val(),
					action
					]);
				$('#addRowModal').modal('hide');

			});
		});
	</script>
	<script src="assets/excel/js/exceljs.min.js"></script>
	  <script src="assets/excel/js/table2excel.core.js"></script>
	  <script>
	    function exportTables () {
	      new Table2Excel('#basic-datatables').export()
	    }
	</script>
</div>




<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>

<script>
$(document).ready(function () {
    	$("#contact-popup").show();
});

</script>


<script type="text/javascript">
	function hideA(x) {
		if(x.checked) 
			{
				document.getElementById("A").style.visibility = "hidden";
				document.getElementById("B").style.visibility = "visible";
			}
		else {
			document.getElementById("B").style.visibility = "hidden";
			document.getElementById("A").style.visibility = "hidden";
		}
		
	}

	function hideB(x) {
		if(x.checked) {
			document.getElementById("B").style.visibility = "hidden";
			document.getElementById("A").style.visibility = "visible";
		}
		else {
			document.getElementById("B").style.visibility = "hidden";
			document.getElementById("A").style.visibility = "hidden";
		}
	}
</script>
</body>
</html> 