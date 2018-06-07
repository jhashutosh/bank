<?php
include "../config/config.php";
registerSession();
$id=$_REQUEST["id"];
$password=$_REQUEST["password"];
$lgn=$_REQUEST["lgn"]; // From login screen
$fy=$_REQUEST['fy'];
$yes=$_REQUEST['yes'];
if ($lgn!=NULL  && $_REQUEST["loginform"]==true){
	$password=md5($password);
}
$HELLO="Due you want to start session , in selected FY ";
$chk_dt="select case when cast(current_date-COALESCE(max(action_date),(SELECT start_dt-1 FROM fy_list where fy='$fy')) as int) >0 then 1 else 0 end dt_diff from init_config";
$dt_res=dBConnect($chk_dt);
$date_diff=pg_result($dt_res,'dt_diff');
$ifPopup=$date_diff;
if($ifPopup==1 && $_REQUEST["loginform"]==true){?>
	<!doctype html>
	<html>
	<head>
	<link rel="stylesheet" href="../JS/themes/base/jquery.ui.all.css">
	<script src="../JS/jquery-1.9.1.js"></script>
	<script src="../JS/ui/jquery.ui.core.js"></script>
	<script src="../JS/ui/jquery.ui.widget.js"></script>
	<script src="../JS/ui/jquery.ui.tabs.js"></script>
	<script src="../JS/ui/jquery.ui.autocomplete.js"></script>
	<script src="../JS/ui/jquery-ui-1.10.3.custom.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/test.css" />
	<link rel="stylesheet" href="../JS/sandi-theme.css">
	<script>
	$(function(){
		$( "#popupDiv" ).dialog({
		modal: true,
		autOpen:true,
		resizable:false,
		draggable:false,
		width:'500px'
		});
		$( "#popupDiv" ).dialog({
    		close: function( event, ui ) {
				document.getElementById("fnForm").submit();
			}
		});
	});
	</script>
	</head>
	<body>
	<div id="popupDiv">
		<form name="fnForm" id="fnForm" action="./authorization.php?op=f">
		<table>
		<tr><td colspan='2'  align="center">Are You want to run function</td></tr>
		<tr><td align="center"><?php echo $HELLO;?>
		Yes<INPUT type="radio"  name="yes" value="y">
		</td>
		<td align="center">
		No<INPUT type="radio"  name="yes" value="n">
		</td>
		</tr>
		<tr><td colspan='2' align="right"><input type="submit" value="enter"></td></tr>
		</table>
		<INPUT type="hidden"  name="id" value="<?php echo $id;?>">
		<INPUT type="hidden"  name="password" value="<?php echo $password;?>">
		<INPUT type="hidden"  name="fy" value="<?php echo $fy;?>">
		<INPUT type="hidden"  name="lgn" value="1">
		</form>
		
	
	</div>
	</body>
	</html>
<?php }
else{
$chk_sql="select checkAutho('$id','$password','$fy','$yes') as xxx";
echo $chk_sql;
$chk_res=dBConnect($chk_sql);
$vrfy=pg_result($chk_res,'xxx');
//echo $vrfy;
if($vrfy!='0'){
$_SESSION['fy']=$fy;
$_SESSION['tmpFy']=$fy;
$_SESSION['staff_id']=$id;
$_SESSION['role']=trim($vrfy);
header("Location: ../main/main.php?status=ok");
}
else {
	//setcookie("staff_id");
header("Location: ../index.php?af=1");
}
}
?>