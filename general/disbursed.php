<?php
include "../config/config.php";
$staff_id==verifyAutho();
$mdate=$_REQUEST['mdate'];
$fy=$_SESSION['fy'];
getDetailFy($fy,$f_start_dt,$f_end_dt);
$start_date=$_REQUEST["start_date"];
if(empty($start_date) ) { $start_date=$f_start_dt; }
$end_date=$_REQUEST["end_date"];
if(empty($end_date) ) { $end_date=$f_end_dt;}
if(empty($mdate)){$mdate=date('d.m.Y');}
$sql_statement="SELECT monthly_return_loan('$mdate') As monthly";
//echo $sql_statement;
$result=dBConnect($sql_statement);
$name=pg_result($result,'monthly');
echo "<html>";
echo "<head>";
//////////////date///////////////
echo "<title>  Kcc Loan Disbursed";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/date_validation.js\"></script>";
//echo "<script src=\"../JS/dateValidation.js\"></script>";
?>
<SCRIPT LANGUAGE="JavaScript">

</script>
<?php
/////////////////////////////////
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<table align=center bgcolor=\"white\"><tr><font size=+3><b>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "</table>";
echo "<form name=\"f1\" action=\"disbursed.php\" method=\"POST\" onsubmit=\"return check();\">";

echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Date Between (DD/MM/YYYY) :<td><input type=TEXT size=12 name=\"start_date\" id=\"start_date\" value=\"$start_date\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\"> AND <input type=TEXT size=12 name=\"end_date\" id =\"end_date\" value=\"$end_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.end_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
echo "<hr>";
echo "<center>";
echo "<table width=\"100%\"><tr><td>";
echo "<table border=\"1\" align=center>";
echo "<tr><td bgcolor=\"#0000CD\" colspan=\"10\" align=\"center\"><b><font color=\"WHITE\">KCC LOAN DISBURSED AS ON $f_end_dt </font>";
echo "<tr bgcolor=#BA55D3>";
echo "<th bgcolor=\"#9ACD32\" rowspan=1>Sl.No.</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=1>Customer Id</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=1>Name</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=1>Loan Amount</th>";
$sql_statement="select distinct b.customer_id,a.name1,sum(c.loan_amount)
from customer_master a,loan_ledger_hrd b ,loan_issue_dtl c where a.customer_id=b.customer_id  and b.loan_serial_no=c.loan_serial_no
and c.action_date between '$start_date' and '$end_date'and b.loan_type='kcc'group by b.customer_id,a.name1
order by name1";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
for($j=0,$i=1; $j<pg_NumRows($result); $j++,$i++){
$row=pg_fetch_array($result,$j);
echo "<tr>";
//echo "<th>$i";
echo "<td align=right >$i</td>";
echo "<td align=right >$row[0]</td>";
$r0+=$row[0];
echo "<td align=right >$row[1]</td>";
$r1+=$row[2];
echo "<td align=right >$row[2]</td>";
   }
}
//------------------------------Sum---------------------------------------
echo "<tr>";
echo "<th align=right bgcolor=aqua colspan=\"1\">Total:";
echo "<th align=right bgcolor=aqua>";
echo "<th align=right bgcolor=aqua>";
echo "<th align=right bgcolor=aqua>".amount2Rs($r1);
echo "</table>";

///////////////////////////update////////////////////////////////////////////////////////////////

echo "</body>";
echo "</html>";
?>
