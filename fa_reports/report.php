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
<li><h3><A HREF="../fa_reports/coding_report.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Financial Report</A>(Trial[Adj],Trading,P/L,P/L App,Balance Sheet)</h3>
<!--
<li><h3><A HREF="balance_sheet_nav.php">Balance Sheet(nav)</A></h3> -->
<li><h3><A HREF="gl_ledger.php">Account Ledgers</A></h3>

<li><h3><A HREF="monthly_cash_ac.php">Monthly Cash A/C</A></h3>
<li><h3><A HREF="yearly_cash_ac.php">Yearly Cash A/C</A></h3>
<li><h3><A HREF="divi_report.php">Dividend Report</A></h3>
<li><h3><A HREF="../fa_reports/gl_ledger.php">Account Ledgers</A></h3>
<li><h3><A HREF="../fa_reports/gl_ledger_db.php">Day Book Original</A></h3>
<!--
<li><h3><A HREF="yearly_cash_ac_p.php">****Yearly Cash A/C(BreakUp)</A></h3>
<li><h3><A HREF="npa_register.php">NPA Register</A></h3>
<!--<li><h3><A HREF="npa_register1.php">Aman-NPA Register</A></h3>
<li><h3><A HREF="npa_register.php">Boro-NPA Register</A></h3>
<li><h3><A HREF="">****Asset clasf.&Provising</A></h3>
<li><h3><A HREF="">****Periodwise overdues</A></h3>
<li><h3><A HREF="">****Depreciation chart</A></h3>
-->
</ul>
</td>
</table>
</BODY>
</HTML>
