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
if($op=='pr'){
?>
<table>
<tr>
<tdcolspan=3><font color=#808000 size=4><b>Staff Attendence Information</b></font></td>
<ul type=disc>
<li><A HREF="../payroll/ead.php?op=ast">Attendence Details</A> - Informations about Staff Attendence

</table>
<hr>
</table>
<?
}
//<li><A HREF="../payroll/eld.php?op=ast">Leave Details</A> - Informations about Leave Attendence
?>
</TABLE>
</BODY>
</HTML>
