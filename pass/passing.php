<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];                                               
?>
<HTML>
<HEAD>
<TITLE>Passing Authority</TITLE>
<link rel="stylesheet" type="text/css" href="../css/test.css">
<font size=4><b></font><br>
<I></I>
<HR>
<BODY>
<TABLE>
<table>
<tr>
<tdcolspan=3><font color=#808000 size='3'><b>Passing Authority</b></font></td>
<ul type=disc>
<font size='2'>
<li><A HREF="../pass/pass_date.php">Pass Withdrawls Date wise</A>
<!--<li><A HREF="../pass/pass_acc.php">Pass Withdrawls Account wise</A>-->
</font>

</table>
<hr>
</table>
</TABLE>
</BODY>
</HTML>
