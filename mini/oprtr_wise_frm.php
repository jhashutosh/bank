<?
include "../config/config.php";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>customer_wise frame</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
$c_id=$_REQUEST['c'];
$optr_nm=$_REQUEST['optr_nm'];
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";
$TBGCOLOR='#9A95F1';
$TCOLOR='#C7C6D7';
echo"<body bgcolor='grey'>";
echo"<table valign=\"top\"width='100%'  align='center'>";
$sql="select om.id,om.operator_name,mm.mini_name,osd.bill_no,osd.bill_date,
	sum(Tot_crop_area) as tot_crp_area,sum(Tot_Sal_amt) as tot_sal_amt,sum(paid_amt) as paid_amt,sum(due_amt) as due_amt
from  LC_operator_salary_details osd, LC_Mini_Operator_Link mol, LC_operator_master om, LC_mini_master mm
where osd.id_Mini_Operator_Link=om.id
and   mol.id_operator_master=om.id
and   mol.id_mini_master=mm.id
and   om.id=$optr_nm
and   osd.Paid_amt>0
--and   osd.bill_date >=(select start_dt from fy_list where fy=(select max(fy) from fy_list)) 
--and   osd.bill_date <=(select close_dt from fy_list where fy=(select max(fy) from fy_list))
group by om.id,om.operator_name,mm.mini_name,osd.bill_no,osd.bill_date
order by om.id";
$res=dBConnect($sql);
//echo $sql;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
//echo"<tr style='height:30px'><td align='center'  width='9%'bgcolor='$color' ><font color='000033'>".$row['id']."</font></td>";
//echo"<td align='center' width='20%'bgcolor='$color' ><font color='000033'>".$row['operator_name']."</font></td>";
echo"<td align='center' width='10%'bgcolor='$color' ><font color='000033'>".$row['mini_name']."</font></td>";
echo"<td align='center' width='5%'bgcolor='$color' ><font color='000033'>".$row['bill_no']."</font></td>";
echo"<td align='center' width='15%'bgcolor='$color' ><font color='000033'>".$row['bill_date']."</font></td>";
echo"<td align='center' width='10%'bgcolor='$color'><font color='000033'>".$row['tot_crp_area']."</font></td>";
echo"<td align='center' width='25%'bgcolor='$color'><font color='000033'>".$row['tot_sal_amt']."</font></td>";
echo"<td align='center' width='15%'bgcolor='$color' ><font color='000033'>".$row['paid_amt']."</font></td>";
echo"<td align='center' width='10%'bgcolor='$color' ><font color='000033'>".$row['due_amt']."</font></td>";
echo"</tr>";
}
echo"</table></body>";
?>
