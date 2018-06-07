<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST["menu"];
$starting_date=$_REQUEST["starting_date"];
$ending_date=$_REQUEST["ending_date"];
if( empty($starting_date) ) { $starting_date=date("d/m/Y",time()-604800); }
if( empty($ending_date) ) { $ending_date=date("d/m/Y"); }
if($menu=='fd'){$name="Fixed Deposits";$table="customer_fd";}
if($menu=='ri'){$name="Re Investment Deposits";$table="customer_ri";}
if($menu=='rd'){$name="Recurring Deposits";$table="customer_rd";}
if($menu=='mis'){$name="MIS Deposits";$table="customer_mis";}
echo "<html>";
echo "<head>";
echo "<title>Fixed Deposit Summary Statement";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h3>Summary Statement - $name";
echo "</h3>";
echo "<hr>";
echo "<form method=\"POST\" action=\"deposit_summary.php?menu=$menu\">";
echo "Summary statement of bank between <input type=\"TEXT\" name=\"starting_date\" size=\"15\" value=\"$starting_date\">";
echo " and <input type=\"TEXT\" name=\"ending_date\" size=\"15\" value=\"$ending_date\">";
echo " <input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "<hr>";
//-----------------------------------------------------------------
echo "<br>";
// Ledger Section
// Summary Statement of fixed deposits based on date of deposit/opeining
//
$sql_statement="SELECT opening_date, sum(principal) AS amount_deposit, sum(maturity_amount)-sum(principal) AS total_interest, sum(maturity_amount) AS maturity_amount,count(certificate_no) AS certificate_no FROM deposit_info  WHERE account_type='$menu' AND action_date BETWEEN '$starting_date' AND '$ending_date' GROUP BY action_date ORDER BY opening_date";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"red\" colspan=\"5\" align=\"center\"><font color=\"white\">Summary of $name (Based on Date of Deposit)</font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>No. of Certificate</th>";
echo "<th bgcolor=$color>Opening date</th>";
echo "<th bgcolor=$color>Amount deposit</th>";
echo "<th bgcolor=$color>Total interest</th>";
echo "<th bgcolor=$color>Maturity amount</th>";
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
if($row['certificate_no']==$certificate_no_DEFAULT){$row['certificate_no']="";}
echo "<td align=right bgcolor=$color>".$row['certificate_no']."</td>";
echo "<td align=right bgcolor=$color>".$row['acdtion_date']."</td>";
echo "<td align=right bgcolor=$color>".$row['amount_deposit']."</td>";
echo "<td align=right bgcolor=$color>".$row['total_interest']."</td>";
echo "<td align=right bgcolor=$color>".$row['maturity_amount']."</td>";
}
echo "<tr>";
$color="cyan";
$sql_statement="SELECT sum(principal) AS amount_deposit,sum(maturity_amount)-sum(principal) AS total_interest, sum(maturity_amount) AS maturity_amount,count(certificate_no) AS certificate_no FROM deposit_info WHERE account_type='$menu' action_date BETWEEN '$starting_date' AND '$ending_date'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
	echo "<h4>Not found!!!</h4>";
} else {
for($j=1; $j<=pg_NumRows($result); $j++) {
$row=pg_fetch_array($result,($j-1));
echo "<td align=right bgcolor=$color><b>".$row['certificate_no']."</b></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color><B>".$row['amount_deposit']."</B></td>";
echo "<td align=right bgcolor=$color><b>".$row['total_interest']."</b></td>";
echo "<td align=right bgcolor=$color><b>".$row['maturity_amount']."</b></td>";
}
}

echo "</table>";
}

echo "<hr>";
echo "<br>";
//-----------------------------------------------------------------

