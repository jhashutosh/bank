<?php 
include "../config/config.php";
$menu=$_REQUEST["menu"]; 
$staff_id=verifyAutho();
?>
<HTML>
<head>
<TITLE>Control Register</TITLE>
<LINK href="../css/test.css" type="text/css" rel="STYLESHEET">
</head>
<BODY>
<center>
<font color="GREEN">
<H1>Control Register</H1>
</font>
</center>
<HR>
<table width=\"100%\">
<tr>
<td width=\"50%\">
<table>
<tr>
<td>
<ul>
<li><A HREF="npa_register.php"><font size=4>Overdue NPA Register</font></A>
<li><A HREF=""><font size=4>balancing Register</font></A>
<li><A HREF=""><font size=4>Membership Register</font></A>
<li><A HREF="acc_op_cl_reg.php"><font size=4>Accounts Opened &<br> closed Register</font></A>
<li><A HREF="in_op_de_reg.php"><font size=4>Inoperative Deposit A/c Register</font></A>
<li><A HREF="maturity_register.php"><font size=4 style="verdana">Maturity Register</font></A>
<li><A HREF=""><font size=4 style="Times new roman" >Insurance Policy Register</font></A>
<li><A HREF=""><font size=4>Borrowing Due Date Register</font></A>
</ul>
</td>
</td>
</tr>
</table>
<td width=\"5%\">
<table>
<tr>
<td>&nbsp;</td>
</tr>
</table
</td>

<td width=\"45%\">
<table>
<tr>
<td>
<ul>
<li><A HREF=""><font size=4>Investment Maturity Register</font></A>
<li><A HREF=""><font size=4>Pledged Stock Register</font></A>
<li><A HREF=""><font size=4>Suit Field Register</font></A>
<li><A HREF=""><font size=4>Dcb Register</font></A>
<li><A HREF=""><font size=4>Minutes Book</font></A>
<li><A HREF=""><font size=4>Gold Stock Register</font></A>
<li><A HREF=""><font size=4 name="verdana">Sundry Debtors</font></A>
<li><A HREF=""><font size=4>Sundry Creditors</font></A>
</ul>
</td>
</tr>
</table>
</td>
</table>
</BODY>
</HTML>
