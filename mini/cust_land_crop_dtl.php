<?
include "../config/config.php";
$staff_id=verifyAutho();
$q=$_REQUEST['q'];
//echo $q;
$l=$_REQUEST['l'];
//echo $l;
$a=$_REQUEST['a'];
$dup=$_REQUEST['dup'];
$col_array=array('#FFDEAD','#ABF862',"#9CE6D6",'#B3A3EB','silver');
$view=$_REQUEST['v'];
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" href=\"../css/autosuggest_inquisitor.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\" />";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<style type='text/css' >
#main td{
border:solid 1px #EFEFEF;
background-color: #CDCDCD;
}
</style>
<?
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/date_validation.js\"></script>";
echo "<script src=\"../JS/loading_mini.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"#A8A8A8\" onload=\"customer_id.focus();\">";
if (empty($op) && empty($q) && empty($l)  && empty($a) && empty($c)){
echo "<center><font color=BLUE size=+3><b>MINI Customer Land Crop Entry </b></font></center>";
$color="grey";
//form start here=================================================================================================================================
echo "<hr>";
echo "<form method=\"POST\" name=\"f1\" action=\"cust_land_crop_dtl.php?op=i\" onSubmit=\"return check();\">";
echo "<table  align=center width=70%  bgcolor='' id='main' cellspacing='5' cellpadding='5'>";
echo "<tr><TH colspan=5 bgcolor=DARKBLUE><font color=WHITE align=\"center\"><b>Customer Land Crop Detail";
echo "<tr><td align=\"left\">Customer Name:<font color=\"RED\">*</font><td align='left'>&nbsp;";
echo "<select name=\"cust_id\" onchange=\"customer(this.value)\"> <option value=''> Select</option>";
$sql="select distinct(initcap(c.name1)) as name,l.id_customer_master from customer_master c, lc_mini_customer_link l where c.customer_id=l.id_customer_master ";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
	$row=pg_fetch_array($res,$j);
	//echo $sql;
	echo"<option value=".$row['id_customer_master'].">".$row['name']."</option>";
	}
	echo"</select></td>";
	echo "<td align=\"left\">Mini Name: <font color=\"RED\">*</font><td><span id=\"txtHint\"></span></td></tr>";
}
if($q  && empty($l)   && empty($a) && empty($c)){
	//echo $q;
	//echo $cust_name;
	echo "<select name=\"mini_id\"  onchange=\"land(this.value)\"><option value=''> Select</option>";
	$sql="select initcap(c.mini_name) as mini_name,c.id from LC_Mini_Master c where c.id in (select id_mini_master from lc_mini_customer_link where id_customer_master='$q')";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
//echo $sql;
echo"<option value=".$q.",".$row['id'].">".$row['mini_name']."</option>";
}
echo"</select></td>";
}
if($l  && empty($a) && empty($c)){
//echo $l;
$mini=$_REQUEST['mini'];
//echo $mini;
echo"<table width=\"100%\" bgcolor='' cellspacing='5' cellpadding='5'>
<tr><td valign='top'>Land Info : </td><td  valign='top'>";
$sql="select l.land_id,l.dag_no,l.mouja_no,mcl.id_customer_master from land_info l,lc_mini_customer_link mcl  where mcl.id_land_info=l.land_id and l.customer_id=mcl.id_customer_master and l.customer_id='$l' and mcl.id_mini_master=$mini";
$result=dBConnect($sql);
echo "<select name=\"$name\" id=\"$name\"  onchange=\"area(this.value)\">";
 echo "<option value=''>Select</option>";
 if(pg_NumRows($result)==0) {
 echo "<option value=''>Null</option>";
}
else{
      
      for($j=0; $j<pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,$j); 
      echo "<option value=\"".$row[0]."|".$row[3]."\">".ucwords($row[1])."||".ucwords($row[2])."[".$row[0]."]</option>";
    }
}
echo "</select>";
echo"</td><td rowspan='3' valign='top'>Total Land Area: </td><td width='40%'  rowspan='3'><span id=\"ttHint\"></span></td></tr>
<tr><td  valign='top' >Select Area :</td><td  valign='top' ><input type='text' name='lnd_area' id='lnd_area' value='' size='5' onkeypress=\"return numbersonly(event)\" onkeyup=\"en_crop()\"> satak</td></tr>
</table>";
}
if ( empty($op) && empty($q) && empty($l)  && empty($a)  && empty($c)){
echo "<tr><td align=\"left\" colspan=\"4\"><span id=\"textHint\"></span></td></tr>";}

