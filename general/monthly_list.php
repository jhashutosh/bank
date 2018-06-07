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
<font size=+2><b>Scrolling System For Monthly Return </font><br>
<I>Banking parameters configuration and information updation</I>
<HR>
<BODY>
<TABLE Align=Center width=100%>

<center>
<font color="GREEN">
<H1> Monthly Return Module</H1>

</center>


<!--<TH BGCOLOR=#8A2BE2><font size=+2>Monthly Return Module </font></TH>-->
<tr>
<Td>
<ol start=1>
<li><a href="monthly_return_deposit.php?menu=gen" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=500'); return false;">Monthly Return Deposit</A> - For Deposit monthly Return.
<li><a href="monthly_return_loan.php?menu=gen" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Monthly Return Loan</A> - For Loan monthly Return.
<li><a href="monthly_return_shg.php?menu=gen" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Monthly Return SHG</A> - For SHG monthly Return.
<!--<li><a href="monthly_return_shg_ani.php?menu=gen" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Monthly Return SHG</A> - SHG Monthly Return Form For ANIYA.-->
<li><a href="../share/growth_in_share.php?menu=gen" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Groth in Share Capital</A> - Growth in Share 
<li><a href="../customer/cust_report/caste_group.php?menu=gen" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Customer List(Caste Wise)</A> - Member/Non-Member 
<li><a href="../general/consolidated_loan_list.php?p=f" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Consolidated Loan List</A> - All Loan Module
<li><a href="../fa_reports/demand_loan_rpt.php?menu=gen" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Demand collection & balance Statement</A> - Demand Statement  
<li><a href="../share/share_reg.php?menu=sh" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Share Register</A> - Share Register
<li><a href="../general/in_op_de_reg.php?menu=gen" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Inoperative Deposit Accounts Register</A> - (More than 3 Years)

<li><a href="../bankbooks/ccbd.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">DCCB/Other Bank Register</A> - DCCB/SCB
<li><a href="../general/morgate_reg.php?menu=pl" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Certificate Morgate Register</A>-All Loan Module

<li><a href="../fa_reports/npa_register.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">NPA Register</A> - Consolidated Report
<li><A HREF="../fa_reports/gl_ledger_mbook.php" targer='_blank'>Monthly Day Book</A>
<li><A HREF="general_ledger_details.php">Cash Book</A>
<li><A HREF="../fa_reports/monthly_cash_ac.php" targer='_blank'>Monthly Cash Account</A>
<li><A HREF="ac_op_cl.php">Account open & Closed Register</A>
<!--
<li><A HREF="../fa_reports/a_balance_sheet.php?type=a">Balance Sheet</A>[Annexture Wise]
<li><A HREF="../fa_reports/p_balance_sheet.php?type=g">Balance Sheet</A>[GL Code Wise]
<li><A HREF="../fa_reports/balance_sheet.php">Balance Sheet</A>[Break UP]
<li><A HREF="../fa_reports/profit_loss.php">Profit & Loss</A>
<li><A HREF="../fa_reports/profit_loss_ap.php">Profit & Loss AP</A>

<li><A HREF="../fa_reports/trial_balance_before.php">Trial Balance Before</A>-Opening Balance of General Ledger-->

</ol>
</td>
<td>&nbsp;</td>
<td>
<ol start=21>
<!--
<li><A HREF="../fa_reports/trial_balance.php">Trial Balance Adj</A>  Closing Balance of General Ledger
<li><A HREF="../fa_reports/trial_balance_dr.php">Cash Cum Trial[Dr]</A>  Closing Dr. Balance Of General Ledger
<li><A HREF="../fa_reports/trial_balance_cr.php">Cash Cum Trial[Cr]</A> Closing Cr. Balance Of General Ledger
<li><A HREF="../fa_reports/gl_ledger.php">Account Ledgers</A>
-->
</ol>
</TABLE>

</BODY>
</HTML>



