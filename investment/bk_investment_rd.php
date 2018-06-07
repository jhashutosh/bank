<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$account_no=$_REQUEST['account_no'];
$account_type=$_REQUEST['account_type'];
$type_of=$_REQUEST['type_of'];
$bank_name=$_REQUEST['bank_name'];
$branch_name=$_REQUEST['branch_name'];
$certifiacate_no=$_REQUEST['cer_no'];
$op_date=$_REQUEST['op_date'];
$remarks=$_REQUEST['remarks'];
$period=$_REQUEST["period"];
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/loading1.js\"></script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<title>Investment";
echo "</title>";
?>
<SCRIPT LANGUAGE="JavaScript">
function onCheck(){
	if(str.length==0){
		alert("You Should select First")
	}
	else{
		if(str=="ln"){
			alert(str)
			document.form1.gl_code.disabled=false;
		
			}
		
	}
}
function f1(){
showHint(str);
}
function f2(str){
if(str=='po'){
//alert(str);
document.form1.ac_type.disabled=false;
}
else{
document.form1.ac_type.disabled=true;
}
document.form1.gl_code.disabled=true;
}
function f3(str){
if(str=='cash'){
document.form1.ch_no.value=0;
document.form1.ch_no.disabled=true;
document.form1.bank_ac_no.disabled=true;
document.form1.rm.focus();
}
if(str=='ch'){
document.form1.ch_no.disabled=false;
document.form1.bank_ac_no.disabled=false;
document.form1.ch_no.value='';
document.form1.ch_no.focus();
}
if(str=='trf'){
document.form1.ch_no.value=0;
document.form1.ch_no.disabled=true;
document.form1.bank_ac_no.disabled=false;
document.form1.bank_ac_no.focus();
}
if(str=='dft'){
document.form1.ch_no.disabled=false;
document.form1.bank_ac_no.disabled=true;
document.form1.ch_no.value='';
document.form1.ch_no.focus();
}
if(str.length==0){
document.form1.ch_no.value=0;
document.form1.ch_no.disabled=true;
document.form1.bank_ac_no.disabled=true;
}
}
</script>
<?
//--------------------------------------------------------------------------------------------




//--------------------Display
$sql_statement="SELECT * FROM bank_bk_dtl WHERE (account_type<>'sb' AND account_type<>'ca' AND account_type<>'ln' AND account_type<>'sh' and account_type<>'ri') AND status='op'";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
echo "<table align=center bgcolor=silver width=100%>";
echo "<tr><th colspan=5 bgcolor=#8A2BE2><font color=white>Bank Account Details</font></th>";
echo "<tr bgcolor=GREEN><th>Sl No.<th>A/C No.<th>Bank Name<th>Balance<th>Operation";
		$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
		echo "<tr>";
		echo "<td bgcolor=$color align=\"CENTER\"><B>".($j+1);
		echo "<td bgcolor=$color align=\"CENTER\"><B>".strtoupper($row['account_type'])."[".$row['account_no']."]";
		echo "<td bgcolor=$color align=\"CENTER\"><B>".$row['b_name'];
		$balance=(float)ccb_deposits_current_balance($row['account_no']);
		echo "<td bgcolor=$color align=\"RIGHT\"><B>".amount2Rs($balance);
		if(trim($row['account_type'])=='rd'){
		//statement
		echo "<td bgcolor=$color align=\"CENTER\"><B><a href=\"statement.php?menu=".$row['account_type']."&id=".$row['link_tb']."&account_no=".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;\">Statement</a>&nbsp;||&nbsp;";
		//deposit
		echo "<a href=\"operation_page.php?menu=".$row['account_type']."&id=".$row['link_tb']."&account_no=".$row['account_no']."&op=d\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=600,height=300'); return false;\">Deposit</a>";
		if($balance>0){
		//withdrawal
		echo "&nbsp;||&nbsp;<a href=\"a.php?menu=".$row['account_type']."&id=".$row['link_tb']."&account_no=".$row['account_no']."&op=w\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=600,height=300'); return false;\">Withdrawal</a>";
		}
            }
	    else{
		//statement
		echo "<td bgcolor=$color align=\"CENTER\"><B><a href=\"statement.php?menu=".$row['account_type']."&op=1&id=".$row['link_tb']."&account_no=".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=400'); return false;\">Statement</a>&nbsp;";
		
		
		//withdrawal
		echo "&nbsp;||&nbsp;<a href=\"a.php?menu=".$row['account_type']."&id=".$row['link_tb']."&account_no=".$row['account_no']."&op=w\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=600,height=300'); return false;\">Withdrawal</a>";
		
		}		
		
	}
}
//---------------------------------------------------------------------------------------------

