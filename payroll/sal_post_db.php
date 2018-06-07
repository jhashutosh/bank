<? 
include "../config/config.php";
?>
<script language="JAVASCRIPT">
function closeme() { 
	close(); 
} 
function myRefresh(URL){
	window.opener.location.href =URL;
    	self.close();
    	}
</script>
<?
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$staff_id=verifyAutho();
$time=date('d/m/Y H:i:s ');
$year=$_REQUEST['year'];
$month=$_REQUEST['month'];
$ym=$year.$month;
echo"<body bgcolor='lightgreen'>";
$sql="select count(*) from emp_sal_reg where year_month='$ym' and status='Y'";
$res=dBConnect($sql);
$row=pg_fetch_array($res,0);
if($row['count']==0)
{
$sql_statement="select emp_update_sal_reg('$year','$month','$staff_id','$time')";
$result=dBConnect($sql_statement);
//echo $sql_statement;
echo"Salary posting is done successfully for this month";
}
else
echo"Salary is already posted for this month";
echo"<br><div align='center'><input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"myRefresh('../payroll/main.php')\"\"></div>";
echo"</body>";
?>
