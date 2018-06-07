<?php
include "../config/config.php";
echo "<head>";
echo "<title>Ratio Specification Derived</title>";
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




function showdropdwn2(e){		
		var ratio_name=document.getElementById("rt_nm").value;
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
				document.getElementById("lnk_rt_nm").innerHTML=xmlhttp.responseText;	
			return true;		
					
    				}
  			}
		
		xmlhttp.open("GET","drop_down_drvd2.php?ratio_name="+ratio_name,true);
		xmlhttp.send();
}
function showdropdwn(e){		
		var ratio_name=document.getElementById("ratio_name").value;
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
				document.getElementById("link_rt_nm").innerHTML=xmlhttp.responseText;	
			return true;		
					
    				}
  			}
		
		xmlhttp.open("GET","drop_down_drvd.php?ratio_name="+ratio_name,true);
		xmlhttp.send();
}
</script>
<?php
echo "<body bgcolor=\"silver\">";
echo"<form  name='f1' action=\"ratio_spc_drvd.php?op=i\" method='post' onSubmit=\"return validator1(this);\">";
if($op=='i')
{
	$rt_id=$_REQUEST['ratio_name'];
	//echo $rt_id;
	$link_rt_nm=$_REQUEST['link_rt_nm'];
	$asmd=$_REQUEST['arth_op'];

	$sql="select ratio_mast2_save($rt_id,$link_rt_nm,'$asmd')";
	$result=dBConnect($sql);
	//echo $sql;


}

echo"<table valign=\"top\"width='80%' align='center' bgcolor='grey' >";
echo"<tr><th colspan='4'bgcolor='#3B4444'><font color='white' size='2'>Derived Ratio Specification</font></th></tr><tr><td  colspan='2'></td></tr><tr><td  colspan='2'></td></tr><tr><td  colspan='2'></td></tr>";
echo "<tr><td colspan=\"1\" align='right'><font color='black'size='2' align='left'>Ratio Name<font color='red' >*</font>&nbsp;:&nbsp;</td><td align=''left>";
echo"<select name=\"ratio_name\" id=\"ratio_name\" onChange=\"return showdropdwn(event);\"> <option value=''> Select</option>";
$sql="select distinct(ratio_name) as ratio_name,id from ratio_level where derived=1";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
echo"<option  value=\"".$row['id']."\">".$row['ratio_name']."</option>";
}
echo"</select></td>";
echo"<td align='right' colspan=\"1\"><font color='black' size='2'>Link Ratio Name:</font></td>";
echo "<td align='left'>";
echo "<select name=\"link_rt_nm\" id=\"link_rt_nm\"> <option value=''> Select</option>";
echo"</select></td></tr>";
echo "<tr><td align='right' colspan=\"1\"><font color='black' size='2'>Arithmatic Operation</font><font color='red' >*</font>:</td>";
echo "<td align='left'  >";
echo "<select name=\"arth_op\" id=\"arth_op\"> <option value=''> Select</option>";
echo"<option >/</option>";
echo"<option >*</option>";
echo"<option >+</option>";
echo"<option >-</option>";
echo"</select></td>";
echo"<td align='right'  colspan='2'><input type='submit' value='Save'></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='2'></td></tr><tr><td  colspan=''></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='2'></td></tr><tr><td  colspan=''></td></tr>";
echo "</table>";
echo"<HR>";
/*echo"<table width='60%' align='center'>";
echo"<tr><th bgcolor='#3B4444' colspan='4'><font color='white' size='4'>Ratio Master Search</font></th></tr>";
echo"<tr><td  colspan='4'></td></tr>";
echo"<tr>";
echo "<th bgcolor='#3B4444' width=\"10%\"><font color='white' size='2'>Serial No.</font></th>";
echo "<th bgcolor='#3B4444' width=\"20%\"><font color='white' size='2'>Ratio Name</font></th>";
echo "<th bgcolor='#3B4444' width=\"20%\"><font color='white' size='2'>Amount/Percent</font></th>";
echo "<th bgcolor='#3B4444' width=\"10%\"><font color='white' size='2'>Derived</font></th>";
echo"<tr><td colspan=\"4\" align=center><iframe src=\"ratio_mas_frm.php?\" width=\"100%\" height=\"150\" scrollbars=yes, top=100,left=150, width=1098,height=300></iframe>";*/
echo"</table>";
echo"</form>";
//================================Search Tool======================================
echo"<form  name='f2' action=\"asst_hdr_ldr.php?\" method='post'>";
echo"<table width='80%' align='center' bgcolor='grey'>";
echo"<tr><th colspan='6'bgcolor='#3B4444'><font color='white' size='2'>Search For Derived Ratio Specification</font></th></tr><tr><td  colspan='2'></td></tr><tr><td  colspan='2'></td></tr><tr><td  colspan='2'></td></tr>";
echo"<tr><td colspan=\"1\" align='right'><font color='black'size='2' align='left'>Derived Ratio Name</td><td align='left'>";
echo"<select name=\"rt_nm\" id=\"rt_nm\" onChange=\"return showdropdwn2(event);\"> <option value=''> Select</option>";
$sql3="select distinct(ratio_name) as ratio_name,id from ratio_level where derived=1";
$res3=dBConnect($sql);
for($j=0;$j<pg_NumRows($res3);$j++){
$row3=pg_fetch_array($res3,$j);
echo"<option value=\"".$row3['id']."\" >".$row3['ratio_name']."</option>";
}
echo"</select></td>";
echo"<td align='right' colspan=\"1\"><font color='black' size='2'>Link Ratio Name</font></td>";
echo "<td align='left'  >";
echo "<select name=\"lnk_rt_nm\" id=\"lnk_rt_nm\"> <option value=''>Select</option>";
echo"</td><td align='right'  colspan='2'><input type='submit' value='Search'></td></tr>";

echo"</table>";
echo"</form>";
echo "</body>";

?>
