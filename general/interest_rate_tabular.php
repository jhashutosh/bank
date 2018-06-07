<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$period=$_REQUEST['period'];
if ($menu=='fd'){$method='Days';}
if ($menu=='rd' ||$menu=='ri'){$method='Months';}
if ( $menu=='mis'){$method='year';}

if ($menu=='fd'){$menu1='Fixed Deposit';}
if ($menu=='rd'){$menu1='Recurring Deposit';}
if ($menu=='ri'){$menu1='Re-investment';}
if ($menu=='mis'){$menu1='MIS';}
echo "<html>";
echo "<head>";
echo "<title>Table: interest_rate";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=#F0E68C>";
echo "<h1><center>".strtoupper($menu)." Interest Rate Chart";
echo "</h1>";
//echo "<i>[fd_interest_rate] table in tabular format";
echo "<hr>";
$sql_statement="SELECT * FROM interest_rate where deposit_type='$menu' and period=$period ORDER BY id ";
$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_NumRows($result)==0) {
echo "<center><font color=\"green\"><h1><blink>Please Give The Interest Rate</blink></h1></font>";
echo "<h2>Go To</h2>";
echo "<h2>Setup--->Deposit--->Interest Rate Master--->$menu1--->New interest rate</center></h2>";
} else {
echo "<table width=\"100%\">";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Id</th>";
if ($menu!='sb'){
echo "<th bgcolor=$color>Period</th>";
}
echo "<th bgcolor=$color>Rate</th>";
echo "<th bgcolor=$color>Year With Effect</th>";
echo "<th bgcolor=$color>Scheme</th>";
echo "<th bgcolor=$color>Remarks</th>";
echo "<th bgcolor=$color>Operator code</th>";
echo "<th bgcolor=$color>Operation</th>";
echo "<th bgcolor=$color>Entry time</th>";
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=right bgcolor=$color>".$row['id']."</td>";
if ($menu!='sb'){
echo "<td align=left bgcolor=$color>".$row['period']." $method</td>";
}
echo "<td align=right bgcolor=$color>".$row['rate']."</td>";
echo "<td align=Center bgcolor=$color>".$row['year_witheffect']."</td>";
echo "<td bgcolor=$color>".$scheme_array[$row['scheme']]."</td>";
echo "<td align=right bgcolor=$color>".$row['remarks']."</td>";
echo "<td align=right bgcolor=$color>".$row['operator_code']."</td>";
echo "<td align=right bgcolor=$color><a href=\"interest_rate_ef.php?menu=$menu\">New</a><<>><a href=\"interest_rate_ef.php?menu=$menu&status=u&id=".$row['id']."\">Update</td>";
echo "<td align=right bgcolor=$color>".$row['entry_time']."</td>";

}
echo "</table>";
}
echo "</body>";
echo "</html>";
?>
