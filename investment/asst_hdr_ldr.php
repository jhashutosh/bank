<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$op=$_REQUEST['op'];
echo "<head>";
echo "<title>Asset Header</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<script >
function showcodehints(e){		
		var gl_sub_header_code=document.getElementById("gl_sub_header_code").value;
			if (window.XMLHttpRequest) // code for IE7+, Firefox, Chrome, Opera, Safari
 			{
  				xmlhttp=new XMLHttpRequest();
  			}
		else		// code for IE6, IE5
  			{
  				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 			 }

		xmlhttp.onreadystatechange=function() {
  			if (xmlhttp.readyState==4 && xmlhttp.status==200)
    				{
				document.getElementById("asst_ldgr").innerHTML=xmlhttp.responseText;	
			return true;		
					
    				}
  			}
		
		xmlhttp.open("GET","drop_down.php?gl_sub_header_code="+ gl_sub_header_code,true);
		xmlhttp.send();
}
function showdropdwn(e){		
		var gl_sub_header_code=document.getElementById("gl_sub_hdr_cde").value;
			if (window.XMLHttpRequest) // code for IE7+, Firefox, Chrome, Opera, Safari
 			{
  				xmlhttp=new XMLHttpRequest();
  			}
		else		// code for IE6, IE5
  			{
  				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 			 }

		xmlhttp.onreadystatechange=function() {
  			if (xmlhttp.readyState==4 && xmlhttp.status==200)
    				{
				document.getElementById("asset_ledgr").innerHTML=xmlhttp.responseText;	
			return true;		
					
    				}
  			}
		
		xmlhttp.open("GET","drop_down2.php?gl_sub_header_code="+ gl_sub_header_code,true);
		xmlhttp.send();
}
function validator1(f)
	{	var msg='';//alert("msg");
		if(f.dt_to.value==null || f.dt_to.value=='')
		{
			msg+="Please Give Date..\n";//return false;
		}
		if(f.gl_sub_header_code.value==null || f.gl_sub_header_code.value=='') {
			msg+="Please Select Asset Sub Header..\n";//return false;
		}
		if(f.rsk_wght.value==null || f.rsk_wght.value==''){
			msg+="Please enter Risk Weight Percent..";//return false;
			
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
<?
echo "</head>";
echo "<body bgcolor=\"silver\">";

if($op=='i')
{
	$dt_frm=$_REQUEST['dt_frm'];
	$dt_to=$_REQUEST['dt_to'];	
	$gl_sub_header_code=$_REQUEST['gl_sub_header_code'];
	$asst_ldgr=$_REQUEST['asst_ldgr'];
	echo $asst_ldgr;
	$rsk_wght=$_REQUEST['rsk_wght'];
	$sql="select risk_wght_prcnt_vld('$dt_frm','$dt_to','$gl_sub_header_code','$asst_ldgr') as char";
	$res=dBConnect($sql);
	//echo $sql;
	$row=pg_fetch_array($res,0);
	$get_result=$row['char'];
	
	if($get_result!=null){
				echo "<table align='center'><th><font color='RED' size='5'><blink>$get_result</blink></font></th>";
	}
			
	else
	{
			if(empty($asst_ldgr))
			{
			$sql_statement="select risk_wght_prcnt_save('$dt_frm','$dt_to','$gl_sub_header_code',null,$rsk_wght)";
			$result=dBConnect($sql_statement);
			echo $sql_statement;
			}
			else
			{
			$sql_statement="select risk_wght_prcnt_save('$dt_frm','$dt_to','$gl_sub_header_code','$asst_ldgr',$rsk_wght)";
			$result=dBConnect($sql_statement);
			echo $sql_statement;
			}
			if(pg_NumRows($result)>0)
			{
				echo "<table align='center'><th><font color='Green' size='3'><blink>Data Successfully Inserted!!</font><th></table>";
			}
			else
			{
				echo "<table align='center'><th ><font color='RED' size='3'><blink>Failed To Insert Data!!</blink></font><th></table>";
			}
			
	}


}
echo"<form  name='f1' action=\"asst_hdr_ldr.php?op=i\" method='post' onSubmit=\"return validator1(this);\">";
echo"<table valign=\"top\"width='80%' align='center' bgcolor='grey'>";
echo"<tr><th colspan='6'bgcolor='darkblue'><font color='white' size='2'>Risk Weighted Assets % Master</font></th></tr><tr><td  colspan='2'></td></tr><tr><td  colspan='2'></td></tr><tr><td  colspan='2'></td></tr>";
echo "<tr><td colspan=\"2\" align='right'><font color='black'size='2' align='left'>Date From&nbsp;:&nbsp;</td><td align=''left>";
echo"<input type=\"TEXT\" name=\"dt_frm\" size=\"8\" value=\"$f_start_dt\"  $HIGHLIGHT>";
echo"</td>";
echo "<td colspan=\"2\" align='right'><font color='black'size='2' align='left'>Date To<font color='red' >*</font>&nbsp;:&nbsp;</td><td align='left'>";
echo"<input type=\"TEXT\" name=\"dt_to\" id=\"dt_to\" size=\"8\" value=\"$f_end_dt\"  onblur=\"return validator1(this);\"$HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.dt_to,'dd/mm/yyyy','Choose Date')\" >";
echo"</td>";
echo"</tr>";
echo "<tr><td align='right' colspan=\"2\"><font color='black' size='2'>Asset Sub Header</font><font color='red' >*</font>:</td>";
echo "<td align='left'  >";
echo "<select name=\"gl_sub_header_code\" id=\"gl_sub_header_code\" onChange=\"return showcodehints(event);\"  onblur=\"return validator1(this);\"> <option value=''> Select</option>";
$sql="select distinct(gl_sub_header_code) as gl_sub_header_code from gl_master where cast(gl_sub_header_code as int) between 20000 and 29999";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
echo"<option >".$row['gl_sub_header_code']."</option>";
}
echo"</select></td>";
echo"<td align='right' colspan=\"2\"><font color='black' size='2'>Asset Ledger:</font></td>";
echo "<td align='left'  >";
echo "<select name=\"asst_ldgr\" id=\"asst_ldgr\" onblur=\"return validator1();\"> <option value=''> Select</option>";
echo"</select></td></tr>";
echo"<tr><td align='right' colspan='2'><font color='black' size='2' align='left'>Risk Weight(%)<font color='red' >*</font>&nbsp;:&nbsp;</td><td align='left'>";
echo"<input type='text' name='rsk_wght' id='rsk_wght' size='5'  onblur=\"return validator1();\"$HIGHLIGHT ></td><td align='right'  colspan='3'><input type='submit' value='Save'></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='2'></td></tr><tr><td  colspan=''></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='2'></td></tr><tr><td  colspan=''></td></tr>";
echo "</table>";
echo"<HR>";
echo"</form>";
//===================================================Search Tool======================================================================================
echo"<form  name='f2' action=\"asst_hdr_ldr.php?\" method='post'>";
echo"<table width='80%' align='center' bgcolor='#596D6D'>";
echo"<tr><th colspan='9'bgcolor='darkblue'><font color='white' size='2'>Search For Risk Weighted Assets</font></th></tr><tr><td  colspan='2'></td></tr><tr><td  colspan='2'></td></tr><tr><td  colspan='2'></td></tr>";
echo"<tr><td colspan=\"2\" align='right'><font color='black'size='2' align='left'>Date From&nbsp;:&nbsp;</td><td align=''left>";
echo"<input type=\"TEXT\" name=\"dat_frm\" size=\"8\" value='".$f_start_dt."'  $HIGHLIGHT></td>";
echo "<td align='right' colspan=\"2\"><font color='black' size='2'>Asset Sub Header</font><font color='red' >*</font>:</td>";
echo "<td align='left'  >";
echo"<select name=\"gl_sub_hdr_cde\" id=\"gl_sub_hdr_cde\" onChange=\"return showdropdwn(event);\"> <option value=''> Select</option>";
$sql="select distinct(gl_sub_header_code) as gl_sub_header_code from gl_master where cast(gl_sub_header_code as int) between 20000 and 29999  ";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
echo"<option value='".$row['gl_sub_header_code']."' >".$row['gl_sub_header_code']."</option>";
}
echo"</select></td>";
echo"<td align='right' colspan=\"2\"><font color='black' size='2'>Asset Ledger:</font></td>";
echo "<td align='left'  >";
echo "<select name=\"asset_ledgr\" id=\"asset_ledgr\"> <option value=''>Select</option>";
echo"</td></tr><tr><td align='right'  colspan='9'><input type='submit' value='Search'></td></tr></table>";
//==============================================GridView====================================================================================================
echo"<table width='95%' align='center'>";
echo"<tr>";
echo "<th bgcolor='#7F9BBF' width=\"5%\"><font color='#043C70' size='2'>Serial No.</font></th>";
echo "<th bgcolor='#7F9BBF' width=\"10%\"><font color='#043C70' size='2'>Date From</font></th>";
echo "<th bgcolor='#7F9BBF' width=\"10%\"><font color='#043C70' size='2'>Date To</font></th>";
echo "<th bgcolor='#7F9BBF' width=\"15%\"><font color='#043C70' size='2'>Gl Sub Header Code</font></th>";
echo "<th bgcolor='#7F9BBF' width=\"20%\"><font color='#043C70' size='2'>Gl Sub Header Desc.</font></th>";
echo "<th bgcolor='#7F9BBF' width=\"15%\"><font color='#043C70' size='2'>Gl Mas Code</font></th>";
echo "<th bgcolor='#7F9BBF' width=\"20%\"><font color='#043C70' size='2'>Gl Mas Desc.</font></th>";
echo "<th bgcolor='#7F9BBF' width=\"10%\"><font color='#043C70' size='2'>Percentage</font></th>";
echo"<tr><td colspan=\"8\" align=center><iframe src=\"risk_dis.php?dat_frm=$dat_frm&gl_sub_hdr_cde=$gl_sub_hdr_cde&asset_ledgr=$asset_ledgr\" width=\"100%\" height=\"150\" scrollbars=yes, top=100,left=150, width=1098,height=300></iframe>";
echo"</table>";
echo "</form>";
echo "</body>";
?>
