<?php
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,$f_start_dt,$f_end_dt);
$year=$_REQUEST['current_date'];
$months=trim($_REQUEST['months']);
$end_dt=$_REQUEST['end_dt'];
$start_dt=$_REQUEST['start_dt'];
if(empty($end_dt)){

	$sql_statement="DELETE FROM monthly_return_deposit";
}
else{
	$sql_statement="DELETE FROM monthly_return_deposit;SELECT monthly_return_deposit('$end_dt') as deposit_return";
}
//echo $sql_statement;
$result=dBConnect($sql_statement);
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
	/*var rpt=document.getElementById("rpt_body").innerHTML;
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
					//document.getElementById("st").value='ok';
					document.getElementById("stp").innerHTML=xmlhttp.responseText;					
				}
  			}
		//alert(html);
		var file="php2pdf.php?u="+rpt;
		//alert(file)
		xmlhttp.open("POST",file,true);
		xmlhttp.send();*/
}
</script>

<div id="rpt_body">
<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"\" onload=\"cd.focus();\">";
echo "<center><font size=+3>$SYSTEM_TITLE</font><br>";
echo "<i>Monthly Return Forms as on". $month_array[$months].",$year</i></center>";
echo "<hr>";
echo "<form name=\"f1\" METHOD=\"POST\" ACTION=\"monthly_return_deposit.php\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\">";
echo"<tr><td><b>Return Month as on :<td>";
echo"<input type=TEXT size=4 name=current_date id=cd Value=\"\" onclick=\"this.value=''\" $HIGHLIGHT>&nbsp;-&nbsp;";
makeSelectwithJS($month_array,'months',$m,'months','onChange=myFunc(this.value);');
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "<input type=\"HIDDEN\" name=\"start_dt\" id=\"start_dt\" value=\"\">";
echo "<input type=\"HIDDEN\" name=\"end_dt\" id=\"end_dt\" value=\"\">";
echo "<input type=\"HIDDEN\" name=\"st\" id=\"st\" value=\"\">";

echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> <input type=\"BUTTON\" name=\"pdf\" value=\"MakePDF\" onclick=\"makePDF()\">";
echo "</table></form>";
echo "<hr>";
echo "<center>";

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


echo "<table width=\"100%\" class=\"border\"><tr><td>";
echo "<table class=\"border\" align=center>";
echo "<tr><td bgcolor=\"#0000CD\" colspan=\"16\" align=\"center\"><b><font color=\"WHITE\" size=\"+3\">MONTHLY RETURN OF DEPOSIT On <b>".$month_array[$months].",$year</b></font>";
echo "<tr bgcolor=#BA55D3>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Sl.No.</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Type of deposit</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Begining of the<br>Year on $f_start_dt</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Begining of the<br>Month on $start_dt</th>";

echo "<th bgcolor=\"#9ACD32\"colspan=2>During the month<br>($start_dt to $end_dt)</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>End of Month on $end_dt</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>Decrease or increase</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>% of <br>Decrease/<br>increase</th>";

echo "<th bgcolor=\"#9ACD32\" rowspan=2>Begining of the month no of A/C($start_dt)</th>";
echo "<th colspan=2 bgcolor=\"#9ACD32\">During the Month</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>End of the month no of A/C($end_dt)</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan=2>No of A/C Transction Ledger</th>";
echo "<tr>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Deposit</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Withdrawal</th>";

echo "<th colspan=1 bgcolor=\"#9ACD32\">closed</th>";
echo "<th colspan=1 bgcolor=\"#9ACD32\">Open</th>";
//============================================================
$sql_statement="SELECT * FROM monthly_return_deposit";
$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_NumRows($result)>0){
for($j=0,$i=1; $j<pg_NumRows($result); $j++,$i++){
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<th>$i";
echo "<td><b>".$type_of_account1_array[$row[0]]."</td>";
$r1+=$row[1];
echo "<td align=right >".amount2Rs($row[1])."</td>";
$r2+=$row[2];
echo "<td align=right >".amount2Rs($row[2])."</td>";

$r4+=$row[4];
echo "<td align=right >".amount2Rs($row[4])."</td>";
$r5+=$row[5];
echo "<td align=right >".amount2Rs($row[5])."</td>";
$r3+=$row[3];
echo "<td align=right >".amount2Rs($row[3])."</td>";
$r01=$X=$row[3]-$row[1];
if($r01<0){$COLOR="RED";$r01="(".amount2Rs(abs($r01)).")";}
else{$COLOR="BLACK";$r01=amount2Rs(abs($r01));}
echo "<td align=right ><FONT color=$COLOR>".$r01."</td>";
$per=$X*100/$row[3];
$per=round($per,2);
if(empty($per))$per=0;
if($per<0){$COLOR="RED";$per="(".amount2Rs(abs($per)).")";}
else{$COLOR="BLACK";$per=amount2Rs(abs($per));}
echo "<td align=right ><FONT color=$COLOR>".$per."%</td>";

$r9+=$row[9];
echo "<td align=right >$row[9]</td>";
$r12+=$row[12];
echo "<td align=right >$row[12]</td>";
$r11+=$row[11];
echo "<td align=right >$row[11]</td>";
$r10+=$row[10];
echo "<td align=right >$row[10]</td>";
$r13+=$row[13];
echo "<td align=right >$row[13]</td>";

   }
}


//====================================FINAL STATEMENT ========================================
echo "<tr>";
echo "<th align=right bgcolor=aqua colspan=\"2\">Total:";
echo "<th align=right bgcolor=aqua>".amount2Rs($r1);
echo "<th align=right bgcolor=aqua>".amount2Rs($r2);

echo "<th align=right bgcolor=aqua>".amount2Rs($r4);
echo "<th align=right bgcolor=aqua>".amount2Rs($r5);
echo "<th align=right bgcolor=aqua>".amount2Rs($r3);
echo "<th align=right bgcolor=aqua>";
echo "<th align=right bgcolor=aqua>";

echo "<th align=right bgcolor=aqua>$r9";
echo "<th align=right bgcolor=aqua>$r12";
echo "<th align=right bgcolor=aqua>$r11";

echo "<th align=right bgcolor=aqua>$r10";
echo "<th align=right bgcolor=aqua>$r13";
echo "</table>";
echo "</body>";
echo "</html>";
?>
</div>

