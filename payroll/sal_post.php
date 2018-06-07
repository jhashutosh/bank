<? 
include "../config/config.php"; 
$staff_id=verifyAutho();
$time=date('d/m/Y H:i:s ');
$m=date('m');
$y=date('Y');
$sql="select substr(max(year_month),1,4) yr, substr(max(year_month),5) mn from emp_sal_reg where status ='N'";
$res=dBConnect($sql);
$m=pg_result($res,'mn');
//$y=($m=='12')?pg_result($res,'yr')+1:pg_result($res,'yr');
//$m=($m=='12')?'01':$m+1;
$y=pg_result($res,'yr');
$m=(strlen($m)==1)?'0'.$m:$m;
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<body bgcolor='006699'>";
if (!empty($m)){
echo"<form name='f1' action='sal_post_db.php' method='post'>";
echo"<table align='center' width='100%' >";
echo"<tr><td colspan='6' bgcolor='#CDCDCD' align='center'><font color='#00000f'>Final Salary Posting</td></tr>";
echo"<tr><td colspan='6'><br></td></tr>";
echo"<tr><td align='right'><font color='white'></td><td><font color='white'></td><td><input type='hidden' name='year' size='4' value=$y READONLY $HIGHLIGHT></td>";
echo"<td align='right'><font color='white'></td><td><font color='white':</td><td><input type=\"hidden\" name=\"month\" size=\"2\" value=$m READONLY $HIGHLIGHT></td></tr>";
echo"<tr><td colspan='6' align=center><font size=+1 color='white'> ".$month_array[trim($m,'0')]." , $y</td></tr>";
echo"<tr><td colspan='6'><br></td></tr>";
echo"<tr><td colspan='6' align='center'><input type=\"SUBMIT\" name=\"submit\" value=\"Submit\"></td></tr>";
echo"</form>";}
else {
echo"<center>";
echo"<font size=+1 color='#CDCDCD'>You Havn't Process Salary yet for any Month</font>";
echo"</center>";}
echo"</body>";
?>
