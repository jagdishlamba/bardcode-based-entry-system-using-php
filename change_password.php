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
	$unique_id=mysqli_real_escape_string($conn,$unique_id);
	
	$c_password=$_POST['c_password'];
	$c_password=mysqli_real_escape_string($conn,$c_password);

	$n_password=$_POST['n_password'];
	$n_password=mysqli_real_escape_string($conn,$n_password);

	$cn_password=$_POST['cn_password'];
	$cn_password=mysqli_real_escape_string($conn,$cn_password);
	
	$select="select * from tbl_member where username='$unique_id'";
	$run_select=mysqli_query($conn,$select);
	$row_getq=mysqli_fetch_array($run_select);
	$hashedPassword = $row_getq['password'];
	
	if (password_verify($c_password, $hashedPassword)) {

		if ($n_password==$cn_password) {
			$newHashedPassword = password_hash($n_password, PASSWORD_DEFAULT);
	        $update="update tbl_member set password='$newHashedPassword' where username='$unique_id'";
			$run_update=mysqli_query($conn,$update);
			if ($run_update)
				{
					echo '<script type="text/javascript">';
					echo 'alert("Password changed successfully.");';
					echo 'window.location.assign("logout.php");';
					echo '</script>';
				}
			else {
		    	echo '<script type="text/javascript">';
				echo 'alert("Error in updating password.");';
				echo 'window.location.assign("change_password.php");';
				echo '</script>';
				}
		}
		else {
		    echo '<script type="text/javascript">';
			echo 'alert("Both new passwords are not same.");';
			echo 'window.location.assign("change_password.php");';
			echo '</script>';
		}

	}    
   
    else {
    	echo '<script type="text/javascript">';
		echo 'alert("Current password did not match.");';
		echo 'window.location.assign("change_password.php");';
		echo '</script>';
		}
}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Change Password</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="vendor/registration/bootstrap.min.css">
  <script src="vendor/registration/jquery.min.js"></script>
  <script src="vendor/registration/popper.min.js"></script>
  <script src="vendor/registration/bootstrap.min.js"></script>
</head>
<body>
	<center>
    <div class="container-fluid">
	    <h2 align="center"><u>Change Password</u></h2>
	    <div class="card-body">
							
		<form  method="POST" enctype="multipart/form-data">
			<table>
				<tr>
					<td>Current User: </td>
					<td></td>
					<td> <input type="text" class="form-control col-sm-10" id="unique_id" value="<?php echo strtoupper($_SESSION['username']) ?>" name="unique_id" disabled> </td>
				</tr>
				<tr>
					<input type="hidden" class="form-control col-sm-10" id="unique_id" value="<?php echo $_SESSION['username'] ?>" name="unique_id"> </td>
					<td>Current Password: </td>
					<td></td>
					<td> <input type="password" class="form-control col-sm-10" id="unique_id" placeholder="Enter current password" name="c_password" required> </td>
				</tr>
				<tr>
					<td>New Password: </td>
					<td></td>
					<td> <input type="password" class="form-control col-sm-10" id="unique_id" placeholder="Enter new password" name="n_password" required> </td>
				</tr>

				<tr>
					<td>Re-Enter New Password: </td>
					<td></td>
					<td> <input type="text" class="form-control col-sm-10" id="unique_id" placeholder="Confirm new password" name="cn_password" required> </td>
				</tr>
				<tr>
					<td colspan="4" align="center">
						<button type="submit" value ="submit" name="submit" class="btn btn-primary btn-sm ">Submit</button>
						<button type="reset" value ="reset" name="reset" class="btn btn-danger btn-sm">Reset</button>
						<button type="submit" class="btn btn-primary btn-sm" onclick="window.location.assign('dashboard.php')">Cancel</button>
					</td>
				</tr>
			</table>

		    </form>
	</div>
</div>
</center>
</body>
</html>