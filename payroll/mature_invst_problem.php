<head>
<script>
function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	if (unicode!=8){ 
		if (unicode<46||unicode>57||unicode==47) {
			return false;		
		}
	}
}

function closeme() { 
	close(); 
}
function myRefresh(URL){
	window.opener.location.href =URL;
    	self.close();
    	}

</script> 
<?
include "../config/config.php";
echo "<title>Mature Form</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$c_id=$_REQUEST['c_id'];
$type=$_REQUEST['type'];
$op=$_REQUEST['op'];
$emp_id =$_REQUEST['emp_id'];
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
echo "<body bgcolor=\"white\">";
//echo $type;

if($type=='bn'){
$deposit_no=$_REQUEST['deposit_no'];
echo"<form  name='f1' action=\"mature_invst.php?type=bn&c_id=$c_id&op=i&emp_id=$emp_id&deposit_no=$deposit_no\" method='post' onSubmit=\"return validator(this);\">";
if($op=='i')
{
$mat_dat=$_REQUEST['mat_dat'];
$mat_amt=$_REQUEST['mat_amt'];
$sql="insert into emp_pforgratuity_sb_dtl () values ()";
$res=dBConnect($sql);
echo $sql;
	$t_id=getTranId();
	$sql_statement="insert into gl_ledger_hrd(tran_id, action_date,fy,operator_code,entry_time) values 						('$t_id','$mat_dat','$fy','$staff_id',now())";
	$sql_statement.=";insert into gl_ledger_dtl (tran_id, gl_mas_code, amount, dr_cr,account_no) 
						values ('$t_id','$gl_mas_code',$mat_amt-$gain,'Cr','$deposit_no')";
	$sql_statement.=";insert into gl_ledger_dtl (tran_id, gl_mas_code, amount, dr_cr) 
						values ('$t_id','28101',$mat_amt,'Dr')";
	/*if($gain>0)
	
	$sql_statement.=";insert into gl_ledger_dtl (tran_id, gl_mas_code, amount, dr_cr,account_no) 
						values ('$t_id','12220',$gain,'Cr','$deposit_no')";*/

echo $sql_statement;
	$result=dBConnect($sql_statement);
echo "<div align='center'><b></b><br>";
echo"<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme(),myRefresh('../payroll/pf_invst_dtl.php?c_id=$c_id&id=$emp_id#tabs-1')\"></div>";

}
if(empty($op)){
echo"<table valign=\"top\"width='100%' align='center' bgcolor='#E0E0E0'>";
echo"<tr><th colspan='4'bgcolor='#FF95C3'><font color='white' size='1'>Deposit Number : <b><font size='+2' color='#F73056'>$deposit_no </font></th></tr>";
echo"<tr><td  colspan='4'></td></tr><tr><td  colspan='4'></td></tr><tr><td  colspan='4'></td></tr>";

echo "<tr><td  colspan=\"1\" align='right'><font color='black'size='2' >Mature Amount &nbsp;:</td>";
echo"<td><input type='text' name='mat_amt' size='6' onkeypress=\"return numbersonly(event);\"></td>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Mature Date&nbsp;:</td>";
echo"<td><input type='text' name='mat_dat' size='10'>   <input type='button' value='..' onclick=\"showCalendar(f1.mat_dat,'dd.mm.yyyy','Choose Date')\" ></td></tr>";
echo"<tr><td  colspan='4'></td></tr><tr><td  colspan='4'></td></tr><tr><td  colspan='4'></td></tr>";
echo"<tr><td colspan='4'bgcolor='#839EB8' align='center'><input type='submit'  value='Submit'></td><tr><td  colspan='3'></td></tr>";
echo"</table>";
echo"</form>";
		}
}
echo"</body>";
?>
