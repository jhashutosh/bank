<?
include "../config/config.php";
$staff_id==verifyAutho();
$menu=$_REQUEST['menu'];
$title=strtoupper($menu)." Provissional Interest";
$ending_date=$_REQUEST["ending_date"];
if( empty($ending_date) ) { $ending_date=date("d.m.Y"); }
if($menu=='rd' || $menu=='mis'){$cols=5;}
else{$cols=6;}
echo "<html>";
echo "<head>";
echo "<title>$title";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"ed.focus();\">";
echo "<hr>";
echo "<form method=\"POST\" action=\"provisional_interest2.php?menu=$menu\">";
echo "<table width=\"100%\" bgcolor=\"YELLOW\"><tr>";
echo "<th>$title as on:<th><input type=\"TEXT\" name=\"ending_date\" id=\"ed\" size=\"15\" value=\"$ending_date\" $HIGHLIGHT>";
echo "&nbsp <input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "</table></form>";
echo "<hr>";
$sql_statement="SELECT compute_main_deposit_pint1('$menu','$ending_date') AS pint";
$result=dBConnect($sql_statement);
echo $sql_statement; 
if(pg_NumRows($result)==0){
	echo "<br><font color=\"RED\">Failed to calculate.</font>";
} 
else{
	$current_balance=pg_result($result,'pint');
echo "<font size=\"+2\" color=\"GREEN\"><center>Total Payable Interest&nbsp;:&nbsp;&nbsp;<font color=\"BLUE\"<B>Rs.".amount2Rs($current_balance)."/=</B></font></font>";
echo "<table width=\"100%\">";
echo "<tr><th bgcolor=\"green\" colspan=\"$cols\" align=\"center\"><font color=\"white\">$title List</font>";
//Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color width=\"75\">Account No.</th>";
if($menu!='rd'){
echo "<th bgcolor=$color width=\"75\">Certificate No.</th>";
}
echo "<th bgcolor=$color width=\"175\">Name</th>";
echo "<th bgcolor=$color width=\"75\">Principal</th>";
echo "<th bgcolor=$color width=\"100\">Maturity Date</th>";
echo "<th bgcolor=$color width=\"100\">Interest</th>";
echo "<tr><td colspan=\"$cols\" align=center><iframe src=\"provisional_interest_db1.php?menu=$menu\" width=\"100%\" height=\"300\" ></iframe>";
echo "<tr>";
$sql_statement="SELECT SUM(principal) AS p,COUNT(*) as c,SUM(interest) AS i FROM provissional_interest WHERE trim(deposit_type)='$menu'";
$result=dBConnect($sql_statement);
echo $sql_statement; 
$count_row=pg_result($result,'c');
$t_p=pg_result($result,'p');
$t_i=pg_result($result,'i');
$color="cyan";
echo "<th align=center bgcolor=$color colspan=\"3\"><B>Total: $count_row<th align=right bgcolor=$color>".amount2Rs($t_p);
echo "<th align=center bgcolor=$color><th align=right bgcolor=$color>".amount2Rs($t_i);
echo "</table>";
}
echo "</body>";
echo "</html>";
?>