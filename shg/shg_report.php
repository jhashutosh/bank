<?php 
include "../config/config.php"; 
$staff_id=verifyAutho();
?>
<HTML>
<TITLE>SHG Reports</TITLE>
<link rel="stylesheet" type="text/css" href="../css/test.css" />
<center>
<font color="GREEN">

<H1>SHG Reports</H1>
</font>
</center>
<HR>
<BODY>
<! center>
<TABLE>
<TR>
<TD>
<ol>
<li><A HREF="shg_group_list.php"> Shg group list</A>
<li><A HREF="shg_total_info.php"> Total Deposit of SHG groups</A>
<li><A HREF="../general/loan_main.php?menu=sgl">Total Loan Information</A>
<li><A HREF="../general/list_of_loan.php?menu=sgl&op=o">Overdue loan list</A>
<li><A HREF="../general/list_of_loan.php?menu=sgl&op=d">Due loan list</A>
<li><A HREF="shg_closed.php">SHG loan closed account list</A>
<li><A HREF="shg_ri.php">List of Re investment</A>
<li><A HREF="shg_rd.php">List of Recurring Deposits</A>
<li><A HREF="shg_fd.php">List of Fixed Deposits</A>
<li><A HREF="shg_sb.php">List of Saving Deposits</A>
<?php
echo "<li><a href=\"../general/loan_list.php?menu=sgl\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=720,height=1000'); return false;\">Debtors List</A>";


echo "<li><a href=\"../general/list_of_loan.php?menu=sgl\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=750,height=800'); return false;\">List of Loan According to Account No.</a>";
?>
</ol>
<TR>
<TD>
</TABLE>

</BODY>
</HTML>
