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

<li><A HREF="investment_fd.php"><b>Investment FD</b></A>
<li><A HREF="investment_ri.php"><b>Investment Ri</b></A>
<li><A HREF="investment_rd.php"><b>Investment Rd </b></A>
<!--<li><A HREF="investment_ri_shg.php"><b>Investment Ri-SHG</b></A>
<li><A HREF="investment_fd_uco.php"><b>Investment Fd UCO</b></A>
<li><A HREF="investment_fd_axis.php"><b>Investment FD AXIS</b></A>
<li><A HREF="provisional_interest_pf.php"><b>Receiveable Interest Investment Pf </b></A>
<li><A HREF="provisional_interest_fd_uco.php"><b>Receiveable Interest Investment FD UCO </b></A>
<li><A HREF="provisional_interest_fd_axis.php"><b>Receiveable Interest Investment FD AXIS </b></A>
<li><A HREF="provisional_interest_ri_shg.php"><b>Receiveable Interest Investment Ri-SHG </b></A>-->
<li><A HREF="provisional_interest_ri.php"><b>Receiveable Interest Investment Ri </b></A>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="provisional_interest_ri_print.php"><b>For Print </b></A>
<li><A HREF="provisional_interest_rd.php"><b>Receiveable Interest Investment Rd </b></A>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="provisional_interest_ri.php"><b>For Print </b></A>



</ol>
<TR>
<TD>
</TABLE>
<hr>

</BODY>
</HTML>


