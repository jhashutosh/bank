<?php 
include "../config/config.php";
$menu=$_REQUEST["menu"]; 
$staff_id=verifyAutho();
?>

<HTML>
<HEAD>
<TITLE>Saving Deposit Reports</TITLE>
<LINK href="../css/test.css" type="text/css" rel="STYLESHEET">
</HEAD>
<BODY>
<center>
<font color="GREEN">
<H1>Customer Reports</H1>
</font>
</center>

<! center>
<HR>
<TABLE>
<TR>
<TD>
<ol>
<!--<li><A HREF="cust_report/customer_list_b_date.php"><b>New Account List.</b></A>-->
<li><A HREF="cust_report/customer_account_list.php"><b>Customer List.</b></A>
<li><A HREF="cust_report/customer_cust.php?menu=cust"><b>Caste Wise Customer List </b></A>
<li><A HREF="../general/search.php?menu=cust">Search</A>
<li><A HREF="cust_report/caste_group.php"><b>Caste Wise Customer List </b></A>
<li><A HREF="cust_report/customer_summary.php"><b>List of Account in Details.</b></A>
<!--<li><A HREF="dhal_due_list.php"><b>Total Information</b></A>-->
</ol>
<TR>
<TD>
</TABLE>
<hr>

</BODY>
</HTML>