// Ledger Section
// Summary Statement of fixed deposits based on date of maturity
//
$sql_statement="SELECT maturity_date, sum(amount_deposit) AS amount_deposit, sum(maturity_amount)-sum(principal) AS total_interest, sum(maturity_amount) AS maturity_amount,count(certificate_no) AS certificate_no FROM fd_ledger  WHERE maturity_date BETWEEN '$starting_date' AND '$ending_date' GROUP BY maturity_date ORDER BY maturity_date";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>No maturity!!!</h4>";
} else {
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"5\" align=\"center\"><font color=\"white\">Summary of $name (Based on Date of Maturity)</font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>No. of Certificate</th>";
echo "<th bgcolor=$color>Maturity date</th>";
echo "<th bgcolor=$color>Amount deposit</th>";
echo "<th bgcolor=$color>Total interest</th>";
echo "<th bgcolor=$color>Maturity amount</th>";
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=right bgcolor=$color>".$row['certificate_no']."</td>";
echo "<td align=right bgcolor=$color>".$row['maturity_date']."</td>";
echo "<td align=right bgcolor=$color>".$row['amount_deposit']."</td>";
echo "<td align=right bgcolor=$color>".$row['total_interest']."</td>";
echo "<td align=right bgcolor=$color>".$row['maturity_amount']."</td>";
}
echo "<tr>";
$color="cyan";
$sql_statement="SELECT sum(principal) AS amount_deposit, sum(maturity_amount)-sum(principal) AS total_interest, sum(maturity_amount) AS maturity_amount,count(certificate_no) AS certificate_no FROM deposit_info WHERE account_type='$menu' AND maturity_date BETWEEN '$starting_date' AND '$ending_date'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
	echo "<h4>Not found!!!</h4>";
} else {
for($j=1; $j<=pg_NumRows($result); $j++) {
$row=pg_fetch_array($result,($j-1));
echo "<td align=right bgcolor=$color><b>".$row['certificate_no']."</b></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color><b>".$row['amount_deposit']."</b></td>";
echo "<td align=right bgcolor=$color><b>".$row['total_interest']."</b></td>";
echo "<td align=right bgcolor=$color><B>".$row['maturity_amount']."</B</td>";
}
}

echo "</table>";
}
echo "<hr>";
echo "<br>";

//--------------------------------------------
// Ledger Section
// Detail Statement of fixed deposits based on date of deposit/opeining
//
$sql_statement="SELECT * FROM deposit_info  WHERE (maturity_date>'$starting_date' and action_date <'$ending_date') AND (withdrawal_date > '$starting_date' or withdrawal_date is null) ORDER BY action_date";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"blue\" colspan=\"14\" align=\"center\"><font color=\"white\">Detail of $name (Based on Date of Deposit)</font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Account no</th>";
echo "<th bgcolor=$color>No. of Certificate</th>";
echo "<th bgcolor=$color>Opening date</th>";
echo "<th bgcolor=$color>Scheme</th>";
echo "<th bgcolor=$color>Period</th>";
echo "<th bgcolor=$color>Int. Method</th>";
echo "<th bgcolor=$color>Amount deposit</th>";
echo "<th bgcolor=$color>Rate of interest</th>";
echo "<th bgcolor=$color>Total interest</th>";
echo "<th bgcolor=$color>Maturity amount</th>";
echo "<th bgcolor=$color>Maturity date</th>";
echo "<th bgcolor=$color>Withdrawn type</th>";
echo "<th bgcolor=$color>Withdrawal date</th>";
echo "<th bgcolor=$color>Withdrawal amount</th>";
$i=0;
for($j=1; $j<=pg_NumRows($result); $j++) {
$i++;
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=right bgcolor=$color><a href=\"fd_ledger_detail.php?account_no=".$row['account_no']."\" target=\"_blank\">".$row['account_no']."</a></td>";

echo "<td align=left bgcolor=$color>".$row['certificate_no']."</td>";
echo "<td align=right bgcolor=$color>".$row['opening_date']."</td>";
echo "<td align=right bgcolor=$color>".$scheme_array[trim($row['scheme'])]."</td>";
echo "<td align=right bgcolor=$color>".$row['period']."</td>";
echo "<td align=right bgcolor=$color>".$fd_compute_type_array[trim($row['fd_compute_type'])]."</td>";
echo "<td align=right bgcolor=$color>".$row['amount_deposit']."</td>";
echo "<td align=right bgcolor=$color>".$row['rate_of_interest']."</td>";
echo "<td align=right bgcolor=$color>".$row['total_interest']."</td>";
echo "<td align=right bgcolor=$color>".$row['maturity_amount']."</td>";
echo "<td align=right bgcolor=$color>".$row['maturity_date']."</td>";
echo "<td align=right bgcolor=$color>".$row['withdrawn_type']."</td>";
echo "<td align=right bgcolor=$color>".$row['withdrawal_date']."</td>";
echo "<td align=right bgcolor=$color>".$row['withdrawal_amount']."</td>";
}
echo "<tr>";
$color="cyan";
$sql_statement="SELECT sum(principal) AS amount_deposit, sum(maturity_amount)-sum(principal) AS total_interest, sum(maturity_amount) AS maturity_amount,count(certificate_no) AS certificate_no,sum(withdrawal_amount) AS withdrawal_amount FROM deposit_info  WHERE account_type='$menu' AND (maturity_date>'$starting_date' and opening_date <'$ending_date') AND (withdrawal_date > '$starting_date' or withdrawal_date is null)";
$result=($sql_statement);
if(pg_NumRows($result)==0) {
	echo "<h4>Not found!!!</h4>";
} else {
for($j=1; $j<=pg_NumRows($result); $j++) {
$row=pg_fetch_array($result,($j-1));
echo "<td align=right bgcolor=$color><b>Total  $i<b/></td>";
echo "<td align=right bgcolor=$color><b>".$row['certificate_no']."</b></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color><B>".$row['amount_deposit']."</B></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color><b>".$row['total_interest']."</b></td>";
echo "<td align=right bgcolor=$color><b>".$row['maturity_amount']."</b></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color><b>".$row['withdrawal_amount']."</b></td>";
}
}

