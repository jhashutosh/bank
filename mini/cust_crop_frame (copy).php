<?
include "../config/config.php";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$c_id=$_REQUEST['c_id'];
$c_name=$_REQUEST['nm'];
$c_fa_name=$_REQUEST['fa_name'];
$op=$_REQUEST['op'];
$mini_id=$_REQUEST['mini_id'];
$op_bal=$_REQUEST['op_bal'];
$staff_id=verifyAutho();
$e_time=date('d/m/Y H:i:s');
$paid_date=$_REQUEST['pa_dt'];
$fy=$_SESSION['fy'];
$land_id=$_REQUEST['land_id'];
$season_id=$_REQUEST['season_id'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$col_array=array("#FAFC93","#9CE6D6",'#F9B770');
//echo $f_start_dt;
$d_s="select cast ('$f_start_dt'  as date) -1 as date";
$dr=dBConnect($d_s);
$as_on=pg_fetch_result($dr,'date');
//echo $d_s;
//echo $as_on;
echo"<head>";
echo"<title>customer mini frame</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";
echo"<body bgcolor='white'>";
echo"<table valign=\"top\"width='100%' align='center' bgcolor='' border='1'>";
$color='#ABF862';
$sql="select distinct cm.name1, l.mouja_no,l.jl_no,mm.mini_name,l.land_id,lc.tot_crop_area,lc.tot_crop_area_val,mcl.id,mcl.id_customer_master,mm.id as mini_id
from land_info l,lc_mini_customer_link mcl,customer_master cm ,lc_mini_master mm,lc_customer_land_crop_info lc 
where l.land_id=mcl.id_land_info 
	and mcl.id_customer_master=cm.customer_id 
	and mcl.id_mini_master=mm.id 
	and lc.id_mini_customer_link=mcl.id
	and mcl.id_customer_master='$c_id'";
$res=dBConnect($sql);
echo $sql;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='9%'><font color='black' size='2'>".$row['land_id']."</font></td>";

echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='20%'><font color='black' size='2'>".$row['mouja_no']."||".$row['jl_no']."</font></td>";

//echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='10%'><font color='black' size='2'>".$row['jl_no']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='15%'><font color='black' size='2'>".$row['mini_name']."</font></td>";

echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='15%'><font color='black' size='2'>".$row['tot_crop_area']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='11%'><font color='black' size='2'>".$row['tot_crop_area_val']."</font></td>";

$sqls="select * from lc_season_master";
$ress=dBConnect($sqls);
$td=pg_NumRows($ress);
$cols=5+$td;
//echo $cols;
//echo $season_id;
if($season_id!='a'){
echo"<td  bgcolor='$color' align='center' colspan='$td'>";
$sql_crop="select mcl.id_land_info,crm.Id_crop_mas,initcap(cm.crop_desc),clci.Tot_crop_area,clci.Tot_crop_area_val
from LC_Customer_Land_Crop_Info clci, LC_mini_customer_link mcl, LC_Crop_Rate_Master crm, crop_mas cm
where clci.Id_mini_customer_link=mcl.id
and   clci.Id_crop_rate_master=crm.id
and   crm.Id_crop_mas=cast (cm.crop_id as integer)
and   mcl.id_land_info='".$row['land_id']."'
and   crm.Id_season_master=$season_id";
$result=dBConnect($sql_crop);
$crop=pg_result($result,'initcap');
if($crop)
echo $crop;
else echo "<image height=27px; width=25px; src=\"failed1.png\">";
echo"</td>";
}
else{
$sqla="select distinct s.season_start_dt,s.id,foo.Id_season_master,case when foo.initcap is null then 'not found' else foo.initcap end from lc_season_master s left outer join (select crm.Id_season_master,initcap(cm.crop_desc)
from LC_Customer_Land_Crop_Info clci, LC_mini_customer_link mcl, LC_Crop_Rate_Master crm, crop_mas cm
where clci.Id_mini_customer_link=mcl.id
and   clci.Id_crop_rate_master=crm.id
and   crm.Id_crop_mas=cast (cm.crop_id as integer)
and   mcl.id_land_info='".$row['land_id']."' ) as foo on s.id=foo.Id_season_master 
order by s.season_start_dt";
$resa=dBConnect($sqla);
//echo $sqla;
for($k=0;$k<pg_NumRows($resa);$k++)
{
$rowa=pg_fetch_array($resa,$k);
if($rowa['initcap']!='not found')
echo "<td align='center'  bgcolor='$color' width='8%' bgcolor='66CCFF'>".$rowa['initcap']."</td>";
else echo "<td align='center'  bgcolor='$color' width='8%' bgcolor='66CCFF'><blink><image height=27px; width=25px; src=\"failed1.png\"></blink></td>";
}
}
echo"</tr>";}
echo"</table></body>";
?>

