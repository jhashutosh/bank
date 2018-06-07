<?
include "../config/config.php";
$menu=$_REQUEST['menu'];
$staff_id=verifyAutho();
$account_no=$_REQUEST["account_no"];
$id=$_REQUEST['id'];
echo "<HTML>";
echo "<HEAD>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<TITLE>Statement</TITLE>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</HEAD>";
echo "<BODY bgcolor=\"SILVER\">";
echo "<h3>".$type_of_account1_array[$menu]." Account Statement[$account_no]</h3>";
$flag=getBankInfo($id);
if($flag==1){
echo "<hr>";
// Ledger Section*/
$sql_statement="SELECT * FROM bk_investment WHERE account_no='$account_no' AND account_type='$menu'";
//echo $sql_statement; 
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"16\" align=\"center\"><font color=\"white\">Statement [$account_no] </font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Certificate no</th>";
echo "<th bgcolor=$color>Opening date</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color>Rate of interest</th>";
echo "<th bgcolor=$color>Total interest</th>";
echo "<th bgcolor=$color>Maturity amount</th>";
echo "<th bgcolor=$color>Maturity date</th>";
echo "<th bgcolor=$color>Withdrawn type</th>";
echo "<th bgcolor=$color>Withdrawal date</th>";
echo "<th bgcolor=$color>Withdrawal amount</th>";
echo "<th bgcolor=$color>Operator code</th>";
echo "<th bgcolor=$color>Entry time</th>";
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
if($row['certificate_no']==$certificate_no_DEFAULT){$row['certificate_no']="";}
echo "<td align=left bgcolor=$color>".$row['certificate_no']."</td>";

echo "<td align=right bgcolor=$color>".$row['action_date']."</td>";
echo "<td align=right bgcolor=$color>".$row['principal']."</td>";
if($row['interest_rate']==$rate_of_interest_DEFAULT){$row['interest_rate']="";}
echo "<td align=right bgcolor=$color>".$row['interest_rate']."%</td>";
echo "<td align=right bgcolor=$color>".($row['maturity_amount']-$row['principal'])."</td>";
if($row['maturity_amount']==$maturity_amount_DEFAULT){$row['maturity_amount']="";}
echo "<td align=right bgcolor=$color>".$row['maturity_amount']."</td>";
if($row['maturity_date']==$maturity_date_DEFAULT){$row['maturity_date']="";}
echo "<td align=right bgcolor=$color>".$row['maturity_date']."</td>";
//if($row['withdrawn_type']==$withdrawn_type_DEFAULT){$row['withdrawn_type']="";}
echo "<td align=Center bgcolor=$color>".$row['withdrawal_type']."</td>";
if($row['withdrawal_date']==$withdrawal_date_DEFAULT){$row['withdrawal_date']="";}
echo "<td align=right bgcolor=$color>".$row['withdrawal_date']."</td>";
if($row['withdrawal_amount']==$withdrawal_amount_DEFAULT){$row['withdrawal_amount']="";}
echo "<td align=right bgcolor=$color>".$row['withdrawal_amount']."</td>";
echo "<td align=right bgcolor=$color>".$row['operator_code']."</td>";
echo "<td align=right bgcolor=$color>".$row['entry_time']."</td>";
}
echo "</table>";
  }
}
if(!empty($op)){
echo "<DIV ID=\"date_time\" style=\"position:relative; left:5; top:5\">";
echo "<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> </DIV> ";
}

echo "</body>";
echo "</html>";
?>