echo "</table>";
}

echo "<hr>";
echo "<br>";

//--------------------------------------------
// Ledger Section
// Detail Statement of fixed deposits based on date of withdrawal_date 
//
$sql_statement="SELECT * FROM fd_ledger  WHERE withdrawal_date BETWEEN '$starting_date' AND '$ending_date' ORDER BY withdrawal_date";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"pink\" colspan=\"14\" align=\"center\"><font color=\"blue\">Detail of $name (Based on Date of Withdrawal)</font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Account no</th>";
echo "<th bgcolor=$color>No. of Certificate</th>";
echo "<th bgcolor=$color>Opening date</th>";
echo "<th bgcolor=$color>Scheme</th>";
echo "<th bgcolor=$color>Period</th>";
echo "<th bgcolor=$color>Int. Method</th>";
echo "<th bgcolor=$color>Amount deposit</th>";
echo "<th bgcolor=$color>Rate of interest</th>";
echo "<th bgcolor=$color>Total interest</th>";
echo "<th bgcolor=$color>Maturity amount</th>";
echo "<th bgcolor=$color>Maturity date</th>";
echo "<th bgcolor=$color>Withdrawn type</th>";
echo "<th bgcolor=$color>Withdrawal date</th>";
echo "<th bgcolor=$color>Withdrawal amount</th>";

$i=0;
for($j=1; $j<=pg_NumRows($result); $j++) {
$i++;
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=right bgcolor=$color><a href=\"fd_ledger_detail.php?account_no=".$row['account_no']."\" target=\"_blank\">".$row['account_no']."</a></td>";

echo "<td align=right bgcolor=$color>".$row['certificate_no']."</td>";
echo "<td align=right bgcolor=$color>".$row['opening_date']."</td>";
echo "<td align=left bgcolor=$color>".$scheme_array[trim($row['scheme'])]."</td>";
echo "<td align=right bgcolor=$color>".$row['period']."</td>";
echo "<td align=right bgcolor=$color>".$fd_compute_type_array[trim($row['fd_compute_type'])]."</td>";
echo "<td align=right bgcolor=$color>".$row['amount_deposit']."</td>";
echo "<td align=right bgcolor=$color>".$row['rate_of_interest']."</td>";
echo "<td align=right bgcolor=$color>".$row['total_interest']."</td>";
echo "<td align=right bgcolor=$color>".$row['maturity_amount']."</td>";
echo "<td align=right bgcolor=$color>".$row['maturity_date']."</td>";
echo "<td align=right bgcolor=$color>".$row['withdrawn_type']."</td>";
echo "<td align=right bgcolor=$color>".$row['withdrawal_date']."</td>";
echo "<td align=right bgcolor=$color>".$row['withdrawal_amount']."</td>";
}

echo "<tr>";
$color="cyan";

$sql_statement="SELECT sum(principal) AS amount_deposit,sum(maturity_amount)-sum(principal) AS total_interest, sum(maturity_amount) AS maturity_amount,count(certificate_no) AS certificate_no,sum(withdrawal_amount) AS withdrawal_amount FROM deposit_info  WHERE account_type='$menu' AND withdrawal_date BETWEEN '$starting_date' AND '$ending_date'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
	echo "<h4>Not found!!!</h4>";
} 

else {
$i=0;
for($j=1; $j<=pg_NumRows($result); $j++) {
$i++;
$row=pg_fetch_array($result,($j-1));
echo "<td align=right bgcolor=$color>Total $i</td>";
echo "<td align=right bgcolor=$color><b>".$row['certificate_no']."</b></td>";

echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color><B>".$row['amount_deposit']."</B></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color><b>".$row['total_interest']."</b></td>";
echo "<td align=right bgcolor=$color><b>".$row['maturity_amount']."</b></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color><B>".$row['withdrawal_amount']."</B></td>";
}
}
echo "</table>";
}

echo "</body>";
echo "</html>";
?>
