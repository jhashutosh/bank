<?php
include "../config/config.php";
$tran_id=$_REQUEST['tran_id'];
$status=$_REQUEST['status'];
$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
if(!empty($id)){
	$arr=explode(",",$id); // Multiple entry seperated by ,
	$n=count($arr);
	$WHERE_CONDITIONS=""; 
	for($i=0; $i<($n-1);$i++){
		$WHERE_CONDITIONS="$WHERE_CONDITIONS tran_id='$arr[$i]' OR ";
	}
 
	$WHERE_CONDITIONS="WHERE $WHERE_CONDITIONS tran_id='$arr[$i]'"; 
	
} else {
	$WHERE_CONDITIONS=""; 
}
echo "<html>";
echo "<head>";
echo "<title>Monojit</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\">";
echo "</head>";
echo "<body bgcolor=SILVER onload=\"code.focus();\">";

echo "<H1><CENTER>TRANSCTION DELETE</CENTER></H1>";
echo "<HR>";
echo "<form action=\"tran_delete.php\" method=POST name=f1><br>";
echo "<table width=65% align=CENTER bgcolor=#FFE4E1>";
echo "<tr><TH colspan=2 bgcolor=#9ACD32>Transction Delete</th>";
echo "<tr><td>Tran ID  :<td><input type=TEXT name=tran_id id=code $HIGHLIGHT>";
//echo "<tr><td>Particular  :<td><input type=TEXT name=gl_mas_desc size=50 $HIGHLIGHT>";
//echo "<tr><td>GL_SUB_HEADER :<td>";
//makeSelectFromDBWithCode('gl_sub_header_code','gl_sub_header_desc','gl_sub_header','status');
echo "<tr><td><td align=CENTER><input type=submit value=ok><input type=RESET value=Reset>";
echo "</form>";

echo "</body>";
echo "</html>";


$up=$_REQUEST['up'];
$sql=" delete from gl_ledger_dtl where tran_id='$tran_id'";
//echo $sql;
$result=dBConnect($sql);
$sql=" delete from gl_ledger_hrd where tran_id='$tran_id'";
//echo $sql;
$result=dBConnect($sql);


//if(pg_affected_rows($result)<1){
	echo "<h1><center><blink><font color=\"RED\">This Transction has been deleted .....</font></h1>";
//	} 
//else {
//	$i_flag=1;
//    }
//if($i_flag==1){
//echo "<h2><font color=\"green\">Transction has been deleted Successfully.<b>$t_id</b></font></h2>";
//}

  
?>
