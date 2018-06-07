<?
include "../config/config.php";
$staff_id=verifyAutho();
$q=$_REQUEST['q'];
$l=$_REQUEST['l'];
$a=$_REQUEST['a'];
$dup=$_REQUEST['dup'];
$col_array=array('#FFDEAD','#ABF862',"#9CE6D6",'#B3A3EB','silver');

echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" href=\"../css/autosuggest_inquisitor.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\" />";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/date_validation.js\"></script>";
echo "<script src=\"../JS/loading_mini.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"customer_id.focus();\">";
if (empty($op) && empty($q) && empty($l)  && empty($a) && empty($c)){
echo "<center><font color=BLUE size=+3><b>MINI Customer Land Crop Entry </b></font></center>";
$color="#6FACC9";
//form start here=================================================================================================================================
echo "<hr>";
echo "<form method=\"POST\" name=\"f1\" action=\"cust_land_crop_dtl.php?op=i\" onSubmit=\"return check();\">";
echo "<table  align=center width=80%  bgcolor='#6FACC9'>";
echo "<tr><TH colspan=4 bgcolor=DARKBLUE><font color=WHITE align=\"center\"><b>Customer Land Crop Detail";
echo "<tr bgcolor=$color><td align=\"left\">Select Mini:<font color=\"RED\">*</font><td>&nbsp;";
makeSelectFromDBWithCode('Id','Mini_name','LC_Mini_Master','mini_id','','onchange=customer(this.value)');//1
echo "<td align=\"left\">Customer Name: <font color=\"RED\">*</font><td><span id=\"txtHint\"></span></td></tr>";}
//echo"<tr bgcolor=$color><td width='18%'>Land Info : </td><td width='18%'><span id=\"textHint\"></span></td><td>Total Land Area: </td><td><span id=\"ttHint\"></span></td></tr>";}
if($q  && empty($l)   && empty($a) && empty($c)){
makeSelectFromDBWithCodef('distinct c.name1','c.customer_id','customer_master c,lc_mini_customer_link l','c_id','where c.customer_id=l.id_customer_master and l.id_mini_master='.$q.'',$q);//2
}
if($l  && empty($a) && empty($c)){
$mini=$_REQUEST['mini'];
//echo $mini;
echo"<table width=\"100%\"><tr bgcolor='#6FACC9'><td width='18%'>Land Info : </td><td width='18%'>";
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
//makeSelectFromDBWithCodef3('land_id','dag_no','mouja_no','customer_id','land_info','land_id',"where customer_id ='".$l."'",'onchange=area(this.value)');
echo"</td><td colspan=\"2\"></td></tr><tr><td bgcolor='#6FACC9'>Total Land Area: </td><td bgcolor='#6FACC9'><span id=\"ttHint\"></span></td><td width='26%'>Select Area :</td><td><input type='text' name='lnd_area' id='lnd_area' value='' size='5' onkeypress=\"return numbersonly(event)\" onkeyup=\"en_crop()\"> satak</td></tr></table>";
}
if($a && empty($c)){
$sql="select land_area from land_info where land_id='$a'";
$r=dBConnect($sql);
$area=pg_result($r,'land_area');
echo"<td><input type='text' name='tot_area' id='tot_area' size='5' value='$area' > satak</td>";
echo"<input type='hidden' name='ln_id' id='ln_id' value='$a'>";
}
if ( empty($op) && empty($q) && empty($l)  && empty($a)  && empty($c)){
echo "<tr><td align=\"left\" colspan=\"4\"><span id=\"textHint\"></span></td></tr>";
echo"<tr><td>&nbsp;Select Crop :</td><td>&nbsp;";
makeSelectFromDBWithCode('crop_id','initcap(crop_desc)','crop_mas','crp_id','','DISABLED onchange=crop(this.value)');
echo"</td><td colspan=\"2\"></td></tr>";
echo"<tr><td colspan='4'><span id=\"tHint\"></span></td></tr>";}

