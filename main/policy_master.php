<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$operator_code=$staff_id;
$start_date=$_REQUEST["start_date"];
$end_date=$_REQUEST["end_date"];
$op=$_REQUEST['op'];
$c_id=$_REQUEST['c_id'];
$crop_id=$_REQUEST['crop_id'];
$ddate=$_REQUEST['due_date'];
$idrate=$_REQUEST['int_due_rate'];
$iorate=$_REQUEST['int_overdue_rate'];
$land=$_REQUEST['min_land_area'];
$share=$_REQUEST['min_share_qty'];
$limit=$_REQUEST['credit_limit'];
$type=$_REQUEST['loan_type'];
$insurance=$_REQUEST['insurance'];
if($menu=='kcc'){$name='KCC';$cols=1;}
if($menu=='mt'){$name='MT';$cols=2;}
if($menu=='pl'){$name='PL';$cols=2;}
if(!empty($_REQUEST['op_s'])){
if(($c_id=='1') or ($c_id=='4')){$start_date='01.04.'.date('Y');$end_date='31.08.'.date('Y');$ddate="31.03.".(date('Y')+1);}
else if($c_id=='3'){$start_date='01.11.'.date('Y');$end_date='28.02.'.(date('Y')+1);$ddate="31.07.".(date('Y')+1);}
else{
$start_date='01.09.'.date('Y');$end_date='31.01.'.(date('Y')+1);$ddate="31.08.".(date('Y')+1);
}
$min_l=1;
$dr=7;
$odr=11;
}
//if($menu=='pl'||$menu=='mt'){ $end_date='31/03/9999';}
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<script language="javascript">
function onSubmits(f)
{
  f.submit();
}
function check()
{
var y=document.getElementById('cdl').value;
if(y.length==0)
{
alert("Please enter the Credit Limit");
return false;
}

}
</script>
<?php
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"id.focus();\">";
echo "<center>";
echo "<font color=yellow>";
echo "<h1>Master Scale of Finance Entry From</h1>";
echo "<i><B>carefully enter the necessary Information</B></i>";
echo "</font>";
echo "</center>";
echo "<hr>";
if(empty($op)){
echo "<table bgcolor=#FFF0F5 width=90% align=center>";
echo "<tr><TH colspan=7 bgcolor=#808000><font color=WHITE size=+2 align=\"center\"><b>$name Scale of Finance Entry Form";
if($menu=='kcc'){
	if(empty($_REQUEST['op_s'])){
	echo "<form action=\"policy_master.php?menu=$menu&op_s=k\" method=\"post\">";
	echo "<tr><td align=\"left\">Crop Id:<td>";
	makeSelectSubmit4mdb('crop_id','crop_desc','crop_mas','c_id');
	echo "</form>";
	}
	else{
	echo "<form name=\"form1\" method=\"POST\" action=\"policy_master.php?menu=$menu&op=i\">";
	echo "<tr><td align=\"left\">Crop Id:<td><input type=\"TEXT\" name=\"crop_id\" value=\"".getName('crop_id',$c_id,'crop_desc','crop_mas')."\" size=\"10\" readonly $HIGHLIGHT>";;
	echo "<input TYPE=\"HIDDEN\" VALUE=\"$c_id\" name=\"c_id\">";
	}
}

echo "<tr><td align=\"\">Starting Date:<td><input type=\"TEXT\" name=\"start_date\" size=\"9\" value=\"$start_date\" $HIGHLIGHT>";
echo "&nbsp;&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.start_date,'dd/mm/yyyy','Choose Date')\"><br>";
echo "<td align=\"\">Ending Date:<td><input type=\"TEXT\" name=\"end_date\" size=\"9\" value=\"$end_date\" $HIGHLIGHT>";
echo "&nbsp;&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.end_date,'dd/mm/yyyy','Choose Date')\"><br>";
if($menu=='kcc'){
echo "<tr><td align=\"left\">Loan Repayment Date:<td><input type=\"TEXT\" name=\"due_date\" size=\"9\" value=\"$ddate\" $HIGHLIGHT>";
echo "&nbsp;&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.due_date,'dd/mm/yyyy','Choose Date')\"><br>";
echo "<td align=\"left\">Minimum Land Area:<td><input type=\"TEXT\" name=\"min_land_area\" size=\"3\" value=\"$min_l\" $HIGHLIGHT>&nbsp Satak";
echo "<tr><td align=\"left\">Credit Limit:<td>Rs.&nbsp;<input type=\"TEXT\" id=\"cdl\" name=\"credit_limit\" size=\"10\" value=\"$limit\" $HIGHLIGHT>&nbsp/Satak";
echo "<td align=\"left\">Crop Insurance:<td>Rs.&nbsp;<input type=\"TEXT\" name=\"insurance\" size=\"5\" value=\"0\" id=\"insurance\" $HIGHLIGHT onclick=\"insurance.value=''\">&nbsp;%";

}
echo "<tr><td align=\"left\">Due Interest Rate:<td>Rs.&nbsp<input type=\"TEXT\" name=\"int_due_rate\" size=\"3\" value=\"$dr\" $HIGHLIGHT>&nbsp;%";
echo "<td align=\"left\">Overdue  Interest Rate:<td>Rs.&nbsp<input type=\"TEXT\" name=\"int_overdue_rate\" size=\"3\" value=\"$odr\" $HIGHLIGHT>&nbsp;%";
if(empty($_REQUEST['op_s'])){
echo "<td><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\" DISABLED>";
}else{
echo "<td><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\" onclick=\"return check(this.value);\">";
}
echo "</table>";
echo "</form>";
}
if($op=='i' || $op=='u'){
	if($op=='i'){
		$fy=$_SESSION['fy'];
		$sql_statement="INSERT INTO loan_policy(loan_type,start_date,end_date,crop_id,min_land_area,
credit_limit,int_due_rate,int_overdue_rate,due_date,fy,staff_id,entry_time,crop_insurance)VALUES(lower('$name'),'$start_date','$end_date','$c_id',
'$land','$limit','$idrate','$iorate','$ddate','$fy','$staff_id',now(),$insurance)";
		}

