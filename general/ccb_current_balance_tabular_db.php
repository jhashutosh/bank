<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$status=$_REQUEST['status'];
$op=$_REQUEST['op'];
//echo "status is:$status";
echo "<html>";
echo "<head>";
echo "<title>Saving Bank Current Balance";
echo "</title>";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
//$sql_statement="SELECT * FROM ccb_ledger where gl_mas_code=$status";
$sql_statement="SELECT distinct account_no FROM ccb_ledger where gl_mas_code=$status order by account_no";
//echo $sql_statement;
$color=$TCOLOR;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table width=\"\100%\">";
for($j=1; $j<=pg_NumRows($result); $j++) 
{
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
//echo "<td bgcolor=$color><a href=\"set_account.php?menu=sb&account_no=".$row['account_no']."\" target=\"_parent\" width=\"122\" align=\"right\">".$row['account_no']."</a></td>";
	echo "<td  bgcolor=$color width=\"150\" >".$row['account_no']."</td>";
	$id=$id=getCustomerId($row['account_no'],'sb');
	echo "<td  bgcolor=$color width=\"264\" >".getName('bank_id',$id,'bank_name','bank_dtl')."</td>";
	//echo "<td  bgcolor=$color width=\"180\" >".ucwords($row['gl_mas_code'])."</td>";
	echo "<td  bgcolor=$color width=\"160\" >".(float)$row['balance']."</td>";
	//echo "<td  bgcolor=$color width=\"110\">".$row['balance']."</td>";
	}

echo "</table>";
}
echo "</body>";
echo "</html>";
?>
