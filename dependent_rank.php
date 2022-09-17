<?php
include ('connection.php');

if (! empty($_POST["id"])) {
    
    $id = $_POST["id"];
    $select = "select * from rank where category_id= '$id'";
	$result1 = mysqli_query($conn, $select);
	?>
	<option>Select Rank</option>
	<?php
	while ($result = mysqli_fetch_array($result1)) {
	?>
		<option value="<?php echo $result["id"]; ?>"><?php echo $result["rank"]; ?></option>
	<?php
	    }
	}
	?>