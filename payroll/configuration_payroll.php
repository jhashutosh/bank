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
<?
if($op=='ast'){
?>
<table>
<tr>
<tdcolspan=3><font color=#808000 size=4><b>Payroll Information</b></font></td>
<ul type=disc>
<li><A HREF="../asset/baba.php?op=ast">Earning Deduction Parameter</A> - To set Deduction Parameter
<li><A HREF="../asset/baba.php?op=ast">Professional Tax Slab</A> - Slab creation for professional tax according to basic salary
</table>
<hr>
</table>
<?
}
?>
</TABLE>
</BODY>
</HTML>
