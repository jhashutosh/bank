<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
$account_no=$_REQUEST['account_no'];
echo "<html>";
echo "<head>";
echo "<title> KCC Main </title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<hr>";
echo "<form name=\"frm1\" method=\"post\" action=\"due_overdue.php?menu=kcc&op=i\">";
echo "<table align=\"center\" width=\"90%\">";
echo "<tr>";
echo "<td bgcolor=\"green\" colspan=\"3\" align=\"center\"><font color=\"white\" size=\"5\"><b>Due & Overdue Entry Form</b></font>";
echo "<tr>";
$color="#CCCC2222";
echo "<th bgcolor=$color width=30% rowspan=\"1\">KCC A/C No:&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" id=\"txt1\" name=\"text1\" value=\"$account_no\" size=\"15\" $HIGHLIGHT></th>";
echo "<th bgcolor=$color width=30% rowspan=\"1\">Issue Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" id=\"txt2\" name=\"text2\" size=\"15\" $HIGHLIGHT></th>";
echo "<th bgcolor=$color width=30% rowspan=\"1\">Repay Date:&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" id=\"txt3\" name=\"text3\" size=\"15\" $HIGHLIGHT></th>";
echo "<tr>";
echo "<th bgcolor=$color width=30% rowspan=\"1\">Last Rep Date:&nbsp;&nbsp;<input type=\"text\" id=\"txt4\" name=\"text4\" size=\"15\" value=\"31/03/10\" $HIGHLIGHT></th>";
echo "<th bgcolor=$color width=30% rowspan=\"1\">Last Int Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" id=\"txt5\" name=\"text5\" size=\"15\" value=\"31/03/10\" $HIGHLIGHT></th>";
echo "<th bgcolor=$color width=30% rowspan=\"1\">Due Int:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" id=\"txt6\" name=\"text6\" size=\"15\" $HIGHLIGHT></th>";
echo "<tr>";
echo "<th bgcolor=$color width=30% rowspan=\"1\">Overdue Int:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" id=\"txt7\" name=\"text7\" size=\"15\" $HIGHLIGHT></th>";
echo "<th bgcolor=$color width=30% rowspan=\"1\">Due Principal:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" id=\"txt8\" name=\"text8\" size=\"15\" $HIGHLIGHT></th>";
echo "<th bgcolor=$color width=30% rowspan=\"1\">Loan Amount:<input type=\"text\" id=\"txt9\" name=\"text9\" size=\"15\" $HIGHLIGHT></th>";
echo "<tr>";
echo "<th bgcolor=$color width=30% rowspan=\"1\">Due Int Rate:&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" id=\"txt10\" name=\"text10\" size=\"15\" value=\"7\" $HIGHLIGHT>%</th>";
echo "<th bgcolor=$color width=30% rowspan=\"1\">Due Overdue Int:<input type=\"text\" id=\"txt11\" name=\"text11\" size=\"15\" value=\"10\" $HIGHLIGHT>%</th>";
echo "<th bgcolor=$color width=30% rowspan=\"1\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"submit\"  name=\"button\" value=\"submit\"></th>";
echo "</from>";
if($op==i)
{
$account_no=$_REQUEST['text1'];
$issue_date=$_REQUEST['text2'];
$repay_date=$_REQUEST['text3'];
$last_repay_date=$_REQUEST['text4'];
$last_int_date=$_REQUEST['text5'];
$due_int=$_REQUEST['text6'];
$overdue_int=$_REQUEST['text7'];
$due_principal=$_REQUEST['text8'];
$loan_amount=$_REQUEST['text9'];
$due_int_rate=$_REQUEST['text10'];
$due_overdue_rate=$_REQUEST['text11'];
$loan_sl_no=$_REQUEST['loan_sl_no'];
$t_id=getTranId();
$sql_statement="INSERT INTO kcc_op_bal_entry(account_no,tran_id,issue_date,repay_date,last_repayment_date,last_int_date,due_principal,due_int,overdue_int,loan_amount,due_int_rate,
od_int_rate) VALUES('$account_no','$t_id','$issue_date','$repay_date','$last_repay_date','$last_int_date','$due_principal','$due_int','$overdue_int','$loan_amount','$due_int_rate','$due_overdue_rate')";
echo "$sql_statement";
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1){

echo "<br><h5 align=\"center\"><font color=\"RED\" size=\"5\">!!!Sorry You did some mistake!!!</font></h5>";
}
else
{
echo "<h4><font color=\"Green\" size=\"6\">Sucessfully inserted data into database.</font></h4>";
echo "<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";

}

}
echo "</body>";
echo "</html>";
?>
