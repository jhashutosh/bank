<? 
include "../config/config.php"; 
$staff_id=verifyAutho();
?>
<HTML>
<TITLE> Reports</TITLE>
<link rel="stylesheet" type="text/css" href="../css/test.css" />
<center>
<font color="GREEN">

<H1>Mini Reports</H1>
</font>
</center>
<HR>
<BODY>
<! center>
<TABLE>
<TR>
<TD>
<ol>
<li><A HREF="cstmr_wise_pay_dtl.php"> Customer Wise Bill Payment Details</A>
<li><A HREF="oprtr_wise_wtr_bil_dtl.php">Operator Wise Water Bill Payment</A>
<li><A HREF="report_mini_pl.php">Mini Wise Profit & Loss</A>
<!--<li><A HREF="../general/list_of_loan.php?menu=jgl&op=d">Due loan list</A>
<li><A HREF="jlg_closed.php">JLG loan closed account list</A>
<li><A HREF="shg_ri.php">List of Re investment</A>
<li><A HREF="shg_rd.php">List of Recurring Deposits</A>
<li><A HREF="shg_fd.php">List of Fixed Deposits</A>
<li><A HREF="shg_sb.php">List of Saving Deposits</A>
<li><A HREF="member_list.php">Member List</A>-->
</ol>
<TR>
<TD>
</TABLE>
<? footer(); ?>
</BODY>
</HTML>
