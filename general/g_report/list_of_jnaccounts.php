<?php 
include "../../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST["menu"];

if($menu=='fd'){$account_type='fd';}
if($menu=='fd'){$account_type='fd';}
if($menu=='rd'){$account_type='rd';}
if($menu=='ri'){$account_type='ri';}
if($menu=='mis'){$account_type='mis';}
if($status=='jo'){$status_name='Joint';} else {$status_name='Single';}


$sql_statement="select customer_id from customer_all where account_type='$account_type' and operation_mode='$status' order by cast(substring(account_no,3) as int)";

$result=dBConnect($sql_statement);
//echo $sql_statement;
echo "<html>";
echo "<head>";
echo "<title>List of accounts";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\"	>";

if(pg_NumRows($result)==0) {
echo "<h4>Not found abc!!!</h4>";
} else {
$row=pg_NumRows($result);
$account_name=RegetIndex($type_of_account1_array,$account_type);
echo "<table width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\">Customer Details Of $account_name A/C[".ucwords($status_name)." Account Wise]</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color width=\"12%\">Customer Id</th>";
echo "<th bgcolor=$color width=\"13%\">Account No.</th>";
echo "<th bgcolor=$color width=\"15%\">Name</th>";
echo "<th bgcolor=$color width=\"40%\">Address</th>";
echo "<th bgcolor=$color width=\"10%\">Deposit Amount</th>";
echo "<th bgcolor=$color width=\"10%\">withdrawn Amount</th>";
echo "<th bgcolor=$color width=\"10%\">Opening Date</th>";
echo "<th bgcolor=$color width=\"10%\">Withdrawn Date</th>";
echo "<th bgcolor=$color width=\"10%\">&nbsp; View &nbsp;</th>";
echo "<tr><td colspan=\"9\" align=center><iframe src=\"list_of_jnaccounts_db.php?status=$status&account_type=$account_type\" width=\"100%\" height=\"290\" ></iframe>";
echo "<tr bgcolor=cyan><td colspan=9 align=center>Total : <font color=red><b>$row</b></font> SB Account Holder";
echo "</table>";
}
footer();

echo "</body>";
echo "</html>";
?>
