<?php
include "../config/config.php";
$menu=$_REQUEST['menu'];
$mm_name=strtolower($_REQUEST['mm_name']);
$op=$_REQUEST['op'];
$staff_id=verifyAutho();
if(!empty($mm_name)){$WHERE_CONDITIONS="WHERE lower(mm_desc) LIKE '%".$mm_name."%'";}
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/loading2.js\"></script>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/varify.js\"></script>";
echo "<link rel=\"stylesheet\" href=\"../css/autosuggest_inquisitor.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\" />";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
///////////////////////for menu /////////////////////////////////////////////////////
echo "<form name=\"f1\" method=\"POST\" action=\"main_menu.php?menu=rsh\">";
//echo "<table align=center width=90% cellpadding=\"1\">";
//echo "<tr rowspan=\"2\">";
//echo "<td colspan=\"1\" align=\"Left\" bgcolor=#E0FFFF width=5%><b><font color=\"white\"><a href=\"vendor_master.php?menu=rsh\" target=\"_blank\">Vendor</a></font></b></td>";
//echo "<td colspan=\"1\" align=\"Left\" bgcolor=#E0FFFF  width=5%><b><a href=\"customer_report.php\" target=\"_blank\">Customer</a></b></td>";
//echo "<td colspan=\"1\" align=\"Left\" bgcolor=#E0FFFF width=22%><a href=\"received_payment_history.php\" target=\"_blank\"> <b>Received and payment history</a></b></td>";
//echo "<td colspan=\"1\" align=\"Left\" bgcolor=#E0FFFF  width=13%><a href=\"sundry_debtors.php\" target=\"_blank\"> <b>Sundry Debtors </a></b></td>";
//echo "<td colspan=\"1\" align=\"Left\" bgcolor=#E0FFFF  width=13%><a href=\"sundry_creditors.php\" target=\"_blank\"> <b>Sundry Creditors </a></b></td>";
//echo "<td colspan=\"1\" align=\"Left\" bgcolor=#E0FFFF  width=16%><a href=\"trading1.php?menu=rsh\" target=\"_blank\"><b>Monthly Trading A/C</a></b></td>";
//echo "<td colspan=\"1\" align=\"Left\" bgcolor=#E0FFFF  width=14%><a href=\"trading.php?menu=rsh\" target=\"_blank\"> <b>Yearly Trading A/C </a></b></td>";
//echo "</tr>";
//echo "</table>";
///////////////// for menu//////////////////////////////////////////////////////////////
$sql_statement="select * FROM material_master1 $CONDITIONS ORDER BY mm_desc";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
for($j=1; $j<=pg_NumRows($result); $j++){
$row=pg_fetch_array($result,($j-1));
$t+=$row['mm_price'];
$b+=$row['s_price'];
$c+=$row['s_stock'];
$d+=$row['final_stock'];
$e+=$row['final1_value'];
$f+=$row['final_value'];
}
}
//echo "<input type=\"HIDDEN\" value=\"$menu\" name=\"menu\">";
//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
 //Material Name:: <input type=\"\" name=\"mm_name\" id=\"mm_name\" $HIGHLIGHT>&nbsp;<input type=\"SUBMIT\" value=\"Search\">";
echo "</table>";
echo "<table  width=\"90%\">";
echo "<tr><td bgcolor=\"#808000\" colspan=\"18\" align=\"center\"><font color=\"white\"><b>MAIN MENU OF HOUSE BUILDING LOAN</font></tr>";
echo "</form>";
$color="GREEN";
echo "<tr>";
echo "<th bgcolor=$color Rowspan=\"2\" width=\"5%\">Sl. No.</th>";
echo "<th bgcolor=$color Rowspan=\"2\" width=\"12%\">Name</th>";
echo "<th bgcolor=$color Rowspan=\"1\" colspan=\"2\" width=\"12%\">Loan</th>";
echo "<th bgcolor=$color Rowspan=\"2\" width=\"5%\">How Month</th>";
echo "<th bgcolor=$color Rowspan=\"2\" width=\"5%\">Rate of Interest</th>";
echo "<th bgcolor=$color Rowspan=\"2\" width=\"5%\">EMI</th>";
//echo "<th bgcolor=$color Rowspan=\"1\" colspan=\"2\"width=\"12%\">Total Sale this year</th>";
echo "<th bgcolor=$color Rowspan=\"2\" width=\"12%\">End of Repayment Date</th>";
echo "<th bgcolor=$color Rowspan=\"1\" colspan=\"3\"width=\"12%\">Still Now Collection</th>";
echo "<th bgcolor=$color Rowspan=\"2\" width=\"12%\">Pending EMI</th>";
echo "<th bgcolor=$color Rowspan=\"1\" colspan=\"2\"width=\"12%\">Still Now Due</th>";
echo "<th bgcolor=$color Rowspan=\"2\" width=\"12%\">Security</th>";
echo "<th bgcolor=$color Rowspan=\"2\" width=\"12%\">Office Name</th>";
echo "<th bgcolor=$color Rowspan=\"2\" width=\"12%\">Customer No.</th>";
echo "<th bgcolor=$color Rowspan=\"2\"width =\"13%\">Repayment</th>";
echo "</tr>";

echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"6%\">Date</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"6%\">Amount</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"6%\">Total EMI</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"6%\">Overdue Int.</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"6%\">Total</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"6%\">Principal+interest</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"6%\">Stock Quantity</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"6%\">Amount</th>";
echo "</tr>";

/*echo "<tr>";
echo "<th bgcolor=$color rowspan=\"2\" width=\"6%\">Col.1</th>";
echo "<th bgcolor=$color rowspan=\"2\" width=\"6%\">col.2</th>";
echo "<th bgcolor=$color rowspan=\"2\" width=\"6%\">col.3</th>";
echo "<th bgcolor=$color rowspan=\"2\" width=\"6%\">col.4</th>";
echo "<th bgcolor=$color rowspan=\"2\" width=\"6%\">col.5</th>";
echo "<th bgcolor=$color rowspan=\"2\" width=\"6%\">col.6</th>";
echo "<th bgcolor=$color rowspan=\"1\" width=\"12%\">col.7</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"6%\">col.8 </th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"6%\">col.9</th>";
echo "</tr>";*/

/*echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"6%\">1+3 -5</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"6%\">col.2 +col.7</th>";
echo "</tr>";*/

echo "<tr><td colspan=\"18\" align=\"center\"><iframe src=\"main_menu_db.php?menu=$menu&c=$mm_name\" width=\"100%\" height=\"300\"></iframe></td></tr>";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"2\"><font size=3>Total</font></th>";
echo "<th bgcolor=$color colspan=\"1\">".amount2Rs($t)."</th>";
echo "<th bgcolor=$color colspan=\"1\"></th>";
echo "<th bgcolor=$color colspan=\"1\">".amount2Rs($f)."</th>";
echo "<th bgcolor=$color colspan=\"1\"></th>";
echo "<th bgcolor=$color colspan=\"1\">".amount2Rs($b)."</th>";
echo "<th bgcolor=$color colspan=\"1\"></th>";
echo "<th bgcolor=$color colspan=\"1\"></th>";
echo "<th bgcolor=$color colspan=\"1\">".amount2Rs($e)."</th>";
echo "<th bgcolor=$color colspan=\"1\"></th>";
echo "<th bgcolor=$color colspan=\"1\"></th>";
echo "<th bgcolor=$color colspan=\"2\"></th>";
echo "<th bgcolor=$color colspan=\"2\"></th>";
echo "<th bgcolor=$color colspan=\"2\"></th>";
echo "</tr>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
