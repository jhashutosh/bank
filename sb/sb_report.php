<? 
include "../config/config.php";
$menu=$_REQUEST["menu"]; 
$staff_id=verifyAutho();
?>
<HTML>
<head>
<TITLE>Saving Deposit Reports</TITLE>
<LINK href="../css/test.css" type="text/css" rel="STYLESHEET">
</head>
<BODY>
<center>
<font color="GREEN">
<H1>Saving Deposit Reports</H1>
</font>
</center>
<HR>
<table>
<tr>
<td>
<ol>
<li><A HREF="../general/summary_report.php?menu=sb">Summary</A>
<li><A HREF="sb_current_balance.php?menu=sb">Current balance</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=sb&status=name">List of Account(Name Wise)</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=sb&status=account_no">List of Account(Number Wise)</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=sb&status=jn">List of Joint Operation Account</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=sb&status=so">List of Single Operation Account</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=sb&status=14101">List of Account(Member)[14101]</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=sb&status=14301">List of Account(NonMember)[14301]</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=sb&status=14201">List of Account(SHG)[14201]</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=sb&status=14401">List of Account(NREGS)</A>
<li><A HREF="../general/search.php?menu=sb">Search</A>
<li><A HREF="ac_op_cl.php">List Of Account Open & Closed A/C</A>
<li><a href="sb_statement_datewise.php?menu=sb" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">SB Statement A/C No. and Datewise</A>
<li><a href="sb_interest_summary.php?menu=sb" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">SB interest summary</A>
<li><a href="sb_debtors_summary.php?menu=sb" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Details List</A>

</ol>
</td>
<td>&nbsp;</td>
<td>
<ol start=16>
<!-- <li><a href="shg_interest_summary.php?menu=sb" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">SHG interest summary</A>
<li><a href="nregs_interest_summary.php?menu=sb" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">NREGS interest summary</A>
<li><A HREF="sb_cheque_report.php">Clearing Cheque</A>
<li><A HREF="../general/provisional_interest.php?menu=sb">Interest Payable On Saving Deposit</A> -->
<li><A HREF="sb_current_balance_tabular.php?code=14101&menu=sb">code:14101-->Savings Deposit(Individual Members)</A>
<li><A HREF="sb_current_balance_tabular.php?code=14201&menu=sb">code:14201-->Savings Deposit(SHG)</A>
<li><A HREF="sb_current_balance_tabular.php?code=14301&menu=sb">code:14301-->Savings Deposit(Non Members)</A>
<!--<li><A HREF="sb_current_balance_tabular.php?code=14401&menu=sb">Savings Deposit(NREGS)</A>
<li><a href="mem_int_payable.php?menu=sb" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Interest Payable on Savings Deposit(Member)[16101]</A>
<li><a href="shg_int_payable.php?menu=sb" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Interest Payable on Savings Deposit(SHG)[16201]</A>
<li><a href="non_mem_int_payable.php?menu=sb" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Interest Payable on Savings Deposit(Non Members)[16301]</A>

<li><a href="nregs_int_payable.php?menu=sb" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Interest Payable on Savings Deposit(NREGS)[16401]</A>
<li><A HREF="../general/ccb_current_balance.php?op=28202">Savings A/C(SCB/CCB)</A>
<li><A HREF="../general/ccb_current_balance.php?op=28302">code:28302Savings A/C(Others Bank)</A> -->
<li><A HREF="../sb/in_op_de_reg.php">Not operate more than three(3)years</A>
</ol>
</td>
</TABLE>
<hr>
</BODY>
</HTML>
