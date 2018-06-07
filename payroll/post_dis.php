<?
include "../config/config.php";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$emp_id=$_REQUEST['emp_id'];
$saving_regno=$_REQUEST['saving_regno'];
//echo $type;
echo"<head>";
echo"<title>pf_dis</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo"</head>";
echo"<body bgcolor='grey'>";
$TBGCOLOR="white";
$TCOLOR="lightgreen";
echo"<form  name='f1' action='pf_dis.php' method='post' >";
echo"<table valign=\"top\"width='110%' align='center'>";
$sql="select * from emp_pforgratuity_po_dtl e,emp_pforgratuity_po_hdr p where e.emp_id=p.emp_id and e.saving_regno=p.saving_regno";
$res=dBConnect($sql);
//echo $sql;
$color==$TCOLOR;
for($j=0;$j<pg_NumRows($res);$j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($res,$j);
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"20%\"><font color='black' size='2'>".$row['cerf_slno']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"16%\"><font color='black' size='2'>".$row['dt_of_issue']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"16%\"><font color='black' size='2'>".$row['saving_regno']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"18%\"><font color='black' size='2'>".$row['po_name']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"16%\"><font color='black' size='2'>".$row['dt_of_maturity']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"14%\"><font color='black' size='2'>".$row['cerf_amount']."</font></td>";
echo"</tr>";
}
echo"</table></form></body>";



