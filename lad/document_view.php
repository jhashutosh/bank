<?php
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$menu=$_REQUEST["menu"];
$account_no=$_SESSION["current_account_no"];
if($menu=='ccl');
if($menu=='kpl');
if($menu=='lad');
if($menu=='pl');
if($menu=='bdl');
if($menu=='spl');
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() 
{ 
close(); 
}";
echo "</script>";
echo "<form>";
echo "<table align=center bgcolor=\"RED\" width=\"20%\">";
//echo "<tr><td colspan=\"6\" align=center><iframe src=\"morgate_reg.php?status=$op&menu=$menu\" width=\"100%\" height=\"350\" ></iframe>";
echo "<tr>";
//echo "<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close me\" onclick=\"closeme()\">";
echo "<td align=center>";
echo "<input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print me\" onclick=\"print()\"> ";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</form>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"id.focus();\">";
$sql_statement="SELECT * FROM loan_security where account_no='$account_no'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_num_rows($result)<1) {
echo "<h4>No Record or ERROR!!!</h4>";
} else {
echo "<hr>";
echo "<table>";
}
echo "<table valign=\"top\" width=\"100%\" align=\"CENTER\">";
echo "<tr bgcolor=Green>";
echo "<th colspan=\"5\">Details Information of [$account_no] &nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Return\" onclick=\"myRefresh('".$URL."')\"></th>";
echo "<tr bgcolor=\"PINK\">";
echo "<th>Security Type</th>";
echo "<th>Account No.</th>";
echo "<th>Certificate No.</th>";
echo "<th>Maturity Date</th>";
echo "<th>Maturity Value(Rs.)</th>";
for($j=0; $j<pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td  bgcolor=$color>".$pl_doc_type_array[trim($row['security_type'])]."</td>";
echo "<td  bgcolor=$color>".$row['account_no']."</td>";
echo "<td  bgcolor=$color>".$row['security_info']."</td>";
echo "<td bgcolor=$color>".$row['max_date']."</td>";
echo "<td bgcolor=$color align=\"right\">".(float)$row['security_value']."</td>";
$t_val+=$row['security_value'];
	}
echo "<tr bgcolor=AQUA>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"13\"><B>Total:".($j-1)." Certificates Found !!!!!!!!</B></td>";
//echo "<td align=center bgcolor=$color colspan=\"1\"></td>";
//echo "<td align=center bgcolor=$color colspan=\"4\"><B>$t_amount</B></td>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
