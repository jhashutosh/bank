<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$status=$_REQUEST['status'];
$end_date=$_REQUEST['current_date'];
//$gl_code=$_REQUEST['code'];
//echo "status is:$status=>>>>>>>>>>>>>>>>>>>>>>>>>>>>>$end_date";
echo "<html>";
echo "<head>";
echo "<title>Saving Bank Current Balance";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
//$title='Saving Bank';
if($menu=='sh'){
	$sql_statement="SELECT * FROM customer_member cm,(SELECT account_no,SUM(credit-debit) balance FROM mas_gl_tran where gl_mas_code='$status' and action_date<='$end_date' GROUP BY account_no HAVING SUM(credit-debit)>0) cbt where cm.membership_no = cbt.account_no order by cast(substr(membership_no,3,length(membership_no)) AS int)";
}
else{
	$sql_statement="SELECT * FROM customer_sb csb,(SELECT account_no as account,SUM(credit-debit) balance FROM mas_gl_tran where gl_mas_code='$status' and action_date<='$end_date' GROUP BY account HAVING SUM(credit-debit)>0)cbt where csb.account_no= cbt.account order by cast(substr(account_no,4,length(account_no)) AS int)";


}
if($status=="all"){
//$sql_statement=$sql_statement."order by cast(substring(cbt.account_no,3) as int)";
//$sql_statement=$sql_statement."order by cbt.account_no";
}
else{
//$sql_statement=$sql_statement."AND cbt.gl_mas_code='$status' order by cast(substring(cbt.account_no,3) as int)";
//$sql_statement=$sql_statement."AND cbt.gl_mas_code='$status' order by cbt.account_no";
}
//echo $sql_statement;
$color=$TCOLOR;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table width=\"110%\">";
for($j=1; $j<=pg_NumRows($result); $j++) 
{
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td bgcolor=$color width=12%><a href=\"../main/set_account.php?menu=$menu&account_no=".$row['account_no']."\" target=\"_blank\" width=\"100\">".$row['account_no']."</a></td>";
	echo "<td  bgcolor=$color width=\"600\" >".ucwords($row['name1'])."</td>";
	//echo "<td align=right bgcolor=$color width=\"100\">".$row['action_date']."</td>";
	echo "<td align=right bgcolor=$color width=\"\">".amount2Rs($row['balance'])."</td>";
	}

echo "</table>";
}
echo "</body>";
echo "</html>";
?>
