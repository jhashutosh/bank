<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
//echo "op=$op";  
if ($menu=='fd'){$period='Days';}
if ($menu=='ri'){$period='Months';}
if ($menu=='rd' || $menu=='mis'){$period='Years';}
                                                   
?>
<HTML>
<HEAD>
<TITLE>Configuration</TITLE>
<link rel="stylesheet" type="text/css" href="../css/test.css">
<font size=+2><b>Scrolling System For Banking </font><br>
<I>Banking parameters configuration and information updation</I>
<HR>
<BODY>
<TABLE Align=Center width=100%>
<TR>
<TH BGCOLOR=#8A2BE2><font size=+2>Deposit Module </font></TH>
<tr>
<Td>
<ul type=disc>
<li><a href="scroll.php?menu=sb" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Savings Deposits Module</A> - For Saving Deposits  Scroll.
<li><a href="scroll.php?menu=fd" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Fixed Deposits Module</A> - For Fixed Deposits Scroll.
<li><a href="scroll.php?menu=rd" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Recurring Deposits Module</A> - For Recurring Deposits Scroll.
<li><a href="scroll.php?menu=ri" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Reinvestment Deposits Module</A> - For Reinvestment Deposits Scroll.
<li><a href="scroll.php?menu=mis" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">MIS Deposits Module</A> - For MIS Deposits Scroll.
<li><a href="scroll.php?menu=all" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">ALL Deposits Module</A> - For ALL Deposits Scroll.

</TABLE>
<TABLE Align=Center width=100%>
<TR>
<TH BGCOLOR=#8A2BE2><font size=+2>Loan Module </font></TH>
<tr>
<Td>
<ul type=disc>
<li><a href="scroll_loan.php?menu=kcc" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">KCC Loan Module</A> - For KCC Loan Scroll.
<!--<li><a href="scroll_loan.php?menu=pl" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Pledge Loan Module</A> - For Pledge Loan  Scroll.-->
<li><a href="scroll_loan.php?menu=lad" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">LAD Loan Module</A> - For LAD Loan Scroll.
<li><a href="scroll_loan.php?menu=mt" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">MT Loan Module</A> - For MT Loan Scroll.
<!--<li><a href="scroll_loan.php?menu=ccl" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Cash Credit Loan Module</A> - For Cash Credit Loan  Scroll.-->
<li><a href="scroll_loan.php?menu=ser" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Service Loan Module (HRL)</A> - For Service Loan Scroll (HRL).
<!--<li><a href="scroll_loan.php?menu=bdl" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Bond Loan Module</A> - For Bond Loan Scroll.-->
<li><a href="scroll_loan.php?menu=kpl" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">KVP Loan Module (PL)</A> - For KVP Loan Scroll (PL).
<!--<li><a href="scroll_loan.php?menu=spl" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">SMP Loan Module</A> - For SMP Loan  Scroll.-->
<li><a href="scroll_loan.php?menu=sfl" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Staff Loan Module</A> - For Staff Loan Scroll.
<li><a href="scroll_loan.php?menu=car" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Car Loan Module</A> - For Car Loan Scroll.
<li><a href="scroll_loan.php?menu=fis" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Fishery Loan Module</A> - For Fishery Loan Scroll.
<li><a href="scroll_loan.php?menu=sgl" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">SHG Loan Module</A> - For SHG Scroll.
<li><a href="scroll_loan.php?menu=all" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">All Loan Module</A> - For All Loan Scroll.




</BODY>
</HTML>



