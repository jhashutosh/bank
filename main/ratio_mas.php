<?php
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,$f_start_dt,$f_end_dt);
$op=$_REQUEST['op'];
echo "<head>";
echo "<title>Asset Header</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
?>
<script>
function validator1(f)
	{	var msg='';//alert("msg");
		if(f.rto_nm.value==null || f.rto_nm.value=='') {
			msg+="Its A mandatory Field Enter Ratio Name..\n";//return false;
		}
		if(f.amt_perct.value==null || f.amt_perct.value=='')
		{
			msg+="Its A mandatory Field Select Your Choice..\n";//return false;
		}
		if(msg==''){
			return true;
		}
		else{
			alert(msg);
			return false;
		}
	}
</script>
<?php
echo "<body bgcolor=\"silver\">";
echo"<form  name='f1' action=\"ratio_mas.php?op=i\" method='post' onSubmit=\"return validator1(this);\">";
if($op=='i')
{
	$ratio_name=$_REQUEST['rto_nm'];
	$amt_prct=$_REQUEST['amt_perct'];
	if($amt_prct=='amt')
	{
		$amt_prct=0;
		//echo $amt_prct;
	}
	else
	{
		$amt_prct=1;
		//echo $amt_prct;
	}
	$derived=$_REQUEST['drvd'];
	//echo $derived;
	if($derived=='on')
	{
		$derived=1;
		//echo $derived;
	}
	else
	{
		$derived=0;
		//echo $derived;
	}
	$sql="select ratio_mast_save('$ratio_name',$amt_prct,$derived)";
	$result=dBConnect($sql);
	//echo $sql;


}
echo"<table valign=\"top\"width='60%' align='center' bgcolor='grey'>";
echo"<tr><th colspan='4'bgcolor='#3B4444'><font color='white' size='2'>Ratio Master</font></th></tr><tr><td  colspan='2'></td></tr><tr><td  colspan='2'></td></tr><tr><td  colspan='2'></td></tr>";
echo "<tr><td colspan=\"1\" align='center'><font color='black'size='2' align='left'>Ratio Name<font color='red' >*</font>&nbsp;:&nbsp;</td><td align=''left>";
echo"<input type=\"TEXT\" name=\"rto_nm\" size=\"15\" value=\"\"  $HIGHLIGHT>";
echo"</td>";
echo "<td align='right' colspan=\"1\"><font color='black' size='2'>Amount/Percent</font><font color='red' >*</font>:</td>";
echo "<td align='left'  >";
echo "<select name=\"amt_perct\" id=\"amt/perct\"> <option value=''> Select</option>";
echo"<option value='amt'>Amount</option>";
echo"<option value='prcnt'>Percent</option>";
echo"</select></td></tr>";
echo"<tr><td align='center' colspan=\"1\" ><font color='black' size='2'>Derived</font></td><td align='left' colspan=\"1\"><input type=\"checkbox\" name=\"drvd\" id=\"drvd\" style=\"width:20px;height:20px\"></td>";
echo"<td align='right'  colspan='2'><input type='submit' value='Save'></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='2'></td></tr><tr><td  colspan=''></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='2'></td></tr><tr><td  colspan=''></td></tr>";
echo "</table>";
echo"<HR>";
echo"<table width='60%' align='center'>";
echo"<tr><th bgcolor='#3B4444' colspan='4'><font color='white' size='4'>Ratio Master Search</font></th></tr>";
echo"<tr><td  colspan='4'></td></tr>";
echo"<tr>";
echo "<th bgcolor='#3B4444' width=\"10%\"><font color='white' size='2'>Serial No.</font></th>";
echo "<th bgcolor='#3B4444' width=\"20%\"><font color='white' size='2'>Ratio Name</font></th>";
echo "<th bgcolor='#3B4444' width=\"20%\"><font color='white' size='2'>Amount/Percent</font></th>";
echo "<th bgcolor='#3B4444' width=\"10%\"><font color='white' size='2'>Derived</font></th>";
echo"<tr><td colspan=\"4\" align=center><iframe src=\"ratio_mas_frm.php?\" width=\"100%\" height=\"150\" scrollbars=yes, top=100,left=150, width=1098,height=300></iframe>";
echo"</table>";

echo"</form>";
echo "</form>";
echo "</body>";
?>
