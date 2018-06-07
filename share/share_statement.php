<?php
include "../config/config.php";
$staff_id=verifyAutho();
if(isset($_REQUEST['account_no']))
{
$account_no=$_REQUEST['account_no'];
}
else
{
	$account_no='';
}

if(empty($account_no)){
$account_no=$_SESSION["current_account_no"];
}
$menu=$_REQUEST['menu'];
//isPermissible($menu);
echo "<html>";
echo "<head>";
echo "<title>Statement";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h3>Account Statement [$account_no]";
echo "</h3><hr>";
// Customization required for WHERE CLAUSE
$id=getCustomerIdFromMember($account_no);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
$sql_statement="SELECT * FROM share_detail_view WHERE account_no='$account_no' and action_date<=current_date order by entry_time DESC";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>New Account</h4>";
} else {
echo "<table valign=\"top\" width=\"100%\">";
share_current_balance($account_no,$no,$val,date('Y/m/d'));
echo "<tr><td bgcolor=\"green\" colspan=\"12\" align=\"center\"><font color=\"white\">Statement</font><font color=BLACK size=+1><b>[Current Balance:Value=>Rs. $val/= And No.=>$no]</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color rowspan=2>Transaction Id</th>";
echo "<th bgcolor=$color rowspan=2>Particulars</th>";
echo "<th bgcolor=$color rowspan=2>Action Date</th>";
echo "<th bgcolor=$color colspan=\"2\">Issue</th>";
echo "<th bgcolor=$color colspan=\"2\">BuyBack</th>";
echo "<th bgcolor=$color colspan=\"2\">Balance</th>";
echo "<th bgcolor=$color rowspan=2>Operator code</th>";
//echo "<th bgcolor=$color rowspan=2>Ledger Folio</th>";
echo "<th bgcolor=$color rowspan=2>Entry time</th><tr>";
echo "<th bgcolor=$color colspan=\"1\">share</th>";
echo "<th bgcolor=$color colspan=\"1\">value(Rs.)</th>";
echo "<th bgcolor=$color colspan=\"1\">share</th>";
echo "<th bgcolor=$color colspan=\"1\">value(Rs.)</th>";
echo "<th bgcolor=$color colspan=\"1\">share</th>";
echo "<th bgcolor=$color colspan=\"1\">value(Rs.)</th>";
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
if(trim($row['dr_cr'])=='Cr'){
       $val_issue=sprintf("%-12.0f",$row['amount']);
       $no_issue=sprintf("%-12.0f",$row['qty']);
       $val_buyback=0;
       $no_buyback=0;
}
else {
       $val_issue=0;
       $no_issue=0;
       $val_buyback=sprintf("%-12.0f",$row['amount']);
       $no_buyback=sprintf("%-12.0f",$row['qty']);
}
echo "<td align=left bgcolor=$color>".$row['tran_id']."</td>";
echo "<td align=left bgcolor=$color>".$row['particulars']."</td>";
echo "<td align=left bgcolor=$color>".$row['action_date']."</td>";
echo "<td align=right bgcolor=$color>$no_issue</td>";
echo "<td align=right bgcolor=$color>$val_issue</td>";
echo "<td align=right bgcolor=$color>$no_buyback</td>";
echo "<td align=right bgcolor=$color>$val_buyback</td>";
echo "<td align=right bgcolor=$color>$no</td>";
echo "<td align=right bgcolor=$color>$val</td>";
echo "<td align=left bgcolor=$color>".$row['operator_code']."</td>";
//echo "<td align=left bgcolor=$color>".$row['lf_no']."</td>";
echo "<td align=left bgcolor=$color>".$row['entry_time']."</td>";

$val=$val-$val_issue+$val_buyback;
$no=$no-$no_issue+$no_buyback;
}
echo "</table>";
  }

}

echo "</body>";
echo "</html>";
?>