if($menu=='pl' || $menu=='mt' ){
$sql_statement="INSERT INTO loan_policy(loan_type,start_date,end_date,
int_due_rate,int_overdue_rate,staff_id,entry_time)VALUES(lower('$type'),'$start_date','$end_date',
$idrate,$iorate,'$staff_id',now())";
		}

	if($op=='u'){
	 $sql_statement="UPDATE loan_policy SET min_land_area='$land',min_share_qty='$share',credit_limit='$limit',
 int_due_rate='$idrate',int_overdue_rate='$iorate',due_date='$ddate'   WHERE crop_id='$id'";
	}
  
    echo $sql_statement;
    $result=dBConnect($sql_statement);
    if (pg_affected_rows($result)<1){
     echo "<br><h4><font color=\"RED\">Failed to insert data into database.</font></h4>";
	}
   else{
     $tag=($op=='u')?'Updated':"Inserted";
     echo "<br><h4><font color=\"Green\">Successfully $tag data into database.</font></h4>";
     header("location:policy_view.php?op=".strtolower($name));
	}
		
   }

if($op=='up'){
$sql_statement="SELECT * FROM policy_master where crop_id='$id'";
echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<form name=\"form1\" method=\"POST\" action=\"policy_master.php?menu=$menu&op=u\">";
echo "<table bgcolor=#00BFFF width=90% align=center>";
echo "<tr><th colspan=6 bgcolor=Yellow>Update Form of Loan Policy</th></tr>";
echo "<tr><td align=\"left\">Crop Id:<td><input type=\"TEXT\" name=\"crop_id\" size=\"15\" value=\"$id\" $HIGHLIGHT>";
if($menu=='kcc'){
echo "<td align=\"left\">Land:<td><input type=\"TEXT\" name=\"min_land_area\" size=\"15\" value=\"$land\" $HIGHLIGHT>";
echo "<td align=\"left\">Share:<td><input type=\"TEXT\" name=\"min_share_qty\" size=\"15\" value=\"$share\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Credit Limit:<td><input type=\"TEXT\" name=\"credit_limit\" size=\"15\" value=\"$limit\" $HIGHLIGHT>";
}
echo "<td align=\"left\">Interest Rate:<td><input type=\"TEXT\" name=\"int_due_rate\" size=\"15\" value=\"$idrate\" $HIGHLIGHT>";
echo "<td align=\"left\">Interest Overdue Rate:<td><input type=\"TEXT\" name=\"int_overdue_rate\" size=\"15\" value=\"$iorate\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Loan Repayment Date:<td><input type=\"TEXT\" name=\"due_date\" size=\"15\" value=\"$ddate\" $HIGHLIGHT>";
echo "<tr><td><td><td><td><td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "</table>";
echo "</form>";
  }


echo "</body>";
echo "</html>";
?>





