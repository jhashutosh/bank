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
<font size=+2><b>System For Ledger View </font><br>
<I>Banking parameters configuration and information updation</I>
<HR>
<BODY>
<TABLE Align=Center width=100%>
<TR>
<TH BGCOLOR=#8A2BE2><font size=+2>Show Ledger Details</font></TH>
<tr>
<Td>
<ul type=disc>
<li><a href="general_ledger_details.php?menu=gen&op=c&gl_code=28101" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1000,height=900'); return false;">Cash</A> - Cash Book Details.

<li><a href="general_ledger_details.php?menu=gen&op=b" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Bank</A> - Bank Book Details.


<li><a href="../fa_reports/gl_ledger.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Day</A> - Bank Book Details.
<li><a href="gl_master_header.php?op=v">Ledger</A> - Other Ledger Details.
<li><a href="new_code.php?menu=gen&op=c">New GL Subhead Create</A> - Other Ledger Details.
<li><a href="annexture_2.php?menu=gen">Annexure </A>Annexure  Details.
<li><a href="annexture_general_view.php?menu=gen">Annexure  View</A>
