<?
include "../config/config.php";
echo "<html>";
echo "<head>";
echo "<title>SHG loan  Closed Account List";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
//echo "<b><u><font color=\"red\">Report No. 6</u> </b></font>";

 //echo "<h3><font color=\"red\">SHG Loan Closed Account List</font>";
 //echo "</h3>";
echo "<form method=\"POST\" action=\"shg_closed.php\">";
$db=pg_pConnect("host=$HOST dbname=$DATABASE");
$sql_statement="SELECT  * FROM shg_closed_loan";
$result=pg_Exec($db,$sql_statement);
//echo $sql_statement;
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
}
 else {
echo "<table width=\"100%\>";
echo "<tr><td bgcolor=\"cyan\" colspan=\"6\" align=\"center\"><font color=\"red\"><b><b></font>"
;
echo "<tr><td bgcolor=\"green\" colspan=\"11\" align=\"left\"><font color=\"white\"><b>Report 6: &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;SHG LOAN CLOSED ACCOUNT LIST<b></font>";// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Group No.</th>";
echo "<th bgcolor=$color colspan=\"1\">Group Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Leader Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Loan account no.</th>";
 echo "<th bgcolor=$color colspan=\"1\">Closing Date </th>";
echo "<tr>";
for($j=1; $j<=pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,($j-1));
	echo "<td align=right bgcolor=$color><a href=\"shg_mem_detail.php?group_no=".$row['group_no']."\" target=\"display\">".$row['group_no']."</a></td>";
	echo "<td align=right bgcolor=$color>".$row['title']."</td>";
 echo "<td align=right bgcolor=$color>".$row['leader']."</td>";
	echo "<td align=right bgcolor=$color>".$row['loan_account_no']."</td>";
echo "<td align=right bgcolor=$color>".$row['date_of_closing']."</td>";
echo"<tr>";
}
$color="cyan";
   echo "<td align=left bgcolor=$color colspan=\"3\"><B>Total:&nbsp;".($j-1)."</B></td>";
   echo "<td align=right bgcolor=$color><B> </B></td>";
   echo "<td align=right bgcolor=$color><B></B></td>";
   echo "<td align=right bgcolor=$color><B></b></td>";
echo "</table>";
}
echo "<br>";
footer();
echo "</body>";
echo "</html>";
?>
