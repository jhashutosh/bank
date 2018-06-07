<?php
include "../config/config.php";
$staff_id=verifyAutho();
$CONDITIONS=$_REQUEST['c'];
if(!empty($CONDITIONS)){$CONDITIONS="WHERE lower(mm_desc) LIKE '%".$CONDITIONS."%'";}
$menu=$_REQUEST['menu'];
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$sql_statement="select * FROM material_master1 $CONDITIONS ORDER BY mm_desc";
$result=dBConnect($sql_statement);
echo "<Table bgcolor=\"Black\" width=\"100%\" >";
if(pg_NumRows($result)>0){
for($j=1; $j<=pg_NumRows($result); $j++){
$flag=0;
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
if(empty($row['mm_stock'])){$flag=1;}
echo "<tr>";
echo "<td align=center bgcolor=$color width =\"8%\"><font color=$fcolor><a href=\"material_wise_stock.php?menu=$menu&mm_code=".$row['mm_code']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\"><font color=$fcolor>".ucwords($row['mm_desc'])."</a></td>";
echo "<td align=left bgcolor=$color width =\"9%\"><b><font color=$fcolor>".$row['mm_stock']."<BR>".strtoupper($row['uom'])."</font></b></td>";
echo "<td align=left bgcolor=$color width =\"9%\"><font color=red>".ucwords($row['mm_price'])."</font></td>";
if($flag==1){
echo "<td align=left bgcolor=$color width =\"5%\"><font color=$fcolor></td>";
echo "<td align=left bgcolor=$color width =\"6%\"><font color=$fcolor></td>";
echo "<td align=left bgcolor=$color width =\"9%\"><font color=$fcolor></td>";
echo "<td align=left bgcolor=$color width =\"9%\"><font color=$fcolor></td>";
echo "<td align=left bgcolor=$color width =\"14%\"><font color=green>".$row['final_p_value']."/".strtoupper($row['uom'])."</td>";
echo "<td align=left bgcolor=$color width =\"10%\"><font color=$fcolor></td>";
echo "<td align=left bgcolor=$color width =\"8%\"><font color=$fcolor></td>";
}
else{
echo "<td align=left bgcolor=$color width =\"9%\"><font color=$fcolor>".ucwords($row['p_stock'])."<BR>".strtoupper($row['uom'])."</font></td>";
echo "<td align=left bgcolor=$color width =\"6%\"><font color=red>".amount2Rs($row['final_value'])."</td>";
echo "<td align=left bgcolor=$color width =\"9%\"><font color=$fcolor>".ucwords($row['s_stock'])."<BR>".strtoupper($row['uom'])."</font></td>";
echo "<td align=left bgcolor=$color width =\"9%\"><font color=red>".ucwords($row['s_price'])."</td>";
echo "<td align=left bgcolor=$color width =\"14%\"><font color=green>".$row['final_p_value']."/".strtoupper($row['uom'])."</td>";
echo "<td align=left bgcolor=$color width =\"10%\"><font color=$fcolor>".ucwords($row['final_stock'])."<BR>".strtoupper($row['uom'])."</td>";
echo "<td align=left bgcolor=$color width =\"8%\"><font color=red>".amount2Rs($row['final1_value'])."</td>";

}
echo "<td bgcolor=$color>";
if($flag==1){
echo "<a href=\"opening_stock.php?menu=$menu&mm_code=".$row['mm_code']."&mm_desc=".$row['mm_desc']."&uom=".$row['uom']."&mg_code=".$row['mg_code']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=200,left=350, width=350,height=250'); return false;\">Opening</a> ||";
     }
else
{
echo "<a href=\"purchases_ledger_hrd.php?menu=rsh&material=".$row['mm_code']."\" target=\"_parent\">Purchase</a> || <a href=\"sales_ledger_hrd.php?menu=rsh&material=".$row['mm_code']."\" target=\"_parent\">Sales</a></td>";
}
  }
}

?>
