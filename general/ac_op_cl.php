<?php
include "../config/config.php";
$staff_id=verifyAutho();
$type_of_diposit_array=array(
"sb"=>"Savings",
"fd"=>"Fixed Deposit",
"rd"=>"Reccuring Deposit",
"ri"=>"Reinvestment",
"mis"=>"Monthly Income Scheme",
"hsb"=>"Home Savings",
"ca"=>"Current Account",
"shg"=>"Self Help Group"
);


$fy=$_SESSION['fy'];
getDetailFy($fy,$f_start_dt,$f_end_dt);
$year=$_REQUEST['current_date'];
$months=trim($_REQUEST['months']);
$end_dt=$_REQUEST['end_dt'];
$start_dt=$_REQUEST['start_dt'];
$menu=$_REQUEST['menu'];
$status=$_REQUEST['status'];
$op=$_REQUEST['op'];
$p=$_REQUEST['p'];
$type=$_REQUEST['type'];
$type1=$_REQUEST['type1'];
{$menu=getIndex($type_of_diposit_array,$type);}
{$status=getIndex($type_of_status_array,$type1);}
//echo $start_dt;
//echo $end_dt;


$current_date=$_REQUEST["current_date"];


if($menu=='sb'){$table='customer_sb';}
if($menu=='fd'){$table='customer_fd';}
if($menu=='rd'){$table='customer_rd';}
if($menu=='ri'){$table='customer_ri';}
if($menu=='mis'){$table='customer_mis';}
if($menu=='shg'){$table='customer_shg';}
if($menu=='ca'){$table='customer_ca';}
if($menu=='hsb'){$table='customer_hsb';}

/*if(empty($end_dt)){

	$sql_statement="DELETE FROM monthly_return_deposit";
}
else{
	$sql_statement="DELETE FROM monthly_return_deposit;SELECT monthly_return_deposit('$end_dt') as deposit_return";
}

$result=dBConnect($sql_statement);*/
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
	alert(document.getElementById("rpt_body").innerHTML);
}
</script>
<?php
echo "<div id=\"rpt_body\">";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"\" onload=\"cd.focus();\">";
echo "<center><font size=+3>$SYSTEM_TITLE</font><br>";
echo "<i>Monthly Return Forms as on $name</i></center>";
echo "<hr>";
echo "<form name=\"f1\" METHOD=\"POST\" ACTION=\"ac_op_cl.php\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\">";
echo"<tr><td><b>Return Month as on :<td>";
echo"<input type=TEXT size=4 name=current_date id=cd Value=\"\" onclick=\"this.value=''\" $HIGHLIGHT>&nbsp;-&nbsp;";
makeSelectwithJS($month_array,'months',$m,'months','onChange=myFunc(this.value);');
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "<input type=\"HIDDEN\" name=\"start_dt\" id=\"start_dt\" value=\"\">";
echo "<input type=\"HIDDEN\" name=\"end_dt\" id=\"end_dt\" value=\"\">&nbsp;";

makeSelect($type_of_diposit_array,'type','');
makeSelect($type_of_status_array,'type1','');
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> <input type=\"BUTTON\" name=\"pdf\" value=\"MakePDF\" onclick=\"makePDF()\">";
echo "</table></form>";
echo "<hr>";
echo "<center>";

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
echo "<center>";

echo "<table class=\"border\" align=center width=75%>";
//echo $type;
echo "<tr><td bgcolor=\"#0000CD\" colspan=\"16\" align=\"center\"><b><font color=\"WHITE\" size=\"+1\"> $type ACCOUNT OPEN & CLOSE REGISTER<b>".$month_array[$months].",$year</b></font>";
echo "<tr bgcolor=#BA55D3>";
echo "<th bgcolor=\"#9ACD32\">Sl.No.</th>";
echo "<th bgcolor=\"#9ACD32\">A/C No</th>";
echo "<th bgcolor=\"#9ACD32\">Opening Date</th>";
echo "<th bgcolor=\"#9ACD32\">Name</th>";
echo "<th bgcolor=\"#9ACD32\">Father's Name</th>";
echo "<th colspan=2 bgcolor=\"#9ACD32\">Address</th>";

//============================================================
//echo $type1;

if($type1=='opening') $where="(opening_date between '$start_dt' and '$end_dt')"; 
if($type1=='closed') $where="(closing_date between '$start_dt' and '$end_dt')";
$sql_statement="SELECT * from $table where account_type='$menu' and status='$status' and $where";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
for($j=0,$i=1; $j<pg_NumRows($result); $j++,$i++){
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<th>$i";
echo "<td><font size=+1>".$row['account_no']."</td>";
echo "<td>".$row['opening_date']."</td>";
echo "<td><font size=+1>".ucwords($row['name1'])."</td>";
echo "<td>".$row['father_name']."</td>";
echo "<td>".$row['address']."</td>";
   }
}


echo "</body>";
echo "</html>";
?>
