<?php
include "../config/config.php";
echo "<html>";
echo "<head>";
echo "<title>SHG loan  Closed Account List";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<b><u><font color=\"red\">Report No. 6</u> </b></font>";

echo "<h1><font color=\"red\">SHG not eligible for loan list</font>";
echo "</h1>";
echo "<form method=\"POST\" action=\"shg_closed.php\">";
$db=pg_pConnect("host=$HOST dbname=$DATABASE");
$sql_statement="SELECT  * FROM shg_info_t WHERE loan_el_date>current_date";
$result=pg_Exec($db,$sql_statement);
//echo $sql_statement;
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
}
 else {
echo "<table width=\"100%\>";
echo "<tr><td bgcolor=\"cyan\" colspan=\"3\" align=\"center\"><font color=\"red\"><b><b></font>"
;
echo "<tr><td bgcolor=\"cyan\" colspan=\"3\" align=\"center\"><font color=\"red\"><b>Closed Account List<b></font>";// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Group No.</th>";
echo "<th bgcolor=$color colspan=\"1\">Group Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Leader Name</th>";
//echo "<th bgcolor=$color colspan=\"1\">Loan account no.</th>";
// echo "<th bgcolor=$color colspan=\"1\">Closing Date </th>";

echo "<tr>";
for($j=1; $j<=pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,($j-1));
	echo "<td align=right bgcolor=$color><a href=\"shg_mem_detail.php?group_no=".$row['group_no']."\" target=\"display\">".$row['group_no']."</a></td>";
	echo "<td align=right bgcolor=$color>".$row['title']."</td>";
 echo "<td align=right bgcolor=$color>".$row['leader']."</td>";
echo"<tr>";
	//echo "<td align=right bgcolor=$color>".$row['loan_account_no']."</td>";
//echo "<td align=right bgcolor=$color>".$row['date_of_closing']."</td>";
}
echo "</table>";
}
echo "<br>";
footer();
echo "</body>";
echo "</html>";
?>
