<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$year=$_REQUEST['current_date'];
$months=trim($_REQUEST['months']);
$end_dt=$_REQUEST['end_dt'];
$start_dt=$_REQUEST['start_dt'];
echo "<hr>";
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
echo "<html>";
echo "<head>";
echo "<title>$PROJECT_TITLE</title>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<script src=\"../JS/date_validation.js\"></script>";
?>
<SCRIPT LANGUAGE="JavaScript">
function check(){
f_s_dt=document.f1.f_start_dt.value;
f_e_dt=document.f1.f_end_dt.value;
start_dt=document.f1.start_dt.value;
end_dt=document.f1.end_dt.value;
if(start_dt.length==0||end_dt.length==0){
alert("Stating Date Should Not be Null")
	document.f1.current_date.focus();
	return false;
}
else{
	
	if(!IsDateLess(f_s_dt,end_dt)){
		alert("Starting Date beyond of ending date of Financial Year")
		document.f1.current_date.focus();
		return false;
	}
	if(!IsDateLess(end_dt,f_e_dt)){
		alert("Ending Date beyond of ending date of Financial Year")
		document.f1.current_date.focus();
		return false;
	}
}

}
function myFunc(m){

var y=document.f1.current_date.value;
if(y.length==0){
	alert("Enter the Year First");
	location.reload();
	return false;
}
else{
	var s=new Date(y,m-1,1);
	m=s.getMonth()+1;
	var strt_strng=s.getDate()+'/'+m+'/'+s.getFullYear();
	var e=new Date(y,m,0);
	m=e.getMonth()+1;
	var end_strng=e.getDate()+'/'+m+'/'+e.getFullYear();
	document.f1.start_dt.value=strt_strng;
	document.f1.end_dt.value=end_strng;
	}
}

function makePDF(){
	var rpt=document.getElementById("rpt_body").innerHTML;
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
					//document.getElementById("st").innerHTML='ok';
					document.getElementById("stp").innerHTML=xmlhttp.responseText;					
				}
  			}
		//alert(html);
		var file="php2pdf.php?u=("+rpt+")";
		alert(file)
		xmlhttp.open("POST",file,true);
		xmlhttp.send();
}
</script>
<?
echo "<div id=\"rpt_body\">";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"\" onload=\"cd.focus();\">";
echo "<center><font size=+3>$SYSTEM_TITLE</font><br>";
echo "<i>Monthly Return Forms as on". $month_array[$months].",$year</i></center>";
echo "<hr>";
echo "<form name=\"f1\" METHOD=\"POST\" ACTION=\"in_op_de_reg.php\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\">";
echo"<tr><td><b>Return Month as on :<td>";
echo"<input type=TEXT size=4 name=current_date id=cd Value=\"\" onclick=\"this.value=''\" $HIGHLIGHT>&nbsp;-&nbsp;";
makeSelectwithJS($month_array,'months',$m,'months','onChange=myFunc(this.value);');
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "<input type=\"HIDDEN\" name=\"start_dt\" id=\"start_dt\" value=\"\">";
echo "<input type=\"HIDDEN\" name=\"end_dt\" id=\"end_dt\" value=\"\">";
echo "<input type=\"HIDDEN\" name=\"st\" id=\"st\" value=\"\">";
//echo "<div id=stp></div>";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> <input type=\"BUTTON\" name=\"pdf\" value=\"MakePDF\" onclick=\"makePDF()\">";
echo "</table></form>";
echo "<hr>";
echo "<center>";


//------------------------------------- display code below----------------------------------------
if(!empty($end_dt)){
//$sql_statement="select c.name1, b.account_no,sum(e.deposits)-sum(e.withdrawals) as balance, max(e.action_date) as lastoperation from gl_ledger_hrd a,gl_ledger_dtl b,customer_master c,customer_account d,sb_ledger e where a.tran_id=b.tran_id and c.customer_id=d.customer_id and b.account_no=d.account_no and d.account_no=e.account_no and a.tran_id=e.tran_id and '$end_dt' -a.action_date>730 and d.account_type='sb' group by c.name1, b.account_no";
$sql_statement="SELECT foo.*,name1,father_name,address FROM (SELECT account_no,SUM(credit-debit) as balance,MAX(action_date) as MAX_DATE FROM mas_gl_tran  where type='sb' AND gl_mas_code<>'28101' GROUP BY account_no) AS foo,customer_sb s WHERE foo.account_no=s.account_no AND '$end_dt'-MAX_DATE>1095 ORDER BY CAST(SUBSTR(foo.account_no,4,length(foo.account_no)-3)AS BIGINT)";
$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_NumRows($result)>0){
	echo "<table bgcolor=\"#667C26\" width=\"100%\" align=\"CENTER\">";
	echo "<tr><th colspan=\"6\" bgcolor=green><font color=white size=5>INOPERATIVE DEPOSIT A/C REGISTER</th>";
	echo "</tr>";
	$color="#CCCCC5555";

	echo "<tr>";
	echo "<th colspan=\"1\" bgcolor=\"$color\">SL NO</th>";
	echo "<th colspan=\"1\" bgcolor=\"$color\">Name of the<BR>depositor</th>";
	echo "<th colspan=\"1\" bgcolor=\"$color\">Father Name</th>";
	
	echo "<th colspan=\"1\" bgcolor=\"$color\">Account no.</th>";
	echo "<th colspan=\"1\" bgcolor=\"$color\">Balance<BR>(Rs.)</th>";
	echo "<th colspan=\"1\" bgcolor=\"$color\">Date of last<BR>Operation</th>";
	echo "<th colspan=\"1\" bgcolor=\"$color\">Date of last<BR>Remarks</th>";
	echo "</tr>";
	for ($i=0;$i<pg_NumRows($result);$i++)
		{
			$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
			$row=pg_fetch_array($result,$j);
			echo "<tr>";
			echo "<th colspan=\"1\" bgcolor=\"$color\">$i</th>";
			echo "<td bgcolor=$color>".ucwords($row['name1'])."</td>";
			echo "<td bgcolor=$color>".ucwords($row['account_no'])."</td>";
			echo "<td bgcolor=$color>".ucwords($row['balance'])."</td>";
			echo "<td bgcolor=$color>".ucwords($row['lastoperation'])."</td>";
			echo "<td bgcolor=$color>Inoperative</td>";
			echo "</tr>";
		}
	echo "</table>";

}
echo "<h3> Record Not Found!!!!!</h3>";
}
//-----------------------------------------------------------------------------------------------------------

echo "</body>";
echo "</html>";
?>
