<?php 
include "../config/config.php";
$menu=$_REQUEST["menu"]; 
$staff_id=verifyAutho();
?>
<HTML>
<head>
<TITLE>Reinvestment Deposit Reports</TITLE>
<LINK href="../css/test.css" type="text/css" rel="STYLESHEET">
</head>
<BODY>
<center>
<font color="GREEN">
<H1>Reinvestment Deposit Reports</H1>
</font>
</center>
<HR>
<table>
<tr>
<td>
<ol>
<li><A HREF="../general/summary_report.php?menu=ri">Summary</A>

<li><A HREF="../general/current_balance_deposit.php?menu=ri">Current balance</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=ri&status=name">List of Account(Name Wise)</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=ri&status=account_no">List of Account(Number Wise)</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=ri&status=jn">List of Joint Operation Account</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=ri&status=so">List of Single Operation Account</A>

<li><A HREF="../general/all_deposit.php?menu=ri&op=p">Pre-Mature List Between Date</A>
<li><A HREF="../general/all_deposit.php?menu=ri&op=2t">Today Mature List</A>

<li><A HREF="../general/all_deposit.php?menu=ri&op=m">Mature List </A>
<!--
</ol>
</td>
<td>&nbsp;</td>
<td>
<ol start=11>
<li><A HREF="../general/all_deposit.php?menu=ri&op=2m">Tomorrow Mature List </A>
<li><A HREF="../general/all_deposit.php?menu=ri&op=d2m">Day After Tomorrow Mature List </A>
-->
<li><A HREF="../general/all_deposit.php?menu=ri&op=m">Matured And Withdrawal List</A>
<li><A HREF="../general/all_deposit.php?menu=ri&op=mbt">Matured But Not Withdrawal List</A>

<li><A HREF="../general/provisional_interest.php?menu=ri">Payable Interest </A>
&nbsp;&nbsp;&nbsp;&nbsp;<a HREF="../general/provisional_interest_fd_print.php?menu=ri">for print</a>
<li><A HREF="../general/search.php?menu=ri">Search</A>
<!--
<li><A HREF="sb_provisional_interest_tabular.php">Interest Payable On ReInvestment Deposit</A> 
<li><A HREF="../general/ccb_current_balance.php?op=22403">Invest In Re-investmentment Deposit(SCB/CCB)[22403]</A>
<li><A HREF="../general/ccb_current_balance.php?op=22503">Invest In Re-investmentment Deposit(Others)[22503]</A>
-->
</ol>
</td>
</TABLE>
<hr>
</BODY>
</HTML>
