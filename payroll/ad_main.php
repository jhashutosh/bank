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
<li><A HREF="../payroll/ad_mas.php">Adhoc Grant Master</A> -Adhoc Grant Informations from Govt.
<li><A HREF="../payroll/ad_dtl.php">Adhoc Grant Details</A> - Adhoc Distribution to Staff
</table>
<hr>
</table>
</TABLE>
</BODY>
</HTML>
