<? 
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
<li><h3><A HREF="liabilities.php?menu=lia">Liabilities</A></h3>
<li><h3><A HREF="liabilities.php?menu=assets">Assets</A></h3>
<li><h3><A HREF="liabilities.php?menu=pur">Purchase</A></h3>
<li><h3><A HREF="liabilities.php?menu=sale">sale</A></h3>
<li><h3><A HREF="liabilities.php?menu=income">Income</A></h3>
<li><h3><A HREF="liabilities.php?menu=expen">Expenditure</A></h3>
</ul>
</td>
</table>
</BODY>
</HTML>
