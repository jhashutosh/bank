<?php
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
echo"<table valign=\"top\"width='110%' align='center'>";
$color="#F0E68C";
$color==$TCOLOR;
$sql_statement=" select asset_mast_rpt('refcursor')";
$sql_statement.=";fetch all from refcursor";
//echo $sql_statement;
$result=dBConnect($sql_statement);
$a=pg_NumRows($result)-1;
for($j=0;$j<pg_NumRows($result);$j++){
$row=pg_fetch_array($result,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<td align=center width='15%' bgcolor=$color>".$row['SRL'];
if($j==$a){
	echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"25%\">".$row['ASSET MASTER']."</td>";

}
else{
echo "<td align=center width='35%' bgcolor=$color><a href=\"asset_mstr_item.php?asst_mstr=".$row['ASSET MASTER']."\" onClick=\"window.open(this.href,'_child','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=250,left=350, width=1000,height=400'); return false;\">".$row['ASSET MASTER']."</a></td>";


//<a href=\"asset_mstr_item.php?asst_mstr=".$row['ASSET MASTER']."\" target=_parent onClick=\"window.open(this.href,'_child','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=120, width=1100,height=650'); color='red' return=false;\">".$row['ASSET MASTER'];
}
echo "<td align=center width='25%' bgcolor=$color>".$row['NO. OF ITEM(S)'];
echo "<td align=center width='25%' bgcolor=$color>".$row['CURRENT VALUE']."</td>";
echo"</tr>";
}
echo"</table></body>";
?>

