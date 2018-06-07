<?
include "../config/config.php";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>Crop Link</title>";
?>
<script language="JAVASCRIPT">
function closeme() { 
	close(); 
}
function myRefresh(URL){
	window.opener.location.href =URL;
    	self.close();
    	}

</script>
<?
echo"</head>";
$sql="select * from lc_season_master where id=$season_id";
$res=dBConnect($sql);
$season=pg_result($res,'season_desc');
$st_dt=pg_result($res,'season_start_dt');
$en_dt=pg_result($res,'season_end_dt');
$name_sql="select initcap(cm.name1)
from lc_mini_customer_link mcl,customer_master cm 
where mcl.id_customer_master=cm.customer_id 
and mcl.id=$mcl_id";
//echo $name_sql;
$name_res=dBConnect($name_sql);
$name=pg_result($name_res,'initcap');
echo"<body bgcolor='silver'>";
echo"<form  name='f1' action='crop_link.php?op=i' method='post' >";
echo"<table valign=\"top\"width='100%' align='center' >";
echo"<tr><th bgcolor='#D8EEEF' align='center' colspan=\"4\">Link Crop for $season </th></tr>";
echo"<tr><td bgcolor='#D8EEEF' align='center' colspan=\"1\">Farmer's Name :</td><td   bgcolor='#D8EEEF' align='center' colspan=\"3\"  width=''><font color='black' size='2'>$name</font></td></tr>";
//echo"<HR>";
echo"<tr><td  bgcolor='#D8EEEF' align='center' colspan=\"1\" width=''>Season : </td><td  bgcolor='#D8EEEF' align='center' colspan=\"1\" width=''><font color='black' size='2'>$season ( $st_dt - $en_dt) </font></td>";
echo"<td bgcolor='#D8EEEF' align='center' colspan=\"1\" width=''>Land Id :</td><td  bgcolor='#D8EEEF' align='center' colspan=\"1\" width=''><font color='black' size='2'>$land_id</font></td></tr>";
echo"<tr><td  bgcolor='#D8EEEF' align='center' colspan=\"1\" width=''>Select Crop :</td><td  bgcolor='#D8EEEF' align='center' colspan=\"1\" width=''>";
$sql_statement="SELECT cm.crop_id,initcap(cm.crop_desc) from crop_mas cm,LC_Crop_Rate_Master crm ,lc_season_master sm where cast(cm.crop_id as integer)=crm.id_crop_mas and crm.id_season_master=sm.id and sm.id =$season_id";
$result=dBConnect($sql_statement);
 echo "<select name=\"$name\" id=\"$name\">";
 echo "<option value=''>Select</option>";
 if(pg_NumRows($result)==0) {
 echo "<option value=''>Null</option>";
}
else{
      
      for($j=0; $j<pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,$j); 
      echo "<option value=\"".$row[0]."\">".ucwords($row[1])."</option>";
    }
}
echo "</select>";


echo"</td>";
echo"<td bgcolor='#D8EEEF' align='center' colspan=\"2\" ><input type=\"submit\" value=\"Submit\"> &nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme(),myRefresh('../mini/cust_crop_frame.php?season_id=$season_id&c_id=$c_id')\"></td></tr>";
echo"</table></form></body>";
?>
