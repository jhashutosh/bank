<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$current_date=$_REQUEST['current_date'];
$status=$_REQUEST['code'];
//echo "status is:$status";
if(empty($current_date) ) {$current_date=date("d/m/Y");}
$balance=$_REQUEST['balance'];
if($menu=='sb'){
if($status=="28202"){$person="Savings A/c(SCB/CCB)";}
if($status=="28302"){$person="Savings A/c(Other Banks)";}
}
echo "<html>";
echo "<head>";
echo "<title>Saving Bank Current Balance";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"cd.focus();\">";
echo "<hr>";
echo "<form name=\"f1\" action=\"ccb_current_balance_tabular.php?menu=$menu&code=$status\" method=\"POST\">";
echo "<table align=center bgcolor=\"BLUE\"><tr><td  align=\"center\"><b>Current Balance as on :<td><input type=TEXT size=12 name=current_date id=cd value=$current_date $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.current_date,'dd/mm/yyyy','Choose Date')\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "</table></form>";
echo "<hr>";
echo "<table align=center width=\"90%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"5\" align=\"center\"><font color=\"white\">Current Balance of $person as on $current_date</font><font size=+1 color=\"Black\"<B>[Rs.$balance]</font></b>";
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color width=\"110\">A/C No.</th>";
echo "<th bgcolor=$color width=\"500\">Action_date</th>";
echo "<th bgcolor=$color width=\"500\">Gl Master Code</th>";
echo "<th bgcolor=$color width=\"500\">Deposit</th>";
echo "<th bgcolor=$color colspan=\"1\">Balance</th>";
echo "<tr><td colspan=\"5\" align=\"center\"><iframe src=\"ccb_current_balance_tabular_db.php?status=$status\" width=\"850\" height=\"310\" ></iframe></td></tr>";
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=4><B>Total</B></td>";
echo "<td align=right bgcolor=$color><B>".$balance."</B></td>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
