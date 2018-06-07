<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$account_no=$_SESSION["current_account_no"];
$crop_id=$_REQUEST['crop_id'];
$chkinfo=$_REQUEST["land_info"];
$id=getCustomerId($account_no,$menu);
echo "<html>";
echo "<head>";
echo "<title>Credit Limit of [$id] for ".getName('crop_id',$crop_id,'crop_desc','crop_mas')."</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/max_limit.js\"></script>";
?>
<script language="JAVASCRIPT">
function closeme() { 
	close(); 
}
function myRefresh(URL){
	var crop_id=document.getElementById("crop").value;
	URL=URL+"&crop_id="+crop_id;
	//alert(URL)
	window.opener.location.href =URL;
    	self.close();
    	}

</script>
<?php
echo "</head>";

//echo "<body onload=\"ShowInfo();\">";
echo "<body onload=\"get_check_value() ;\">";
if(empty($_REQUEST['op'])){
//$sql_statement="SELECT * FROM land_info where customer_id='$id' AND land_id NOT IN(SELECT security_id FROM loan_security WHERE status='l')";
$sql_statement="SELECT * FROM land_info where customer_id='$id'";
//echo $sql_statement;

$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Information Not Found !!!!!!!!!!</h4>";
}else {echo "<input type=\"HIDDEN\" value=\"$crop_id\" name=\"crop_id\" id=\"crop_id\">";
$color=$TCOLOR;
echo "<table valign=\"top\" width=\"100%\" align=\"CENTER\">";
echo "<tr bgcolor=Green>";
echo "<th rowspan=\"2\">Land Id</th>";
echo "<th rowspan=\"2\">Date</th>";
echo "<th  rowspan=\"2\">Dag No.</th>";
echo "<th rowspan=\"2\">Mouja No.</th>";
echo "<th rowspan=\"2\">JL No.</th>";
echo "<th rowspan=\"2\">GP</th>";
echo "<th rowspan=$chkinfo\"2\">Mark</th>";
echo "<th  rowspan=\"2\">Mini No.</th>";
echo "<th colspan=\"3\">Karbanama</th>";
echo "<tr bgcolor=Green><th>Bond Value</th>";
echo "<th>Area</th>";
echo "<th>Value</th>";
echo "<form name=\"orderform\" action=\"addLand.php?menu=$menu&op=i\" method=\"POST\"  onSubmit=\"return varify();\">";
for($j=0; $j<pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td align=right bgcolor=$color><input type=\"checkbox\" name=\"music\" value=\"".$row['land_id']."\" onclick=\"ShowInfo();\">".$row['land_id']."</td>";
echo "<td  bgcolor=$color>".$row['action_date']."</td>";
echo "<td  bgcolor=$color>".$row['dag_no']."</td>";
echo "<td  bgcolor=$color>".$row['mouja_no']."</td>";
echo "<td bgcolor=$color>".$row['jl_no']."</td>";
echo "<td  bgcolor=$color>".getName('panchayat_id',trim($row['gp']),'panchayat_desc
','panchayat_mas'). "</td>";
echo "<td align=right bgcolor=$color>".getName('mark_id',trim($row['land_identity']),'mark_desc','land_identification_mas')."</td>";
echo "<td align=right bgcolor=$color>".getName('mini_id',trim($row['mini_no']),'mini_desc','mini_mas')."</td>";
$t_area+=$row['land_area'];
echo "<td bgcolor=$color align=\"RIGHT\">".amount2Rs($row['karbanama_bond_value'])."</td>";
$t_k_val+=$row['karbanama_bond_value'];
echo "<td align=right bgcolor=$color>".getAcer($row['land_area'])."</td>";
$t_value+=$row['land_value'];
echo "<td align=right bgcolor=$color> Rs. ".amount2Rs((float)$row['land_value'])."/=</td>";
}
echo "<tr bgcolor=AQUA>";
echo "<th colspan=8>Total : $j Land Infomation Found!!!!!!";
echo "<td  align=right><b>".amount2Rs($t_k_val);
echo "<td  align=right><b>".getAcer($t_area);
echo "<td align=right><b> Rs. ".amount2Rs($t_value)." /=";
echo "<tr bgcolor=YELLOW><th colspan=\"10\">Your Credit Limit will Be: Rs.<div id=\"show_info\" name=\"show_info\"></div>";
echo "<input type=\"HIDDEN\" value=\"$crop_id\" name=\"crop_id\" id=\"crop_id\">";
echo "<input type=\"HIDDEN\" value=\"\" name=\"land_info\" id=\"land_info\">";
echo "<td><input type=\"SUBMIT\" Value=\"Save\">&nbsp;";
echo "<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\">";
echo "</form>";
echo "</table>";
	}
}
if($_REQUEST['op']=='i'){
$chkinfo=explode(",",$chkinfo);

$max_limit=getCreditLimit($chkinfo,$crop_id);
$fy=getFy($action_date);
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
$loan_sl_no=nextValue('loan_sl_no');
echo "<form name=\"childForm\">";
echo "<h1> Land Information </h1>";
echo "<i>information for sao loan system</i><hr>";
getLoanInt('kcc',date('d/m/Y'),$due,$over,$crop_id);
$gl_code=getGlCode4mCustomerAccount($account_no,$action_date);
echo $due;
$sql_statement="INSERT INTO loan_ledger_hrd(loan_serial_no,loan_type,customer_id,account_no,fy,crop_id,max_limit,int_due_rate, int_overdue_rate,gl_code,gl_status) VALUES ('$loan_sl_no','sao','$id','$account_no','$fy','$crop_id',$max_limit,$due,$over,$gl_code,'d')";

for($i=0;$i<count($chkinfo);$i++){
		getSecurityInfo($chkinfo[$i],$area,$val);
		$sql_statement=$sql_statement.";INSERT INTO loan_security(loan_serial_no,account_no,security_type,security_id,security_info,security_value) VALUES ('$loan_sl_no','$account_no','land','$chkinfo[$i]','$area',$val)";
   	}
//echo $sql_statement;
   }
  echo "<input type=\"HIDDEN\" id=\"crop\" value=\"$crop_id\">";	
  $result=dBConnect($sql_statement);
  if(pg_affected_rows($result)<1){
	echo "<font size=+2 color=red>Failed to insert data into database.<br>please contact to System administator &nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"></font>";
	}
  else{
	echo "<font size=+2 color=green>Successfully Inserted data into database.&nbsp;<input type=button onclick=\"myRefresh('sao_loan_issue.php?menu=sao')\" value=\"Return\"></font>";
	
   }
 echo "</form>";
}
?>
