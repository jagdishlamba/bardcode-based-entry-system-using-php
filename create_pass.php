<?php 
include ('navbar.php'); 
include ('connection.php');


if ($conn===false) {
  die("Error: Could not connect. " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create Pass</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
  <script src="vendor/jquery/jquery-3.3.1.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container-fluid">
      <h2 align="center"><u>Make Pass</u></h2>
      <br>
      <form class="form-horizontal" method="POST" enctype="multipart/form-data">
      <div class="form-row">
        <div class="form-group col-md-3">
          <input type="text" class="form-control" id="unique_id" placeholder="Enter unique ID" name="unique_id" autofocus="on" required>
        </div>
        <div class="form-group col-md-1">
          <button type="submit" value ="submit" name="submit" class="btn btn-primary btn-sm form-control">Submit</button>
        </div>
      </div>
      </form>
    </div>
    <hr>
<?php
if(isset($_POST['submit']))
{
  $unique_id=$_POST['unique_id'];
  $unique_id=mysqli_real_escape_string($conn,$unique_id);
  
    
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
                        $photo=$row_getq['photo'];
                        


                        $get="select * from user_type where id='$user_type'";
                        $run_get=mysqli_query($conn,$get);
                        $row_get=mysqli_fetch_array($run_get);
                        ?>
                        <div class="row">
            <div class="col-md-12">
             
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-striped table-hover" >
                      <thead>
                        <tr>
                          <th>Unique_id</th>
                          <th>Rank</th>
                          <th>Name</th>
                          <th>Unit/Place</th>
                          <th>User Type</th>
                          <th>User Category</th>
                          <th>Stay Loc</th>
                          <th>Photo</th>
                          <th>Action</th>
                                                  
                        </tr>
                      </thead>
                      
                      <tbody>
                        <tr>
                          <td><?php echo $unique_id ?></td>
                          <td><?php echo $rank['rank'] ?></td>
                          <td><?php echo $name ?></td>
                          <td> <?php echo $unit ?></td>
                          <td> <?php echo $row_get['usertype']; ?></td>
                          <td> <?php echo $user_category['category_name'] ?></td>
                          <td> <?php echo $stay_loc ?></td>
                          <td><img src="images/<?php echo $photo; ?>"width="60px"height="60px"style="border:1px solid black;"><br></td>
                          <td>
                            <form action="generate_pass.php" method="POST" enctype="multipart/form-data">
                              <input type="hidden" value="<?php echo $unique_id ?>" name="unique_id" required>
                              <button type="submit" name="g_submit" class="btn btn-primary btn-sm form-control">Create</button>
                            </form>
                          </td>
                          </tr>
                     
                      
                        
                      </tbody>

                    </table>
                    </div>

                    
    </div>
                       
    <?php              
  }

  else
  {
    echo '<script type="text/javascript">';
    echo 'alert("Data not found!!!");';
    echo 'window.location.assign("create_pass.php");';
    echo '</script>';
  }
}
?>



 
</body>

</html>

