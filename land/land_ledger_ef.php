<?php
include "../config/config.php";

$land_type_array=array(
		"1"=>"Owned by Customer",
		"0"=>"Only For Mini"
		);
function makeSelectlnd($element_array,$element,$default){

	echo "<SELECT name=\"".$element."\" id=\"$element\">";
	
	if(!empty($default)){
		echo "<option value=$default>".$element_array[$default];
	}
	if(empty($default)) $default=500; 
	while(list($key,$val)=each($element_array)){
		if($key!=$default){
			echo "<option value=$key>".$val;
		}
	}
	echo "</select>";
}
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$entry_time=date('d/m/Y h:i:s');
$status=$_REQUEST['status'];
$account_no=$_SESSION["current_account_no"];
if(empty($status)){
isPermissible($menu);
}
$op=$_REQUEST['op'];
$id=$_REQUEST['land_id'];
$action_date=$_REQUEST['action_date'];
$dag_no=$_REQUEST['dag_no'];
$jl_no=$_REQUEST['jl_no'];
$mouja=$_REQUEST['mouja'];
$mark=$_REQUEST['mark'];
$lnd_flg=$_REQUEST['lnd_flg'];
$gp=$_REQUEST['panchayat'];
$karbanama=$_REQUEST['karbanama'];
$area=$_REQUEST['area'];
$land_value=$_REQUEST['land_value'];
$mini=$_REQUEST['mini'];
$type=$_REQUEST['land_type'];
//echo $lnd_flg;
echo "<html>";
?>
<script language="JAVASCRIPT">
function closeme() { 
	close(); 
}
function myRefresh(URL){
	//alert(URL)
	window.opener.location.href =URL;
    	self.close();
    	}

