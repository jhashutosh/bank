<?php
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
$menu=$_SESSION['menu'];
getDetailFy($fy,$f_start_dt,$f_end_dt);
$year=$_REQUEST['current_date'];
$months=trim($_REQUEST['months']);
$end_dt=$_REQUEST['end_dt'];
$start_dt=$_REQUEST['start_dt'];
//echo $end_dt;
echo "<html>";
echo "<head>";
echo "<title>$PROJECT_TITLE</title>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<script src=\"../JS/date_validation.js\"></script>";
?>
<SCRIPT LANGUAGE="JavaScript">
function check(){
f_s_dt=document.f1.f_start_dt.value;
f_e_dt=document.f1.f_end_dt.value;
start_dt=document.f1.start_dt.value;
end_dt=document.f1.end_dt.value;
if(start_dt.length==0||end_dt.length==0){
alert("Stating Date Should Not be Null")
	document.f1.current_date.focus();
	return false;
}
else{
	
	if(!IsDateLess(f_s_dt,end_dt)){
		alert("Starting Date beyond of ending date of Financial Year")
		document.f1.current_date.focus();
		return false;
	}
	if(!IsDateLess(end_dt,f_e_dt)){
		alert("Ending Date beyond of ending date of Financial Year")
		document.f1.current_date.focus();
		return false;
	}
}

}
function myFunc(m){

var y=document.f1.current_date.value;
if(y.length==0){
	alert("Enter the Year First");
	location.reload();
	return false;
}
else{
	var s=new Date(y,m-1,1);
	m=s.getMonth()+1;
	var strt_strng=s.getDate()+'/'+m+'/'+s.getFullYear();
	var e=new Date(y,m,0);
	m=e.getMonth()+1;
	var end_strng=e.getDate()+'/'+m+'/'+e.getFullYear();
	document.f1.start_dt.value=strt_strng;
	document.f1.end_dt.value=end_strng;
	}
}
</script>

<div id="rpt_body">
<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"\" onload=\"cd.focus();\">";
echo "<center><font size=+3>$SYSTEM_TITLE</font><br>";
//echo "<i>Monthly Return Forms as on". $month_array[$months].",$year</i></center>";
echo "<hr>";
echo "<form name=\"f1\" METHOD=\"POST\" ACTION=\"monthly_return_shg.php\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\">";
echo"<tr><td><b>Return Month as on :<td>";
echo"<input type=TEXT size=4 name=current_date id=cd Value=\"\" onclick=\"this.value=''\" $HIGHLIGHT>&nbsp;-&nbsp;";
makeSelectwithJS($month_array,'months',$m,'months','onChange=myFunc(this.value);');
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "<input type=\"HIDDEN\" name=\"start_dt\" id=\"start_dt\" value=\"\">";
echo "<input type=\"HIDDEN\" name=\"end_dt\" id=\"end_dt\" value=\"\">";
echo "<input type=\"HIDDEN\" name=\"st\" id=\"st\" value=\"\">";

echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\">";
echo "</table></form>";
echo "<hr>";
echo "<center>";
//========================================SHG INFO ===========================================
echo "<table class=\"border\" width='80%' align=center>";
echo "<tr><td bgcolor=\"grey\" colspan=\"20\" align=\"center\"><b><font color=\"WHITE\">MONTHLY RETURN OF SELF HELP GROUP on <font color='lightgreen'>". $month_array[$months].",$year</font></td></tr></table>";
echo "<table class=\"border\" width='70%' align=center><tr><td bgcolor=\"#0000CD\" colspan=\"14\" align=\"center\"><b><font color=\"WHITE\"> SELF HELP GROUP Information on ". $month_array[$months].",$year</font>";
$sql_statement=" select mth_rpt_hrd('shg','$end_dt','a')";
$sql_statement.=";fetch all from a";
//echo $sql_statement;
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result,0);
echo "<tr bgcolor=#BA55D3>";
echo "<th bgcolor=\"#9ACD32\" Colspan=3>No of Group</th>";
echo "<th bgcolor=\"#9ACD32\" Colspan=3>Type of Group</th>";
echo "<th bgcolor=\"#9ACD32\" Colspan=7>Member</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Total<br>Member</th>";
echo "<tr bgcolor=#BA55D3>";
echo "<th bgcolor=\"#9ACD32\">Begining</th>";
echo "<th bgcolor=\"#9ACD32\">During </th>";
echo "<th bgcolor=\"#9ACD32\">End</th>";
echo "<th bgcolor=\"#9ACD32\">Male</th>";
echo "<th bgcolor=\"#9ACD32\">Female</th>";
echo "<th bgcolor=\"#9ACD32\">Mixed</th>";
echo "<th bgcolor=\"#9ACD32\">Male</th>";
echo "<th bgcolor=\"#9ACD32\">Female</th>";
echo "<th bgcolor=\"#9ACD32\">SC</th>";
echo "<th bgcolor=\"#9ACD32\">ST</th>";
echo "<th bgcolor=\"#9ACD32\">OBC</th>";
echo "<th bgcolor=\"#9ACD32\">Minority</th>";
echo "<th bgcolor=\"#9ACD32\">General</th></tr>";
echo "<tr>";echo "<td align=right>".$row['cnt_op'];
echo "<td align=right>".$row['cnt_dur'];
echo "<td align=right>".$row['cnt_end'];
echo "<td align=right>".$row['cnt_gm'];
echo "<td align=right>".$row['cnt_gf'];
echo "<td align=right>".$row['cnt_gx'];
echo "<td align=right>".$row['cnt_ml'];
echo "<td align=right>".$row['cnt_fm'];
echo "<td align=right>".$row['cnt_sc'];
echo "<td align=right>".$row['cnt_st'];
echo "<td align=right>".$row['cnt_obc'];
echo "<td align=right>".$row['cnt_mnr'];
echo "<td align=right>".$row['cnt_gn'];
echo "<td align=right>".$row['cnt_tot'];

