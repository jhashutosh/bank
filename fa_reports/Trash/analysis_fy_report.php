<? 
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
<td>

<ul>
<li><h3><A HREF="npa_register.php">Working Fund</A></h3>
<li><h3><A HREF="">Average Yield</A></h3>
<li><h3><A HREF="">Average Cost</A></h3>
<li><h3><A HREF="">Financial Margin</A></h3>
<li><h3><A HREF="">Transaction cost</A></h3>
<li><h3><A HREF="">Risk cost</A></h3>
<li><h3><A HREF="">Net margin</A></h3>
<li><h3><A HREF="">Net Worth</A></h3>
<li><h3><A HREF="">Capital Adequacy Ratio</A></h3>
<li><h3><A HREF="">Credit Deposit Ratio</A></h3>
<li><h3><A HREF="">Ratio of Total Loans to Total Assets</A></h3>
</ul>
</td>
<td>&nbsp;</td>
<td>

<ul>
<li><h3><A HREF="">Ratio of Total Deposits to Total Assets</A></h3>
<li><h3><A HREF="">Ratio of operating Expenses to Average Total Assets</A></h3>
<li><h3><A HREF="">Ratio of interest earned to interest paid</A></h3>
<li><h3><A HREF="">Coding</A></h3>
<li><h3><A HREF="">Liabilities</A></h3>
<li><h3><A HREF="">Assets</A></h3>
<li><h3><A HREF="">Purchase</A></h3>
<li><h3><A HREF="">sale</A></h3>
<li><h3><A HREF="">Income</A></h3>
<li><h3><A HREF="">Expenditure</A></h3>
</ul>
</td>
</table>
</BODY>
</HTML>
