<?php 
include "../../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST["menu"];
if($menu=='sb'){$table='customer_sb';}
if($menu=='fd'){$table='customer_fd';}
if($menu=='hsb'){$table='customer_hsb';}
if($menu=='rd'){$table='customer_rd';}
if($menu=='ri'){$table='customer_ri';}
if($menu=='mis'){$table='customer_mis';}
$op=$status;
$sql_statement="SELECT * FROM $table a where opening_date=(select max(opening_date) from $table b where a.account_no=b.account_no)";
if($status=="name"){
$sql_statement .= " ORDER BY name1";
}
else if($status=="so"||$status=="jn"){
$sql_statement .= " AND type_of_customer='$status' ORDER BY name1";
 $status=$type_of_account2_array[$status];
 }
else if($status=="14101"||$status=="14201"||$status=="14301"||$status=="14401"||$status=="14103"||$status=="14203"||$status=="14303"||$status=="14403"||
$status=="14102"||$status=="14202"||$status=="14302"||$status=="14402"||
$status=="14104"||$status=="14204"||$status=="14304"||$status=="14404"){
$sql_statement .= " AND gl_mas_code='$status' ORDER BY name1";
$status=strtoupper(findGlDesc($status));
}
else if($status=="account_no")
{$sql_statement .= " ORDER BY cast(substring(account_no,4) as int)";}
//{$sql_statement .= " ORDER BY account_no";}
//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<html>";
echo "<head>";
echo "<title>List of accounts";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\"	>";
//echo $sql_statement;
if(pg_NumRows($result)==0) {
echo "<h4>Not found abc!!!</h4>";
} else {
$row=pg_NumRows($result);
$account_name=RegetIndex($type_of_account1_array,$account_type);
echo "<table width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\">Customer Details Of $account_name A/C[".ucwords($status)." Wise]</font>";
// Place line comments if you do not need column header.
$color="#F0E68C";
echo "<tr>";
echo "<th bgcolor=$color width=\"12%\">Customer Id</th>";
echo "<th bgcolor=$color width=\"13%\">Account No.</th>";
echo "<th bgcolor=$color width=\"15%\">Name</th>";
echo "<th bgcolor=$color width=\"40%\">Address</th>";
echo "<th bgcolor=$color width=\"10%\">Opening Date</th>";
echo "<th bgcolor=$color width=\"10%\">&nbsp; View &nbsp;</th>";
echo "<tr><td colspan=\"6\" align=center><iframe src=\"list_of_accounts_db.php?status=$op&menu=$menu\" width=\"100%\" height=\"350\" ></iframe>";
echo "<tr bgcolor=cyan><td colspan=6 align=center>Total : <font color=red><b>$row </b></font>". strtoupper($menu)." Account Holder";
echo "</table>";
}
echo "</body>";
echo "</html>";
?>
