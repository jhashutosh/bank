<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];                                               
?>
<HTML>
<HEAD>
<TITLE>Configuration</TITLE>
<link rel="stylesheet" type="text/css" href="../css/test.css">
<font size=+2><b>Advance options</font><br>
<I>Banking parameters configuration and information updation</I>
<HR>
<BODY>
<TABLE>
<table>
<tr>
<tdcolspan=3><font color=#808000 size=4><b>Staff PF Information</b></font></td>
<ul type=disc>
<li><A HREF="../payroll/stf_pf_loan_dtl.php">PF Loan Issue</A> - Staff PF Loan Issue
<li><A HREF="../payroll/stf_pf_loan_dtl_op.php">PF Loan Opening</A> - Staff PF Loan Opening
</table>
<hr>
</table>
</TABLE>
</BODY>
</HTML>