if($a && empty($c)){
$sql="select land_area from land_info where land_id='$a'";
$r=dBConnect($sql);
$area=pg_result($r,'land_area');
echo"<td colspan='2' valign='top'><input type='text' name='tot_area' id='tot_area' size='5' value='$area' > satak<br></td></tr>";
echo"<input type='hidden' name='ln_id' id='ln_id' value='$a'>";
echo"<tr><td>&nbsp;Select Crop :</td><td>&nbsp;&nbsp;";
makeSelectFromDBWithCodef('cm.crop_id','initcap(cm.crop_desc)',"crop_mas cm,LC_Crop_Rate_Master crm ,lc_season_master sm where cast(cm.crop_id as integer)=crm.id_crop_mas and crm.id_season_master=sm.id and sm.id not in 
(SELECT sm.id
from  crop_mas cm,LC_Crop_Rate_Master crm,LC_Customer_Land_Crop_Info clci, LC_Mini_Customer_Link mcl,lc_season_master sm
where clci.id_crop_rate_master=crm.id
and crm.id_season_master=sm.id
and crm.id_crop_mas=cast(cm.crop_id as integer)
and clci.id_mini_customer_link=mcl.id
and mcl.id_land_info='".$a."')",'crp_id','','');
echo"</td></tr>";
echo"<tr><td width='100%' colspan='2'><span id=\"tHint\"></span></td></tr>";}

if($c){
$sql="select * from lc_crop_rate_master where id_crop_mas=$c";
$res=dBConnect($sql);
echo"<table width='100%' cellspacing='5' cellpadding='5'><tr ID='cr' name='cr' ><td >Crop rate :</td><td  align='right'>&nbsp;&nbsp;<input type='text' name='rate' id='rate' size='5' value='".pg_result($res,'crop_rate')."'>&nbsp;Rs./satak</td></tr></table>";
//<td  width='26%'>Effective Date :</td><td><input type='text' name='eff_date' id='eff_date' size='10' value='".pg_result($res,'with_effect_from')."'></td>";
echo"<input type='hidden' value='".pg_result($res,'id')."' name='crp_rt_id' >";
}
if (empty($op) && empty($q) && empty($l)  && empty($a) && empty($c)){
echo"<td colspan='1' align='left'>&nbsp;Total Cost : </td><td colspan='2' align='left'>&nbsp;<input type='text' name='tot_cost' id='tot_cost' size='10' value='' onclick=\"cal();\"></td>";
echo"<input type='hidden' value='' name='cust_lnk' id='cust_lnk' >";
//echo"<input type='hidden' value='' name='cust_id' id='cust_id' >";
echo "<td align=\"right\" colspan=\"2\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\"></tr>";
echo "</table>";
echo "<hr>";
if($dup=='1') echo "<center><font color='red'><h3>Duplicate Entry !!</center> ";}
echo "</form>";
$color='#F9B770';
if(empty($op) && empty($q) && empty($l)  && empty($a) && empty($c)){//work in progress.....
echo"<table align=center width='100%' >";
echo"<tr bgcolor='grey'>";
echo"<th>Mini Description";
echo"<th>Farmer's Name [Id]";
echo"<th>Land Id[Dag No.||Mouja No.]";
echo"<th>Crop";
echo"<th>Total Crop Area";
echo"<th>Total Area Value";
echo"</tr>";
if(empty($view)){
$sql="select li.*,m.mini_name,initcap(c.name1) as name1,l.land_id ,l.dag_no,l.mouja_no,c.customer_id,initcap(cm.crop_desc) as crop
from lc_customer_land_crop_info li,lc_mini_master m ,lc_mini_customer_link mcl ,customer_master c ,land_info l ,lc_crop_rate_master crm,crop_mas cm
where  li.id_mini_customer_link=mcl.id
and mcl.id_mini_master=m.id
and li.id_crop_rate_master=crm.id
and cm.crop_id=cast(crm.id_crop_mas as character)
and c.customer_id=mcl.id_customer_master
and mcl.id_land_info=l.land_id
order by m.id,c.customer_id,l.land_id,li.entry_time";}
if($view=='j'){
$cust_id=$_REQUEST['cust_id'];
$mini_id=$_REQUEST['mini_id'];
$sql="select li.*,m.mini_name,initcap(c.name1) as name1,l.land_id ,l.dag_no,l.mouja_no,c.customer_id,initcap(cm.crop_desc) as crop
from lc_customer_land_crop_info li,lc_mini_master m ,lc_mini_customer_link mcl ,customer_master c ,land_info l ,lc_crop_rate_master crm,crop_mas cm
where  li.id_mini_customer_link=mcl.id
and mcl.id_mini_master=m.id
and li.id_crop_rate_master=crm.id
and cm.crop_id=cast(crm.id_crop_mas as character)
and c.customer_id=mcl.id_customer_master
and mcl.id_land_info=l.land_id
and mcl.id_customer_master='$cust_id'
/*and mcl.id_mini_master=$mini_id*/
order by m.id,c.customer_id,l.land_id,li.entry_time";}
//echo $sql;
$res=dBConnect($sql);
$i=0;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$row1=pg_fetch_array($res,$j-1);
if($row['mini_name']!=$row1['mini_name'])
{
$color=$col_array[$i];
if($i==count($col_array)-1)
$i=0;
$i++;
	
}

echo"<tr bgcolor='$color'>";
echo"<td style='height:30px;'>".$row['mini_name'];
echo"<td>".$row['name1']."[".$row['customer_id']."]";
echo"<td>".$row['land_id']."[".$row['dag_no']."||".$row['mouja_no']."]";
echo"<td>".$row['crop'];
echo"<td>".$row['tot_crop_area'];
echo"<td>".$row['tot_crop_area_val'];
echo"</tr>";

}
}

//--------------------------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------------------------
if ($op=='i'){

$cust_lnk=$_REQUEST['cust_lnk'];
$crp_rt_id=$_REQUEST['crp_rt_id'];
$tot_cost=$_REQUEST['tot_cost'];
$land_id=$_REQUEST['ln_id'];
$tot_area=$_REQUEST['tot_area'];
$lnd_area=$_REQUEST['lnd_area'];
$cust_id=$_REQUEST['cust_id'];
$mini_id=$_REQUEST['mini_id'];
$mini_i=explode(',',$mini_id);
$mini_id=$mini_i[1];
$entry_time=date('d/m/Y H:i:s');

/*$sql="select LC_Customer_Land_Crop_Info_Vld_Fnc($mini_id,'$cust_id','$land_id')";
$res=dBConnect($sql);*/
//echo $sql;
//$vald=pg_fetch_result($res,'LC_Customer_Land_Crop_Info_Vld_Fnc');
$vald="1";
//echo $vald;
$sql="select id from lc_mini_customer_link where id_customer_master='$cust_id' and id_mini_master=$mini_id and id_land_info='$land_id'";
$res=dBConnect($sql);
//echo $sql;
$cust_lnk=pg_fetch_result($res,'id');
if($vald=='1'){
//$sql="select LC_Customer_Land_Crop_Info_Save_Fnc($cust_lnk,$crp_rt_id, $tot_area, $tot_cost,'$staff_id','$entry_time')";
$sql="select LC_Customer_Land_Crop_Info_Save_Fnc($cust_lnk,$crp_rt_id, $lnd_area, $tot_cost,'$staff_id','$entry_time')";
$res=dBConnect($sql);
echo $sql;
if(pg_NumRows($res)>0){
header("location:../mini/cust_land_crop_dtl.php?v=j&cust_id=$cust_id&mini_id=$mini_id ");
		      }	
else echo " function error";
	    }
//else header("location:../mini/cust_land_crop_dtl.php?dup=1&v=j&cust_id=$cust_id&mini_id=$mini_id");
}
echo "</body>";
echo "</html>";
//====================================================All javascript functions here===========================================
//php function==========================================================================================================

function makeSelectFromDBWithCodef($id,$desc1,$table,$name,$WHERE,$JS){
 if (empty($WHERE)){
 	$sql_statement="SELECT  $id,$desc1 from $table order by $id";
	}
 else{
	$sql_statement="SELECT  $id,$desc1 from $table $WHERE ORDER BY $desc1";
	}
//echo $sql_statement;
 
 
$result=dBConnect($sql_statement);
 echo "<select name=\"$name\" id=\"$name\" DISABLED onchange=\"crop(this.value)\">";
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
}
//=====================================================================================================================

?>
<script type="text/javascript">

function numbersonly(e)
{
	var unicode=e.charCode? e.charCode : e.keyCode;
	//alert(unicode)
	if (unicode!=8) { 
		if (unicode<46||unicode>57||unicode==47) {
			return false;
		
							  }
			}
}

function customer(str)
{
	showHint_customer(str);
}
function land(str,cst)
{	a=str.split(',');
	//alert("cust id->"+str+"<-link id")
	showHint_land(a[0],a[1]);
}
function area(str)
{
	a=str.split('|');
	//alert(a[0]+a[1])
	showHint_area(a[0],a[1]);
	
}

function crop(str)
{	
	showHint_crop(str);
	alert("Calculating total Amount for Mini in your land");
	cal()
	
}

function en_crop()
{	
	
	if(document.f1.lnd_area.value.length>0){
			
			if(parseFloat(document.getElementById('lnd_area').value)>parseFloat(document.getElementById('tot_area').value))
				{document.getElementById('lnd_area').value='';}
			else{
				document.f1.crp_id.disabled=false;
			    }
						} 
	else{
		document.getElementById('cr').style.display='none';
		document.f1.crp_id.disabled=true;
		document.f1.lnd_area.focus();
	}

	
}


function cal(){
var lnd_area=parseFloat(document.getElementById('lnd_area').value);

var rate=parseFloat(document.getElementById('rate').value);
var cost=Math.round(lnd_area*rate);
//alert(lnd_area+"<-area||rate->"+rate)
document.getElementById('tot_cost').value=cost;
}

</script>
