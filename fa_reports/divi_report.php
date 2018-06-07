<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$mdate=$_REQUEST['mdate'];
$fy1=$_SESSION['fy'];
$action_date=date('d/m/Y');
//$fy=getFy($action_date);
//echo "<h1>$fy1</h1>";
//$tot=0;
//getDetailFy($fy,&$f_start_dt,&$f_end_dt);
//$row_func=pg_fetch_array($res_func,0);

echo "<html>";
echo "<head>";
?>

<link rel="stylesheet" href="../retail/css/retail.css">
<SCRIPT LANGUAGE="JavaScript">
function Result(str)
{
//alert(str)
if (str=='n')
	{
		document.getElementById("n").style.display='';
	}
	else
	{
		document.getElementById("n").style.display='none';
	}
if (str=='y')
	{
		document.getElementById("y").style.display='';
	}
	else
	{
		document.getElementById("y").style.display='none';
	}
}
</SCRIPT>
<?php
echo "<title>Dividend Report";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\">";

echo "<table align=center bgcolor=\"silver\"><tr><td><font size=+3><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
//echo "</table>";
echo "<form name=\"f1\" action=\"divi_report.php\" method=\"POST\" onsubmit=\"return check();\">";
echo "<tr><td align=center><input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
echo "<hr>";

echo "<center>";
echo "<table bgcolor='white' align=center width='75%' class=\"border\">";
echo "<tr><td bgcolor=\"#0000CD\" colspan=\"8\" align=\"center\"><b><font color=\"WHITE\">DIVIDEND REPORT</font>";
echo "<tr bgcolor=#BA55D3>";
echo "<th bgcolor=\"#9ACD32\" rowspan=1>Sl.No.</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=1>Membership No</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=1>SB Account No</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=1>Name</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=1>Op Bal Share</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=1>Buy Back</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=1>Share Value</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=1>Dividend</th>";
$sql_statement="BEGIN;select dividend_cal('$action_date','a'); FETCH ALL FROM a;";
$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_NumRows($result)>0){
for($j=0; $j<pg_NumRows($result);$j++){
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td>".($j+1)."</td>";
	//echo "<td >".$row['account_no']."</td>";
	echo "<td ><a href=\"../main/pop_up_account.php?menu=sh&account_no=".$row['account_no']."\" target=\"_blank\">".$row['account_no']."</a></td>";
	if(trim($row['acc_no'])=='No SB Account'){
	$no_sb+=1;
	$Color="RED";
	}
	else{
	$sb+=1;
	$Color="GREEN";
	}
	echo "<td ><a href=\"../main/pop_up_account.php?menu=sb&account_no=".$row['acc_no']."\" target=\"_blank\"><font color=$Color>".$row['acc_no']."</font></a></td>";
	echo "<td >".getName('customer_id',$row['customer_id'],'name1','customer_master')."</td>";
	echo "<td align=right >".$row['opening_bal']."</td>";
	echo "<td align=right >".$row['buy_back']."</td>";
	echo "<td align=right >".$row['value_of_share']."</td>";
	$tot_share+=$row['value_of_share'];
	echo "<td align=right >".$row['dividend']."</td></tr>";
	$tot+=$row['dividend'];
   }
}

echo "<tr>";
//echo "<th align=center bgcolor=aqua colspan=\"6\">Total Account No : $j</th>";
echo "<th align=center bgcolor=aqua colspan=\"6\">Total : $j Accounts Found (Total Paid A/C: <font color=green>$sb</font> and Total Suspence A/C: <font color=red>$no_sb</font>)</th>";
echo "<th align=right bgcolor=aqua>$tot_share</th>";
echo "<th align=right bgcolor=aqua>$tot</th></tr>";
echo "</table>";
echo "<br>";
/*
$sql="select max(action_date) as ac_date,max(fy) as max_fy from dividend_po_che";
$res=dbConnect($sql);
//echo $sql;
$row=pg_fetch_array($res,0);
$fy=$row['max_fy'];
$post_date=$row['ac_date'];
if($fy==$fy1)
{
	echo "<h2><font color='#790722'>You Are Postted Dividend In This Year And Posting Date Is </font><font color='#0012EB'>$post_date</font><h2>";
}
else
{
	echo "<form name=\"f2\" action=\"posting.php\" method=\"post\">";
	echo "<table width='40%'>";
	echo "<tr><td align=\"left\"><h2><marquee><font color=\"#7429EF\">Are You Want To Posting Dividend : </td></h2>";
	echo "<td><SELECT name=\"status\" ><option value=\"n\" onclick=\"Result(this.value)\">No</option><option value=\"y\" onclick=\"Result(this.value)\">Yes</option></td>";
	echo "<tr ID='n' style='display:none'>";
	echo "<tr ID='y' style='display:none'>";
	echo "<td align=\"center\"><input type='submit' value='Posting'></td></tr>";
	echo "</table>";
	echo "</form>";
}
*/
echo "</body>";
echo "</html>";
?>
