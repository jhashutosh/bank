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
<tdcolspan=3><font color=#808000 size=4><b>Payroll Information</b></font></td>
<ul type=disc>
<li><A HREF="../payroll/next.php?op=ast">Department Master</A> - To set informations about Departments
<li><A HREF="../payroll/next.php?op=ast">Designation Master</A> - To set informations about Designation
<li><A HREF="../payroll/next.php?op=ast">Grade</A> - Add informations about Grade 
<li><A HREF="../payroll/hme.php?op=ast">Holiday Master</A> -To set Holidays
</table>
<hr>
</table>
<?
}
?>
</TABLE>
</BODY>
</HTML>
