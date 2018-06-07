<?
include "../config/config.php";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$emp_id=$_REQUEST['emp_id'];
$type=$_REQUEST['type'];
//echo $type;
$saving_regno=$_REQUEST['saving_regno'];
echo"<head>";
echo"<title>pf_dis</title>";
echo"</head>";
echo"<body bgcolor='grey'>";
$TBGCOLOR="white";
$TCOLOR="lightgreen";
if($type=='lic')
{
echo"<table valign=\"top\"width='100%' align='center'>";
$sql="select * from emp_pforgratuity_lic_hdr where emp_id='$emp_id'";
$res=dBConnect($sql);
//echo $sql;
$color==$TCOLOR;
for($j=0;$j<pg_NumRows($res);$j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($res,$j);
$pol_no=$row['pol_no'];
echo "<tr>";
$sql="select max(rcpt_date),sum(premium_amount) from emp_pforgratuity_lic_dtl where pol_no='$pol_no' and emp_id=$emp_id";
$res=dBConnect($sql);
$row3=pg_fetch_array($res,0);
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"8%\"><font color='black' size='2'>".$row['pol_no']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"18%\"><font color='black' size='2'>".$row['dt_of_commencement']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"10%\"><font color='black' size='2'>".$row['pol_val']."</font></td>";
echo "<td  bgcolor='$color' align='center'  colspan=\"1\"  width=\"13%\"><font color='black' size='2'>".$row['dt_of_maturity']."</font></td>" ;
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"11%\"><font color='black' size='2'>".$row3['sum']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"22%\"><font color='black' size='2'>".$row3['max']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"10%\"><a href=\"../payroll/lic_pre.php?&emp_id=$emp_id&pol_no=$pol_no\" target=_parent onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=1000,height=800'); return false;\"><font bgcolor='darkblue' style='bold'><em>Add Premium</em></font></td>";
echo "<td align=center bgcolor=$color align='center'  width=\"10%\"><a href=\"../payroll/pf_bnk_edit.php?id=".$row['id']."&emp_id=$emp_id&type=lic&pol_no=$pol_no\" target=_parent onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=1000,height=800'); return false;\"> Edit </td>";
echo"</tr>";
}
}
if($type=='po')
{echo $emp_id;
echo"<form  name='f1' action='pf_dis.php' method='post' >";
echo"<table valign=\"top\"width='120%' align='center'>";
$sql="select * from emp_pforgratuity_po_hdr where emp_id='$emp_id'";
$res=dBConnect($sql);
//echo $sql;
$color==$TCOLOR;
for($j=0;$j<pg_NumRows($res);$j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($res,$j);
$saving_regno=$row['saving_regno'];
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"75\"><font color='black' size='2'>".$row['saving_regno']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"35\"><font color='black' size='2'>".$row['dt_of_issue']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"125\"><font color='black' size='2'>".$row['tot_no_of_cerf']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"85\"><font color='black' size='2'>".$row['dt_of_maturity']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"70\"><font color='black' size='2'>".$row['tot_amount']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"75\"><a href=\"../payroll/post_off_cert.php?&emp_id=$emp_id&saving_regno=$saving_regno\" target=_parent onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=1000,height=800'); return false;\"><font bgcolor='darkblue' style='bold',style='italics'><em>Add Certificate</em></font></td>";
echo "<td align=center bgcolor=$color align='center'  width=\"10%\"><a href=\"../payroll/pf_bnk_edit.php?id=".$row['id']."&emp_id=$emp_id&type=po&saving_regno=$saving_regno\" target=_parent onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=1000,height=800'); return false;\"> Edit </td>";
echo"</tr>";
}
}
echo"</table>";
if($type=='bank')
{
echo"<table valign=\"top\"width='100%' align='center'>";
$sql="select * from emp_pforgratuity_sb_dtl where emp_id=$emp_id";
$res=dBConnect($sql);
//echo $sql;
$color==$TCOLOR;
for($j=0;$j<pg_NumRows($res);$j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($res,$j);
$pol_no=$row['pol_no'];
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"10%\"><font color='black' size='2'>".$row['deposit_no']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"25%\"><font color='black' size='2'>".$row['bank_name']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"20%\"><font color='black' size='2'>".$row['amount']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"20%\"><font color='black' size='2'>".$row['dt_of_issue']."</font></td>";
echo "<td  bgcolor='$color' align='center'  colspan=\"1\"  width=\"20%\"><font color='black' size='2'>".$row['dt_of_maturity']."</font></td>" ;
echo "<td align=center bgcolor=$color align='center' width=\"5%\"><a href=\"../payroll/pf_bnk_edit.php?id=".$row['id']."&emp_id=$emp_id&type=bank\" target=_parent onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=1000,height=800'); return false;\"> Edit </td>";
echo"</tr>";
}
echo"</table>";
}
echo"</table>";
echo"</body>";
?>
