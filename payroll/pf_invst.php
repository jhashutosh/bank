<?
include "../config/config.php";
$staff_id=verifyAutho();
$entryt_time=date('d/m/Y h:i:s');
$TCOLOR='white';
$TBGCOLOR='#80ADF6';
$op=$_REQUEST['op'];
$type_of_pf_investment_array=array(
		"bank"=>"Bank",
		"po"=>"Post Office",
		"lic"=>"LIC",
		"other"=>"Other"			
);
?>
<script LANGUAGE="JavaScript">

function showDesc(str){
if (str=='bank')

{
document.getElementById('desca').style.display='none';
document.getElementById('cat_sub').value='';
document.getElementById('descb').style.display='';
}
else

{
document.getElementById('descb').style.display='none';
document.getElementById('cat_sub1').value='';
document.getElementById('desca').style.display='';

}

}


function val(f)
{
var l=parseInt(document.getElementById('gl_mas_cd').value.length);
var grnl=document.getElementById('cat_sub').value.length;
var grnl1=document.getElementById('cat_sub1').value.length;
var sandl=document.getElementById('cat').value.length;
var cat=document.getElementById('cat').value;
var gl_mas_cd=document.getElementById('gl_mas_cd').value;
var sub_hdr=document.getElementById('sub_hdr').value;
if(sandl==0)
{
alert("You Must select Category");
return false;
}
if(grnl==0 && grnl1==0)
{
alert("You Must enter "+cat+"- sub type\neg. Individual,Society,PF");
return false;
}
if(l==0)
{
alert("You Must select Gl Mas Code");
return false;
}
return chkmas();
}

function getgl(){
//alert("sec");
var str=document.getElementById("sub_hdr").value;
//alert(str);
var url="getgl.php?sub_hdr="+str;
//alert(url);
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
		{	//alert(xmlhttp.responseText);
		
		
			document.getElementById("hintSpan2").innerHTML=xmlhttp.responseText;
			
		}
						}
	xmlhttp.open("POST",url,true);
	xmlhttp.send();
}
</script>
<?
if($op=='i'){
$cat=$_REQUEST['cat'];
$cat_sub=strtolower($_REQUEST['cat_sub1']);
$cat_sub=(empty($cat_sub))?$_REQUEST['cat_sub']:$cat_sub;
$id_sql="select case when max(id) is null then 1 else (max(id)+1) end from emp_investment_mas";
$res=dBConnect($id_sql);
$id=pg_fetch_result($res,'case');
$gl_mas_cd=$_REQUEST['gl_mas_cd'];
//echo $sub_hdr;
$sql="insert into emp_investment_mas (id,
                        type,
                        invst_desc,
                        operator_code,
                        entry_time,gl_mas_code) values($id,'$cat','$cat_sub','$staff_id','$entryt_time','$gl_mas_cd')";
$res=dBConnect($sql);
//echo $sql;
}
echo "<html>";
echo "<head>";
echo "<title>Adhoc Master</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<body bgcolor=\"#EFEFEF\"><br>";
echo "<form name=\"f1\" METHOD=\"POST\" ACTION=\"pf_invst.php?op=i\" onSubmit=\"return val(this.form);\">";
echo "<table width=\"80%\" bgcolor='#efefef' align='center' valign='bottom' height='30%'>";
echo "<tr><td bgcolor=\"006666\" colspan=\"4\" align=\"center\"><b><font color=\"WHITE\">PF Investment Master</font>";
echo "</td></tr>";
echo "<tr><td bgcolor=\"#efefef\" align='left'  colspan='2'>Select Investment Type&nbsp;&nbsp;:&nbsp;";

makeSelectcategory($type_of_pf_investment_array,"cat",'','onchange=showDesc(this.value);');
echo"</td>";
echo"<td bgcolor=\"#efefef\" colspan='2' align='left' id='descb' style='display:none'>&nbsp;&nbsp;&nbsp;Investment Description&nbsp;:&nbsp;
<select name='cat_sub1' id='cat_sub1'>
<option value=''>Select</option>
<option value='sb'>Savings</option>
<option value='rd'>Reccuring Deposit</option>
<option value='ri'>Reinvestment</option>
</select>
</td>";
echo"<td bgcolor=\"#efefef\" colspan='2' align='left' id='desca' style='display:none'>&nbsp;&nbsp;&nbsp;Investment Description&nbsp;:&nbsp;
<input type='text' name='cat_sub' id='cat_sub'></td>";
echo"</tr>";

echo "<tr><td  colspan=\"2\"  align='left'><font color='black' size='2'>Select Sub Header&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<select name=\"sub_hdr\" id=\"sub_hdr\" onchange=\"getgl();\">
 <option value=''> Select</option>";
$sql=" select gl_sub_header_code,gl_sub_header_desc  from gl_sub_header where gl_header_code='22000'";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
//echo $sql;
echo"<option value=\"".$row['gl_sub_header_code']."\">[".$row['gl_sub_header_code']."]".$row['gl_sub_header_desc']."</option>";
//echo"</td>";
}
echo"</select></td>";
echo"<td bgcolor=\"#efefef\" align='left' colspan='2'><span id='hintSpan2'></span></td>";
echo"</tr>";
echo"<tr>";
echo"<td bgcolor=\"#efefef\" colspan='4' align='center'><input type='submit' name='Enter' value='Enter'></td></tr></table>";
echo"<br>";
echo"<table width=\"90%\" bgcolor='#efefef' align='center'><tr><th BGCOLOR='#636363' align='center'><font color='white'>PF Investment Category</th>";
echo"<th BGCOLOR='#636363' align='center'><font color='white'>Legder CODE & DESC</th></tr>";
$TBGCOLOR="WHITE";
$TCOLOR="silver";
$FCOLOR="black";
$FBCOLOR="grey";
$sql_statement="select i.type,upper(i.invst_desc) as invst_desc,g.* from emp_investment_mas i,gl_master g where i.gl_mas_code=g.gl_mas_code ";
//echo $sql_statement;
$result=dBConnect($sql_statement);
for($j=0;$j<pg_NumRows($result);$j++)
{
$color=($color==$TBGCOLOR)?$TCOLOR:$TBGCOLOR;
$fcolor=($fcolor==$FBCOLOR)?$FCOLOR:$FBCOLOR;
$row=pg_fetch_array($result,$j);
echo"<tr><td align='center' bgcolor=$color>";
echo "<font color='$fcolor'>".ucwords($row['type'])."-".ucwords($row['invst_desc']);
echo"</td>";
echo"<td align='center' bgcolor=$color>";
echo "<font color='$fcolor'>".ucwords($row['gl_mas_desc'])."[".$row['gl_mas_code']."]";
echo"</td></tr>";

}


echo"</table>";

?>
