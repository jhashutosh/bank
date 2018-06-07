<?
include "../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
$time=date('d/m/Y H:i:s ');
$staff_id=verifyAutho();
$id=$_REQUEST['id'];
$name=$_REQUEST['name'];
$bp=$_REQUEST['basicpay'];
$ef=$d.$_REQUEST['efctfrm'];
$doj=$_REQUEST['doj'];
$sql="select * from emp_sal_dtl where emp_id=$id and effected_from = (select max(effected_from) from emp_sal_dtl where emp_id=$id) ";
$result=dBConnect($sql);
$row=pg_fetch_array($result,0);
$x=(empty($row['basic']))?0:$row['basic'];
$y=date('m/Y');
$a=(empty($bp))?$x:$bp;
$b=(empty($ef))?$y:$ef;
echo "<head>";
echo "<title>Basic Pay entry";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
?>
<script language="JAVASCRIPT">
function closeme() { 
	close(); 
}
function myRefresh(URL){
	window.opener.location.href =URL;
    	self.close();
    	}

</script>
<?
echo "</head>";
echo"<body bgcolor='006699'>";
echo"<form name='f1' action='basic_pay.php?menu=ast&id=$id&name=$name&doj=$doj' method='post'>";
echo"<table align='center' width='100%' >";
echo"<tr><th colspan='3' bgcolor='aqua' align='center'><font color='darkblue'>Basic Pay Entry Form</font> </th></tr>";
echo"<tr><th colspan='3' bgcolor='9999FF' align='center'>ID -><font color='white' size='3'><blink><b> &nbsp; $id</blink></font></th></tr>";

echo"<tr><td colspan='3' align='center'><font color='white' size='2'>";if(empty($row['effected_from']))
echo"salary information not available";
else echo"previously effected from  : ".$row['effected_from']."";
echo"</font></td></tr>";
echo"<tr><td colspan='3'></td></tr><tr><td colspan='3'></td></tr>";
echo"<tr><td align='right'><font color='white'><b>Basic Pay</td><td>:</td><td >Rs.<input type='text' name='basicpay' size='8' value=$a $HIGHLIGHT></td></tr>";
echo"<tr><td align='right'> <font color='white'><b>Effect From</td><td>:</td><td ><input type=\"TEXT\" name=\"efctfrm\" size=\"12\" value=$b READONLY $HIGHLIGHT><font color='red'>&nbsp;*</font>";
//echo "&nbsp<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.efctfrm,'dd/mm/yyyy','Choose Date')\"></td></tr>";
echo"<tr><td align='center' colspan='3'><input type='submit' value='confirm'></td></tr>";

//echo"<tr><td align='center' colspan='3'><a href=\"emp_sal_dtl.php?menu=ast&id=$id&name=$name&doj=$doj&bp=$bp&ef=$ef&si=$staff_id&ts=$time\"  onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=300, width=600,height=400'); return false;\"> Proceed </a> </td></tr>";
echo"<tr><td align='center' colspan='3'><iframe src=\"emp_sal_dtl.php?menu=ast&id=$id&name=$name&doj=$doj&bp=$bp&ef=$ef&si=$staff_id&ts=$time\" width=\"100%\" height=\"300\" ></iframe></td></tr>";
echo"<tr><td colspan='3' align='center'><input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme(),myRefresh('../payroll/emp_db.php')\"></td></tr>";
echo"</form></body>";
?>
