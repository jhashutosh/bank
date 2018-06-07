<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
//echo "op=$op";  
?>
<HTML>
<HEAD>
<TITLE>Configuration</TITLE>
<link rel="stylesheet" type="text/css" href="../css/test.css">
<font size=+2><b>MINI System  </font><br>
<I>Banking parameters configuration and information updation</I>
<HR>
<BODY>
<TABLE Align=Center width=100%>

<center>
<font color="GREEN">
<H1> MINI REPORT</H1>

</center>


<!--<TH BGCOLOR=#8A2BE2><font size=+2>Monthly Return Module </font></TH>-->
<tr>
<Td>
<li><a href="../mini/mini_cust_link.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">mini_cust_link</A>
<li><a href="../mini/mini_operator_link.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">mini_operator_link</A>
<li><a href="../mini/mini_opening_bal.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">mini_opening_bal</A>
</ol>
</TABLE>

</BODY>
</HTML>



