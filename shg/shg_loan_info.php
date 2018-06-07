<?php
//fd_date wise matured list
include "config.php";
$db=pg_pConnect("host=$HOST dbname=$DATABASE");
$sql_statement="SELECT * FROM shg_main_int()";
$result=pg_Exec($db,$sql_statement);
echo "<html>";
echo "<head>";
echo "<title>Shg loan info";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h3><u><font color =\"red\">Report No.4</h3></u></font>";
echo "<h1>Loan information of SHG groups ";
echo "</h1>";
echo "<hr>";
echo "<form method=\"POST\" action=\"shg_loan_info.php\">";
echo "<hr>";
echo "<table  border=\"1\" width=\"80%\">";

echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\">Loan details of Shg groups</font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color >Loan Details</th>";
echo "<th bgcolor=$color >No. of groups</th>";
echo "<th bgcolor=$color >Loan amount taken(Rs.)</th>";
$color=$TCOLOR;
echo "<tr>";
echo "<td bgcolor=$color><a href=\"shg_due_list.php\"target=\"display\">Loan Due</td>";
$sql_statement="SELECT * FROM loan_due";
$result=pg_Exec($db,$sql_statement);
if(pg_NumRows($result)==0) {
  $loan_due=0;
  $i=1;
} 
else
{
  for($i=0;$i<=pg_NumRows($result);$i++)
    {
      $row=pg_fetch_array($result,$i);
      $loan_due=$loan_due+$row['principal'];
    }
}
echo "<td align=right bgcolor=$color>".($i-1)."</td>";
echo "<td align=right bgcolor=$color>$loan_due</td>";
echo "<tr>";
echo "<td bgcolor=$color><a href=\"shg_overdue_list.php\"target=\"display\"> Loan Overdue</td>";
//echo "<td bgcolor=$color>Loan Overdue</a></td>";
$sql_statement="SELECT * FROM loan_overdue";
$result=pg_Exec($db,$sql_statement);
if(pg_NumRows($result)==0) {
  $i=1;
  $loan_overdue=0;
} 
else
{
  for($i=0;$i<=pg_NumRows($result);$i++)
    {
      $row=pg_fetch_array($result,$i);
      $loan_overdue=$loan_overdue+$row['principal'];
    }
}
echo "<td align=right bgcolor=$color>".($i-1)."</td>";
echo "<td align=right bgcolor=$color>$loan_overdue</td>";
echo "<tr>";
echo "<td bgcolor=$color><a href=\"shg_not_el.php\"target=\"display\">Running but not eligible for Loan</td>";
$sql_statement="SELECT * FROM shg_loan_not_eligible";
$result=pg_Exec($db,$sql_statement);
if(pg_NumRows($result)==0) {
  $i=0;
  //$loan_overdue=0;
} 
else{
  $i=pg_NumRows($result);
  }
echo "<td align=right bgcolor=$color>$i</td>";

echo "<td align=right bgcolor=$color>XXX</td>";
echo "<tr>";
echo "<td bgcolor=$color><a href=\"shg_not_running.php\"target\">Eligible but loan not taken</td>";

$sql_statement="SELECT * FROM shg_loan_eligible_but";
$result=pg_Exec($db,$sql_statement);
if(pg_NumRows($result)==0) {
  $i=0;
  //$loan_overdue=0;
  } 
else{
  $i=pg_NumRows($result);
  }
echo "<td align=right bgcolor=$color>$i</td>";
echo "<td align=right bgcolor=$color>XXX</td>";
echo "<tr>";
echo "<td bgcolor=$color><a href=\"shg_closed.php\" target=\"display\">Loan repayed & closed a/c<a></td>";
$sql_statement="SELECT * FROM shg_loan_not_eligible";
$result=pg_Exec($db,$sql_statement);
if(pg_NumRows($result)==0) {
  $i=0;
 } 
else{
  $i=pg_NumRows($result);
  }
//	echo "<td bgcolor=$color>Loan repayed & closed a/c list</td>";
echo "<td align=right bgcolor=$color>$i</td>";
echo "<td align=right bgcolor=$color>XXX</td>";
//$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
//$row=pg_fetch_array($result,($j-1));
echo "<tr>";
//	echo "<td align=right bgcolor=$color><a href=\"set_account.php?account_no=".$row['account_no']."&menu=fd\" target=\"target\">".$row['account_no']."</a></td>";
//echo"<tr>";
//	echo "<td align=right bgcolor=$color></td>";

echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color><B>Total </B></td>";
echo "<td align=right bgcolor=$color><B></B></td>";
echo "<td align=right bgcolor=$color><B></B></td>";

echo "<br>";
echo"</table>";
footer();

echo "</body>";
echo "</html>";
?>
