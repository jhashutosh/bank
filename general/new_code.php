<?php
include "../config/config.php";
$gl_mas_code=$_REQUEST['gl_mas_code'];
$gl_mas_desc=$_REQUEST['gl_mas_desc'];
$status=$_REQUEST['status'];
$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
if(!empty($id)){
	$arr=explode(",",$id); // Multiple entry seperated by ,
	$n=count($arr);
	$WHERE_CONDITIONS=""; 
	for($i=0; $i<($n-1);$i++){
		$WHERE_CONDITIONS="$WHERE_CONDITIONS gl_mas_code='$arr[$i]' OR ";
	}
 
	$WHERE_CONDITIONS="WHERE $WHERE_CONDITIONS gl_mas_code='$arr[$i]'"; 
	
} else {
	$WHERE_CONDITIONS=""; 
}
echo "<html>";
echo "<head>";
echo "<title>Monojit</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\">";
echo "</head>";
echo "<body bgcolor=SILVER onload=\"code.focus();\">";
if($op=='c'){
echo "<H1><CENTER>GENERAL LADGER MASTER</CENTER></H1>";
echo "<HR>";
echo "<form action=\"new_code.php?op=i\" method=POST name=f1><br>";
echo "<table width=65% align=CENTER bgcolor=#FFE4E1>";
echo "<tr><TH colspan=2 bgcolor=#9ACD32>General Ledger Master</th>";
echo "<tr><td>Code  :<td><input type=TEXT name=gl_mas_code id=code $HIGHLIGHT>";
echo "<tr><td>Particular  :<td><input type=TEXT name=gl_mas_desc size=50 $HIGHLIGHT>";
echo "<tr><td>GL_SUB_HEADER :<td>";
makeSelectFromDBWithCode('gl_sub_header_code','gl_sub_header_desc','gl_sub_header','status','');
echo "<tr><td><td align=CENTER><input type=submit value=ok><input type=RESET value=Reset>";
echo "</form>";

echo "</body>";
echo "</html>";
}
 
if($op=='i'){
$up=$_REQUEST['up'];
$sql="INSERT INTO gl_master VALUES('$gl_mas_code',lower('$gl_mas_desc'),'$status')";
//echo $sql;
$result=dBConnect($sql);
 if(pg_affected_rows($result)<1)
  {
   echo "<h1><blink>sorry row duplicated!!!!!!!!!!!!!!!!!!</h1>";
  }
 else{
	header('Location:new_code.php?op=v&gl_mas_code=$gl_mas_code');
	
     }
}


  
?>
