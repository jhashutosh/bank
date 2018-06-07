<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];                                               
?>
<HTML>
<HEAD>
<TITLE>Report</TITLE>
<link rel="stylesheet" type="text/css" href="../css/test.css">
<font size=4><b>Advance options</font><br>
<I>Report</I>
<HR>
<BODY>
<TABLE>
<table>
<tr>
<tdcolspan=3><font color=#808000 size='3'><b>Staff PF Information</b></font></td>
<ul type=disc>
<font size='2'>
<li><A HREF="../payroll/salary_report.php">Annual Salary Statement</A>
<li><A HREF="../payroll/sal_reg_entry.php">Salary Register Detail</A>
<li><A HREF="../payroll/pf.php">PF Deposit Statement</A>
<li><A HREF="../payroll/pf_dtls.php">PF Detail Statement</A>
<li><A HREF="../payroll/pf_sb_rep.php">PF Savings</A>
<li><A HREF="../payroll/pf_rd_rep.php">PF RD</A>
<li><A HREF="../payroll/pf_ri_rep.php">PF RI</A>
<li><A HREF="../payroll/pf_loan_rep.php">PF Loan</A>
<!--<li><A HREF="../payroll/pf_dtls.php">PF Detail Statement</A>-->
</font>

</table>
<hr>
</table>
</TABLE>
</BODY>
</HTML>
