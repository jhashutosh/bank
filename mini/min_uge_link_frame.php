<?
include "../config/config.php";
$frmr_id=$_REQUEST['c'];
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>framer frame</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";

echo"<body bgcolor='grey'>";
echo"<table valign=\"top\"width='110%' align='center' bgcolor='red'>";
$sql=
"select mcl.Id_mini_master,cm.crop_desc,crm.Crop_rate,sum(clci.Tot_crop_area) crop_area,sum(clci.Tot_crop_area_val) crop_area_val
from  	LC_Customer_Land_Crop_Info clci, 
	LC_Mini_Customer_Link mcl, 
	LC_Crop_Rate_Master crm,
	crop_mas cm, 		      
	customer_master custm,
	land_info li
where   clci.Id_mini_customer_link=mcl.Id
and	clci.Id_crop_rate_master=crm.Id
and 	mcl.Id_customer_master=custm.customer_id 
and	crm.Id_crop_mas=cast(cm.crop_id as integer)
and 	mcl.Id_customer_master=custm.customer_id
and     mcl.Id_customer_master='C-38'
group by mcl.Id_mini_master,cm.crop_desc,crm.Crop_rate
";
$res=dBConnect($sql);
//echo $sql;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
echo "<tr>";
echo "<td  bgcolor='lightgreen' align='center' colspan=\"1\"  width='15%'><font color='black' size='2'>".$row['id_mini_master']."</font></td>";
echo "<td  bgcolor='lightgreen' align='center' colspan=\"1\" width='20%'><font color='black' size='2'>".$row['crop_desc']."</font></td>";
echo"<td align='center' width='20%'bgcolor='lightgreen'><font color='000033'>".$row['crop_rate']."</font></td>";
echo"<td align='center' width='15%'bgcolor='lightgreen'><font color='000033'>".$row['crop_area']."</font></td>";
echo"<td align='center' width='30%'bgcolor='lightgreen'><font color='000033'>".$row['crop_area_val']."</font></td>";
echo"</tr>";
}
echo"</table></body>";
?>

