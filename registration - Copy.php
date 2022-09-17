<?php 
include ('navbar.php'); 
include ('connection.php');


if ($conn===false) {
	die("Error: Could not connect. " . mysqli_connect_error());
}

// =============================================================================================
// Submit button action here
// =============================================================================================
if(isset($_POST['submit']))
{
	
	$unique_id=$_POST['unique_id'];
	$unique_id=mysqli_real_escape_string($conn,strtoupper($unique_id));
	
	$rank=$_POST['rank'];
	$rank=mysqli_real_escape_string($conn,strtoupper($rank));

	$name=$_POST['name'];
	$name=mysqli_real_escape_string($conn,strtoupper($name));

	$unit=$_POST['unit'];
	$unit=mysqli_real_escape_string($conn,strtoupper($unit));

	$user_type=$_POST['user_type'];
	$user_type=mysqli_real_escape_string($conn,strtoupper($user_type));

	$user_category=$_POST['user_category'];
	$user_category=mysqli_real_escape_string($conn,strtoupper($user_category));

	$stay_loc=$_POST['stay_loc'];
	$stay_loc=mysqli_real_escape_string($conn,strtoupper($stay_loc));

	$mobile=$_POST['mobile'];
	

	$st_pic=$_FILES['photo']['name'];
	  
	//image temp names
	  
	$temp_name=$_FILES['photo']['tmp_name'];
	   
	$f_extension1 = explode('.',$st_pic);
	  
	$f_extension1 = strtolower(end($f_extension1));
	 
	$f_newfile1 = uniqid().'.'.$f_extension1;

	move_uploaded_file($temp_name,"images/$f_newfile1");
	
	
	$insert="insert into user_detail (unique_id,rank,name,unit,user_type,user_category, id,stay_loc, mobile, photo) 
		values('$unique_id','$rank','$name','$unit','$user_type','$user_category', '$unique_id', '$stay_loc', '$mobile', '$f_newfile1')";

	$run_insert=mysqli_query($conn,$insert);
	if($run_insert)
	{
		echo '<script type="text/javascript">';
		echo 'alert("Data Successfully Added!!!");';
		echo 'window.location.assign("registration.php");';
		echo '</script>'; 	
	}
	else
	{
		echo '<script type="text/javascript">';
		echo 'alert("Error in adding data!!!");';
		echo 'window.location.assign("registration.php");';
		echo '</script>';
	}
}
// =============================================================================================
// Delete button action here
// =============================================================================================

