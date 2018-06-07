<?
include "../config/config.php";
//$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$menu=$_REQUEST['menu'];
$tran_id=$_REQUEST['tid'];
$ac_st=$_REQUEST['st'];
if($ac_st=='i'){
	$sql_statement="update sb_cheque_clearing set clearing_dt='".$_REQUEST['clearing_dt']."' ,clearing_ref='".$_REQUEST['clearing_ref']."' ,bank_charge='".$_REQUEST['bank_charge']."'  where tran_id='$tran_id'";
$result=dBConnect($sql_statement);
}
echo "<html>";
echo "<head>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<title>Saving Bank Clearing Cheque List";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$title='Saving Bank Cheque Clearing List: Click on Tran Id of cheque you want to edit';

$sql_statement="select tran_id, account_no, action_date,cheque_no, bank_name, amount, clearing_dt, clearing_ref, bank_charge from sb_cheque_clearing where tran_id='$tran_id'";
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result,0);
echo "<table bgcolor=#00CED1 width=90% align=center>";
echo "<tr><td bgcolor=\"green\" colspan=\"4\" align=\"center\"><font color=\"white\">Enter Clearing Information of Selected Cheque</font><font color=BLACK size=+1></font>";
echo "<tr>";
echo "<td>Action Date: </td>";
echo "<td>".$row['action_date']. "</td>";
echo "<td>Tran Id: </td>";
echo "<td>".$row['tran_id']."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Account No: </td>";
echo "<td>".$row['account_no']. "</td>";
echo "<td>Tran Id: </td>";
echo "<td>".$row['tran_id']."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Cheque No: </td>";
echo "<td>".$row['cheque_no']. "</td>";
echo "<td>Cheque Dt: </td>";
echo "<td>".$row['cheque_date']."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Bank Name: </td>";
echo "<td>".$row['bank_name']. "</td>";
echo "<td>Bank Branch: </td>";
echo "<td>".$row['branch']."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Cheque Dt: </td>";
echo "<td>".$row['cheque_date']. "</td>";
echo "<td>Amount: </td>";
echo "<td>".$row['amount']."</td>";
echo "</tr>";

echo "<form name=\"f2\" method=\"POST\" action=\"sb_clearing_cheque_list.php?menu=$menu&st=i&tid=$tran_id\">";

echo "<tr>";
echo "<td>Clearing Dt: </td>";
echo "<td><input type=\"TEXT\" name=\"clearing_dt\" size=\"15\" value=".$row['clearing_dt']."></td>";
echo "<td>Clearing Ref: </td>";
echo "<td><input type=\"TEXT\" name=\"clearing_ref\" size=\"15\" value=".$row['clearing_ref']."></td>";
echo "</tr>";

echo "<tr>";
echo "<td>Bank Charges: </td>";
echo "<td><input type=\"TEXT\" name=\"bank_charge\" size=\"15\" value=".$row['bank_charge']."></td>";
echo "<td>Submit: </td>";
echo "<td><input type=\"Submit\"  value=\"Enter\"></td>";
echo "</tr>";

echo "</form>";


echo "</table>"; 

$sql_statement="select tran_id, account_no, action_date,cheque_no, bank_name, amount, clearing_dt, clearing_ref, bank_charge from sb_cheque_clearing where clearing_dt is null or action_date > current_date-5 order by tran_id desc";

$result=dBConnect($sql_statement);
$row=pg_fetch_array($result,($j-1));
if(pg_NumRows($result)==0) {
  echo "<h4>No Cheques Pending Clearance or deposited in last 5 days</h4>";
} else {
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\">$title</font><font color=BLACK size=+1></font>";
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Transaction Id</th>";
echo "<th bgcolor=$color>Date</th>";
echo "<th bgcolor=$color>Cheque No</th>";
echo "<th bgcolor=$color>Bank Name</th>";
echo "<th bgcolor=$color>Clearing_dt</th>";
echo "<th bgcolor=$color>Bank Charge</th>";
echo "<th bgcolor=$color>Amount</th>";

for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=right bgcolor=$color><a href=\"sb_clearing_cheque_list.php?menu=$menu&tid=".$row['tran_id']."\">".$row['tran_id']."</a></td>";
echo "<td align=right bgcolor=$color>".$row['action_date']."</td>";
echo "<td align=right bgcolor=$color>".$row['cheque_no']."</td>";
echo "<td align=right bgcolor=$color>".$row['bank_name']."</td>";
echo "<td align=right bgcolor=$color>".$row['clearing_dt']."</td>";
echo "<td align=right bgcolor=$color>".$row['bank_charge']."</td>";
echo "<td align=right bgcolor=$color>".$row['amount']."</td>";
   }  // for loop
echo "</table>";
}// data loop

if(!empty($op)){
echo "<DIV ID=\"date_time\" style=\"position:relative; left:5; top:5\">";
echo "<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> </DIV> ";
}

echo "</body>";
echo "</html>";
?>
