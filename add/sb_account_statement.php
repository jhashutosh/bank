<?
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$menu=$_REQUEST['menu'];
if(empty($op)){
	$account_no=$_SESSION["current_account_no"];
	isPermissible($menu);
}
else{
	$account_no=$_REQUEST["account_no"];
}
echo "<html>";
echo "<head>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<title>Statement";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$title='Saving Bank';
echo "<h3>Account Statement [$account_no]";
echo "</h3><hr>";
$id=getCustomerId($account_no,$menu);
//echo "id is :$id";
// Customization required for WHERE CLAUSE
$flag=getGeneralInfo_Customer($id);
if($flag==1)
{
$gl_code=getGlCode4mCustomerAccount($account_no);
//$sql_statement="SELECT * FROM sb_ledger WHERE account_no='$account_no' ORDER BY action_date, tran_id DESC";
$sql_statement="SELECT * FROM advance_ledger WHERE account_no='$account_no' AND action_date<= current_date ORDER BY entry_time DESC";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>New Account</h4>";
} else {
echo "<table valign=\"top\" width=\"100%\">";
$balance=sb_current_balance($account_no);
if($balance>0){$dr_cr="Cr.";}
else{$dr_cr="Dr.";}


//echo $balance;
echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\">Statement</font><font color=BLACK size=+1><b>[Current Balance:Rs.".amount2Rs(abs($balance))." $dr_cr]</b></font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;

echo "<tr>";
echo "<th bgcolor=$color>Transaction Id</th>";
echo "<th bgcolor=$color>Date</th>";
echo "<th bgcolor=$color>Particulars</th>";
echo "<th bgcolor=$color>Given (Rs.)</th>";
echo "<th bgcolor=$color>Back (Rs.)</th>";
echo "<th bgcolor=$color>Balance (Rs.)</th>";
echo "<th bgcolor=$color>Remarks</th>";
echo "<th bgcolor=$color>Operator code</th>";
echo "<th bgcolor=$color>Entry time</th>";
for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
if(!empty($row['cheque_no'])){$par="ch-".$row['cheque_no']."[".$row['certificate_no']."]";}
else{$par=$row['particulars'];}
echo "<tr>";
echo "<td align=right bgcolor=$color><a href =\"../general/voucherdetails.php?tran_id=".$row['tran_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=700,height=500'); return false;\" >".$row['tran_id']."</a></td>";
echo "<td align=right bgcolor=$color>".$row['action_date']."</td>";
echo "<td  bgcolor=$color>".$par."</td>";
echo "<td align=right bgcolor=$color>".$row['given']."</td>";
echo "<td align=right bgcolor=$color>".$row['back']."</td>";
echo "<td align=right bgcolor=$color>".abs($row['balance'])." ".$row['dr_cr']."</td>";
echo "<td align=right bgcolor=$color>".$row['remarks']."</td>";
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
