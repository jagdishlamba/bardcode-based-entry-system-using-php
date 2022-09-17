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
  <title>Backup</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="vendor/registration/bootstrap.min.css">
  <script src="vendor/registration/jquery.min.js"></script>
  <script src="vendor/registration/popper.min.js"></script>
  <script src="vendor/registration/bootstrap.min.js"></script>
</head>
<body>
	
	<div class="container-fluid">
    	<br><br>
    	<form method="POST" enctype="multipart/form-data">
    		<div class="row">
    			<div class="col-md-4"></div>
    			<div class="col-md-3">
    				<p> Do you really want to take backup ??</p>
    			</div>
    			<div class="col-md-1">
	  				<button type="submit" value ="submit" name="submit" class="btn btn-primary btn-sm">Click Me</button>
	  			</div>
	  		</div>
		</form>
	</div>

<?php

function EXPORT_DATABASE($host,$user,$pass,$name,$backup_name=false,$tables=false)
{ 
	set_time_limit(3000); $mysqli = new mysqli($host,$user,$pass,$name); $mysqli->select_db($name); $mysqli->query("SET NAMES 'utf8'");
	$queryTables = $mysqli->query('SHOW TABLES'); while($row = $queryTables->fetch_row()) { $target_tables[] = $row[0]; }	if($tables !== false) { $target_tables = array_intersect( $target_tables, $tables); } 
	$content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `".$name."`\r\n--\r\n\r\n\r\n";
	foreach($target_tables as $table){
		if (empty($table)){ continue; } 
		$result	= $mysqli->query('SELECT * FROM `'.$table.'`');  	$fields_amount=$result->field_count;  $rows_num=$mysqli->affected_rows; 	$res = $mysqli->query('SHOW CREATE TABLE '.$table);	$TableMLine=$res->fetch_row(); 
		$content .= "\n\n".$TableMLine[1].";\n\n";   $TableMLine[1]=str_ireplace('CREATE TABLE `','CREATE TABLE IF NOT EXISTS `',$TableMLine[1]);
		for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) {
			while($row = $result->fetch_row())	{ //when started (and every after 100 command cycle):
				if ($st_counter%100 == 0 || $st_counter == 0 )	{$content .= "\nINSERT INTO ".$table." VALUES";}
					$content .= "\n(";    for($j=0; $j<$fields_amount; $j++){ $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); if (isset($row[$j])){$content .= '"'.$row[$j].'"' ;}  else{$content .= '""';}	   if ($j<($fields_amount-1)){$content.= ',';}   }        $content .=")";
				//every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
				if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) {$content .= ";";} else {$content .= ",";}	$st_counter=$st_counter+1;
			}
		} $content .="\n\n\n";
	}
	$content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
	$backup_name = $backup_name ? $backup_name : $name.'___('.date('H-i-s').'_'.date('d-m-Y').').sql';
	ob_get_clean(); header('Content-Type: application/octet-stream');  header("Content-Transfer-Encoding: Binary");  header('Content-Length: '. (function_exists('mb_strlen') ? mb_strlen($content, '8bit'): strlen($content)) );    header("Content-disposition: attachment; filename=\"".$backup_name."\""); 
	echo $content; 

	// $ftp_server="192.168.2.204";
	// $ftp_username = "admin";
	// $ftp_password = "info*@001?123456789";
	// $ftp_conn=ftp_connect($ftp_server) or die ("could not connect to Mysql");
	// $login =ftp_login($ftp_conn, $ftp_username, $ftp_password);

	// if (ftp_put($ftp_conn, "PUBLIC/it/sql_backup/abc.sql", $content, FTP_ASCII))
	// {
	// 	echo "hi";
	// }
	// else
	// {
	// 	echo "bye";
	// }
	// ftp_close($ftp_conn);

	exit;
}
?>

<?php
if(isset($_POST['submit']))
{
	EXPORT_DATABASE("localhost","root","Cosf15f1911@lcshp","ges");
}		
		
?>