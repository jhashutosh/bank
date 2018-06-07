<?php
include "../config/config.php";
$staff_id=verifyAutho();
echo "<html>";
echo "<head>";
echo "<title>NPA";
echo "</title>";
?>
<script language="JAVASCRIPT">
function validator1(f)
	{	//alert("ok");
		var msg='';//alert("msg");
		if(f.sub_stnd.value==null || f.sub_stnd.value=='' || f.sub_stnd.value<1 || f.sub_stnd.value>100)
		{
			msg+="Please Give Substandard and between 1 & 100 %..\n";//return false;
		}
		if(f.doubt_1.value==null || f.doubt_1.value=='' || f.doubt_1.value<1 || f.doubt_1.value>100)
		{
			msg+="Please Give Doubtful 1 and between 1 & 100 %..\n";//return false;
		}
		if(f.doubt_2.value==null || f.doubt_2.value=='' || f.doubt_2.value<1 || f.doubt_2.value>100)
		{
			msg+="Please Give Doubtful 2 and between 1 & 100 %..\n";//return false;
		}
		if(f.doubt_3.value==null || f.doubt_3.value=='' || f.doubt_3.value<1 || f.doubt_3.value>100)
		{
			msg+="Please Give Doubtful 3 and between 1 & 100 %..\n";//return false;
		}
		if(f.uns_ln.value==null || f.uns_ln.value=='' || f.uns_ln.value<1 || f.uns_ln.value>100)
		{
			msg+="Please Give Unsecured Loan and between 1 & 100 %..\n";//return false;
		}
		if(f.ls_ast.value==null || f.ls_ast.value=='' || f.ls_ast.value<1 || f.ls_ast.value>100)
		{
			msg+="Please Give Lost Asset and between 1 & 100 %..\n";//return false;
		}
		if(msg==''){
			return true;
		}
		else{
			alert(msg);
			return false;
		}
	}
function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	//alert(unicode)
	if (unicode!=8){ 
		if (unicode<46||unicode>57||unicode==47) {
			return false;		
		}
	}
	
}

</script>
<?php
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";

echo "<form method=\"POST\" action=\"npa.php?op=e\" name=\"f1\" onSubmit=\"return validator1(this);\">";
echo "<table bgcolor=#E6E6FA align=center width=100% height=\"40%\" >";
echo "<tr><th colspan=\"6\" bgcolor=#F5F5DC><font color=black size=4>NPA Form</font></th></tr>";
echo "<tr><td align=\"right\" colspan=\"3\">Substandard&nbsp;:&nbsp;</td>";
echo"<td align=\"left\" colspan=\"3\"><input type=\"text\" name='sub_stnd' id='sub_stnd' size=\"10\" onblur=\"onlyInteger(this);\" onkeypress=\"return numbersonly(event);\" ></td></tr>";
echo "<tr><td  colspan=\"1\" align=\"right\">Doubtful-I&nbsp;:&nbsp;</td><td align=\"left\">";
echo"<input type=\"text\" name='doubt_1' id='doubt_1' size=\"10\" onblur=\"validator1(this);\" onkeypress=\"return numbersonly(event);\" ></td><td  colspan=\"1\" align=\"right\">Doubtful-II&nbsp;:&nbsp;</td><td align=\"left\">";
echo"<input type=\"text\" name='doubt_2' id='doubt_2' size=\"10\" onblur=\"validator1(this);\" onkeypress=\"return numbersonly(event);\" ></td><td  colspan=\"1\" align=\"right\">Doubtful-III&nbsp;:&nbsp;</td><td align=\"left\">";
echo"<input type=\"text\" name='doubt_3' id='doubt_3' size=\"10\" onblur=\"validator1(this);\"  onkeypress=\"return numbersonly(event);\" ></td></tr>";
echo "<tr><td  colspan=\"1\" align=\"right\">Unsecured Loan&nbsp;:&nbsp;</td><td align=\"left\">";
echo"<input type=\"text\" name='uns_ln'  id='uns_ln'size=\"10\" onblur=\"validator1(this);\"  onkeypress=\"return numbersonly(event);\" ></td>";
echo "<td  colspan=\"1\" align=\"right\">Loss Assets&nbsp;:&nbsp;</td><td align=\"left\">";
echo"<input type=\"text\" name='ls_ast' id='ls_ast' size=\"10\" onblur=\"validator1(this);\" onkeypress=\"return numbersonly(event);\" ></td>";
echo "<td  colspan=\"1\" align=\"right\">Action Date&nbsp;:&nbsp;</td><td align=\"left\"><input type=\"TEXT\" name=\"act_dt\" size=\"12\" value=\"".date("d.m.Y")."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.act_dt,'yyyy/mm/dd','Choose Date')\" ></td></tr>";

echo "<tr><td align=RIGHT colspan='6'><INPUT TYPE=\"SUBMIT\" VALUE=\"Enter\"></td></tr>";

echo"<HR>";
echo"<table valign=\"top\" width='100%' bgcolor='silver'>"; 
echo"<tr bgcolor='#F5F5DC'>";
echo"<td align='center' width='15%'><font color='black'>Substandard</font></td>";
echo"<td align='center' width='15%' ><font color='black'>Doubtful-I</font></td>";
echo"<td align='center' width='15%' ><font color='black'>Doubtful-II</font></td>";
echo"<td align='center' width='15%' ><font color='black'>Doubtful-III</font></td>";
echo"<td align='center' width='15%'><font color='black'>Unsecured Loan</font></td>";
echo"<td align='center' width='15%'><font color='black'>Loss Assets</font></td>";
echo"<td align='center' width='10%'bgcolor=><font color='black'>Action Date</font></td>";
echo "<tr><td colspan=\"7\" align=center><iframe src=\"npa_frame.php\" width=\"100%\" height=\"200\" ></iframe></td></trs>";

if($op=='e'){
$sub_stnd=$_REQUEST['sub_stnd'];
$doubt_1=$_REQUEST['doubt_1'];
$doubt_2=$_REQUEST['doubt_2'];
$doubt_3=$_REQUEST['doubt_3'];
$uns_ln=$_REQUEST['uns_ln'];
$ls_ast=$_REQUEST['ls_ast'];
$act_dt=date("y/m/d");
$sql_statement="INSERT Into npa_mas values('$act_dt',$sub_stnd,$doubt_1,$doubt_2,$doubt_3,$uns_ln,$ls_ast)";
echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1)
  {
   echo "<h1><blink>sorry database not updated due to some reason!!!!!!!!!!!!!!!!!!</h1>";
  }



}
echo"</table></form></body>";
?>
