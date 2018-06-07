<? 
include "../config/config.php";
$menu=$_REQUEST["menu"]; 
$staff_id=verifyAutho();
$id=$_REQUEST['id'];
$mm=$_REQUEST['mm'];
$yy=$_REQUEST['yy'];
$ym=$yy.$mm;
$time=date('d/m/Y H:i:s ');
$sql="select count(*) from emp_sal_reg where year_month='$ym' and status='Y'";
$res=dBConnect($sql);
//echo $sql;
$row=pg_fetch_array($res,0);
//$row=pg_fetch_array($pgres,0);
echo "<html>";
echo "<head>";
echo "<title>EMPLOYEE DETAILS";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<script language="JAVASCRIPT">
function closeme() { 
	close(); 
}

</script>
<?
echo "</head>";
echo"<body bgcolor='lightyellow'>";
//echo $row['emp_create_sal_reg'];
//echo $mm;
//echo $psql;
//echo $pgres;
if($row['count']==0){
$psql="select emp_create_sal_reg('$yy','$mm','$staff_id','$time')";
$pgres=dBConnect($psql);
//echo $psql;
echo" <b>Salary Processing completed !!!!<br><b>";}
else{echo"Salary Register is already processed for this month";}
echo"<div align='center'><input type='button' name='close' value='close' onclick=\"closeme()\"></div>";
echo"</body></html>";
?>

