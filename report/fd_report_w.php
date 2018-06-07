<?
include "../config/config.php";
$staff_id=verifyAutho();
$date1=date('l dS \of F Y');
$menu=$_REQUEST["menu"];
if($menu=='sh'){$s_page="scroll_sh.php";}
else{$s_page="scroll.php";}
$starting_date=$_REQUEST["starting_date"];
$ending_date=$_REQUEST["ending_date"];

if( empty($starting_date) ) { $starting_date="05/02/2000"; }
//if( empty($starting_date) ) { $starting_date=date("d/m/Y",time()-604600); }
if( empty($ending_date) ) { $ending_date=date("d/m/Y"); }
if ($menu=='sb'){$table='sb_detail_view';$name='Saving Deposit';}
if ($menu=='fd'){$table='fd_detail_view';$name='Fixed Deposit';}
if ($menu=='rd'){$table='rd_detail_view';$name='Recurring Deposit';}
if ($menu=='ri'){$table='ri_detail_view';$name='Re-Investment Deposit';}
if ($menu=='mis'){$table='mis_detail_view';$name='MIS Deposit';}
if ($menu=='sh'){$table='share_detail_view';$name='Share';}
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"st_dt.focus();\">";
echo "<font color=\"blue\"><b>$SYSTEM_TITLE</font>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<font color=\"green\">$date1</font></center><br>";
echo "<font size=+2>Withdrawal from - FD";
echo "</font>";
echo "<hr>";
echo "<form method=\"POST\" action=\"fd_report_w.php?menu=$menu\">";
echo "FD Date: <input type=\"HIDDEN\" name=\"starting_date\" size=\"12\" value=\"$starting_date\" id=\"st_dt\" $HIGHLIGHT>";
echo "  <input type=\"TEXT\" name=\"ending_date\" size=\"12\" value=\"$ending_date\" $HIGHLIGHT>";
echo " <input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "<hr>";

$sql_statement="SELECT action_date,SUM(case when dr_cr='Cr' THEN amount ELSE 0 END) as deposit,SUM(case when dr_cr='Dr' THEN amount ELSE 0 END) as withdrawal from $table group by action_date having action_date BETWEEN '$starting_date' AND '$ending_date'  ORDER BY action_date DESC";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table valign=\"top\" width=\"50%\" align=center>";
echo "<tr><td bgcolor=\"red\" colspan=\"2\" align=\"center\"><font color=\"white\"><b>WithDrawal Amount upto $ending_date</b></font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Date</th>";
echo "<th bgcolor=$color>Withdrawals (Rs.)</th>";
//echo "<th bgcolor=$color>Deposits (Rs.)</th>";
//echo "<th bgcolor=$color>Balance (Rs.)</th>";
//echo "<th bgcolor=$color>Operation</th>";
$total_withdrawals=0;
//$total_deposits=0;
//$total_balance=0;
//$off_set=0;
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=right bgcolor=$color>".$row['action_date']."</td>";
echo "<td align=right bgcolor=$color>".$row['withdrawal']."</td>";
//echo "<td align=right bgcolor=$color>".$row['deposit']."</td>";
//echo "<td align=right bgcolor=$color>".($row['deposit']-$row['withdrawal'])."</td>";
//echo "<td align=center bgcolor=$color><a href=\"../general/".$s_page."?menu=$menu&current_date=".$row['action_date']."\"onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;\">Details</a></td>";
$total_withdrawals=$total_withdrawals+$row['withdrawal'];
//$total_deposits=$total_deposits+$row['deposit'];
}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color><B>Total</B></td>";
echo "<td align=right bgcolor=$color><B>".$total_withdrawals."</B></td>";
//echo "<td align=right bgcolor=$color><B>".$total_deposits."</B></td>";
//echo "<td align=right bgcolor=$color><B>".($total_deposits-$total_withdrawals)."</B></td>";
//echo "<td align=center bgcolor=$color></td>";
echo "</table>";
}

echo "</body>";
echo "</html>";
?>
