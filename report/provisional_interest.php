<?
include "../config/config.php";
$staff_id==verifyAutho();
$menu=$_REQUEST['menu'];
$title=strtoupper($menu)." Provissional Interest";
$ending_date=$_REQUEST["ending_date"];
if( empty($ending_date) ) { $ending_date=date("d.m.Y"); }

echo "<html>";
echo "<head>";
echo "<title>$title";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"ed.focus();\">";
echo "<hr>";
echo "<form method=\"POST\" action=\"provisional_interest.php?menu=$menu\">";
echo "<table width=\"100%\" bgcolor=\"YELLOW\"><tr>";
echo "<th>$title as on:<th><input type=\"TEXT\" name=\"ending_date\" id=\"ed\" size=\"15\" value=\"$ending_date\" $HIGHLIGHT>";
echo "&nbsp <input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "</table></form>";
echo "<hr>";
$sql_statement="SELECT compute_main_deposit_pint('$menu','$ending_date') AS pint";
$result=dBConnect($sql_statement);
//echo $sql_statement; 
if(pg_NumRows($result)==0){
	echo "<br><font color=\"RED\">Failed to calculate.</font>";
} 
else{
	$current_balance=pg_result($result,'pint');
echo "<font size=\"+2\" color=\"GREEN\"><center>Total Payable Interest&nbsp;:&nbsp;&nbsp;<font color=\"BLUE\"<B>Rs.".amount2Rs($current_balance)."/=</B></font></font>";
echo "<table width=\"100%\">";
echo "<tr><th bgcolor=\"green\" colspan=\"4\" align=\"center\"><font color=\"white\">$title List</font>";
//Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color width=\"93\">Account No.</th>";

echo "<th bgcolor=$color width=\"108\">Certificate No.</th>";

echo "<th bgcolor=$color width=\"652\">Name</th>";
//echo "<th bgcolor=$color width=\"75\">Principal</th>";
//echo "<th bgcolor=$color width=\"100\">Maturity Date</th>";
echo "<th bgcolor=$color width=\"150\">Interest</th>";
echo "<tr><td colspan=\"6\" align=center><iframe src=\"provisional_interest_db.php?menu=$menu\" width=\"100%\" height=\"300\" ></iframe>";
echo "<tr>";
$sql_statement="SELECT SUM(principal) AS p,COUNT(*) as c,SUM(interest) AS i FROM provissional_interest WHERE trim(deposit_type)='$menu'";
$result=dBConnect($sql_statement);
$count_row=pg_result($result,'c');
$t_p=pg_result($result,'p');
$t_i=pg_result($result,'i');
//echo $sql_statement; 
$color="cyan";
echo "<th align=center bgcolor=$color colspan=\"3\"><B>Total: $count_row";
echo "<th align=center bgcolor=$color><th align=right bgcolor=$color>".amount2Rs($t_i);
echo "</table>";
}
echo "</body>";
echo "</html>";
?>
