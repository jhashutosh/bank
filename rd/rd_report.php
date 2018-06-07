<?php 
include "../config/config.php";
$menu=$_REQUEST["menu"]; 
$staff_id=verifyAutho();
?>
<HTML>
<head>
<TITLE>Recurring Deposit Reports</TITLE>
<LINK href="../css/test.css" type="text/css" rel="STYLESHEET">
</head>
<BODY>
<center>
<font color="GREEN">
<H1>Recuring Deposit Reports</H1>
</font>
</center>
<HR>
<table>
<tr>
<td>
<ol>
<li><A HREF="../general/summary_report.php?menu=rd">Summary</A>
<li><A HREF="../general/current_balance_deposit.php?menu=rd">Current balance</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=rd&status=name">List of Account(Name Wise)</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=rd&status=account_no">List of Account(Number Wise)</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=rd&status=jn">List of Joint Operation Account</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=rd&status=so">List of Single Operation Account</A>
<li><A HREF="../general/all_deposit.php?menu=rd&op=p">Pre-Mature List Between Date</A>
<li><A HREF="../general/all_deposit.php?menu=rd&op=2t">Today Mature List</A>
<li><A HREF="../general/all_deposit.php?menu=rd&op=m">Mature List </A>
<li><A HREF="../general/provisional_interest.php?menu=rd">Payable Interest </A>
&nbsp;&nbsp;&nbsp;&nbsp;<a HREF="../general/provisional_interest_fd_print.php?menu=rd">for print</a>
</ol>
</td>
<td>&nbsp;</td>
<td>
<ol start=11>
<li><A HREF="../general/all_deposit.php?menu=rd&op=2m">Tomorrow Mature List </A>
<li><A HREF="../general/all_deposit.php?menu=rd&op=d2m">Day After Tomorrow Mature List </A>
<li><A HREF="../general/all_deposit.php?menu=rd&op=m">Matured And Withdrawal List</A>
<li><A HREF="../general/all_deposit.php?menu=rd&op=mbt">Matured But Not Withdrawal List</A>
<li><A HREF="../general/search.php?menu=rd">Search</A>

<!--<li><A HREF="../general/ccb_current_balance.php?op=22401">Invest In Recurring Deposit(SCB/CCB)[22401]</A>
<li><A HREF="../general/ccb_current_balance.php?op=22501">Invest In Recurring Deposit(Others)[22501]</A>-->
</ol>
</td>
</TABLE>
<hr>
</BODY>
</HTML>
