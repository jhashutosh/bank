<?php
include "../config/config.php";
$m=date('m');
$y=date('Y');
$sql="select substr(max(year_month),1,4) yr, substr(max(year_month),5) mn from emp_sal_reg where status ='Y'";
$res=dBConnect($sql);
$month_from_db=pg_result($res,'mn');
if(!empty($month_from_db)){ 
$m=pg_result($res,'mn');
$y=($m=='12')?pg_result($res,'yr')+1:pg_result($res,'yr');
$m=($m=='12')?'01':$m+1;
$m=(strlen($m)==1)?'0'.$m:$m;
		}
else
		{
$m=date('m');
$y=date('Y');
		}

//echo trim($m,'0');
//echo $y;
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

</script>
<?php
echo "</head>";
echo"<body bgcolor='C3C3C3'>";
echo"<form name='f1' action='sal_reg_func.php' method='post'>";
echo"<table align='center' width='100%'>";
echo"<tr><td colspan='6' align='center' bgcolor='006666'><font color='white'>Salary Processing</td></tr>";
echo"<tr><td colspan='6' align='center'><font color='darkblue' size=+1><blink>$display</blink></td></tr>";
echo"<tr><td align='right'><font color='darkblue'></td><td><font color='darkblue'></td><td><input type='hidden' name='yy' size='4' value=$y READONLY ></td>";
echo"<td align='right'><font color='darkblue'></td><td><font color='darkblue'></td><td><input type=\"hidden\" name=\"mm\" size=\"2\" value=$m READONLY></td></tr>";
echo"<tr><td colspan=6 align=center><font size=+1> ".$month_array[trim($m,'0')]." , $y</td></tr>";
echo"<tr><td colspan='6'><br></td></tr>";
echo"<tr><td align='center' colspan='6'><input type='submit' value='confirm'></td></tr>";

//echo "<tr><td colspan=\"3\" align=center><iframe src=\"sal_reg_func.php?menu=ast&mm=$mm&yy=$yy&ym=$ym\" width=\"100%\" height=\"200\" ></iframe>";
//echo"<tr><td align='center' colspan='3'><blink><a href=\"payslip.php?menu=ast&id=$id&name=$name&mm=$mm&yy=$yy&ym=$ym\"  onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=200, width=900,height=700'); return false,closeme()\"> Get Pay Slip </a></blink> </td></tr>";
echo"</form>";
//echo $ym;
echo"</body>";
?>
