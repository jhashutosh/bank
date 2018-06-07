<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
if(empty($start_date) ) { $start_date=$f_start_dt; }
$end_date=$_REQUEST["end_date"];
if(empty($end_date) ) { $end_date=$f_end_dt;}
$sql_statement="SELECT sb_debtors_summary('$start_date','$end_date') as debtors";
//echo $sql_statement;

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$flag=1;
$total_current_balance=pg_result($result,'debtors');
}

echo "<html>";
echo "<head>";
echo "<title>Debtors List";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/date_validation.js\"></script>";
?>
<SCRIPT LANGUAGE="JavaScript">
function closeme() { close(); }
function check(){
if(document.f1.end_date.value.length==0){
	alert("Please enter the Date before processing")
	document.f1.month.focus();
	return false;
	}
f_s_dt=document.f1.f_start_dt.value;
f_e_dt=document.f1.f_end_dt.value;
end_dt=document.f1.end_date.value;
if(!IsDateLess(f_s_dt,end_dt)){
	alert("Ending Date beyond of starting date of Financial Year")
	document.f1.end_date.focus();
	return false;
	}

if(!IsDateLess(end_dt,f_e_dt)){
	alert("Ending Date beyond of ending date of Financial Year")
	document.f1.end_date.focus();
	return false;
	}

}

</script>
<?
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "<form name=\"f1\" action=\"sb_debtors_summary.php\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>SB Debtors List as on Dated (DD/MM/YYYY) :<td><input type=TEXT size=12 name=\"end_date\" id =\"end_date\" value=\"$end_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.end_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
echo "<hr>";
//$flag=1;
if($flag==1){
$sql_statement="SELECT * FROM debtors_list order by CAST(SUBSTR(account_no,3,LENGTH(account_no)) AS numeric) DESC";
//$sql_statement="SELECT * FROM debtors_list ORDER BY account_no";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table valign=\"top\" width=\"100%\" align=center>";
echo "<tr><th bgcolor=\"GREEN\" colspan=\"8\" align=center><font color=\"white\">SB Debtors Summary As On $end_date</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Account No.</th>";
echo "<th bgcolor=$color>Name</th>";
echo "<th bgcolor=$color>Address</th>";
echo "<th bgcolor=$color>Opening Balance</th>";
echo "<th bgcolor=$color>Deposits</th>";
echo "<th bgcolor=$color>Withdrawals</th>";
echo "<th bgcolor=$color>Current Balance </th>";
echo "<th bgcolor=$color>Interest</th>";

for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
$account_no=$row['account_no'];
echo "<td  bgcolor=$color><a href=\"../main/pop_up_account.php?menu=sb&account_no=".$row['account_no']."\" target=\"_blank\">".$account_no."</a></td>";
echo "<td  bgcolor=$color>".$row['name']."</td>";
echo "<td t bgcolor=$color>".$row['address']."</td>";
echo "<td align=right bgcolor=$color>".amount2Rs($row['op_balance'])."</td>";
$total_op_balance+=$row['op_balance'];
echo "<td align=right bgcolor=$color>".amount2Rs($row['deposits'])."</td>";
$total_deposits+=$row['deposits'];
echo "<td align=right bgcolor=$color>".amount2Rs($row['withdrawal'])."</td>";
$total_withdrawal+=$row['withdrawal'];
echo "<td align=right bgcolor=$color>".amount2Rs($row['current_balance'])."</td>";
$t_current_balance+=$row['current_balance'];
echo "<td align=right bgcolor=$color>".amount2Rs($row['interest'])."</td>";
$total_interest+=$row['interest'];
}

echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"3\"><B>Total : $j Accounts Found </B></td>";
echo "<td align=right bgcolor=$color><B>".amount2Rs($total_op_balance)."</B></td>";
echo "<td align=right bgcolor=$color><B>".amount2Rs($total_deposits)."</B></td>";
echo "<td align=right bgcolor=$color><B>".amount2Rs($total_withdrawal)."</B></td>";
echo "<td align=right bgcolor=$color><B>".amount2Rs($t_current_balance)."</B></td>";
echo "<td align=right bgcolor=$color><B>".amount2Rs($total_interest)."</B></td>";
echo "</table>";
}
}
else{
echo "<br><h5><font color=\"RED\">Failed to Calcutation of debtors list.</font></h5>";
}
echo "</body>";
echo "</html>";

?>
