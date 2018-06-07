<?php
include "../../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
//echo "<h1>status is:$status";
if($menu=='sb'){$table='customer_sb';}
if($menu=='fd'){$table='customer_fd';}
if($menu=='rd'){$table='customer_rd';}
if($menu=='hsb'){$table='customer_hsb';}
if($menu=='ri'){$table='customer_ri';}
if($menu=='mis'){$table='customer_mis';}
$sql_statement="SELECT * FROM $table a where opening_date=(select max(opening_date) from $table b where a.account_no=b.account_no) ";
$op=$status;
$sql_statement="SELECT * FROM $table a where opening_date=(select max(opening_date) from $table b where a.account_no=b.account_no)";
if($status=="name"){
$sql_statement .= " ORDER BY name1";
}
if($status=="so"||$status=="jn"){
$sql_statement .= " AND type_of_customer='$status' ORDER BY name1";
 $status=$type_of_account2_array[$status];
 }
if($status=="14101"||$status=="14201"||$status=="14301"||$status=="14401"||
$status=="14103"||$status=="14203"||$status=="14303"||$status=="14403"||
$status=="14102"||$status=="14202"||$status=="14302"||$status=="14402"||
$status=="14104"||$status=="14204"||$status=="14304"||$status=="14404"){
$sql_statement .= " AND gl_mas_code='$status' ORDER BY name1";
//$status=findGlDesc($status);
}
if($status=="account_no")
{$sql_statement .= " ORDER BY cast(substring(account_no,4) as int)";}
//{$sql_statement .= " ORDER BY account_no";}
//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<head>";
echo "<title>List of accounts";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";


if(pg_NumRows($result)==0) {
echo "<h4>RECORD Not found!!!</h4>";
} else {
echo "<table width=\"100%\">";
$color==$TCOLOR;
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td bgcolor=$color width=\"10%\" >".$row['customer_id']."</td>";
echo "<td bgcolor=$color width=\"13%\" ><a href=\"../../main/pop_up_account.php?menu=$menu&account_no=".$row['account_no']."\" target=\"_blank\">".$row['account_no']."</a></td>";
echo "<td bgcolor=$color width=\"15%\" >".ucwords($row['name1'])."</td>";
echo "<td bgcolor=$color width=\"40%\" >".ucwords($row['address'])."</td>";
echo "<td bgcolor=$color width=\"10%\" >".ucwords($row['opening_date'])."</td>";
echo "<td align=right bgcolor=$color width=\"10%\"><a href=\"../../main/set_account.php?account_no=".$row['account_no']."&menu=$menu\" target=\"_parent\"> ledger </a></td>";
}
echo "</table>";
}

?>