</script>
<?php
echo "<head>";
echo "<title>Entry Form - Land";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"dag.focus();\">";
$flag=getGeneralInfo_Customer($account_no);
if($flag==1){
echo "<hr>";
if(empty($op)){
echo "<form name=\"form1\" method=\"POST\" action=\"land_ledger_ef.php?menu=$menu&op=i&status=$status\">";
echo "<table bgcolor=#556B2F width=90% align=center cellspacing='0'>";
echo "<tr bgcolor='Yellow'><th colspan=3>Entry Form of Land<font size=+1> [$account_no]</font></th>
<th colspan=3 align='right'>Use of Land :";
makeSelectlnd($land_type_array,'lnd_flg','');
echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th></tr>";
$id=getId($menu);
echo "<tr><td align=\"left\">Land Id:<td><input type=\"TEXT\" name=\"land_id\" size=\"5\" value=\"$id\" $HIGHLIGHT READONLY><br>";
echo "<td>Land Type:<td>";
makeSelect($crop_master_array,'land_type','');
echo "<td align=\"left\">Action date:<td><input type=\"TEXT\" name=\"action_date\" size=\"12\" value=\"".date('d/m/Y')."\" $HIGHLIGHT>";
echo "&nbsp;&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.action_date,'dd/mm/yyyy','Choose Date')\"><br>";
echo "<tr><td align=\"left\">Dag No:<td><input type=\"TEXT\" name=\"dag_no\" size=\"12\" id=\"dag\" $HIGHLIGHT>";
echo "<td align=\"left\">Mouja Name:<td><input type=\"TEXT\" name=\"mouja\" size=\"12\" value=\"\" $HIGHLIGHT>";
echo "<td align=\"left\">Khatian No.:<td><input type=\"TEXT\" name=\"jl_no\" size=\"12\" value=\"\" $HIGHLIGHT>";
echo "<tr><td valign=\"top\" align=\"left\">Land Mark:<td>";
makeSelectFromDBWithCode('mark_id','mark_desc','land_identification_mas','mark');
echo "<td valign=\"top\" align=\"left\">GP:<td>";
makeSelectFromDBWithCode('panchayat_id','panchayat_desc','panchayat_mas','panchayat');
echo "<td valign=\"top\" align=\"left\">Mini No.:<td>";
makeSelectFromDBWithCode('mini_id','mini_desc','mini_mas','mini');
echo "<tr><td align=\"left\">Karbanama Bond No:<td><input type=\"TEXT\" name=\"karbanama\" size=\"12\" value=\"\" $HIGHLIGHT>";
echo "<td align=\"left\">Land Area:<td><input type=\"TEXT\" name=\"area\" size=\"12\" value=\"\" $HIGHLIGHT> Satak";
echo "<td align=\"left\">Land Value:<td>Rs.&nbsp<input type=\"TEXT\" name=\"land_value\" size=\"12\" $HIGHLIGHT>";
echo "<tr><td><td><td><td><td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "</table>";
echo "</form>";
  }
if($op=='i' || $op=='u'){
	if($op=='i'){
	$type=getIndex($crop_master_array,$type);
	$flag=checkLand($gp,$dag_no,$jl_no,$mouja);
	if(empty($flag)){
	$sql_statement="INSERT INTO land_info(customer_id,land_id,action_date,dag_no,jl_no,mouja_no,crop_header, mini_no,gp,land_identity,land_area,land_value,karbanama_bond_value,status,staff_id,entry_time,land_flag)VALUES('$account_no','$id','$action_date','$dag_no','$jl_no','$mouja','$type', '$mini','$gp','$mark',$area, $land_value,'$karbanama','a','$staff_id',now(),$lnd_flg)";

		$sql="select id from lc_mini_master where mini_name=(select upper(mini_desc) from mini_mas where mini_id='$mini')";
		$res=dBConnect($sql);
		$mini_mas_id=pg_fetch_result($res,'id');
		$sql="select LC_Mini_Customer_Link_Save_Fnc($mini_mas_id,'$account_no','$id','$action_date',null,'$staff_id','$entry_time')";
			}
	else{
		echo "<h1><i>This Land Already registar to Customer Id of $flag</i></h1>";
		echo "<a href=\"../main/set_account.php?menu=ln&account_no=$flag\">Click</a> here to know details about this Land";
	    }
 
	}
	 if($op=='u'){
	 $sql_statement="UPDATE land_info SET dag_no='$dag_no',jl_no='$jl_no',mouja_no='$mouja',mini_no='$mini',gp='$gp',karbanama_bond_value= '$karbanama',land_area=$area,land_value=$land_value,crop_header='$type',land_identity='$mark',land_flag=$lnd_flg WHERE land_id='$id' AND customer_id='$account_no'";
	$sql="select count(*) from lc_mini_customer_link where id_land_info='$id' AND id_customer_master='$account_no'";
	$res=dBConnect($sql);
	$i_u=pg_fetch_result($res,'count');
	$sql="select id from lc_mini_master where mini_name=(select upper(mini_desc) from mini_mas where mini_id='$mini')";
	$res=dBConnect($sql);
	$mini_mas_id=pg_fetch_result($res,'id');
	echo $i_u;
if($i_u=='1')
	$sql="select LC_Mini_Customer_Link_Vld_Fnc('$id','$account_no',$mini_mas_id,'$action_date','$staff_id','$entry_time')";
else 
	
	$sql="select LC_Mini_Customer_Link_Save_Fnc($mini_mas_id,'$account_no','$id','$action_date',null,'$staff_id','$entry_time')";

	}
echo $sql;
		$result=dBConnect($sql_statement);
		if (pg_affected_rows($result)<1){
			echo "<br><h4><font color=\"RED\">Failed to insert data into database.</font></h4>";
			}
		else{
			if(empty($status)){
			echo $sql;
			$res=dBConnect($sql);
			header("location:../main/set_account.php?menu=ln&account_no=$account_no");
			}
			else{
			echo "<br><h4><font color=\"GREEN\">Sucessfully Insert data into database.</font>&nbsp;<input type=button onclick=\"myRefresh('../customer/customer_statement.php?menu=cust')\" value=\"Return\"></h4>";
			//echo $sql;
			$res=dBConnect($sql);
			$f=pg_fetch_array($res,0);
			$fl=($i_u==1)?$f['LC_Mini_Customer_Link_Vld_Fnc']:$f['LC_Mini_Customer_Link_Save_Fnc'];
			echo $fl;
			/*if($fl=='1')
			echo"Mini Customer Link successfull";
else 
			echo"Mini Customer Link failed";*/

			}
			
	     	}
   }
	
 
if($op=='up'){
$sql_statement="SELECT * FROM land_info where land_id='$id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<form name=\"form1\" method=\"POST\" action=\"land_ledger_ef.php?menu=$menu&op=u\">";
echo "<table bgcolor=#00BFFF width=90% align=center cellspacing='0'>";
echo "<tr bgcolor='Yellow'><th colspan=3>Entry Form of Land<font size=+1> [$account_no]</font></th>
<th colspan=3 align='right'>Use of Land :";
makeSelectlnd($land_type_array,'lnd_flg',pg_result($result,'land_flag'));
echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th></tr>";
echo "<tr><td align=\"left\">Land Id:<td><input type=\"TEXT\" name=\"land_id\" size=\"15\" value=\"$id\" $HIGHLIGHT READONLY><br>";
$type=pg_result($result,'crop_header');
$type=$crop_master_array[$type];
echo "<td>Land Type:<td>";
makeSelect($crop_master_array,'land_type',$type);
echo "<td align=\"left\">Action date:<td><input type=\"TEXT\" name=\"action_date\" size=\"12\" value=\"".pg_result($result,'action_date')."\" $HIGHLIGHT readonly>";
echo "<tr><td align=\"left\">Dag No:<td><input type=\"TEXT\" name=\"dag_no\" size=\"12\" id=\"dag\" value=\"".pg_result($result,'dag_no')."\" $HIGHLIGHT>";
echo "<td align=\"left\">Mouja No.:<td><input type=\"TEXT\" name=\"mouja\" size=\"12\" value=\"".pg_result($result,'mouja_no')."\" $HIGHLIGHT>";
echo "<td align=\"left\">Khatian No.:<td><input type=\"TEXT\" name=\"jl_no\" size=\"12\" value=\"".pg_result($result,'jl_no')."\" $HIGHLIGHT>";
echo "<tr><td valign=\"top\" align=\"left\">Land Mark:<td>";
makeSelectFromDBWithCode('mark_id','mark_desc','land_identification_mas','mark');
echo "<td valign=\"top\" align=\"left\">GP:<td>";
makeSelectFromDBWithCode('panchayat_id','panchayat_desc','panchayat_mas','panchayat');
echo "<td valign=\"top\" align=\"left\">Mini No.:<td>";
makeSelectFromDBWithCode('mini_id','mini_desc','mini_mas','mini');
echo "<tr><td align=\"left\">Karbanama Bond Value:<td><input type=\"TEXT\" name=\"karbanama\" size=\"12\" value=\"".pg_result($result,'karbanama_bond_value')."\" $HIGHLIGHT>";
echo "<td align=\"left\">Land Area:<td><input type=\"TEXT\" name=\"area\" size=\"12\" value=\"".pg_result($result,'land_area')."\" $HIGHLIGHT> Satak";
echo "<td align=\"left\">Land Value:<td>Rs.&nbsp<input type=\"TEXT\" name=\"land_value\" size=\"12\" value=\"".pg_result($result,'land_value')."\"$HIGHLIGHT>";
echo "<tr><td><td><td><td><td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "</table>";
echo "</form>";
  }

}
echo "</body>";
echo "</html>";
?>