echo "</tr></table>";
//===========================================FOR DEPOSIT=================================
echo "<table align=\"CENTER\" class=\"border\" width=\"100%\">";
echo "<tr><td bgcolor=\"#0000CD\" colspan=\"13\" align=\"center\"><b><font color=\"WHITE\"> SELF HELP GROUP DEPOSIT Information on  ". $month_array[$months].",$year</font>";
echo "<tr bgcolor=#BA55D3>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Sl.No.</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Type of deposit</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Begining of the Month</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>End of Month</th>";
echo "<th bgcolor=\"#9ACD32\"colspan=2>During the month</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Decrease or increase</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>% of <br>Decrease/<br>increase</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Begining of the month no of A/C</th>";
echo "<th colspan=2 bgcolor=\"#9ACD32\">During the Month</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>End of the month no of A/C</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>No of A/C Transction Ledger</th>";
echo "<tr>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Deposit</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Withdrawal</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">closed</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Open</th>";
echo "<tr>";
$sql_statement="select mth_rpt_dep('s','$end_dt','b')";
$sql_statement.=";fetch all from b";
//echo $sql_statement;
$result=dBConnect($sql_statement);
for($j=0;$j<=pg_num_rows($result);$j++){
$row=pg_fetch_array($result,$j);
echo "<tr>";echo "<td align=right>".$row['SRL'];
echo "<td align=right>".$row['AC TYPE'];
echo "<td align=right>".$row['op_amt'];
echo "<td align=right>".$row['cl_bal'];
echo "<td align=right>".$row['prd_cr_amt'];
echo "<td align=right>".$row['prd_dr_amt'];
if ($row['inc_dec']<0){
echo "<td align=right><font color='red'>(".abs($row['inc_dec']).")";
echo "<td align=right><font color='red'>(".abs($row['inc_dec_per']).")";
}else{
echo "<td align=right>".$row['inc_dec'];
echo "<td align=right>".$row['inc_dec_per'];}
//echo "<td align=right>".$row['inc_dec'];
//echo "<td align=right>".$row['inc_dec_per'];
echo "<td align=right>".$row['cnt_op_ac'];
echo "<td align=right>".$row['prd_ac_cl'];
echo "<td align=right>".$row['prd_ac_op'];
echo "<td align=right>".$row['cnt_cl_ac'];
echo "<td align=right>".$row['prd_tran'];
echo "</tr>";
}
echo "</table>";
echo "<br><br>";
echo "<table align=\"CENTER\" border=\"1\" width=\"100%\">";
echo "<tr><td bgcolor=\"#0000CD\" colspan=\"15\" align=\"center\"><b><font color=\"WHITE\"> SELF HELP GROUP LOAN Information on  ". $month_array[$months].",$year</font>";
$sql_statement="select mth_rpt_ln('s','$end_dt','b')";
$sql_statement.=";fetch all from b";
//echo $sql_statement;
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result,0);
$n=($row['inc_dcr']<0)?'Decrease':'Increse';
echo "<tr bgcolor=#BA55D3>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Sl.No.</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Type of Loan</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Begining of the Month Loan Issue</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Begining of the Month Loan Repay</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Opening Balance</th>";
echo "<th bgcolor=\"#9ACD32\"colspan=2>During the month</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Closing Balance</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>$n</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>% of $n</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Begining of the month no of A/C</th>";
echo "<th colspan=2 bgcolor=\"#9ACD32\">During the Month</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>End of the month no of A/C</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>No of A/C Transction Ledger</th>";
echo "<tr>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Issue</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Repay</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">closed</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Open</th>";
echo "<tr>";
echo "<tr>";
echo "<td align=right>".$row['SRL'];
echo "<td align=right>".$row['AC TYPE'];
echo "<td align=right>".$row['prv_iss'];
echo "<td align=right>".$row['prv_rpy'];
echo "<td align=right>".$row['op_bal'];
echo "<td align=right>".$row['prd_iss'];
echo "<td align=right>".$row['prd_rpy'];
echo "<td align=right>".$row['cl_bal'];
if ($row['inc_dcr']<0){
echo "<td align=right><font color='red'>(".abs($row['inc_dcr']).")";
echo "<td align=right><font color='red'>(".abs($row['inc_dcr_pr']).")";
}else{
echo "<td align=right>".$row['inc_dcr'];
echo "<td align=right>".$row['inc_dcr_pr'];}
echo "<td align=right>".$row['cnt_op_ac'];
echo "<td align=right>".$row['cnt_prd_cl'];
echo "<td align=right>".$row['cnt_prd_op'];
echo "<td align=right>".$row['cnt_ac_bal'];
echo "<td align=right>".$row['prd_tran'];
echo "</tr>";
echo "</table>";



echo "</body>";
echo "</html>";
?>
