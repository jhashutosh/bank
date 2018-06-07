<?
include "../config/config.php";
$staff_id=verifyAutho();
$entry_time=date('d/m/Y H:i:s ');
//if(empty($mdate)){$mdate=date('d.m.Y');}
echo "<html>";
echo "<head>";
echo "<title>Salary Parameter</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\"></script>";?>
<SCRIPT type="text/javascript">
function checkdate(){
//alert("sec");
var str=document.getElementById("eff_from").value;
//alert("str");
var url="checkparam.php?date="+str;
if (window.XMLHttpRequest) 
	{
		xmlhttp=new XMLHttpRequest();
	}
	else		
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	//alert(xmlhttp.responseText)
			if(xmlhttp.responseText==1)
			{document.getElementById("hintSpan2").innerHTML="<font color=green>You Can Set Salary Parameter </font>";
			document.getElementById("sub").disabled=false;}
			else
			{document.getElementById("hintSpan2").innerHTML=xmlhttp.responseText;
			document.getElementById("sub").disabled=true;}
			
		}
						}
	xmlhttp.open("POST",url,true);
	xmlhttp.send();
}
</SCRIPT>
<?
echo "</head>";
$sql="select * from emp_sal_param where effected_from=(select max(effected_from) from emp_sal_param) ";
$res=dBConnect($sql);
$row=pg_fetch_array($res,0);
echo "<body bgcolor=\"#EFEFEF\">";
echo "<form name=\"f1\" METHOD=\"POST\" ACTION=\"sal_param_db.php\">";
echo "<center>";
echo "<table align='center' bgcolor='#B1B1B1' width='90%' height='40%'>";
echo "<tr><td bgcolor=\"grey\" colspan=\"4\" align=\"center\"><b><font color=\"WHITE\">Salary Parameter Setting</font></td></tr>";
echo "<tr><td bgcolor=\"#EFEFEF\" >Dearness Allowance</td><td bgcolor=\"#EFEFEF\"><input type=\"text\" name=\"da\" value='".$row['da1']."' size=\"10\">%</td>";
echo "<td bgcolor=\"#EFEFEF\">Medical Allowance</td><td bgcolor=\"#EFEFEF\"><input type=\"text\" name=\"ma\" value='".$row['ma1']."' size=\"10\">Rs/-</td>";
echo "<tr><td bgcolor=\"#EFEFEF\">Employer's Contribution PF</td><td bgcolor=\"#EFEFEF\"><input type=\"text\" value='".$row['emplee_cont_pf1']."' name=\"ecrpf\"size=\"10\">%</td>";
echo "<td  bgcolor=\"#EFEFEF\">Employee's Contribution PF</td><td bgcolor=\"#EFEFEF\"><input type=\"text\" name=\"ecpf\" value='".$row['emplee_cont_pf1']."' size=\"10\">%</td></tr>";

echo "<tr><td bgcolor=\"#EFEFEF\">HRA</td><td bgcolor=\"#EFEFEF\"><input type=\"text\" value='".$row['hra1']."' name=\"hra\"size=\"10\">%</td>";
echo "<td  bgcolor=\"#EFEFEF\" colspan='2'></td></tr>";

/*change in bbn
echo "<tr><td bgcolor=\"#EFEFEF\">Special Allowance</td><td bgcolor=\"#EFEFEF\"><input type=\"text\" value='".$row['hra1']."' name=\"spla\"size=\"10\">Rs </td>";

echo "<td bgcolor=\"#EFEFEF\">Key Allowance</td><td bgcolor=\"#EFEFEF\"><input type=\"text\" value='".$row['hra1']."' name=\"ka\"size=\"10\">Rs </td></tr>";

change in bbn
*/

echo "<tr><td  bgcolor=\"#EFEFEF\">Puja Bonus </td><td bgcolor=\"#EFEFEF\"><input type=\"text\" name=\"pbonus\" value='".$row['puja_bonus']."' size=\"10\"> days</td>";
echo "<td  bgcolor=\"#EFEFEF\">Puja Bonus Month</td><td bgcolor=\"#EFEFEF\">
<select name='pbonusm'>
<option value='01'>JAN</option>
<option value='02'>FEB</option>
<option value='03'>MAR</option>
<option value='04'>APR</option>
<option value='05'>MAY</option>
<option value='06'>JUN</option>
<option value='07'>JUL</option>
<option value='08'>AUG</option>
<option value='09'>SEP</option>
<option value='10'>OCT</option>
<option value='11'>NOV</option>
<option value='12'>DEC</option>
</select></td></tr>";
echo "<tr><td  bgcolor=\"#EFEFEF\">Effected From</td><td bgcolor=\"#EFEFEF\"><input type='text' name='eff_from'  value='".$row['effected_from']."'  id='eff_from' size='10' onblur='checkdate();' onchange='checkdate();' onkeyup='checkdate();' $HIGHLIGHT>&nbsp<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.eff_from,'dd/mm/yyyy','Choose Date')\"><span id=\"hintSpan2\"></span></td>";
echo "<td  bgcolor=\"#EFEFEF\" align=\"right\"  colspan=\"2\" ><input type=\"SUBMIT\"  name=\"SUBMIT_BUTTON\" value=\"Submit\" id='sub' disabled></td></tr>";
echo "</table><br>";
echo"<table width='100%'bgcolor='#EFEFEF'>";
echo"<tr bgcolor='Grey'>";
echo"<th rowspan='2' width='11%'><font color='white'>DA</th>";
echo"<th  rowspan='2' width='9%'><font color='white'>HRA</th>";
echo"<th  rowspan='2' width='9%'><font color='white'>MA</th>";
echo"<th colspan='2'><font color='white'>PF Contribution</th>";
echo"<th colspan='2'><font color='white'>Puja Bonus</th>";
echo"<th rowspan='2'><font color='white'>Effect From</th>";
echo"</tr><tr  bgcolor='Grey'>";
echo"<th><font color='white'>Employee</th><th><font color='white'>Employer</th>";
echo"<th><font color='white'>% of Basic</th><th><font color='white'>Month</th></tr></table>";
echo"<table width='100%'bgcolor=''>";
echo"<tr><td colspan='7'><iframe style='background-color:transparent;' marginheight=0 marginwidth=0 noresize FRAMEBODER=NO BORDER=0 BORDERCOLOR=\"#EFEFEF\" FRAMESPACING=0 
src=\"sal_db.php\" width=\"100%\" height=\"200\" ></iframe></td></tr>";
echo"</table>";
echo "</body>";
echo "</html>";
?>
