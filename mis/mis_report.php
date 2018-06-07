<?php 
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
<H1> MIS  Reports</H1>
</font>
</center>
<HR>
<table>
<tr>
<td>
<ol>
<li><A HREF="../general/summary_report.php?menu=mis">Summary</A>
<?//<li><A HREF="date_between_details.php?menu=mis">Date Between Details</A> -->
?>
<?//<li><A HREF="ri_no_of_certificates.php">Interest Rate Wise Certificate List</A> -->
?>
<li><A HREF="../general/current_balance_deposit.php?menu=mis">Current balance</A>
<li><A HREF="../general/provisional_interest.php?menu=mis">Payable Interest</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=mis&status=name">List of Account(Name Wise)</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=mis&status=account_no">List of Account(Number Wise)</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=mis&status=jn">List of Joint Operation Account</A>
<li><A HREF="../general/g_report/list_of_accounts.php?menu=mis&status=so">List of Single Operation Account</A>

<li><A HREF="../general/all_deposit.php?menu=mis&op=p">Pre-Mature List Between Date</A>
<li><A HREF="../general/all_deposit.php?menu=mis&op=2t">Today Mature List</A>

<li><A HREF="../general/all_deposit.php?menu=mis&op=m">Mature List </A>
<li><A HREF="../general/all_deposit.php?menu=mis&op=2m">Tomorrow Mature List </A>
<li><A HREF="../general/all_deposit.php?menu=mis&op=d2m">Day After Tomorrow Mature List </A>
<li><A HREF="../general/all_deposit.php?menu=mis&op=m">Matured And Withdrawal List</A>
<li><A HREF="../general/all_deposit.php?menu=mis&op=mbt">Matured But Not Withdrawal List</A>

<li><A HREF="../general/search.php?menu=mis">Search</A>
</ol>
</td>
<td>&nbsp;</td>
<td>
<ol start=13>

</ol>
</td>
</TABLE>
<hr>
</BODY>
</HTML>
