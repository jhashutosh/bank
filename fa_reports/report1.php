<? 
include "../config/config.php";
$menu=$_REQUEST["menu"]; 
$staff_id=verifyAutho();
?>
<HTML>
<head>
<TITLE>Final Report</TITLE>
<LINK href="../css/test.css" type="text/css" rel="STYLESHEET">
</head>
<BODY>
<center>
<font color="GREEN">
<H1> Final Report</H1>
</font>
</center>
<HR>
<table width=\"100%\">
<tr>
<td>

<ul>
<li><h3><A HREF="trial_balance_before.php">Trial Balance Before</A></h3>
<li><h3><A HREF="trial_balance.php">Trial Balance Adj</A></h3>
<li><h3><A HREF="trial_balance_dr.php">Cash Cum Trial[Dr]</A></h3>
<li><h3><A HREF="trial_balance_cr.php">Cash Cum Trial[Cr]</A></h3>
<li><h3><A HREF="trading.php">Trading A/C</A></h3>
<li><h3><A HREF="profit_loss.php">Profit & Loss</A></h3>
<li><h3><A HREF="profit_loss_ap.php">Profit & Loss AP</A></h3>
<li><h3><A HREF="p_balance_sheet.php">Balance Sheet(Normal)</A></h3>
<li><h3><A HREF="balance_sheet_pro.php">Balance Sheet(prograsive)</A></h3>
<li><h3><A HREF="balance_sheet.php">Balance Sheet(BreakUp)</A></h3>
<li><h3><A HREF="balance_sheet_nav.php">Balance Sheet(nav)</A></h3>
<li><h3><A HREF="gl_ledger.php">Account Ledgers</A></h3>
</ul>
</td>
<td>&nbsp;</td>
<td>

<ul>
<li><h3><A HREF="gl_ledger_db.php">Day Book</A></h3>
<li><h3><A HREF="monthly_cash_ac.php">Monthly Cash A/C</A></h3>
<li><h3><A HREF="yearly_cash_ac.php">Yearly Cash A/C</A></h3>
<li><h3><A HREF="divi_report.php">Dividend Report</A></h3>
<li><h3><A HREF="yearly_cash_ac_p.php">****Yearly Cash A/C(BreakUp)</A></h3>

<li><h3><A HREF="npa_register.php">NPA Register</A></h3>
<!--<li><h3><A HREF="npa_register1.php">Aman-NPA Register</A></h3>
<li><h3><A HREF="npa_register.php">Boro-NPA Register</A></h3>-->
<li><h3><A HREF="">****Asset clasf.&Provising</A></h3>
<li><h3><A HREF="">****Periodwise overdues</A></h3>
<li><h3><A HREF="">****Depreciation chart</A></h3>

</ul>
</td>
</table>
</BODY>
</HTML>
