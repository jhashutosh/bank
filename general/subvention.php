<?php
include "../config/config.php";
$staff_id=verifyAutho();
$mdate=$_REQUEST['mdate'];
$fy=$_SESSION['fy'];
getDetailFy($fy,$f_start_dt,$f_end_dt);
$start_date=$_REQUEST["start_date"];
if(empty($start_date) ) { $start_date=$f_start_dt; }
$end_date=$_REQUEST["end_date"];
if(empty($end_date) ) { $end_date=$f_end_dt;}
if(empty($mdate)){$mdate=date('d.m.Y');}
$min_amou=$_REQUEST['min_amou'];
$max_amou=$_REQUEST['max_amou'];
$rate=$_REQUEST['rate'];
$c_id=$_REQUEST['c_id'];

$sql_statement="select int_due_rate from loan_policy where crop_id='$c_id' and fy='$fy'";
$result=dBConnect($sql_statement);
//echo $sql_statement;
$int_due_rate=pg_result($result,'int_due_rate');

$int_paid=$int_due_rate-$rate;

//echo "<h1>$min_amou==$max_amou==$rate==$c_id==$int_due_rate==$int_paid</h1>";
echo "<html>";
echo "<head>";
echo "<title> Subvention Report";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/date_validation.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<table align=center><tr><font size=+3><b>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "</table>";
echo "<form name=\"f1\" action=\"subvention.php\" method=\"POST\">";

echo "<table align=center bgcolor=\"#EFEEDD\">";
echo "<tr>";
echo "<td><b>Date Between (DD/MM/YYYY) :";
echo "<td>&nbsp;<input type=TEXT size=12 name=\"start_date\" id=\"start_date\" value=\"$start_date\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\"> ";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;AND";
echo "<td> <input type=TEXT size=12 name=\"end_date\" id =\"end_date\" value=\"$end_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.end_date,'dd/mm/yyyy','Choose Date')\">";
echo "<td align=\"center\" ><input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\">";
//echo "<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";

echo "</tr>";
echo "<tr>";
echo "<td><b>Loan Amount Between :";
echo "<td><input type=\"text\" size=\"12\" name=\"min_amou\" id=\"min_amou\" value=\"$min_amou\">";
echo "&nbsp;TO&nbsp;<input type=\"text\" size=\"12\" name=\"max_amou\" id=\"max_amou\" value=\"$max_amou\">";
echo "<td>Subvention Rate :<input type=\"text\" size=\"2\" name=\"rate\" id=\"rate\" maxlength=\"2\" value=\"$rate\">";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select Crop :";
	makeSelectSubmit4mdb('crop_id','crop_desc','crop_mas','c_id');

echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";

echo "</table></form>";
echo "<hr>";

echo "<center>";
echo "<table width=\"100%\" ><tr><td>";
echo "<table class=\"border\" align=center>";
echo "<tr><td bgcolor=\"#0000CD\" colspan=\"20\" align=\"center\"><b><font color=\"WHITE\" SIZE=\"4\">Subvention Claim </font>";
echo "<tr bgcolor=#DDDFFF>";
echo "<th rowspan=2>Sl.No.</th>";
echo "<th rowspan=2>Account No</th>";
echo "<th rowspan=2>Name of Borrower </th>";
echo "<th rowspan=2>Crop Name</th>";
echo "<th rowspan=2>Amount Disbursed Upto $max_amou</th>";
echo "<th rowspan=2>Date of Loan Issue</th>";
echo "<th rowspan=2>Borrowers Repayment Date</th>";
echo "<th rowspan=2>Due Date of Loan Repayment</th>";
echo "<th colspan=2>Amount Repaid/Paid Towards</th>";
echo "<th colspan=2>Total Effect Of ".round(($int_due_rate),0)."%</th>";
echo "<tr bgcolor=#DDDFFF>";
echo "<th colspan=1 >Principal</th>";
echo "<th colspan=1 >Due Interest Rate ".round(($int_due_rate),0)."%</th>";
echo "<th colspan=1 >Interest Collection (Rate $int_paid%)</th>";
echo "<th colspan=1 >Claim of Subsity (Rate $rate%)</th>";

