<?php 
include ('navbar.php'); 
include ('connection.php');


if ($conn===false) {
	die("Error: Could not connect. " . mysqli_connect_error());
}

if(isset($_POST['delete']))
{
	$id=$_POST['id'];
	$id=mysqli_real_escape_string($conn,$id);

	$delete_entry="delete from manual_entry where id='$id'";
    mysqli_query($conn,$delete_entry);
		
	
	$run_insert=mysqli_query($conn,$delete_entry);
	if($run_insert)
		{
			echo '<script type="text/javascript">';
			// echo 'alert("Entry Successfully Deleted!!!");';
			echo 'window.location.assign("delete_entry.php");';
			echo '</script>'; 	
		}
	else
	{
		echo '<script type="text/javascript">';
		echo 'alert("Error in deleting data!!!");';
		echo 'window.location.assign("delete_entry.php");';
		echo '</script>';
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Delete</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="vendor/registration/bootstrap.min.css">
  <script src="vendor/registration/jquery.min.js"></script>
  <script src="vendor/registration/popper.min.js"></script>
  <script src="vendor/registration/bootstrap.min.js"></script>
</head>
<body>
    
<!-- table section starts from here -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<div class="table-responsive">
								<table id="basic-datatables" class="display table table-striped table-hover" >
									<thead>
										<tr>
											<th>Unique_id</th>
											<th>Rank</th>
											<th>Name</th>
											<th>Date In</th>
											<th>Time In</th>
											<th>Date Out</th>
											<th>Time Out</th>
											<th></th>
										</tr>
									</thead>
											
									<tbody>
										<?php
											$select="select * from manual_entry";
											$run_select=mysqli_query($conn,$select);
																							
											if(mysqli_num_rows($run_select)!=0)
											{
												while($row_select=mysqli_fetch_array($run_select))
												{	
													$userid = $row_select['userid'];
													$select1="select * from user_detail where id='$userid'";
													$run_select1=mysqli_query($conn,$select1);
													$row_select1=mysqli_fetch_array($run_select1);																			
													$unique_id= $row_select1['unique_id'];
													$rank= $row_select1['rank'];
													$name= $row_select1['name'];
													$datein=$row_select['datein'];
													$timein=$row_select['timein'];
													$dateout=$row_select['dateout'];
													$timeout=$row_select['timeout'];
										?>

										
											<tr>
												<td><?php echo $unique_id ?></td>
												<td><?php echo $rank ?></td>
												<td><?php echo $name ?></td>
												<td><?php echo $datein ?></td>
												<td><?php echo $timein ?></td>
												<td><?php echo $dateout ?></td>
												<td> <?php echo $timeout ?></td>
												<td>
													<form method='post' enctype='multipart/form-data'>
														<input type='hidden' name='id' value=<?php echo $row_select['id']; ?>>

													   		<button class='btn btn-danger btn-sm' type='submit' onclick="return confirm('Are you sure ?')" name='delete'>Delete</button></th>
													</form>
												</td>
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
<!-- table section ends here -->
</body>

</html>

