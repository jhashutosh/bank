<?
include "../config/config.php";
$menu=$_REQUEST['menu'];
$staff_id=verifyAutho();
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<table  width=\"100%\">";
echo "<tr><td bgcolor=\"red\" colspan=\"10\" align=\"center\"><font color=\"white\"><b>Summry of SHGs as on ".date('d/m/Y')."</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color width =\"80\">Group no</th>";
echo "<th bgcolor=$color width =\"200\">Group Name</th>";
echo "<th bgcolor=$color width=\"46\">Type</th>";
echo "<th bgcolor=$color width =\"75\">Member</th>";
//echo "<th bgcolor=$color>Date of opening</th>";
echo "<th bgcolor=$color width =\"120\">Eligible date for loan</th>";
echo "<th bgcolor=$color width =\"80\">Deposit(Rs.)</th>";
echo "<th bgcolor=$color width =\"80\">Loan (Rs.)</th>";
//echo "<th bgcolor=$color>Edit/Update</th>";
echo "<th bgcolor=$color>Operation</th>";
echo "<tr><td colspan=\"10\" align=\"center\"><iframe src=\"shg_info_view_db.php?menu=$menu\" width=\"900%\" height=\"390\"></iframe></td></tr>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
