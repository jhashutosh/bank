<?php
 include "../config/config.php";
 $gl_header_code=$_REQUEST['gl_header_code'];
 $gl_header_desc=$_REQUEST['gl_header_desc'];
 $status=$_REQUEST['status'];
 $op=$_REQUEST['op'];
?>
<html>
<head>
<title>Monojit</title>
<link rel="stylesheet" type="text/css" href="../css/test.css">
</head>
<body bgcolor=SILVER onload="code.focus();">
<?php
 if($op=='c'){
 ?>

<H1><CENTER>GENERAL SUB HEAD LADGER</CENTER></H1>
<HR>
<form action="gl_sub_header.php?op=i" method=POST name=f1><br>
<table width=65% align=CENTER bgcolor=#FFE4E1>
 <tr><TH colspan=2 bgcolor=Gold>General Ledger Sub Header</th>
 <tr><td>Code  :<td><input type=TEXT name=gl_header_code id=code <?echo $HIGHLIGHT;?> >
 <tr><td>Particular  :<td><input type=TEXT name=gl_header_desc size=50 <?echo $HIGHLIGHT;?>>
 <tr><td>Gl_HEADER :<td><? makeSelectFromDBWithCode("gl_header_code","gl_header_desc","gl_header","status");?>
<tr><td><td align=CENTER><input type=submit value=ok><input type=RESET value=Reset>
</form>

<?php
 }
if($op=='i'){
 $sql="INSERT INTO gl_sub_header VALUES('$gl_header_code',lower('$gl_header_desc'),'$status')";
 echo  $sql;
 $result=dBConnect($sql);
 if(pg_affected_rows($result)<1)
  {
   echo "<h1><blink>sorry row duplicated!!!!!!!!!!!!!!!!!!</h1>";
  }
 else{
	header('Location:gl_sub_header.php?op=v&gl_header_code=$gl_header_code');
     }
}
if($op=='v'){
  $sql="SELECT * FROM gl_sub_header";
  $result=dBConnect($sql);
  if(pg_NumRows($result)>0){
 	echo "<table align=center width=80%>";
	echo "<tr><th colspan=4 bgcolor=#8A2BE2>General Sub Header</th>";
	echo"<tr bgcolor=#7FFFD4><th>Code<th>Particulars<th>GL_Header_code<th>Operation";
	$color=$TCOLOR;
	for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
		$code=$row["gl_sub_header_code"];
		if($code==$gl_header_code){$color='orange';}
          	echo "<tr bgcolor=$color><td>$code<td>".ucwords($row["gl_sub_header_desc"])."<td>".$row["gl_header_code"]; 
		echo "<td bgcolor=$color align=CENTER><a href=#>N</a>&nbsp;&nbsp;&nbsp;<a href=#>U</a>";
                 
		}
	  echo "<tr><th colspan=4 bgcolor=AQUA>Total $j Ledger Sub header Found!!!!";
       }
 }
?>
</body>
</html>
