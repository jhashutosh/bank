<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$code=$_REQUEST['code'];
//$op=$_REQUEST['op'];
echo "status is:$code";
echo "<html>";
echo "<head>";
echo "<title>Saving Bank Current Balance";
echo "</title>";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
//$title='Saving Bank';
if($code=='28202'||$code=='28302'){
}
$sql_statement="SELECT * FROM ccb_ledger where gl_mas_code='$code'";
echo $sql_statement;
$color=$TCOLOR;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table width=\"90%\">";
for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td bgcolor=$color><a href=\"set_account.php?menu=sb&account_no=".$row['account_no']."\" target=\"_parent\" width=\"100\">".$row['account_no']."</a></td>";
	echo "<td  bgcolor=$color width=\"600\" >".ucwords($row['action_date'])."</td>";
	echo "<td  bgcolor=$color width=\"600\" >".ucwords($row['gl_mas_code'])."</td>";
	echo "<td  bgcolor=$color width=\"600\" >".ucwords($row['deposits'])."</td>";
	//echo "<td align=right bgcolor=$color width=\"100\">".$row['action_date']."</td>";
	echo "<td align=right bgcolor=$color width=\"\">".$row['balance']."</td>";
	}

echo "</table>";
}
echo "</body>";
echo "</html>";
?>
