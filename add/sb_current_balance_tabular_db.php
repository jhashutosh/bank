<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$status=$_REQUEST['status'];
//echo "status is:$status";
echo "<html>";
echo "<head>";
echo "<title>Saving Bank Current Balance";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
//$title='Saving Bank';
if($menu=='sh'){
	$sql_statement="SELECT * FROM customer_member cm,current_balance_t cbt where cm.membership_id = cbt.account_no ";
}
else{
	$sql_statement="SELECT * FROM customer_sb csb,current_balance_t cbt where csb.account_no= cbt.account_no ";
}
if($status=="all"){
//$sql_statement=$sql_statement."order by cast(substring(cbt.account_no,3) as int)";
$sql_statement=$sql_statement."order by cbt.account_no";
}
else{
//$sql_statement=$sql_statement."AND cbt.gl_mas_code='$status' order by cast(substring(cbt.account_no,3) as int)";
$sql_statement=$sql_statement."AND cbt.gl_mas_code='$status' order by cbt.account_no";
}
//echo $sql_statement;
$color=$TCOLOR;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table width=\"100%\">";
for($j=1; $j<=pg_NumRows($result); $j++) 
{
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td bgcolor=$color><a href=\"../main/set_account.php?menu=sb&account_no=".$row['account_no']."\" target=\"_parent\" width=\"100\">".$row['account_no']."</a></td>";
	echo "<td  bgcolor=$color width=\"600\" >".ucwords($row['name1'])."</td>";
	//echo "<td align=right bgcolor=$color width=\"100\">".$row['action_date']."</td>";
	echo "<td align=right bgcolor=$color width=\"\">".$row['balance']."</td>";
	}

echo "</table>";
}
echo "</body>";
echo "</html>";
?>