if($c){
$sql="select * from lc_crop_rate_master where id_crop_mas=$c";
$res=dBConnect($sql);
echo"<table width='100%'><tr ID='cr' name='cr' ><td width='15%'>Crop rate :</td><td width='20%' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='rate' id='rate' size='5' value='".pg_result($res,'crop_rate')."'>&nbsp;Rs./satak</td><td  width='26%'>&nbsp;&nbsp;&nbsp;Effective Date :</td><td>&nbsp;&nbsp;&nbsp;<input type='text' name='eff_date' id='eff_date' size='10' value='".pg_result($res,'with_effect_from')."'></td></tr></table>";
echo"<input type='hidden' value='".pg_result($res,'id')."' name='crp_rt_id' >";
}
if ( empty($op) && empty($q) && empty($l)  && empty($a) && empty($c)){
echo"<td colspan='1' align='left'>&nbsp;Total Cost : </td><td colspan='3' align='left'>&nbsp;<input type='text' name='tot_cost' id='tot_cost' size='10' value='' onclick=\"cal();\"></td>";
echo"<input type='hidden' value='' name='cust_lnk' id='cust_lnk' >";
echo"<input type='hidden' value='' name='cust_id' id='cust_id' >";
echo "<tr><td align=\"right\" colspan=\"4\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\"></tr>";
echo "</table>";
echo "<hr>";
if($dup=='1') echo "<center><font color='red'><h3>Duplicate Entry !!</center> ";}
echo "</form>";
$color='#F9B770';
if(empty($q) && empty($l)  && empty($a) && empty($c)){
echo"<table align=center width='100%' >";
echo"<tr bgcolor='grey'>";
echo"<th>Mini Description";
echo"<th>Farmer's Name [Id]";
echo"<th>Land Id[Dag No.||Mouja No.]";
echo"<th>Crop";
echo"<th>Total Crop Area";
echo"<th>Total Area Value";
echo"</tr>";

if(empty($op)){
$sql="select li.*,m.mini_name,initcap(c.name1) as name1,l.land_id ,l.dag_no,l.mouja_no,c.customer_id,initcap(cm.crop_desc) as crop
from lc_customer_land_crop_info li,lc_mini_master m ,lc_mini_customer_link mcl ,customer_master c ,land_info l ,lc_crop_rate_master crm,crop_mas cm
where  li.id_mini_customer_link=mcl.id
and mcl.id_mini_master=m.id
and li.id_crop_rate_master=crm.id
and cm.crop_id=cast(crm.id_crop_mas as character)
and c.customer_id=mcl.id_customer_master
and mcl.id_land_info=l.land_id
order by m.id,c.customer_id,l.land_id,li.entry_time";
}
if($op=='c'){
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
and mcl.id_customer_master=$cust_id
and mcl.id_mini_master=$mini_id
order by m.id,c.customer_id,l.land_id,li.entry_time";}

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
$cust_id=$_REQUEST['cust_id'];
$mini_id=$_REQUEST['mini_id'];
$entry_time=date('d/m/Y H:i:s');

$sql="select LC_Customer_Land_Crop_Info_Vld_Fnc($mini_id,'$cust_id','$land_id')";
$res=dBConnect($sql);
echo $sql;
//echo $sql;
$vald=pg_fetch_result($res,'LC_Customer_Land_Crop_Info_Vld_Fnc');
echo $vald;
$sql="select id from lc_mini_customer_link where id_customer_master='$cust_id' and id_mini_master=$mini_id and id_land_info='$land_id'";
$res=dBConnect($sql);
echo $sql;
$cust_lnk=pg_fetch_result($res,'id');
if($vald=='1'){
$sql="select LC_Customer_Land_Crop_Info_Save_Fnc($cust_lnk,$crp_rt_id, $tot_area, $tot_cost,'$staff_id','$entry_time')";
$res=dBConnect($sql);
echo $sql;
if(pg_NumRows($res)>0){
header("location:../mini/cust_land_crop_dtl.php?op=c&cust_id=$cust_id&mini_id=$mini_id");
		      }	
else echo " function error";
	    }
else header("location:../mini/cust_land_crop_dtl.php?dup=1&op=c&cust_id=$cust_id&mini_id=$mini_id");
}
echo "</body>";
echo "</html>";
//====================================================All javascript functions here===========================================
//php function==========================================================================================================
/*function makeSelectFromDBWithCodef3($id,$desc1,$desc2,$cid,$table,$name,$WHERE,$JS){
 if (empty($WHERE)){
 	$sql_statement="SELECT  $id,$desc1,$desc2,$cid from $table order by $id";
	}
 else{
	$sql_statement="SELECT  $id,$desc1,$desc2,$cid from $table $WHERE ORDER BY $id";
	}
//echo $sql_statement;
 
 
$result=dBConnect($sql_statement);
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
}
*/

function makeSelectFromDBWithCodef($id,$desc1,$table,$name,$WHERE,$JS){
 if (empty($WHERE)){
 	$sql_statement="SELECT  $id,$desc1 from $table order by $id";
	}
 else{
	$sql_statement="SELECT  $id,$desc1 from $table $WHERE ORDER BY $desc1";
	}
//echo $sql_statement;
 
 
$result=dBConnect($sql_statement);
 echo "<select name=\"$name\" id=\"$name\"  onchange=\"land(this.value,$JS)\">";
 echo "<option value=''>Select</option>";
 if(pg_NumRows($result)==0) {
 echo "<option value=''>Null</option>";
}
else{
      
      for($j=0; $j<pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,$j); 
      echo "<option value=\"".$row[1]."\">".ucwords($row[0])."[".$row[1]."]</option>";
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
	showHint_customer(str)
}
function land(str,mini)
{	
	//alert("cust id->"+str+"<-link id")
	a=str.split('|');
	document.getElementById('cust_id').value=a[0];
	document.getElementById('cust_lnk').value=a[1];
	showHint_land(a[0],mini)
}
function area(str)
{
	a=str.split('|');
	//alert(a[0]+a[1])
	showHint_area(a[0],a[1])
	
}

function crop(str)
{	
	showHint_crop(str)
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
