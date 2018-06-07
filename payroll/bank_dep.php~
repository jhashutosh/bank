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
$deposit_no=$_REQUEST['deposit_no'];
echo"<form  name='f1' action=\"bank_dep.php?c_id=$c_id&op=i&emp_id=$emp_id&deposit_no=$deposit_no&gl_mas_code=$gl_mas_code&opr=$opr&liab_code=$liab_code\" method='post' onSubmit=\"return validator(this);\">";
if($op=='i')
{echo $liab_code;
$dep_dat=$_REQUEST['dep_dat'];
$dep_amt=($opr=='w')?(-1)*$_REQUEST['dep_amt']:$_REQUEST['dep_amt'];
$t_type=$_REQUEST['t_typ'];
$depint=($t_type=='int')?int_amt:dep_amount;
$up=''; 
if ($t_type=='int') {$up=",int_amt=int_amt+$dep_amt ";
					$cr_gl=$liab_code;}
else $cr_gl=28101;
$sql="insert into emp_pforgratuity_sb_dtl (emp_id ,deposit_no,$depint,action_date , operator_code ,entry_time) values ($emp_id,'$deposit_no',$dep_amt,'$dep_dat','$staff_id',now())";
$sql.=";update emp_pforgratuity_sb_hdr set deposit_amount=deposit_amount+$dep_amt $up where deposit_no='$deposit_no'";
$res=dBConnect($sql);
echo $sql;
	$t_id=getTranId();
	$sql_statement="insert into gl_ledger_hrd(tran_id, type,action_date,fy,operator_code,entry_time) values ('$t_id','pfi','$dep_dat','$fy','$staff_id',now())";
	if($opr=='w')
	{

	$sql_statement.=";insert into gl_ledger_dtl (tran_id, gl_mas_code, amount, dr_cr,account_no) 
						values ('$t_id','$gl_mas_code',$dep_amt,'Cr','$deposit_no')";
	$sql_statement.=";insert into gl_ledger_dtl (tran_id, gl_mas_code, amount, dr_cr) 
						values ('$t_id','28101',$dep_amt,'Dr')";



	}

	else {

	$sql_statement.=";insert into gl_ledger_dtl (tran_id, gl_mas_code, amount, dr_cr,account_no) 
						values ('$t_id','$gl_mas_code',$dep_amt,'Dr','$deposit_no')";
	$sql_statement.=";insert into gl_ledger_dtl (tran_id, gl_mas_code, amount, dr_cr) 
						values ('$t_id','$cr_gl',$dep_amt,'Cr')";


	}



echo $sql_statement;
	$result=dBConnect($sql_statement);
echo "<div align='center'><b></b><br>";
if(pg_affected_rows($result)>0)
echo "Deposit Successfull | transaction Id:<font color='green'>$t_id</font>";
echo"<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme(),myRefresh('../payroll/pf_invst_dtl.php?c_id=$c_id&id=$emp_id#tabs-1')\"></div>";

}
if(empty($op)){
echo"<table valign=\"top\"width='100%' align='center' bgcolor='#E0E0E0' cellspacing=0 cellpadding=0>";
echo"<tr><th colspan='3'bgcolor='#FF95C3'><font color='white' size='1'>Deposit Number : <b><font size='+2' color='#F73056'>$deposit_no </font></th>
<td bgcolor='#FF95C3'>";
if ($opr!='w')
echo"transaction type:<select name='t_typ'><option value='ca'>Cash</option><option value='int'>Interest</option></select>";
echo"</tr>";
echo"<tr><td  colspan='4'><br></td></tr>";

echo "<tr><td  colspan=\"1\" align='right'><font color='black'size='2' >";
if($opr=='w')
	echo "Withdrawl&nbsp;";
else
	echo "Deposit&nbsp;"; 
echo"Amount &nbsp;:</td>";
echo"<td><input type='text' name='dep_amt' size='6' onkeypress=\"return numbersonly(event);\"></td>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Date&nbsp;:</td>";
echo"<td><input type='text' name='dep_dat' size='10'>   <input type='button' value='..' onclick=\"showCalendar(f1.dep_dat,'dd.mm.yyyy','Choose Date')\" ><br></td></tr>";
echo"<tr><td  colspan='4'></td></tr><tr><td  colspan='4'></td></tr><tr><td  colspan='4'></td></tr>";
echo"<tr><td colspan='4'bgcolor='#839EB8' align='center'><input type='submit'  value='Submit'></td><tr><td  colspan='3'></td></tr>";
echo"</table>";
echo"</form>";
		}
echo"</body>";
?>
