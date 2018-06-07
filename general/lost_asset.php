<?php
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$menu=$_REQUEST['menu'];
$ins=$_REQUEST['ins'];
if(empty($op)){
	$account_no=$_SESSION["current_account_no"];
	isPermissible($menu);
}
else{
	$account_no=$_REQUEST["account_no"];

}
echo"<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\"></script>";
echo"</head>";
if($ins=='i'){
$sl_no=$_REQUEST['ln_sl_no'];
$desc=$_REQUEST['desc'];
$type_of_npa=$_REQUEST['type_of_npa'];
$sql="insert into lost_ast_mas (account_no,loan_serial_no,npa_type,remarks,action_date,operator_code,entry_time) values('$account_no','$sl_no','$type_of_npa','$desc',current_date,'$staff_id',now())";
echo $sql;
$res=dBConnect($sql);
if(pg_affected_rows($res)<1) {
	$str="<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} 
else {
	$str="<h3><font color=\"GREEN\">You Transaction is being Processing .......</font></h3><br>";
	}
}
echo"<body>";
$id=getCustomerId($account_no,$menu);
//echo "id is :$id";
// Customization required for WHERE CLAUSE
$flag=getGeneralInfo_Customer($id);
echo "<hr>";
echo"<form method='post' action='lost_asset.php?menu=$menu&ins=i'>";
echo"<table align='center' width='85%'>";
echo"<tr><th colspan='4'>Lost/Unsecured Asset for [$account_no]</th></tr>
<tr><td  colspan='4' align='center'><br></td></tr>";
$sql="select h.*,c.crop_desc from loan_ledger_hrd h,crop_mas c where account_no='$account_no' and status='op' and h.crop_id=c.crop_id order by h.fy";
$res=dBConnect($sql);
//echo $sql;
echo"<tr><td>Select Loan Serial Number :</td><td><select name='ln_sl_no'><option value=''>Select</option>";
for($j=0; $j<pg_NumRows($res); $j++)
{ $row=pg_fetch_array($res,$j);
	echo "<option value=".$row['loan_serial_no'].">[Crop Season : ".$row['crop_desc']."] fy:".$row['fy']."</option>";
	
} 
echo"</select></td><td>Description for Loss : </td><td><input type='text' name='desc'></td></tr>
<tr><td  colspan='1' align='center'>Type Of NPA:</td><td><select name='type_of_npa'><option value='l'>Lost Assets</option><option value='u'>Unsecure Assets</option></SELECT><td  colspan='2' align='center'><input type='submit' value='confirm Asset Loss'></td></tr>";
echo"</table>";
echo"<hr>";
echo $str;
echo"</body>";
?>
