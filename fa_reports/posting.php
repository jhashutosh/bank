<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
$action_date=date('d/m/Y');
$sql_statement="select dividend_posting('$action_date')";
//echo $sql_statement;
$result=dBConnect($sql_statement);

if(pg_NumRows($result)<0){
  	 echo "<h1><blink>sorry database not updated due to some reason!!!!!!!!!!!!!!!!!!</h1>";
    	 }
else{
	$sql_statement="insert into dividend_po_che values('$action_date','$fy','$staff_id',now())";
	$result=dBConnect($sql_statement);
	//echo $sql_statement;
	header("location:divi_report.php?menu=po");
    }
?>
