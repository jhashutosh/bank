<?php 
include "../config/config.php";
$menu=$_REQUEST["menu"]; 
$staff_id=verifyAutho();
?>
<HTML>
<head>
<TITLE>Fixed Deposit Reports</TITLE>
<LINK href="../css/test.css" type="text/css" rel="STYLESHEET">
</head>
<BODY>
<center>
<font color="GREEN">
<H1>Fixed  Deposit Reports</H1>
</font>
</center>
<HR>
<table>
<tr>
<td>
<ol>
<li><A HREF="../general/summary_report.php?menu=fd">Summary</A>

<li><A HREF="../general/current_balance_deposit_FD.php?menu=fd">Current balance</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=fd&status=name">List of Account(Name Wise)</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=fd&status=account_no">List of Account(Number Wise)</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=fd&status=jn">List of Joint Operation Account</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=fd&status=so">List of Single Operation Account</A>

<li><A HREF="../general/all_deposit.php?menu=fd&op=p">Pre-Mature List Between Date</A>
<li><A HREF="../general/all_deposit.php?menu=fd&op=2t">Today Mature List</A>

<li><A HREF="../general/all_deposit.php?menu=fd&op=m">Mature List </A>
<!--
</ol>
</td>
<td>&nbsp;</td>
<td>

<ol start=11>

<li><A HREF="../general/all_deposit.php?menu=fd&op=2m">Tomorrow Mature List </A>
<li><A HREF="../general/all_deposit.php?menu=fd&op=d2m">Day After Tomorrow Mature List </A>
-->
<li><A HREF="../general/all_deposit.php?menu=fd&op=m">Matured And Withdrawal List</A>
<li><A HREF="../general/all_deposit.php?menu=fd&op=mbt">Matured But Not Withdrawal List</A>
<li><A HREF="fd_closing_account.php">Closing Account List</A>
<li><A HREF="../general/provisional_interest.php?menu=fd">Payable Interest </A>
&nbsp;&nbsp;&nbsp;&nbsp;<a HREF="../general/provisional_interest_fd_print.php?menu=fd">for print</a>
<li><A HREF="../general/search.php?menu=fd">Search</A>
<!--
<li><A HREF="sb_provisional_interest_tabular.php">Interest Payable On Fixed Deposit</A> 
<li><A HREF="../general/ccb_current_balance.php?op=22402">Invest In Fixed Deposit(SCB/CCB)[22402]</A>
<li><A HREF="../general/ccb_current_balance.php?op=22502">Invest In Fixed Deposit(Others)[22502]</A>
-->
</ol>
</td>
</TABLE>
<hr>
</BODY>
</HTML>
