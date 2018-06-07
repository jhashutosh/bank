<?
include "../../config/config.php";
$status=$_REQUEST['status'];
$account_type=$_REQUEST['account_type'];
$sql_statement="select customer_id,account_no,name1,address,certificate_no,opening_date,principal, withdrawal_amount,withdrawal_date from customer_all where account_type='$account_type' and operation_mode='$status' order by cast(substring(account_no,3) as int)";

$result=dBConnect($sql_statement);
echo "<head>";
echo "<title>List of accounts";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\">";


if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table width=\"100%\">";
$color==$TCOLOR;
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td bgcolor=$color width=\"12%\" >".$row['customer_id']."</td>";
echo "<td bgcolor=$color width=\"13%\" ><a href=\"account_sb_detail.php?account_no=".$row['account_no']."\" target=\"_blank\">".$row['account_no']."</a></td>";
echo "<td bgcolor=$color width=\"15%\" >".ucwords($row['name1'])."</td>";
echo "<td bgcolor=$color width=\"40%\" >".ucwords($row['address'])."</td>";
echo "<td bgcolor=$color width=\"40%\" >".ucwords($row['principal'])."</td>";
echo "<td bgcolor=$color width=\"40%\" >".ucwords($row['withdrawal_amount'])."</td>";
echo "<td bgcolor=$color width=\"10%\" >".ucwords($row['opening_date'])."</td>";
echo "<td bgcolor=$color width=\"40%\" >".ucwords($row['withdrawal_date'])."</td>";
echo "<td align=right bgcolor=$color width=\"10%\"><a href=\"set_account.php?account_no=".$row['account_no']."&menu=sb\" target=\"_parent\"> ledger </a></td>";
}
echo "</table>";
}

?>
