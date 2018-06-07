<?
include "../config/config.php";
//echo "<h1>hi</h1>";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$current_date=$_REQUEST["current_date"];
if(empty($current_date) ) { $current_date=date("d/m/Y"); }
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
echo "<table align=center bgcolor=\"#90EE90\" width=\"20%\">";
echo "<tr>";
echo "<td align=\"right\">";
echo "<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close me\" onclick=\"closeme()\">";
echo "</td>";
echo "<td>";
echo "<input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print me\" onclick=\"print()\"> ";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</form>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"id.focus();\">";
$sql_statement="SELECT master.gl_mas_code,initcap(b.gl_mas_desc) as gl_mas_desc, sum(credit-debit) as bal 
FROM 
( SELECT gl_mas_code,sum(debit) as debit, sum(credit) as credit, sum(credit-debit) as bal from mas_gl_tran as a WHERE action_date<=$current_date and gl_mas_code::text >= '10000'::text AND gl_mas_code::text <= '19999'::text GROUP BY gl_mas_code ) 
as master,
gl_master_vw as b 
WHERE master.gl_mas_code= b.gl_mas_code and bs_pl='L' GROUP BY master.gl_mas_code,b.gl_mas_desc HAVING master.gl_mas_code<>'12302' and master.gl_mas_code in('14101','14201','14301','14401')";
echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_num_rows($result)<1) {
echo "<h4>No Record or ERROR!!!</h4>";
} else {
//echo "<font color=#000080 size=+2><I><b>Material Master Details</b></I></font>";
echo "<hr>";
echo "<table>";
}
echo "<table valign=\"top\" width=\"60%\" align=\"center\">";
$color=$TCOLOR;
echo "<tr><td bgcolor=\"GREEN\" colspan=\"4\" align=\"center\"><font color=\"white\" size=5><b>Sundry Debtors/Customer Details</b></font>";
echo "<tr>";
echo "<th bgcolor=$color>Customer Id</th>";
echo "<th bgcolor=$color>Customer Name</th>";
echo "<th bgcolor=$color>Due Amount</th>";
//echo "<th bgcolor=$color>Operation</th>";

for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";

echo "<td align=center bgcolor=$color>".$row[0]."</td>";
echo "<td align=center bgcolor=$color>".ucwords($row[1])."</td>";
echo "<td align=center bgcolor=$color>".ucwords($row[2])."</td>";
$t_amount+=$row[2];
echo "<td align=center bgcolor=$color><A HREF=\"sb_current_balance.php?id=".$row[0]."&name=".$row[1]."&p=".$row[2]."\">Receipt</a> </td>";
}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"2\"><B>Total:".($j-1)." Items Found !!!!!!!!</B></td>";
echo "<td align=center bgcolor=$color colspan=\"1\"><B>$t_amount</B></td>";
echo "<td align=center bgcolor=$color colspan=\"1\"></td>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
