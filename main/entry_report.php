<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$fy=$_SESSION['fy'];
getDetailFy($fy,$f_start_dt,$f_end_dt);
$start_date=$_REQUEST["start_date"];
if(empty($start_date) ) { $start_date=$f_start_dt; }
$end_date=$_REQUEST["end_date"];
if(empty($end_date) ) { $end_date=$f_end_dt;}
echo "<html>";
echo "<head>";
echo "<title>  Trial Balance";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/date_validation.js\"></script>";
//echo "<script src=\"../JS/dateValidation.js\"></script>";
?>
<SCRIPT LANGUAGE="JavaScript">
function check(){
return true;
}
</script>
<?php
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<table align=center bgcolor=\"silver\"><tr><font size=+3><b>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "</table>";
echo "<form name=\"f1\" action=\"entry_report.php\" method=\"POST\" onsubmit=\"return check();\">";

echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Date Between (DD/MM/YYYY) :<td><input type=TEXT size=12 name=\"start_date\" id=\"start_date\" value=\"$start_date\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\"> AND <input type=TEXT size=12 name=\"end_date\" id =\"end_date\" value=\"$end_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.end_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";

echo "</table></form>";

//--------------------------------------------printinting R-----------------------------------------------------------------------------
echo "<table bgcolor=\"#667C26\" width=\"100%\" align=\"CENTER\">";
echo "<tr><th colspan=\"15\" bgcolor=green><font color=white size=5> MONTHLY REPORT OF DATA ENTRY </th>";
echo "</tr>";
$color="#CCCCC5555";
echo "<tr>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">S.NO</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Operator Name</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Customer</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Share</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Opening A/C(SB/FD/RD/RI/MIS)</th>";
echo "<th colspan=\"6\" bgcolor=\"$color\">Deposit</th>";
echo "<th colspan=\"7\" bgcolor=\"$color\">Loan</th>";
echo "</tr>";
echo "<tr>";
echo "<th colspan=1 bgcolor=\"$color\">SAVINGS</th>";
echo "<th colspan=1 bgcolor=\"$color\">FD</th>";
echo "<th colspan=1 bgcolor=\"$color\">RD</th>";
echo "<th colspan=1 bgcolor=\"$color\">RI</th>";
echo "<th colspan=1 bgcolor=\"$color\">MIS</th>";
echo "<th colspan=1 bgcolor=\"$color\">SUNDRY DEPOSIT</th>";
echo "<th colspan=1 bgcolor=\"$color\">KCC</th>";
echo "<th colspan=1 bgcolor=\"$color\">MT</th>";
echo "<th colspan=1 bgcolor=\"$color\">PLEDGE</th>";
echo "<th colspan=1 bgcolor=\"$color\">HOME LOAN</th>";
echo "<th colspan=1 bgcolor=\"$color\">CAR LOAN</th>";
echo "<th colspan=1 bgcolor=\"$color\">EDUCATION LOAN</th>";
echo "<th colspan=1 bgcolor=\"$color\">STAFF LOAN</th>";

//------------------------------------- display code below----------------------------------------

$sql_statement="
select a.c1,a.c2,b.c1,c.c1,d.c1,e.c1,f.c1,g.c1,h.c1 from
 (select distinct(operator_code) c1,count(customer_id) c2 from customer_master group by operator_code)a,
(select count(membership_no) c1 from membership_info  group by operator_code)b,
 (select count(account_no) c1 from customer_account where  account_type in('sb','fd','rd','ri','mis','kcc','mt','pl','car','ccl','kpl','sfl','house'))c,
 (select count(tran_id) c1 from gl_ledger_hrd where  type='sb' 
and action_date between '$start_date' and '$end_date')d,
(select count(tran_id) c1 from gl_ledger_hrd where type='fd'
and action_date between '$start_date' and '$end_date')e,
(select count(tran_id) c1 from gl_ledger_hrd where  type='rd'
and action_date between '$start_date' and '$end_date')f,
(select count(tran_id) c1 from gl_ledger_hrd where  type='ri'
and action_date between '$start_date' and '$end_date')g,
(select count(tran_id) c1 from gl_ledger_hrd where  type='mis'
and action_date between '$start_date' and '$end_date')h";
//echo $sql_statement;
//$sql_statement="select * from customer_master";

$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);

