<?php 
include ('navbar.php'); 
include ('connection.php');


if ($conn===false) {
	die("Error: Could not connect. " . mysqli_connect_error());
}

// =============================================================================================
// Update button from registration action here
// =============================================================================================

if(isset($_POST['update']))
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

  $mobile=$_POST['mobile'];
  $mobile=mysqli_real_escape_string($conn,strtoupper($mobile));

  $photo=$_POST['photo'];
  $photo=mysqli_real_escape_string($conn,strtoupper($photo));
}

// =============================================================================================
// Update button action here
// =============================================================================================

if(isset($_POST['cupdate']))
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
  $mobile=mysqli_real_escape_string($conn,strtoupper($mobile));

  $st_pic=$_FILES['photo']['name'];
  $temp_name=$_FILES['photo']['tmp_name'];
  $f_extension1 = explode('.',$st_pic);
  $f_extension1 = strtolower(end($f_extension1));
  $f_newfile1 = uniqid().'.'.$f_extension1;
  move_uploaded_file($temp_name,"images/$f_newfile1");

	$update="update user_detail set unique_id = '$unique_id',rank = '$rank',name='$name',unit='$unit',user_type= '$user_type',user_category='$user_category', stay_loc='$stay_loc', mobile='$mobile', photo='$f_newfile1' where unique_id='$unique_id'";
	
	$run_insert=mysqli_query($conn,$update);
	if($run_insert)
		{
			echo '<script type="text/javascript">';
			echo 'alert("Data Updated successfully!!!");';
			echo 'window.location.assign("registration.php");';
			echo '</script>'; 	
		}
	else
	{
		echo '<script type="text/javascript">';
		echo 'alert("Error in updating data!!!");';
		echo 'window.location.assign("registration.php");';
		echo '</script>';
	}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Update Registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="vendor/registration/bootstrap.min.css">
  <script src="vendor/registration/jquery.min.js"></script>
  <script src="vendor/registration/popper.min.js"></script>
  <script src="vendor/registration/bootstrap.min.js"></script>
  <script>
    function getState(val) {
        $("#loader").show();
      $.ajax({
      type: "POST",
      url: "dependent_rank.php",
      data:'id='+val,
      success: function(data){
        $("#state-list").html(data);
        $("#loader").hide();
      }
      });
    }
</script>
</head>
<body>
  <div class="container">
  <h3 align="center"><u>Update User Data</u></h3><br><br>
  <form class="form-horizontal" method="POST" enctype="multipart/form-data">
    <div class="form-row">
              
          <div class="form-group col-md-2">
            <label for="unique_id"><font color="red">ID No</font><font size="3" color="red">*</font></label>
            <input type="text" class="form-control" id="unique_id" placeholder="Enter unique ID" name="unique_id"  required value=<?php echo $unique_id ?>>
          </div>

          <div class="form-group col-md-3">
              <label for="user_category">Type of person</label>
             <select class="form-control" name="user_category" id="country-list" class="demoInputBox" onChange="getState(this.value);">
                      <option value="">Select Category</option>
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
            <label for="rank">Rank</label>
             <select  class="form-control" name="rank" id="state-list" class="demoInputBox">
                    <option value="">Select Rank</option>
                  </select>     
            </div>
          

            <div class="form-group col-md-5">
              <label for="name">Name</label>
               <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" required value='<?php echo $name ?>'>
            </div>
            
          </div>
   <div class="form-row">
      <div class="form-group col-md-2">
        <label for="name">Unit/Place</label>
        <input type="text" class="form-control" id="unit" placeholder="Enter unit or place" name="unit" required value=<?php echo $unit ?>>
      </div>
    

      <div class="form-group col-md-2">
        <label for="user_type">Category</label>
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
      <label for="name">Mobile</label>
      <input type="text" class="form-control"  name="mobile" placeholder="Enter Mobile Number" value=<?php echo $mobile ?>>
    </div>
    

    <div class="form-group col-md-3">
      <label for="name">Photo</label>
      <input type="file" class="form-control"  name="photo" >
    </div>
  </div>
    

    <div class="form-row">        
      <div class="form-group col-md-3">
        <button type="submit" value="cupdate" name="cupdate" class="btn btn-primary">Update</button>
        <button type="submit" class="btn btn-danger" onclick="window.location.assign('registration.php')">Cancel</button>
      </div>
    </div>
  </form>


</div>

</div>
</form>


</div>
</body>
</html>