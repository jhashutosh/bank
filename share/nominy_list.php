<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
echo "<html>";
echo "<head>";
echo "<title>  Customer List Between Date";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<hr>";
//$sql_statement="SELECT * FROM nomination WHERE account_no like '%M-%'  order by cast(substr(account_no,2,length(account_no)) as int) DESC";


$sql_statement="SELECT nomination.account_no,name1,nomination.name,nomination.address,nomination.age,nomination.relation,customer_member.father_name1,customer_member.share_balance from nomination,customer_member where nomination.account_no=customer_member.membership_no order by cast(substr(account_no,2,length(account_no)) as int) DESC";

//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<center>";
echo "<h4><font size=5 color=green><blink> Please Enter Customer Details!!!</blink></font></h4>";
echo "</center>";
} else {
echo "<table width=\"100%\"class=\"border\">";
echo "<tr><td bgcolor=\"green\" colspan=\"10\" align=\"center\"><font size=3 color=\"white\"><b>Nomination Register</b></font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Membership No.</th>";
echo "<th bgcolor=$color>Member Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Nominee's Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Nominee's Address</th>";
echo "<th bgcolor=$color colspan=\"1\">Nominee's Age</th>";
echo "<th bgcolor=$color colspan=\"1\">Relation</th>";
echo "<th bgcolor=$color colspan=\"1\">Georgian Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Balance</th>";



for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td bgcolor=$color><a href=\"share_statement.php?menu=sh&account_no=".$row['account_no']."\" targer='_blank'>".ucwords($row['account_no'])."</a></td>";
	echo "<td bgcolor=$color>".ucwords($row['name1'])."</td>";
	echo "<td bgcolor=$color>".ucwords($row['name'])."</td>";
	echo "<td bgcolor=$color>".ucwords($row['address'])."</td>";
	echo "<td bgcolor=$color>".ucwords($row['age'])."</td>";
	echo "<td bgcolor=$color >".$relation_array[$row['relation']]."</td>";
	echo "<td bgcolor=$color>".ucwords($row['father_name1'])."</td>";
	echo "<td bgcolor=$color align=RIGHT>".amount2Rs($row['share_balance'])."</td>";
$total=$total+$row['share_balance'];
}
echo "<tr>";
$color="cyan";

echo "<td align=center bgcolor=$color colspan=\"7\"><b>Total:  $j Account  !!!!!!</b></td>";
 echo "<td align=\"right\" bgcolor=$color><B>".amount2Rs($total)."</B></td>";
echo "</table>";
}
echo "</body>";
echo "</html>";
?>
