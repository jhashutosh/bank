<?php
include "../config/config.php";
$gl_mas_code=$_REQUEST['gl_mas_code'];
$gl_mas_desc=$_REQUEST['gl_mas_desc'];
$annexture_id=$_REQUEST['id'];
$status=$_REQUEST['status'];
$op=trim($_REQUEST['op']);
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
echo "<title>General Ledger</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\">";
echo "</head>";
echo "<body bgcolor=SILVER onload=\"code.focus();\">";
if($op=='c'){
echo "<H1><CENTER>GENERAL LEDGER MASTER</CENTER></H1>";
echo "<HR>";
echo "<form action=\"gl_master_header.php?op=i\" method=POST name=f1><br>";
echo "<table width=65% align=CENTER bgcolor=#FFE4E1>";
echo "<tr><TH colspan=2 bgcolor=#9ACD32>General Ledger Master</th>";
echo "<tr><td>Code  :<td><input type=TEXT name=gl_mas_code id=code $HIGHLIGHT>";
echo "<tr><td>Particular  :<td><input type=TEXT name=gl_mas_desc size=50 $HIGHLIGHT>";
//echo "<tr><td>Annexture Id  :<td><input type=TEXT name=annexture_id size=20 $HIGHLIGHT>";

echo "<tr><td>Annexure  Id :<td>";
makeSelectFromDBWithCode('id','annexture_desc','annexture_mas','id');


echo "<tr><td>GL_SUB_HEADER :<td>";
makeSelectFromDBWithCode('gl_sub_header_code','gl_sub_header_desc','gl_sub_header','status');
echo "<tr><td><td align=CENTER><input type=submit value=ok><input type=RESET value=Reset>";
echo "</form>";
echo "</body>";
echo "</html>";
}
 
if($op=='i'){
$up=$_REQUEST['up'];
if(empty($annexture_id)){
	$sql="INSERT INTO gl_master(gl_mas_code,gl_mas_desc,gl_sub_header_code) VALUES('$gl_mas_code','$gl_mas_desc','$status')";
}
else{
	$sql="INSERT INTO gl_master VALUES('$gl_mas_code','$gl_mas_desc','$status',$annexture_id)";
}
echo $sql;
$result=dBConnect($sql);
 if(pg_affected_rows($result)<1)
  {
   echo "<h1><blink>sorry row duplicated!!!!!!!!!!!!!!!!!!</h1>";
  }
 else{
	header('Location:gl_master_header.php?op=v&gl_mas_code=$gl_mas_code');
	
     }
}
if($op=='v'){
  echo "<form method=\"POST\" action=\"gl_master_header.php?op=$op\">";
  echo "<table width=100% bgcolor=YELLOW align=center><tr><td align=CENTER><b>Search By Code:&nbsp<input type=\"TEXT\" name=\"id\" id=\"code\" size=\"15\" value=\"$id\" $HIGHLIGHT>&nbsp<input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"   go   \"></table></form>";
  //echo $WHERE_CONDITIONS;
  $sql="SELECT * FROM gl_master $WHERE_CONDITIONS";
  //echo $sql;
  $result=dBConnect($sql);
  if(pg_NumRows($result)!=0){
 	echo "<table align=center width=90%>";
	echo "<tr><th colspan=6 bgcolor=#8A2BE2>General Master Header</th>";
	echo"<tr bgcolor=#7FFFD4><th>Code<th>Particulars<Th>Balance(Rs.)<th>Annexture Id<th>GL_SUB_Header_code<th>Operation";
	$color=$TCOLOR;
	for($j=0;$j<pg_NumRows($result);$j++){
 		$row=pg_fetch_array($result,$j);
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
		$code=$row["gl_mas_code"];
          	if($code==$gl_mas_code){$color="GREEN";}
		$balance=getGlBalance($code);
		echo "<tr bgcolor=$color><td><a href=\"general_ledger_details.php?menu=gen&op=l&gl_code=$code\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1000,height=900'); return false;\">$code</a><td>".ucwords($row["gl_mas_desc"])."<td align=\"RIGHT\"><a href=\"general_ledger_details.php?menu=gen&op=l&gl_code=$code\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1000,height=900'); return false;\"><b>$balance</b></a>"; 
		echo "<td bgcolor=$color align=right>".$row['annexure_id'];
		echo "<td align=\"center\">".$row["gl_sub_header_code"]."<td bgcolor=$color align=CENTER><a href=\"gl_master_header.php?op=c\">New</a>||&nbsp;&nbsp;&nbsp;<a href=\"gl_master_header.php?op=a&gl_code=$code\">Alter</a>";
                 
		}
		echo "<tr><th colspan=6 bgcolor=AQUA>Total $j Ledger Sub header Found!!!!";
       }
  }
