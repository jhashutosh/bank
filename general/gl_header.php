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
<? 
if($op=="c"){
 ?>

<h1><b><i>General Ledger Header</i></b></h1>
<hr>
<br>
<form action="gl_header.php?op=i" method=POST name=f1>
<table width=65% align=CENTER bgcolor=#E0FFFF>
 <tr><TH colspan=2 bgcolor=GREEN>General Ledger Header</th>
 <tr><td>Code  :<td><input type=TEXT name=gl_header_code id=code <?echo $HIGHLIGHT;?> >
 <tr><td>Particular  :<td><input type=TEXT name=gl_header_desc size=50 <?echo $HIGHLIGHT;?>>
 <tr><td>Type:<td><? makeSelect($header_type_array,"status","");?>
 <input type=HIDDEN name=op value=1>
 <tr><td><td align=CENTER><input type=submit value=ok><input type=RESET value=Reset>
</form>
</body>
</html>
<?
 }
if($op=='i')
{
 $sql="INSERT INTO gl_header VALUES('$gl_header_code',lower('$gl_header_desc'),upper('$status'))";
 $result=dBConnect($sql);
 if(pg_affected_rows($result)<1)
  {
   echo "<h1><blink>sorry row duplicated!!!!!!!!!!!!!!!!!!</h1>";
  }
 else{
	header('Location:gl_header.php?op=v');
     }
}
if($op=='v')
{
  //echo "<h1><center>Inserted</h1><tr>";
  //echo "<a href=\"test.php\"><blink>Click here to next entry</a><br><hr>";
  $sql="SELECT * FROM gl_header";
  $result=dBConnect($sql);
  if(pg_NumRows($result)>0)
	{
 		echo "<table align=center bgcolor=#FFE4B5 width=80%>";
		echo "<tr><th colspan=4 bgcolor=GREEN>General Header</th>";
		echo "<tr bgcolor=#FF00FF><th>Code<th>Particulars<th>Type<th>Operation";
		$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++)
		{
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
		echo "<tr>";
		echo "<td bgcolor=$color>".$row["gl_header_code"];
		echo "<td bgcolor=$color>".ucwords($row["gl_header_desc"]);
		echo "<td bgcolor=$color>".$header_type_array[trim($row["status"])]; 
		echo "<td bgcolor=$color align=CENTER><a href=#>N</a>&nbsp;&nbsp;&nbsp;<a href=#>U</a>";
                 
		}
	        echo "<tr><th colspan=4 bgcolor=AQUA>Total $j Ledger header Found!!!!";
       }

} 
?>
