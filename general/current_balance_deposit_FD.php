<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$end_date=$_REQUEST['end_date'];
if(empty($end_date)){$end_date=date('d.m.Y');}
if($menu=='fd'){$name="Fixed Deposits";$table="customer_fd";$no=4;}
if($menu=='ri'){$name="Re Investment Deposits";$table="customer_ri"; $no=4;}
if($menu=='rd'){$name="Recurring Deposits";$table="customer_rd"; $no=4;}
if($menu=='mis'){$name="MIS Deposits";$table="customer_mis"; $no=5;}
echo "<html>";
echo "<head>";
echo "<title>Re-Investment Current Balance";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<form name=\"f1\" action=\"current_balance_deposit.php?menu=$menu\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Current Balance as on Dated (DD/MM/YYYY) :<td><input type=TEXT size=12 name=\"end_date\" id =\"end_date\" value=\"$end_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.end_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
echo "<hr>";

//customer_rd
/*$sql_statement="SELECT account_no,certificate_no,action_date,maturity_date,maturity_amount,name1,deposit_balance(account_no,'$end_date') as balance FROM $table WHERE (withdrawal_date IS NULL OR withdrawal_date>'$end_date') AND action_date<'$end_date' ORDER BY (CAST (SUBSTR(account_no,$no,LENGTH(account_no)) AS INT))";*/

$sql_statement="select a.account_no,b.certificate_no,b.action_date,b.maturity_date,b.maturity_amount,b.name1,a.balance 
from 
(select account_no,sum(deposit-withdrawal) as balance from
(SELECT account_no,action_date,SUM(case when dr_cr='Cr' THEN amount ELSE 0 END) as deposit,SUM(case when dr_cr='Dr' THEN amount ELSE 0 END) as withdrawal from fd_detail_view group by account_no,action_date having action_date BETWEEN '1980-03-01' AND '$end_date' ORDER BY action_date DESC) a group by account_no order by account_no) a,
(
SELECT  DISTINCT account_no,certificate_no,action_date,maturity_date,maturity_amount,name1 FROM customer_fd  WHERE certificate_no NOT IN (select certificate_no from customer_fd where withdrawal_date<'$end_date') ORDER BY account_no
) b
where a.account_no=b.account_no order by account_no";

//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table BGCOLOR=\"YELLOW\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\">Current Balance of $name</font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Account No.</th>";
if($menu!='rd' || $menu!='mis' ){
echo "<th bgcolor=$color>Certificate No.</th>";
}
echo "<th bgcolor=$color width\"275\">Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Opening Date</th>";
echo "<th bgcolor=$color colspan=\"1\">Maturity Date</th>";
echo "<th bgcolor=$color colspan=\"1\">Maturity Amount</th>";
echo "<th bgcolor=$color colspan=\"1\">Principal</th>";
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td align=Center bgcolor=$color><a href=\"../main/set_account.php?menu=$menu&account_no=".$row['account_no']."\" target=\"display\">".$row['account_no']."</a></td>";
if($menu!='rd' || $menu!='mis' ){
 echo "<td  bgcolor=$color>".$row['certificate_no']."</td>";
}
	echo "<td bgcolor=$color>".ucwords($row['name1'])."</td>";
	echo "<td align=right bgcolor=$color>".$row['action_date']."</td>";
	echo "<td align=right bgcolor=$color>".$row['maturity_date']."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['maturity_amount'])."</td>";
if($menu=='rd'||$menu=='fd'||$menu=='ri'){
	$c_val=$row['balance'];
	echo "<td align=right bgcolor=$color>".amount2Rs($c_val)."</td>";
	$total_deposit+=$c_val;
	}
else{
echo "<td align=right bgcolor=$color>".amount2Rs($row['principal'])."</td>";
$total_deposit=$total_deposit+$row['principal'];
}
	$total_maturity_amount=$total_maturity_amount+$row['maturity_amount'];
	
}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=5><B>Total: $j Accounts found!!!!</B></td>";
echo "<td align=right bgcolor=$color><B>".amount2Rs($total_maturity_amount)."</B></td>";
echo "<td align=right bgcolor=$color><B>".amount2Rs($total_deposit)."</B></td>";
echo "</table>";
}

echo "<br>";



echo "</body>";
echo "</html>";
?>
