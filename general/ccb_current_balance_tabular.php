<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$current_date=$_REQUEST['current_date'];
$status=$_REQUEST['op'];
//echo "status is:$status";
if(empty($current_date) ) {$current_date=date("d/m/Y");}
$balance=$_REQUEST['balance'];
if ($status=='28202'){$person='Savings A/c(SCB/CCB)[28202]';}
if ($status=='28302'){$person='Savings A/c(Other Banks)[28302]';}
if ($status=='22401'){$person='Invest In Recurring Deposit(SCB/CCB)[22401]';}
if ($status=='22402'){$person='Invest In Fixed Deposit(SCB/CCB)[22402]';}
if ($status=='22403'){$person='Invest In Re-invest Deposit(SCB/CCB)[22403]';}
if ($status=='22501'){$person='Invest In Recurring Deposit(Other Banks)[22501]';}
if ($status=='22502'){$person='Invest In Fixed Deposit(Other Banks)[22502]';}
if ($status=='22503'){$person='Invest In Re-invest Deposit(Other Banks)[22503]';}
echo "<html>";
echo "<head>";
echo "<title>Saving Bank Current Balance";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"cd.focus();\">";
echo "<hr>";
echo "<table align=center width=\"50%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"3\" align=\"center\"><font color=\"white\">Current Balance of $person as on $current_date</font><font size=+1 color=\"Black\"<B>[Rs.$balance]</font></b>";
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color width=\"250\">A/C No.</th>";
echo "<th bgcolor=$color width=\"400\">Bank Name</th>";
//echo "<th bgcolor=$color width=\"400\">Gl Master Code</th>";
echo "<th bgcolor=$color width=\"250\">Current Balance</th>";
//echo "<th bgcolor=$color width=\"250\">Balance</th>";
echo "<tr><td colspan=\"3\" align=\"center\"><iframe src=\"ccb_current_balance_tabular_db.php?status=$status\" width=\"600\" height=\"380\" ></iframe></td></tr>";
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=2><B>Total</B></td>";
echo "<td align=right bgcolor=$color><B>".$balance."</B></td>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
