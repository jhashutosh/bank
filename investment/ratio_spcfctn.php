<?
include "../config/config.php";
echo "<head>";
echo "<title>Ratio Specification</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
?>
<script >
function validator1(f)
	{	var msg='';//alert("msg");
		if(f.ratio_name.value==null || f.ratio_name.value=='') {
			msg+="Its A mandatory Field Select Ratio Name..\n";//return false;
		}
		if(f.gl_sub_header_code.value==null || f.gl_sub_header_code.value=='')
		{
			msg+="Its A mandatory Field Select Your Sub-Header..\n";//return false;
		}
		if(f.arth_op.value==null || f.arth_op.value=='')
		{
			msg+="Its A mandatory Field Select Your Arithmatic Operation..\n";//return false;
		}
		if(msg==''){
			return true;
		}
		else{
			alert(msg);
			return false;
		}
	}


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
				document.getElementById("g_ldgr").innerHTML=xmlhttp.responseText;	
			return true;		
					
    				}
  			}
		
		xmlhttp.open("GET","drop_down_rt.php?gl_sub_header_code="+ gl_sub_header_code,true);
		xmlhttp.send();
}
function showdropdwn(e){		
		var gl_sub_header_code=document.getElementById("gl_sub_header_code1").value;
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
				document.getElementById("gl_ledgr").innerHTML=xmlhttp.responseText;	
			return true;		
					
    				}
  			}
		
		xmlhttp.open("GET","drop_down_spc.php?gl_sub_header_code="+ gl_sub_header_code,true);
		xmlhttp.send();
}
</script>
<?
echo "<body bgcolor=\"silver\">";
echo"<form  name='f1' action=\"ratio_spcfctn.php?op=i\" method='post' onSubmit=\"return validator1(this);\">";
if($op=='i')
{
	$rt_id=$_REQUEST['ratio_name'];
	echo $rt_id;
	$gl_sub_hdr_cd=$_REQUEST['gl_sub_header_code'];
	$gl_ldgr=$_REQUEST['g_ldgr'];
	$asmd=$_REQUEST['arth_op'];
	$ratio_name=(!empty($ratio_name))?$rt_id:'null';
	$gl_sub_hdr_cde=(!empty($gl_sub_hdr_cde))?"'".$gl_sub_hdr_cd."'":'null';
	$gl_ldgr=(!empty($gl_ldgr))?"'".$gl_ldgr."'":'null';

	$sql="select ratio_mast1_save($rt_id,'$gl_sub_hdr_cd',$gl_ldgr,'$asmd')";
	$result=dBConnect($sql);
	echo $sql;


}

