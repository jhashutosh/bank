<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$end_date=$_REQUEST['end_date'];
if(empty($end_date)){$end_date=date('d.m.Y');}
if($menu=='fd'){$name="Fixed Deposits";}
if($menu=='ri'){$name="Re Investment Deposits";$table="bk_investment"; $no=4;}
if($menu=='rd'){$name="Recurring Deposits";}
if($menu=='mis'){$name="MIS Deposits";}
echo "<html>";
echo "<head>";
echo "<title>Re-Investment Current Balance";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<form name=\"f1\" action=\"investment_current_balance.php?menu=$menu\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Current Balance as on Dated (DD/MM/YYYY) :<td><input type=TEXT size=12 name=\"end_date\" id =\"end_date\" value=\"$end_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.end_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
echo "<hr>";
$sql_statement="SELECT * from bk_investment where account_type='mis'";

//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table BGCOLOR=\"YELLOW\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"8\" align=\"center\"><font color=\"white\">Current Balance of $name</font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Account No.</th>";
if($menu!='rd' || $menu!='mis' ){
echo "<th bgcolor=$color>Certificate No.</th>";
}
echo "<th bgcolor=$color width\"275\">Bank Name</th>";
echo "<th bgcolor=$color width\"275\">Account Type</th>";
echo "<th bgcolor=$color colspan=\"1\">Opening Date</th>";
echo "<th bgcolor=$color colspan=\"1\">Principal</th>";
echo "<th bgcolor=$color colspan=\"1\">Maturity Date</th>";

echo "<th bgcolor=$color colspan=\"1\">Maturity Amount</th>";

for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td align=Center bgcolor=$color><a href=\"../main/set_account.php?menu=$menu&account_no=".$row['account_no']."\" target=\"display\">".$row['account_no']."</a></td>";
if($menu!='rd' || $menu!='mis' ){
 echo "<td  bgcolor=$color>".$row['certificate_no']."</td>";
}
	echo "<td bgcolor=$color>".ucwords($row['b_name'])."</td>";
	echo "<td  bgcolor=$color>".$row['account_type']."</td>";
	echo "<td align=right bgcolor=$color>".$row['op_date']."</td>";
	
	echo "<td align=right bgcolor=$color>".amount2Rs($row['principal'])."</td>";
	echo "<td align=right bgcolor=$color>".$row['maturity_date']."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['maturity_amount'])."</td>";
	$total_deposit=$total_deposit+$row['principal'];

	$total_maturity_amount=$total_maturity_amount+$row['maturity_amount'];
}	
}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=5><B>Total: $j Accounts found!!!!</B></td>";
echo "<td align=right bgcolor=$color><B>".amount2Rs($total_deposit)."</B></td>";
echo "<td align=right bgcolor=$color><B></B></td>";
echo "<td align=right bgcolor=$color><B>".amount2Rs($total_maturity_amount)."</B></td>";

echo "</table>";

echo "<br>";



echo "</body>";
echo "</html>";
?>
