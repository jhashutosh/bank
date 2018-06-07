<?
include "../config/config.php";
echo "<head>";
echo "<title>To create gl_mas_code</title>";

$sql="select gl_mas_desc from gl_master where gl_sub_header_code=(select gl_sub_header_code from gl_sub_header where gl_sub_header_desc='$gl_sub_header_desc')";
$res=dBConnect($sql);
$row=pg_fetch_array($res,0);
$gl_mas_desc=$row['gl_mas_desc']; 
//echo $gl_mas_desc;
?>
<SCRIPT LANGUAGE="JavaScript">
var xmlhttp
function showHint(str){

/*if (str.length==0)
  {
	  document.getElementById("txtHint").innerHTML="";
	  return;
  }*/

xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }

var url="loading.php";
url=url+"?q="+str;
url=url+"&sid="+Math.random();

xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
//state change function
function stateChanged()
{
if (xmlhttp.readyState==4)
  {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
  
  }
}
//browser define function
function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}
//-------------------------------------------------------------------------------------------------------------------


function onCheck(){
var gl_sub_header_desc=document.getElementById('gl_sub_header_desc').value;
	if(str.length==0){
		alert("You Should select First")
	}
	else{
		if(str=="gl_sub_header_desc"){
			
			document.form1.gl_mas_desc.enabled=false;
		
			}
		//
	}
}
function f1(){
showHint(str);
}
function f2(str){
document.form1.gl_mas_desc.enabled=true;
}

</script>
<?
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"<body  bgcolor='silver' onload=\"gl_sub_header_desc.focus();\" >";
echo "<h1 align='center'><font color='black'>Creation Of General Ledger Mas Code!!!</font></h1>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo "</tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr></table>";
echo"<hr>";
echo "<form name=\"form1\" method=\"POST\" action=\"mini_gl_mas_cd_link.php?op=i\">";
if($op=='i')
{
	$gl_mas_desc=$_REQUEST['gl_mas_desc'];
	//echo $gl_mas_desc;
	
	//echo $gl_sub_header_desc;
/*sql="select gl_mas_code,gl_sub_header_code from gl_master where $gl_mas_desc=$gl_mas_desc";
	$res=dBConnect($sql);
	$row=pg_fetch_array($res,0);
	echo $sql;
	$gl_mas_code=$row['gl_mas_code'];
	$gl_sub_header_code=$row['gl_sub_header_code'];*/
	$operator_code=verifyAutho();
	$entry_time=date('d/m/Y H:i:s');
	$sql="insert into LC_Mini_Gl_Master(gl_mas_code,gl_mas_desc,gl_sub_header_code,Operator_code,Entry_time) (SELECT gl_mas_code,gl_mas_desc,gl_sub_header_code, '$operator_code',now() FROM gl_master where gl_mas_code='$gl_mas_desc')";
	//values('$gl_mas_code','$gl_mas_desc','$gl_sub_header_code','$operator_code','$entry_time')";
	$res=dBConnect($sql);
	//echo $sql;
}


echo"<table width='100%'  align='center' bgcolor='silver' >";
echo"<tr><td></td></tr><tr><td ></td></tr>";

echo"<tr><td align='right' width='40%' ><font color='black' size='4'>Gl Sub Header Desc&nbsp;:&nbsp;&nbsp;</font></td>";
echo "<td align='left' width='60%' >";
echo "<select name=\"gl_sub_header_desc\" id=\"gl_sub_header_desc\"  onfocus=\"showHint(this.value);\"  onchange=\"showHint(this.value);\"> <option value=''> Select</option>";
$sql="select gl_sub_header_code,upper(gl_sub_header_desc) as gl_sub_header_desc from gl_sub_header where CAST(gl_sub_header_code as INT)>60000";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$gl_sub_hdr_code=$row['gl_sub_header_code'];
//echo $row['gl_sub_header_desc'];
echo"<option value=\"$gl_sub_hdr_code\">".$row['gl_sub_header_desc']."</option>";
}
echo"</select></td></tr>";
//makeSelectwithJS($gl_mas_desc_array,'gl_mas_desc',"","gl_mas_desc","ENABLED");

echo "<tr><td align='right' width='40%'><font color='black' size='4'>Gl Mas Desc&nbsp;:&nbsp;&nbsp;</font>";
echo"<td align='left' width='60%'> ";
echo "<span id=\"txtHint\"></span>";
echo"</td></tr>";

?>


<?
echo"<tr><td></td></tr><tr><td></td></tr>";
echo"<tr><td   colspan=\"4\" height='10%'></td></tr>";
echo"<tr><td   colspan=\"4\" height='10%'></td></tr>";
echo"<tr><td   colspan=\"4\" height='10%'></td></tr>";
echo"</tr><tr><td colspan='4' align='center'><input type='submit' value='Submit'></td>";
echo"</tr>";
echo"<tr><td   colspan=\"4\" height='10%'></td></tr>";
echo"</table>";
echo"<table width='100%'  align='center' >";
echo "<tr bgcolor='#839EB8'><td align='center' width='30%'><font color='white' size='3'>Gl Mas Code</font></td>";
echo "<td align='center' width='40%'><font color='white' size='3'>Gl Mas Description</font></td>";
echo "<td align='center' width='30%'><font color='white' size='3'>Gl Sub Header Code</font></td>";
echo "<tr><td colspan=\"4\" align=center><iframe src=\"gl_mas_cd_frame.php\" width=\"100%\" height=\"200\" ></iframe></td></trs>";
echo"</tr>";
echo"</table>";
echo"</body>";
?>
