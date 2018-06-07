<? 
include "../config/config.php";
$menu=$_REQUEST["menu"]; 
$staff_id=verifyAutho();
?>
<HTML>
<head>
<TITLE>Advance Modules Reports</TITLE>
<LINK href="../css/test.css" type="text/css" rel="STYLESHEET">
</head>
<BODY>
<center>
<font color="GREEN">
<H1>Advance Module Reports</H1>
</font>
</center>
<HR>
<table>
<tr>
<td>
<ol>
<li><A HREF="../general/summary_report.php?menu=add">Summary</A>
<li><A HREF="current_balance.php?menu=add">Current balance</A>
<li><A HREF="../general/search.php?menu=add">Search</A>

<li><a href="sb_debtors_summary.php?menu=add" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Details List</A>

</td>
</TABLE>
<hr>
</BODY>
</HTML>