if(isset($_POST['delete']))
{
	$unique_id=$_POST['unique_id'];
	$unique_id=mysqli_real_escape_string($conn,$unique_id);

	$get_detail= "select id from user_detail where unique_id ='$unique_id'";
    $run_detail=mysqli_query($conn, $get_detail);
    while ($row_detail=mysqli_fetch_array($run_detail)){
    	$userid = $row_detail['id'];
    }
    $delete_entry="delete from manual_entry where userid='$userid'";
    mysqli_query($conn,$delete_entry);
		
	$delete="delete from user_detail where unique_id='$unique_id'";
	
	$run_insert=mysqli_query($conn,$delete);
	if($run_insert)
		{
			echo '<script type="text/javascript">';
			echo 'alert("Entry Successfully Deleted!!!");';
			echo 'window.location.assign("registration.php");';
			echo '</script>'; 	
		}
	else
	{
		echo '<script type="text/javascript">';
		echo 'alert("Error in deleting data!!!");';
		echo 'window.location.assign("registration.php");';
		echo '</script>';
	}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="vendor/registration/bootstrap.min.css">
  <script src="vendor/registration/jquery.min.js"></script>
  <script src="vendor/registration/popper.min.js"></script>
  <script src="vendor/registration/bootstrap.min.js"></script>
</head>
<body>
    <div class="container-fluid">
	    <h2 align="center"><u>User Registration</u></h2>
		<form method="POST" enctype="multipart/form-data">
			<div class="form-row">
			    <div class="form-group col-md-2">
				    <label for="user_category">User Category</label>
				    <select class="form-control"id="type_of_person" name="user_category" required>
				        <option class="form-control"value="" selected disabled >--Choose--</option>
				        <option class="form-control"value="defence" name="def">Defence</option>
				        <option class="form-control"value="civ_adm" name="civ_adm">Civ_ADM</option>
				        <option class="form-control"value="mes" name="mes">MES</option>
				        <option class="form-control"value="civil" name="civ">Civ</option>
				    </select>
		    	</div>
		    
			    <div class="form-group col-md-2">
			        <label for="unique_id">ID</label>
			        <input type="text" class="form-control" id="unique_id" placeholder="Enter unique ID" name="unique_id" required>
			    </div>
			    <div class="form-group col-md-2">
			        <label for="rank">Rank</label>
			      	<select class="form-control" id="rank" name="rank" required>
			          	<option class="form-control"value="" selected disabled >--Choose--</option>
			          	<option class="form-control"value="mr" name="mr">Mr</option>
			          	<option class="form-control"value="mrs" name="mrs">Mrs</option>
			          	<option class="form-control"value="ldc" name="ldc">LDC</option>
			          	<option class="form-control"value="udc" name="udc">UDC</option>
			          	<option class="form-control"value="os" name="os">OS</option>
			          	<option class="form-control"value="steno" name="steno">Steno</option>
			          	<option class="form-control"value="msgr" name="msgr">MSGR</option>
			          	<option class="form-control"value="safaiwala" name="safaiwala">Safaiwala</option>
			          	<option class="form-control"value="washerman" name="washerman">Washerman</option>
			          	<option class="form-control"value="tailor" name="tailor">Tailor</option>
			          	<option class="form-control"value="barber" name="barber">Barber</option>
			          	<option class="form-control"value="gardener" name="gardener">Gardener</option>
			          	<option class="form-control"value="c/safaiwala" name="c/safaiwala">C/Safaiwala</option>
			          	<option class="form-control"value="projectionist" name="projectionist">Projectionist</option>
			          	<option class="form-control"value="csbo" name="csbo">CSBO</option>
			          	<option class="form-control"value="er" name="er">ER</option>
			          	<option class="form-control"value="cook" name="cook">Cook</option>
			          	<option class="form-control"value="steward" name="steward">Steward</option>
			          	<option class="form-control"value="mts" name="mts">MTS</option>
			          	<option class="form-control"value="cmd" name="cmd">CMD</option>
			          	<option class="form-control"value="sep" name="sep">Sep</option>
			          	<option class="form-control"value="lnk" name="lnk">L/Nk</option>
			          	<option class="form-control"value="nk" name="nk">Nk</option>
			          	<option class="form-control"value="hav" name="hav">Hav</option>
			          	<option class="form-control"value="chm" name="chm">CHM</option>
			          	<option class="form-control"value="rhm" name="rhm">RHM</option>
			          	<option class="form-control"value="nbsub" name="nbsub">Nb Sub</option>
			          	<option class="form-control"value="sub" name="sub">Sub</option>
			          	<option class="form-control"value="submaj" name="submaj">Sub Maj</option>
			        </select>
			    </div>
			    <div class="form-group col-md-4">
			      	<label for="name">Name</label>
			    	<input type="text" class="form-control" id="name" placeholder="Enter name" name="name" required>
			    </div>
			    <div class="form-group col-md-2">
			    	<label for="unit">Unit/ Place</label>
			       	<input type="text" class="form-control" id="unit" placeholder="Enter unit or place" name="unit" required>
			    </div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-2">
				    <label for="user_type">User Type</label>
				    <select class="form-control"id="user_type" name="user_type" required>
				        <option class="form-control"value="" selected disabled >--Choose--</option>
				        <option class="form-control"value="1">Permanent</option>
				        <option class="form-control"value="2">Temporary</option>
				    </select>
   				</div>
     
			    <div class="form-group col-md-2">
				    <label for="stay_loc">Stay Loc</label>
				    <select class="form-control"id="stay_loc" name="stay_loc" required>
				        <option class="form-control"value="" selected disabled >--Choose--</option>
				        <option class="form-control"value="inside">Inside</option>
				        <option class="form-control"value="outside">Outside</option>
				    </select>
			 	</div>

			 	<div class="form-group col-md-3">
			      	<label for="mobile">Mob No</label>
			     	<input type="text" maxlength="10" class="form-control" name="mobile" placeholder="Mobile number">
			    </div>
  
			    <div class="form-group col-md-3">
			      	<label for="photo">Photo</label>
			     	<input type="file" class="form-control" name="photo" accept=".jpg" required>
			    </div>
			    <div class="form-group col-md-1">
			       	<label></label>
			        <button type="submit" value ="submit" name="submit" class="btn btn-primary btn-sm form-control">Submit</button>
			    </div>
			    <div class="form-group col-md-1">
			       	<label></label>
			        <button type="reset" value ="reset" name="reset" class="btn btn-danger btn-sm form-control">Reset</button>
			    </div>
  			</div>
  		</form>
<!-- table section starts from here -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<h4 align="center"><u><b>User Details</u></b></h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="basic-datatables" class="display table table-striped table-hover" >
									<thead>
										<tr>
											<th>SNo</th>
											<th>Unique_id</th>
											<th>Rank</th>
											<th>Name</th>
											<th>Unit/Place</th>
											<th>User Type</th>
											<th>User Category</th>
											<th>Stay Loc</th>
											<th>Mobile</th>
											<th>Photo</th>
											<th></th>
											<th></th>
										</tr>
									</thead>
											
									<tbody>
										<?php
											$i = 1;
											$getq="select * from user_detail";
											$run_getq=mysqli_query($conn,$getq);
											while($row_getq=mysqli_fetch_array($run_getq))
											{

												$unique_id=$row_getq['unique_id'];
												$rank=$row_getq['rank'];
												$name=$row_getq['name'];
												$unit=$row_getq['unit'];
												$user_type=$row_getq['user_type'];
												$user_category=$row_getq['user_category'];
												$stay_loc=$row_getq['stay_loc'];
												$photo=$row_getq['photo'];
												$mobile=$row_getq['mobile'];


												$get="select * from user_type where id='$user_type'";
												$run_get=mysqli_query($conn,$get);
												$row_get=mysqli_fetch_array($run_get);
														
										?>
										<tr>
											<td><?php echo $i++ ?></td>
											<td><?php echo $unique_id ?></td>
											<td><?php echo $rank ?></td>
											<td><?php echo $name ?></td>
											<td> <?php echo $unit ?></td>
											<td> <?php echo $row_get['usertype']; ?></td>
											<td> <?php echo $user_category ?></td>
											<td> <?php echo $stay_loc ?></td>
											<td> <?php echo $mobile ?></td>
											<td> <img src="images/<?php echo $photo; ?>"width="60px"height="60px"style="border:1px solid black;"><br></td>
											<th>
												<form method='post' action = "update_registration.php" enctype='multipart/form-data'>
												    <input type='hidden' name='unique_id' value=<?php echo $unique_id ?>>
												    <input type='hidden' name='rank' value=<?php echo $rank ?>>
												    <input type='hidden' name='name' value='<?php echo $name ?>'>
												    <input type='hidden' name='unit' value=<?php echo $unit ?>>
												    <input type='hidden' name='user_type' value=<?php echo $user_type ?>>
												    <input type='hidden' name='user_category' value=<?php echo $user_category ?>>
												    <input type='hidden' name='stay_loc' value=<?php echo $stay_loc ?>>
												    <input type='hidden' name='mobile' value=<?php echo $mobile ?>>
												    <input type='hidden' name='photo' value=<?php echo $photo ?>>
												    <button class='btn btn-primary btn-sm' type='submit' name='update'>Update</button></th>
												</form>
											<th>
												<?php
												
												if( $_SESSION["username"] == "admin") {
													?>
													<form method='post' enctype='multipart/form-data'>
													   <input type='hidden' name='unique_id' value=<?php echo $unique_id ?>>
													   <button class='btn btn-danger btn-sm' type='submit' onclick="return confirm('Are you sure ?')" name='delete'>Delete</button></th>
													</form>
													<?php
													}
													
												else {
													?>
													<button class='btn btn-danger btn-sm' type='submit' name='delete' disabled>Delete</button></th>
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

