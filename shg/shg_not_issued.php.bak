<?
include "../config/config.php";
/*$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$operator_code=$staff_id;
$starting_date=$_REQUEST["starting_date"];
$ending_date=$_REQUEST["ending_date"];
if( empty($starting_date) ) { $starting_date=date("d/m/Y",time()-604800); }
if( empty($ending_date) ) { $ending_date=date("d/m/Y"); }*/
echo "<html>";
echo "<head>";
echo "<title>Shg group List";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h3><u><font color =\"red\">Report No.8</h3></u></font>";
echo "<h1>SHG groups applied but pending for loan ";
echo "</h1>";
echo "<hr>";
echo "<form method=\"POST\" action=\"shg_not_issued.php\">";
$db=pg_pConnect("host=$HOST dbname=$DATABASE");
$result=pg_Exec($db,$DATESTYLE);
$sql_statement="SELECT * FROM  loan_applied";

$result=pg_Exec($db,$sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4><font color=\"red\">Data Not Found</font></h4>";
} 
else 
{
	echo "<table  border=\"1\" width=\"80%\">";

echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\">Shg list for Loan not issued</font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color >Group No</th>";
echo "<th bgcolor=$color >Loan application no.</th>";
echo "<th bgcolor=$color >Leader name</th>";
echo "<th bgcolor=$color >Loan application date</th>";
echo "<th bgcolor=$color >Loan eligibility date</th>";
echo "<th bgcolor=$color >Loan amount applied(Rs.)</th>";
 echo "</tr>";
$i=0;
for($j=1;$j<=pg_NumRows($result);$j++){
$i++;
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,($j-1));
	echo "<tr>";
$g_id=$row['group_no'];
echo "<td align=right bgcolor=$color>".$g_id."</td>";


 echo "<td align=right bgcolor=$color><a href=\"loan_application_details.php?loan_application_no=".$row['loan_application_no']."\" target=\"display\">".$row['loan_application_no']."</a></td>";



//echo "<td align=right bgcolor=$color>".$row['loan_application_no']."</td>";
echo "<td align=right bgcolor=$color>".$row['leader']."</td>";
echo "<td align=right bgcolor=$color>".$row['action_date']."</td>";
echo "<td align=right bgcolor=$color>".$row['loan_el_date']."</td>";
echo "<td align=right bgcolor=$color>".$row['loan_applied']."<a href=\"shg_loan_ledger_ef.php?group_no=$g_id\">(isuue)</a></td>";
$total_amt=$total_amt+$row['loan_applied'];
}
echo "<tr>";
$color="cyan";
echo "<td align=left bgcolor=$color colspan=\"5\"><B>Total Account $i </B></td>";
echo "<td align=right bgcolor=$color><B>".$total_amt."</B></td>";
echo "<br>";
echo "</table>";
}
footor();
echo "</body>";
echo "</html>";
?>
