<?
include "../config/config.php";
$status=$_REQUEST['status'];
$poperator_code=verifyAutho();
$id=$_REQUEST['id'];
$pf_ac_no=$_REQUEST['pf_ac_no'];
$pf_acc_dt=$_REQUEST['pf_acc_dt'];
$pf_cer_no=$_REQUEST['pf_cer_no'];
$of_op_bal=(empty($_REQUEST['of_op_bal']))?0:$_REQUEST['of_op_bal'];
$pentry_time=date('d/m/Y H:i:s ');
$sql="select emp_pf_dtl_save_fnc($id,'$pf_ac_no','$pf_acc_dt','$pf_cer_no',$of_op_bal,0,0,'$poperator_code','$pentry_time')";
$result=dBConnect($sql);
$row=pg_fetch_array($result,0);
//echo $sql;
//echo $row['emp_pf_dtl_save_fnc'];
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
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
echo "</head>";
echo"<body bgcolor='lightgreen'>";
if($row['emp_pf_dtl_save_fnc']==1)
echo "<div align='center'><b>PF Information Entered Successfully!!!</b><br>";
echo"<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme(),myRefresh('../payroll/emp_db.php')\"></div>";
echo"</body>";

?>
