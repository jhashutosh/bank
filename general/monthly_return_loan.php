<?php
include "../config/config.php";
$staff_id==verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,$f_start_dt,$f_end_dt);
$year=$_REQUEST['current_date'];
$months=trim($_REQUEST['months']);
$end_dt=$_REQUEST['end_dt'];
$start_dt=$_REQUEST['start_dt'];
if(!empty($end_dt)){
	$sql_statement="SELECT monthly_return_loan('$end_dt') As monthly";
	//echo $sql_statement;
	$result=dBConnect($sql_statement);
	$name=pg_result($result,'monthly');
 }
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
function makePDF(){
	alert(document.getElementById("rpt_body").innerHTML);
}
</script>
<?php

echo "<div id=\"rpt_body\">";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"\" onload=\"cd.focus();\">";
echo "<center><font size=+3>$SYSTEM_TITLE</font><br>";
echo "<i>Monthly Return Forms as on ". $month_array[$months].",$year</i></center>";
echo "<hr>";
echo "<form name=\"f1\" METHOD=\"POST\" ACTION=\"monthly_return_loan.php\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\">";
echo"<tr><td><b>Return Month as on :<td>";
echo"<input type=TEXT size=4 name=current_date id=cd Value=\"\" onclick=\"this.value=''\" $HIGHLIGHT>&nbsp;-&nbsp;";
makeSelectwithJS($month_array,'months',$m,'months','onChange=myFunc(this.value);');
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "<input type=\"HIDDEN\" name=\"start_dt\" id=\"start_dt\" value=\"\">";
echo "<input type=\"HIDDEN\" name=\"end_dt\" id=\"end_dt\" value=\"\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> <input type=\"BUTTON\" name=\"pdf\" value=\"MakePDF\" onclick=\"makePDF()\">";
echo "</table></form>";
echo "<hr>";
if(!empty($end_dt)){
echo "<center>";
echo "<table width=\"100%\" class=\"border\"><tr><td>";
echo "<table class=\"border\" align=center>";
echo "<tr><td bgcolor=\"#0000CD\" colspan=\"19\" align=\"center\"><b><font color=\"WHITE\" size=\"+3\">MONTHLY RETURN OF LOAN on ". $month_array[$months].",$year</font>";
echo "<tr bgcolor=#BA55D3>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Sl.No.</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Type of Loan</th>";
echo "<th bgcolor=\"#9ACD32\" colspan=4>31 st march Closing Balance(Rs.)</th>";
echo "<th bgcolor=\"#9ACD32\" colspan=2>Loan Issued during the month</th>";
echo "<th bgcolor=\"#9ACD32\" colspan=4>Amount Repaid during the month</th>";
echo "<th bgcolor=\"#9ACD32\" colspan=3>Due Loan outstanding at the end of the Month</th>";
echo "<th bgcolor=\"#9ACD32\" colspan=3>Overdue Loan outstanding at the end of the Month</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Total Outstanding(due & overdue (Principal+interest))</th>";
echo "<tr>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Principal</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Due Int amount</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Overdue Int amount</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Total</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">No of Members</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Amount(Rs.)</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">No of members</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Principal(Rs.)</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Due interest(Rs.)</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Overdue Interest(Rs.)</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">No of members</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Principal(Rs.)</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Interest</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">No of members</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Principal(Rs.)</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Interest</th>";

$sql_statement="SELECT * FROM monthly_return_loan";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
for($j=0,$i=1; $j<pg_NumRows($result); $j++,$i++){
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<th>$i";
echo "<td><b>".$type_of_account1_array[$row[0]]."</td>";
$r1+=$row[1];
echo "<td align=right >".amount2Rs($row[1])."</td>";
$r2+=$row[2];
echo "<td align=right >".amount2Rs($row[2])."</td>";
$r3+=$row[3];
echo "<td align=right >".amount2Rs($row[3])."</td>";
$r4+=$row[4];
echo "<td align=right >".amount2Rs($row[4])."</td>";
$r5+=$row[5];
echo "<td align=right >$row[5]</td>";
$r6+=$row[6];
echo "<td align=right >".amount2Rs($row[6])."</td>";
$r7+=$row[7];
echo "<td align=right >$row[7]</td>";
$r8+=$row[8];
echo "<td align=right >".amount2Rs($row[8])."</td>";
$r9+=$row[9];
echo "<td align=right >".amount2Rs($row[9])."</td>";
$r10+=$row[10];
echo "<td align=right >".amount2Rs($row[10])."</td>";
$r12+=$row[12];
echo "<td align=right >$row[12]</td>";
$r14+=$row[14];
echo "<td align=right >".amount2Rs($row[14])."</td>";
$r13+=$row[13];
echo "<td align=right >".amount2Rs($row[13])."</td>";
$r15+=$row[15];
echo "<td align=right >$row[15]</td>";
$r17+=$row[17];
echo "<td align=right >".amount2Rs($row[17])."</td>";
$r16+=$row[16];
echo "<td align=right >".amount2Rs($row[16])."</td>";
$r18+=$row[18];
echo "<td align=right >".amount2Rs($row[18])."</td>";

   }
}
//------------------------------Sum---------------------------------------
echo "<tr>";
echo "<th align=right bgcolor=aqua colspan=\"2\">Total:";
echo "<th align=right bgcolor=aqua>".amount2Rs($r1);
echo "<th align=right bgcolor=aqua>".amount2Rs($r2);
echo "<th align=right bgcolor=aqua>".amount2Rs($r3);
echo "<th align=right bgcolor=aqua>".amount2Rs($r4);
echo "<th align=right bgcolor=aqua>$r5";
echo "<th align=right bgcolor=aqua>".amount2Rs($r6);
echo "<th align=right bgcolor=aqua>$r7";
echo "<th align=right bgcolor=aqua>".amount2Rs($r8);
echo "<th align=right bgcolor=aqua>".amount2Rs($r9);
echo "<th align=right bgcolor=aqua>".amount2Rs($r10);
echo "<th align=right bgcolor=aqua>$r12";
echo "<th align=right bgcolor=aqua>".amount2Rs($r14);
echo "<th align=right bgcolor=aqua>".amount2Rs($r13);
echo "<th align=right bgcolor=aqua>$r15";
echo "<th align=right bgcolor=aqua>".amount2Rs($r17);
echo "<th align=right bgcolor=aqua>".amount2Rs($r16);
echo "<th align=right bgcolor=aqua>".amount2Rs($r18);
echo "</table>";
}
echo "</body>";
echo "</html>";

echo "</div>";
?>
