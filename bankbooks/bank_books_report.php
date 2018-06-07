<? 
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

<li><A HREF="current_ac_ccb.php"><b>Current A/C C.C.B</b></A>
<li><A HREF="current_ac_other.php"><b>Current A/C Others Bank</b></A>
<li><A HREF="sb_ac_ccb.php"><b>SB A/C C.C.B</b></A>
<li><A HREF="sb_ac_other.php"><b>SB A/C Others Bank</b></A>
<li><A HREF="all_deposit_statement_bank.php"><b>All Deposit Statement</b></A>
<!--<li><A HREF="kcc_ac_ccb.php"><b>KCC A/C C.C.B</b></A>
<li><A HREF="investment_ri.php"><b>KCC A/C Others Bank</b></A>
<li><A HREF="shg_ac_ccb.php"><b>SHG A/C C.C.B</b></A>
<li><A HREF="all_ac_ccb.php"><b>ALL LOAN A/C C.C.B</b></A>-->
<li><A HREF="ccbd.php"><b>C.C.B REPORT</b></A>
<li><A HREF="../CCB_MTH/report1.php"><b>C.C.B Monthly Report(Loan)</b></A>
<li><A HREF="../CCB_MTH/report-1-1.php"><b>C.C.B Monthly Report(Deposit)</b></A>
<li><A HREF="register.php"><b>Bank Monthly Return</b></A>
</ol>
<TR>
<TD>
</TABLE>
<hr>

</BODY>
</HTML>


