<?
include "../config/config.php";
$frmr_id=$_REQUEST['c'];
//echo $frmr_id;
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>framer frame</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";

echo"<body bgcolor='grey'>";

echo"<form  name='f1' action='frmr_frame.php?op=i' method='post' >";
echo"<table valign=\"top\"width='110%' align='center'>";
$sql=
"select mcl.Id_customer_master,cm.name1,cpd.bill_date,
sum(cpd.Tot_amt) usg_amt,
sum(cpd.paid_amt) paid_amt, sum(cpd.due_amt) due_amt ,sum(cpd.Overdue_amt) Overdue_amt, sum(cpd.Bal_amt) Bal_amt
from LC_Customer_Payment_Details cpd, LC_Customer_Land_Crop_Info clci, LC_Mini_Customer_Link mcl,customer_master cm
where cpd.Id_LC_Customer_Land_Crop_Info=clci.id
and   clci.id_mini_customer_link=mcl.id
and   mcl.Id_customer_master=cm.customer_id
and   mcl.Id_customer_master='$frmr_id'
and   cpd.Action_date >=(select start_dt from fy_list where fy=(select max(fy) from fy_list)) 
and   cpd.Action_date <=(select close_dt from fy_list where fy=(select max(fy) from fy_list))
group by mcl.Id_customer_master, cm.name1, cpd.bill_date";
$res=dBConnect($sql);
//echo $sql;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
echo "<tr>";
echo "<td  bgcolor='lightgreen' align='center' colspan=\"1\"  width='15%'><font color='black' size='2'>".$row['bill_date']."</font></td>";
echo "<td  bgcolor='lightgreen' align='center' colspan=\"1\" width='15%'><font color='black' size='2'>".$row['paid_amt']."</font></td>";
echo "<td  bgcolor='lightgreen' align='center' colspan=\"1\"  width=\"20%\"><a href=\"min_uge_link.php?c=$frmr_id\" target=_parent onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=120, width=1100,height=650'); color='red' return false;\"> <blink>".$row['usg_amt']."</blink></td>";
echo"<td align='center' width='15%'bgcolor='lightgreen'><font color='000033'>".$row['due_amt']."</font></td>";
echo"<td align='center' width='15%'bgcolor='lightgreen'><font color='000033'>".$row['overdue_amt']."</font></td>";
echo"<td align='center' width='20%'bgcolor='lightgreen'><font color='000033'>".$row['bal_amt']."</font></td>";
echo"</tr>";
}
echo"</table></form></body>";
?>



