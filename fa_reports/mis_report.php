<?php 
include "../config/config.php";
$menu=$_REQUEST["menu"]; 
$staff_id=verifyAutho();
?>
<HTML>
<head>
<TITLE>Mis Report</TITLE>
<LINK href="../css/test.css" type="text/css" rel="STYLESHEET">
</head>
<BODY>
<center>
<font color="GREEN">
<H1> MIS Reports</H1>
</font>
</center>
<HR>
<table width=\"100%\">
<tr>
<td>

<ul>
<li><h3><A HREF="demand_loan_rpt_new.php">Demand collection & balance Statement</A></h3>
<!--<li><h3><A HREF="demand_loan_rpt_new.php">Demand collection & balance Statement</A></h3>-->
<li><h3><A HREF="npa_register.php">Overdue NPA Registeg</A></h3>
<li><h3><A HREF="yearly_loan_rpt.php">loan History</A></h3>
<li><h3><A HREF="">Period Wise Classification of overdues</A></h3>
<li><h3><A HREF="">Asset Cassification & provisioning</A></h3>
<li><h3><A HREF="">Stock Position</A></h3>
<li><h3><A HREF="details_deposit_mobalised.php">Details Of Deposits Mobilised</A></h3>
<li><h3><A HREF="">Growth in share capital</A></h3>

</ul>
</td>
<td>&nbsp;</td>
<td>

<ul>
<li><h3><A HREF="">Progress Report</A></h3>
<li><h3><A HREF="">Set of performance indicators</A></h3>
<li><h3><A HREF="">Concise Strecture of balance sheet</A></h3>
<li><h3><A HREF="">Financial Ratios</A></h3>

<li><h3><A HREF="">Cash Flow Statement</A></h3>
<li><h3><A HREF="">MT/LT issued During the year</A></h3>
<li><h3><A HREF="">KCC scheme</A></h3>
</ul>
</td>
</table>
</BODY>
</HTML>