if($op=='a'){
$gl_code=$_REQUEST['gl_code'];
$sql_statement="select * from gl_master where gl_mas_code='$gl_code'";
$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_NumRows($result)>0){
$gl_mas_code=pg_result($result,'gl_mas_code');
$gl_mas_desc=pg_result($result,'gl_mas_desc');
$annexture_id=pg_result($result,'annexture_id');
$gl_sub_header=pg_result($result,'gl_sub_header_code');

$rec_vou=pg_result($result,'rec_vou_ind');
$pay_vou=pg_result($result,'pay_vou_ind');
$cash_account=pg_result($result,'cash_bank_ind');
echo "<H1><CENTER>UPDATE FORM OF LEADGER MASTER</CENTER></H1>";
echo "<HR>";
echo "<form action=\"gl_master_header.php?op=u&gl_code=$gl_mas_code\" method=POST name=f1><br>";
echo "<table width=65% align=CENTER bgcolor=#FFE4E1>";
echo "<tr><TH colspan=2 bgcolor=#9ACD32>General Leadger Master</th>";
echo "<tr><td>Code  :<td><input type=TEXT name=\"gl_code\" id=\"code\" value=\"$gl_mas_code\" $HIGHLIGHT>";
echo "<tr><td>Particular  :<td><input type=TEXT name=\"gl_mas_desc\" size=50 value=\"$gl_mas_desc\"$HIGHLIGHT>";
//echo "<tr><td>Annexture Id  :<td><input type=TEXT name=annexture_id size=20 value=\"$annexture_id\" $HIGHLIGHT>";

echo "<tr><td>Annexture Id :<td>";
makeSelectFromDBWithCode1('id','annexture_desc','annexture_mas','id');



echo "<tr><td>GL_SUB_HEADER :<td><input type=TEXT name=\"gl_sub_code\" id=code value=\"$gl_sub_header\" $HIGHLIGHT readonly></td>";

//echo "<tr><td>Show in Repecipt Voucher :<td><input type=\"text\" name=\"r_voucher\" value=\"$rec_vou\" $HIGHLIGHT></td>";
//echo "<tr><td>Show in Payment Voucher :<td><input type=\"text\" name=\"pay_voucher\" value=\"$pay_vou\" $HIGHLIGHT></td>";
//echo "<tr><td>Cash/Bank Account:<td><input type=\"text\" name=\"cash_voucher\" value=\"$cash_account\" $HIGHLIGHT></td>";
echo "<tr><td><td align=CENTER><input type=submit value=ok><input type=RESET value=Reset>";

echo "</form>";
}
}
if ($op=='u'){
$gl_mas_code=$_REQUEST['gl_code'];
$sql_statement="UPDATE gl_master set gl_mas_desc=lower('$gl_mas_desc'),annexure_id='$annexture_id' where gl_mas_code='$gl_mas_code'";

echo $sql_statement;
$result=dBConnect($sql_statement);
if (pg_affected_rows($result)<1){
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	}
else{
	//header('location:gl_master_header.php?op=v.php');
	header('Location:gl_master_header.php?op=v&gl_mas_code=$gl_mas_code');
	}
}
  
?>
