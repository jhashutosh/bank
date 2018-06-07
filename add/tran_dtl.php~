<?
include "../config/config.php";
//$staff_id=verifyAutho();
//27572/130711
registerSession();
if($_SESSION['role']=='admin'){
$menu=$_REQUEST['menu'];
$tran_id=trim($_REQUEST['tran_id']);
$op=$_REQUEST['op'];
if($op=='k'){
$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type,action_date, certificate_no,fy,remarks,operator_code,entry_time) (SELECT tran_id,type,action_date, certificate_no,fy,remarks,operator_code,entry_time FROM gl_hrd_dummy where tran_id='$tran_id')";
$sql_statement.=";INSERT INTO gl_ledger_dtl (SELECT * FROM gl_dtl_dummy where tran_id='$tran_id')";
$sql_statement.=";UPDATE gl_hrd_dummy SET tran_status='k' WHERE tran_id='$tran_id'";
//echo $sql_statement;
//$result=dBConnect($sql_statement);
if(!(pg_affected_rows($result)<1)){
	header("location:../main/set_account.php?menu=sb&account_no=$account_no");
	}
}
if($op=='d'){
$sql_statement="UPDATE gl_hrd_dummy SET tran_status='d' WHERE tran_id='$tran_id'";
$result=dBConnect($sql_statement);
if(!(pg_affected_rows($result)<1)){
	header("location:../main/nextaccount.php?menu=sb");
	}

}
echo "<html>";
echo "<head>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"tran_id.focus();\">";
echo "<font size=\"+3\"><b>Cross Checking Saving Entry From</b></font><hr>";
//------------------------------------------------------------------------------------------------
echo "<form name=\"f1\" action=\"tran_dtl.php?op=v\" method=\"post\">";
echo "<table align =\"center\" width =\"100%\" Bgcolor=\"Yellow\"><tr align=\"center\">";
echo "<th align=\"RIGHT\">Enter Transaction Id :&nbsp;<td align=\"LEFT\"><input type=\"TEXT\" name=\"tran_id\" id=\"tran_id\" value=\"$tran_id\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"SUBMIT\" VALUE=\"ENTER\">";
echo "</table>";
echo "</form>";
echo "<hr>";

//------------------------------------------------------------------------------------------------
if($_REQUEST['op']=='v'){
$sql_statement="SELECT * FROM gl_hrd_dummy WHERE tran_id='$tran_id' AND tran_status='p'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
 echo "<h1><font color=red><b>Wrong Transaction ID!!!!!!!!!</b></font></h1>";
}
else{
$remarks=pg_result($result,'remarks');
$action_date=pg_result($result,'action_date');
$remarks=pg_result($result,'remarks');
$staff_id=pg_result($result,'operator_code');
//ledger detail INFORMATION 
$sql_statement="SELECT * FROM gl_dtl_dummy WHERE tran_id='$tran_id' AND account_no IS NOT NULL";
//echo $sql_statement;
$result=dBConnect($sql_statement);
$dr_cr=pg_result($result,'dr_cr');
$amount=pg_result($result,'amount');
$account_no=pg_result($result,'account_no');
if(trim($dr_cr)=='Dr')
	$type="Withdrawals";
else
	$type="Deposits";
$id=getCustomerId($account_no,'sb');
$name=getName('customer_id',$id,'name1','customer_master');
echo "<table align =\"center\" width =\"90%\" Bgcolor=\"WHITE\" border=\"1\" cellspacing=\"0\" bordercolor=\"#000000\" bordercolorlight=\"#000000\" bordercolordark=\"#000000\" >";
echo "<tr><th colspan=\"7\">Transaction Informstion of Id : $tran_id</th></tr>";
echo "<tr><th bgcolor=\"$color\">Account No";
echo "<th bgcolor=\"$color\">Holder Name";
echo "<th bgcolor=\"$color\">Action Date";
echo "<th bgcolor=\"$color\">Trasaction Type";
echo "<th bgcolor=\"$color\">Amount";
echo "<th bgcolor=\"$color\">Operator";
echo "<th bgcolor=\"$color\">Operation";
echo "<tr><td bgcolor=\"$color\">$account_no";
echo "<td bgcolor=\"$color\">$name";
echo "<td bgcolor=\"$color\">$action_date";
echo "<td bgcolor=\"$color\">$type";
echo "<td bgcolor=\"$color\" align=\"RIGHT\">".amount2Rs((int)$amount);
echo "<td bgcolor=\"$color\">$staff_id";
echo "<th bgcolor=\"$color\"><a href=\"tran_dtl.php?menu=sb&tran_id=$tran_id&account_no=$account_no&op=k\">Pass</a> || <a href=\"tran_dtl.php?menu=sb&tran_id=$tran_id&op=a\">Alter</a> || <a href=\"tran_dtl.php?menu=sb&tran_id=$tran_id&op=d\">Del</a>";
		}
	}
}
else{
	header("Location: ../main/action_not_permitted.php");
}

?>