//============================================================

$sql_statement="select a.c1,a.c2,a.c3,a.c4,a.c5,b.c1,c.c1,c.c2,round((c.c2/$int_due_rate)*$rate,0) as sub,round((c.c2/$int_due_rate)*$int_paid,0) as int_paid,a.c6 
from 
(select distinct d.name1 c1,sum(a.loan_amount) c2,min(a.action_date) c3,c.crop_desc c4,b.repay_date c5,b.account_no c6,b.loan_serial_no from loan_issue_dtl a,loan_ledger_hrd b,crop_mas c,customer_master d,loan_return_dtl e where a.loan_serial_no=b.loan_serial_no and b.crop_id=c.crop_id and b.loan_serial_no=e.loan_serial_no and b.customer_id=d.customer_id and a.loan_amount between $min_amou and $max_amou and (case when '$end_date'>'$start_date' then e.action_date between '$start_date' and '$end_date' else e.action_date <='$end_date' end) and b.loan_type='kcc' and e.b_principal=0 and c.crop_id='$c_id' and a.action_date>='$start_date' group by d.name1,c.crop_desc,b.repay_date,b.account_no,b.loan_serial_no order by d.name1
) a, 
(select distinct a.action_date c1,b.loan_serial_no from loan_return_dtl a,loan_ledger_hrd b where a.loan_serial_no=b.loan_serial_no and a.action_date <='$end_date' and b.status='cl' and b.loan_type='kcc' and a.b_principal=0 group by a.action_date,a.r_principal,b.loan_serial_no
) b, 
(select distinct sum(r_principal) c1,sum(r_due_int+r_overdue_int) c2,a.loan_serial_no from loan_return_dtl a,loan_ledger_hrd b where a.action_date <='$end_date' and a.loan_serial_no=b.loan_serial_no and b.loan_type='kcc' group by a.loan_serial_no
) c 
where a.loan_serial_no=b.loan_serial_no and b.loan_serial_no=c.loan_serial_no order by a.c1";


$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_NumRows($result)>0){
for($j=0,$i=1; $j<pg_NumRows($result); $j++,$i++){
$row=pg_fetch_array($result,$j);
echo "<tr bgcolor=#EFEFEF>";
echo "<th>$i";
echo "<td align=right ><a href=\"../kcc/kcc_loan_statement.php?menu=kcc&op=i&account_no=$row[10]\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=120,left=150, width=1000,height=600'); return false;\">$row[10]</a></td>";
echo "<td align=right >".ucwords($row[0])."</td>";
echo "<td align=right >".ucwords($row[3])."</td>";
$r1+=$row[1];
echo "<td align=right >$row[1]</td>";
echo "<td align=right >$row[2]</td>";
echo "<td align=right >$row[5]</td>";
echo "<td align=right >$row[4]</td>";

$r6+=$row[6];
echo "<td align=right >$row[6]</td>";
$r7+=$row[7];
echo "<td align=right >$row[7]</td>";
$r9+=$row[9];
echo "<td align=right >$row[9]</td>";
$r8+=$row[8];
echo "<td align=right >$row[8]</td>";
   }
}


//====================================FINAL STATEMENT ========================================
echo "<tr bgcolor=#DDDFFF>";
echo "<th align=left colspan=\"3\">Total Borrowers : $j";
echo "<th align=right >";
echo "<th align=right >".amount2Rs($r1);
echo "<th align=right >";
echo "<th align=right >";
echo "<th align=right >";
echo "<th align=right >".amount2Rs($r6);
//echo "<th align=right bgcolor=aqua>".amount2Rs($r3);
echo "<th align=right >".amount2Rs($r7);
echo "<th align=right >".amount2Rs($r9);
echo "<th align=right >".amount2Rs($r8);
echo "</table>";
echo "</body>";
echo "</html>";
?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("f1");
 frmvalidator.addValidation("min_amou","req","Please Enter Minimum Loan Amount");
 frmvalidator.addValidation("max_amou","req","Please Enter Maximum Loan Amount");
 frmvalidator.addValidation("rate","req","Please Enter Interest Rate");
 frmvalidator.addValidation("c_id","req","Please Select Crop");
 
</script>



