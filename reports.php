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
  	<title>Reports</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="vendor/registration/bootstrap.min.css">
	<script src="vendor/registration/jquery.min.js"></script>
	<script src="vendor/registration/popper.min.js"></script>
	<script src="vendor/registration/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(function() {
			if(!Modernizr.inputtypes.date) {
				console.log("The date field is not supported");
				$("#txtdate").datepicker();
			}
		});
	</script>
</head>
<body>
	<div class="container-fluid">
		<form method="POST" enctype="multipart/form-data">
	  		<div class="form-row">
	  			<div class="form-group col-md-2">
	      			<label>From</label>
	      			<input class="form-control" type="date" name="from_date" id="txtdate" required="" placeholder="yyyy-mm-dd"> 
	      		</div>
	      		<div class="form-group col-md-2">
	      			<label>To</label>
	      			<input class="form-control"  type="date" name="to_date" id="txtdate" required="" placeholder="yyyy-mm-dd">
	      		</div>
	      		<div class="form-group col-md-2">
	      			<label>User Category</label>
	      			<select class="form-control" name="user_category" class="demoInputBox">
	      					<option class="form-control"name="ALL" value="ALL" selected>All</option>
	               		 	<?php
								$category ="select * from user_category";
    							$result1= mysqli_query($conn,$category);
    							while($result=mysqli_fetch_array($result1))
									{
							    ?>
								<option value="<?php echo $result["id"]; ?>"><?php echo $result["category_name"]; ?></option>
								<?php
									}
								?>
						</select>
	      		</div>
	      		<div class="form-group col-md-2">
	      			<label>Entry Type</label>
	      			<select class="form-control" name="entry_type">
				          <option class="form-control" name="all" selected>All</option>
				          <option class="form-control" name="in">In</option>
				          <option class="form-control" name="out">Out</option>
				    </select>
	      		</div>
	      		<div class="form-group col-md-0 ">
			       <label>.</label>
			       <button type="submit" value ="submit" name="search" class="btn btn-primary btn-sm form-control">Search</button>
   				</div>
   			</div>
		</form>
	</div>
	
<?php
if(isset($_POST['search']))
{
	?>

	<div class="row" id="entry_table">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 align="center"><u><b>Entry Detail</u></b></h4>
					<button class="btn btn-primary btn-sm" onclick="exportTables()">Export To Excel</button>
					<button class="btn btn-danger btn-sm" onclick="window.location.assign('reports.php')">Clear</button>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="basic-datatables" class="display table table-striped table-hover" >
							<thead>
								<tr>
									<th>SNo</th>
									<th>Unique Id</th>
									<th>Rank</th>
									<th>Name</th>
									<th>Unit/Place</th>
									<th>User Category</th>
									<th>Veh No</th>
									<th>Date In</th>
									<th>Time In</th>
									<th>Date Out</th>
									<th>Time Out</th>
									<th>Purpose</th>
									<th>Addl Person</th>
								</tr>
							</thead>
							<tbody>
	<?php

	$i = 1;
	$from_date=$_POST['from_date'];
	$from_date=mysqli_real_escape_string($conn,strtoupper($from_date));

	$to_date=$_POST['to_date'];
	$to_date=mysqli_real_escape_string($conn,strtoupper($to_date));

	$user_category=$_POST['user_category'];
	

	$entry_type=$_POST['entry_type'];
	$entry_type=mysqli_real_escape_string($conn,strtoupper($entry_type));

	if ($to_date < $from_date) {
		echo '<script type="text/javascript">';
		echo 'alert("Enter dates properly!!!");';
		echo 'window.location.assign("reports.php");';
		echo '</script>'; 
	}

	else
	{

		if ($user_category=="ALL" and $entry_type=="ALL")
		{
			$select = "select * from manual_entry where ((datein between '$from_date' and '$to_date') or (dateout between '$from_date' and '$to_date'))";
		}
		elseif ($user_category=="ALL" and $entry_type != "ALL")
		{
			if ($entry_type =='IN')
			{
				$select = "select * from manual_entry where (datein between '$from_date' and '$to_date')";
			} 

			elseif ($entry_type == 'OUT')
			{
				$select = "select * from manual_entry where (dateout between '$from_date' and '$to_date')";
			}
		}

		elseif ($user_category != "ALL" and $entry_type=="ALL")
		{
			$select = "select * from manual_entry, user_detail where (manual_entry.datein between '$from_date' and '$to_date' or manual_entry.dateout between '$from_date' and '$to_date') and manual_entry.userid=user_detail.id and user_detail.user_category='$user_category'";
		}

		elseif ($user_category != "ALL" and $entry_type !="ALL")
		{
			if ($entry_type =='IN')
			{
				$select = "select * from manual_entry, user_detail where manual_entry.datein between '$from_date' and '$to_date' and manual_entry.userid=user_detail.id and user_detail.user_category='$user_category'";
			} 

			elseif ($entry_type == 'OUT')
			{
				$select = "select * from manual_entry, user_detail where manual_entry.dateout between '$from_date' and '$to_date' and manual_entry.userid=user_detail.id and user_detail.user_category='$user_category'";
			}
		}

			
			$run_select=mysqli_query($conn,$select);
			
			if(mysqli_num_rows($run_select)!=0)
			{
				while($row_select=mysqli_fetch_array($run_select))
				{
					$userid = $row_select['userid'];
					$getq="select * from user_detail where id='$userid'";
					$run_getq=mysqli_query($conn,$getq);
					$row_getdetail=mysqli_fetch_array($run_getq);
						
						
					$unique_id=$row_getdetail['unique_id'];

					$rank4=$row_getdetail['rank'];
					$rank3= "select * from rank where id ='$rank4'";
					$rank2=mysqli_query($conn,$rank3);
					$rank=mysqli_fetch_array($rank2);

					$name=$row_getdetail['name'];
					$unit=$row_getdetail['unit'];

					$user_category4=$row_getdetail['user_category'];
					$user_category3= "select * from user_category where id ='$user_category4'";
					$user_category2=mysqli_query($conn,$user_category3);
					$user_category=mysqli_fetch_array($user_category2);

					$veh =$row_select['vehno'];
					$datein=$row_select['datein'];
					$timein=$row_select['timein'];
					$dateout=$row_select['dateout'];
					$timeout=$row_select['timeout'];
					$purpose=$row_select['purpose'];
					$addl_person=$row_select['addl_person'];

					?>

										
											<tr>
												<td><?php echo $i++ ?></td>
												<td><?php echo $unique_id ?></td>
												<td><?php echo $rank['rank'] ?></td>
												<td><?php echo $name ?></td>
												<td> <?php echo $unit ?></td>
												<td> <?php echo $user_category['category_name'] ?></td>
												<td> <?php echo $veh ?></td>
												<td><?php echo $datein ?></td>
												<td><?php echo $timein ?></td>
												<td><?php echo $dateout ?></td>
												<td> <?php echo $timeout ?></td>
												<td> <?php echo $purpose ?></td>
												<td> <?php echo $addl_person ?></td>
											</tr>
										
					
					<?php
				}
			}

			else 
			{
				echo '<script type="text/javascript">';
				echo 'alert(" No Data Found !!!");';
				echo 'window.location.assign("reports.php");';
				echo '</script>'; 
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

</body>
</html>