//echo $result; exit;
for ($i=0;$i<pg_NumRows($result);$i++)
{
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">1</th>";
//echo "<th colspan=\"1\" bgcolor=\"white\">Customer</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[0])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[1])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[2])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[3])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[4])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[5])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[6])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[7])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[8])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";



echo "</tr>";
}
/*
//-----------------------------------------------------------------------------------------------------------
$sql_statement="
select a.c1,a.c2,b.c1,c.c1,d.c1,e.c1,f.c1,g.c1,h.c1 from
 (select distinct(operator_code) c1,count(customer_id) c2 from customer_master where operator_code like '%' group by operator_code)a,
(select count(membership_no) c1 from membership_info where operator_code like '%' group by operator_code)b,
 (select count(account_no) c1 from customer_account where operator_code like '%' 
and account_type in('sb','fd','rd','ri','mis','kcc','mt','pl','car','ccl','kpl','sfl','house'))c,
 (select count(tran_id) c1 from gl_ledger_hrd where operator_code like '%' and type='sb' 
and action_date between '$start_date' and '$end_date')d,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like '%' and type='fd'
and action_date between '$start_date' and '$end_date')e,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like '%' and type='rd'
and action_date between '$start_date' and '$end_date')f,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like '%' and type='ri'
and action_date between '$start_date' and '$end_date')g,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like '%' and type='mis'
and action_date between '$start_date' and '$end_date')h";
//echo $sql_statement;
//$sql_statement="select * from customer_master";

$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);

//echo $result; exit;
for ($i=0;$i<pg_NumRows($result);$i++)
{
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">2</th>";
//echo "<th colspan=\"1\" bgcolor=\"white\">Customer</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[0])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[1])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[2])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[3])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[4])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[5])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[6])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[7])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[8])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";



echo "</tr>";
}
//--------------------------------------------------------------------------------
$sql_statement="
select a.c1,a.c2,b.c1,c.c1,d.c1,e.c1,f.c1,g.c1,h.c1 from
 (select distinct(operator_code) c1,count(customer_id) c2 from customer_master where operator_code like 'netware%' group by operator_code)a,
(select count(membership_no) c1 from membership_info where operator_code like 'netware%' group by operator_code)b,
 (select count(account_no) c1 from customer_account where operator_code like 'netware%' 
and account_type in('sb','fd','rd','ri','mis','kcc','mt','pl','car','ccl','kpl','sfl','house'))c,
 (select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'netware%' and type='sb' 
and action_date between '$start_date' and '$end_date')d,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'netware%' and type='fd'
and action_date between '$start_date' and '$end_date')e,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'netware%' and type='rd'
and action_date between '$start_date' and '$end_date')f,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'netware%' and type='ri'
and action_date between '$start_date' and '$end_date')g,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'netware%' and type='mis'
and action_date between '$start_date' and '$end_date')h";
//echo $sql_statement;
//$sql_statement="select * from customer_master";

$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);

//echo $result; exit;
for ($i=0;$i<pg_NumRows($result);$i++)
{
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">3</th>";
//echo "<th colspan=\"1\" bgcolor=\"white\">Customer</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[0])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[1])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[2])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[3])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[4])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[5])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[6])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[7])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[8])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";



echo "</tr>";
}
//--------------------------------------------------------------------------------
$sql_statement="
select i.c1,a.c2,b.c1,c.c1,d.c1,e.c1,f.c1,g.c1,h.c1 from
(select id as c1 from staff where name like 'suman%')i,
 (select distinct(operator_code) c1,count(customer_id) c2 from customer_master where operator_code like 'suman%' group by operator_code)a,
(select count(membership_no) c1 from membership_info where operator_code like 'suman%' group by operator_code)b,
 (select count(account_no) c1 from customer_account where operator_code like 'suman%' 
and account_type in('sb','fd','rd','ri','mis','kcc','mt','pl','car','ccl','kpl','sfl','house'))c,
 (select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'suman%' and type='sb' 
and action_date between '$start_date' and '$end_date')d,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'suman%' and type='fd'
and action_date between '$start_date' and '$end_date')e,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'suman%' and type='rd'
and action_date between '$start_date' and '$end_date')f,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'suman%' and type='ri'
and action_date between '$start_date' and '$end_date')g,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'suman%' and type='mis'
and action_date between '$start_date' and '$end_date')h";
//echo $sql_statement;
//$sql_statement="select * from customer_master";

$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);

//echo $result; exit;
for ($i=0;$i<pg_NumRows($result);$i++)
{
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">4</th>";
//echo "<th colspan=\"1\" bgcolor=\"white\">Customer</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[0])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[1])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[2])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[3])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[4])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[5])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[6])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[7])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[8])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "</tr>";
}
////////////////////////////////////////////////////////////////////////////////////
$sql_statement="
select c.c1,a.c2,b.c1,c.c2,d.c1,e.c1,f.c1,g.c1,h.c1 from
 (select count(customer_id) c2 from customer_master where operator_code like 'jayasree%')a,
(select count(membership_no) c1 from membership_info where operator_code like 'jayasree%')b,
 (select distinct(operator_code) c1,count(account_no) c2 from customer_account where operator_code like 'jayasree%' 
and account_type in('sb','fd','rd','ri','mis','kcc','mt','pl','car','ccl','kpl','sfl','house') group by operator_code)c,
 (select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'jayasree%' and type='sb' 
and action_date between '$start_date' and '$end_date')d,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'jayasree%' and type='fd'
and action_date between '$start_date' and '$end_date')e,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'jayasree%' and type='rd'
and action_date between '$start_date' and '$end_date')f,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'jayasree%' and type='ri'
and action_date between '$start_date' and '$end_date')g,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'jayasree%' and type='mis'
and action_date between '$start_date' and '$end_date')h";
//echo $sql_statement;
//$sql_statement="select * from customer_master";

$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);

//echo $result; exit;
for ($i=0;$i<pg_NumRows($result);$i++)
{
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">5</th>";
//echo "<th colspan=\"1\" bgcolor=\"white\">Customer</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[0])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[1])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[2])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[3])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[4])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[5])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[6])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[7])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[8])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "</tr>";
}
$sql_statement="
select c.c1,a.c2,b.c1,c.c2,d.c1,e.c1,f.c1,g.c1,h.c1 from
 (select count(customer_id) c2 from customer_master where operator_code like 'sujas%')a,
(select count(membership_no) c1 from membership_info where operator_code like 'sujas%')b,
 (select distinct(operator_code) c1,count(account_no) c2 from customer_account where operator_code like 'sujas%' 
and account_type in('sb','fd','rd','ri','mis','kcc','mt','pl','car','ccl','kpl','sfl','house') group by operator_code)c,
 (select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'sujas%' and type='sb' 
and action_date between '$start_date' and '$end_date')d,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'sujas%' and type='fd'
and action_date between '$start_date' and '$end_date')e,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'sujas%' and type='rd'
and action_date between '$start_date' and '$end_date')f,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'sujas%' and type='ri'
and action_date between '$start_date' and '$end_date')g,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'sujas%' and type='mis'
and action_date between '$start_date' and '$end_date')h";
//echo $sql_statement;
//$sql_statement="select * from customer_master";

$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);

//echo $result; exit;
for ($i=0;$i<pg_NumRows($result);$i++)
{
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">6</th>";
//echo "<th colspan=\"1\" bgcolor=\"white\">Customer</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[0])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[1])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[2])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[3])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[4])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[5])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[6])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[7])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[8])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "</tr>";
}
$sql_statement="
select c.c1,a.c2,b.c1,c.c2,d.c1,e.c1,f.c1,g.c1,h.c1 from
 (select count(customer_id) c2 from customer_master where operator_code like 'suvendu%')a,
(select count(membership_no) c1 from membership_info where operator_code like 'suvendu%')b,
 (select distinct(operator_code) c1,count(account_no) c2 from customer_account where operator_code like 'suvendu%' 
and account_type in('sb','fd','rd','ri','mis','kcc','mt','pl','car','ccl','kpl','sfl','house') group by operator_code)c,
 (select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'suvendu%' and type='sb' 
and action_date between '$start_date' and '$end_date')d,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'suvendu%' and type='fd'
and action_date between '$start_date' and '$end_date')e,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'suvendu%' and type='rd'
and action_date between '$start_date' and '$end_date')f,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'suvendu%' and type='ri'
and action_date between '$start_date' and '$end_date')g,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'suvendu%' and type='mis'
and action_date between '$start_date' and '$end_date')h";
//echo $sql_statement;
//$sql_statement="select * from customer_master";

$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);

//echo $result; exit;
for ($i=0;$i<pg_NumRows($result);$i++)
{
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">7</th>";
//echo "<th colspan=\"1\" bgcolor=\"white\">Customer</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[0])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[1])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[2])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[3])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[4])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[5])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[6])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[7])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[8])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "</tr>";
}


/////////////////////////////////////////////////////////////////////////////////
$sql_statement="
select c.c1,a.c2,b.c1,c.c2,d.c1,e.c1,f.c1,g.c1,h.c1 from
 (select count(customer_id) c2 from customer_master where operator_code like 'saikat%')a,
(select count(membership_no) c1 from membership_info where operator_code like 'saikat%')b,
 (select distinct(operator_code) c1,count(account_no) c2 from customer_account where operator_code like 'saikat%' 
and account_type in('sb','fd','rd','ri','mis','kcc','mt','pl','car','ccl','kpl','sfl','house') group by operator_code)c,
 (select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'saikat%' and type='sb' 
and action_date between '$start_date' and '$end_date')d,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'saikat%' and type='fd'
and action_date between '$start_date' and '$end_date')e,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'saikat%' and type='rd'
and action_date between '$start_date' and '$end_date')f,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'saikat%' and type='ri'
and action_date between '$start_date' and '$end_date')g,
(select count(tran_id) c1 from gl_ledger_hrd where operator_code like 'saikat%' and type='mis'
and action_date between '$start_date' and '$end_date')h";
//echo $sql_statement;
//$sql_statement="select * from customer_master";

$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);

//echo $result; exit;
for ($i=0;$i<pg_NumRows($result);$i++)
{
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">8</th>";
//echo "<th colspan=\"1\" bgcolor=\"white\">Customer</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[0])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[1])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[2])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[3])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[4])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[5])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[6])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[7])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row[8])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">0</th>";
echo "</tr>";
}
*/
////////////////////////////////////////////////////////////////////////////////
//--------------------------------------------------------------------------------
echo "</table>";
echo "</body>";
echo "</html>";
?>