echo"<table valign=\"top\"width='100%' align='center' bgcolor='grey'>";
echo"<tr><th colspan='4'bgcolor='#3B4444'><font color='white' size='2'>Ratio Specification</font></th></tr><tr><td  colspan='2'></td></tr><tr><td  colspan='2'></td></tr><tr><td  colspan='2'></td></tr>";
echo "<tr><td colspan=\"1\" align='right'><font color='black'size='2' align='left'>Ratio Name<font color='red' >*</font>&nbsp;:&nbsp;</td><td align=''left>";
echo"<select name=\"ratio_name\" id=\"ratio_name\"> <option value=''> Select</option>";
$sql="select distinct(ratio_name) as ratio_name,id from ratio_level";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
echo"<option value=\"".$row['id']."\">".$row['ratio_name']."</option>";
}
echo"</select></td>";
echo "<td align='right' colspan=\"1\"><font color='black' size='2'>Sub-Header</font><font color='red' >*</font>:</td>";
echo "<td align='left'  >";
echo "<select name=\"gl_sub_header_code\" id=\"gl_sub_header_code\" onChange=\"return showcodehints(event);\"  onblur=\"return validator1(this);\"> <option value=''> Select</option>";
$sql2="select gl_sub_header_desc,gl_sub_header_code from gl_sub_header";
$res2=dBConnect($sql2);
for($j=0;$j<pg_NumRows($res2);$j++){
$row2=pg_fetch_array($res2,$j);
echo"<option value=\"".$row2['gl_sub_header_code']."\">".$row2['gl_sub_header_desc']."</option>";
}
echo"</select></td></tr>";
echo"<tr><td align='right' colspan=\"1\"><font color='black' size='2'>General Ledger:</font></td>";
echo "<td align='left'>";
echo "<select name=\"g_ldgr\" id=\"g_ldgr\" onblur=\"return validator1();\"> <option value=''> Select</option>";
echo"</select></td>";
echo "<td align='right' colspan=\"1\"><font color='black' size='2'>Arithmatic Operation</font><font color='red' >*</font>:</td>";
echo "<td align='left'  >";
echo "<select name=\"arth_op\" id=\"arth_op\"> <option value=''> Select</option>";
echo"<option >/</option>";
echo"<option >*</option>";
echo"<option >+</option>";
echo"<option >-</option>";
echo"</select></td></tr>";
echo"<tr><td align='right'  colspan='4'><input type='submit' value='Save'></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='2'></td></tr><tr><td  colspan=''></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='2'></td></tr><tr><td  colspan=''></td></tr>";
echo "</table>";
echo"</form>";
//================================Search Tool======================================
echo"<form  name='f2' action=\"ratio_spcfctn.php?\" method='post'>";
echo"<table width='100%' align='center' bgcolor='grey'>";
echo"<tr><th colspan='7'bgcolor='#3B4444'><font color='white' size='2'>Search For Ratio Specification</font></th></tr><tr><td  colspan='2'></td></tr><tr><td  colspan='2'></td></tr><tr><td  colspan='2'></td></tr>";
echo"<tr><td colspan=\"1\" align='right'><font color='black'size='2' align='left'>Ratio Name</td><td align='left'>";
echo"<select name=\"rt_nm\" id=\"rt_nm\"> <option value=''> Select</option>";
$sql3="select distinct(ratio_name) as ratio_name,id from ratio_level";
$res3=dBConnect($sql);
for($j=0;$j<pg_NumRows($res3);$j++){
$row3=pg_fetch_array($res3,$j);
echo"<option value=".$row3['id'].">".$row3['ratio_name']."</option>";
}
echo"</select></td>";
echo "<td align='right' colspan=\"1\"><font color='black' size='2'>Sub Header</font><font color='red' >*</font>:</td>";
echo "<td align='left'  >";
echo"<select name=\"gl_sub_header_code1\" id=\"gl_sub_header_code1\" onChange=\"return showdropdwn(event);\"> <option value=''> Select</option>";
$sql4="select gl_sub_header_desc,gl_sub_header_code from gl_sub_header";
$res4=dBConnect($sql4);
for($j=0;$j<pg_NumRows($res4);$j++){
$row4=pg_fetch_array($res4,$j);
echo"<option value=\"".$row4['gl_sub_header_code']."\">".$row4['gl_sub_header_desc']."</option>";
}
echo"</select></td>";
echo"<td align='right' colspan=\"1\"><font color='black' size='2'>Gl Ledger:</font></td>";
echo "<td align='left'  >";
echo "<select name=\"gl_ledgr\" id=\"gl_ledgr\"> <option value=''>Select</option>";
echo"</td></tr><tr><td align='right'  colspan='7'><input type='submit' value='Search'></td></tr>";

echo"</table>";
echo"</form>";
//===========================frame=======================================================
echo"<table width='100%' align='center'>";
echo"<tr>";
echo "<th bgcolor='#3B4444' width=\"5%\"><font color='white' size='2'>Serial No.</font></th>";
echo "<th bgcolor='#3B4444' width=\"20%\"><font color='white' size='2'>Ratio Name</font></th>";
echo "<th bgcolor='#3B4444' width=\"15%\"><font color='white' size='2'>Link Ratio Name</font></th>";
echo "<th bgcolor='#3B4444' width=\"25%\"><font color='white' size='2'>Sub Header</font></th>";
echo "<th bgcolor='#3B4444' width=\"25%\"><font color='white' size='2'>Gl Ledger</font></th>";
echo "<th bgcolor='#3B4444' width=\"10%\"><font color='white' size='2'>Arithmatic Operation</font></th>";
echo"<tr><td colspan=\"6\" align=center><iframe src=\"ratio_spec_srch_frm.php?rt_nm=$rt_nm&gl_s_h=$gl_sub_header_code1&gl_ledgr=$gl_ledgr\" width=\"100%\" height=\"150\" scrollbars=yes, top=100,left=150, width=1098,height=300></iframe>";
echo"</table>";
echo "</body>";

?>
