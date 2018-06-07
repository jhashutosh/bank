<?php
include "../config/config.php";
$op=$_REQUEST['op'];
//echo $op;
if($op=='i'){
$ast=$_REQUEST['ast'];
$liab=$_REQUEST['liab'];
$adv_desc=$_REQUEST['adv_desc'];
//echo $ast;
//echo $liab;
$sql="insert into advance_link (adv_desc,ast_code,liab_code) values ('$adv_desc','$ast','$liab') ";
//echo $sql;
$res=dBConnect($sql);
if(pg_NumRows($res)>0)
echo"<h4><font color='green'>Link Saved Successfully</h4>";
}
?>
<head>
<!--create table advance_link  ( id serial,ast_code character varying(6),liab_code character varying (6)); -->
<title>
</title><?php
echo"<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
</head>
<body bgcolor='grey'>
<table bgcolor='#676767' align='center' width='60%'>
<form action='master.php?op=i' method='post'>
<tr><td colspan='2' align='center'><font color='white' size='+2'>Link Asset & Liability codes for advance</td></tr>
<tr><td bgcolor='#EFEFEF'>Advance Description :<font color='red'>*</font></td><td bgcolor='#EFEFEF'><input type='text' size='30' name='adv_desc' id='adv_desc'></td></tr>
<tr bgcolor='#EFEFEF'><td height='40px;'>Ledger Head from Advance (Asset side Debit code) : </td><td>
<?php
echo"<Select name='ast'>";
$sql="select * from gl_master where gl_sub_header_code ='27200' and gl_mas_code not in (select ast_code from advance_link)order by cast(gl_mas_code as integer) ";
$res=dBConnect($sql);
for($j=0;$j< pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
echo"<option value='".$row['gl_mas_code']."'>".ucwords($row['gl_mas_desc'])."[".$row['gl_mas_code']."]</option>";
}
?>
</select></td></tr>
<?php
$sql="select * from gl_master where gl_mas_code > '18949' and gl_mas_code< '19000'";
$res=dBConnect($sql);
?>
<tr bgcolor='#EFEFEF'><td  height='40px;'>Ledger Head from Advance (Liability Credit code) : </td><td>
<?php
echo"<Select name='liab'>";
for($j=0;$j< pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
echo"<option value='".$row['gl_mas_code']."'>".ucwords($row['gl_mas_desc'])."[".$row['gl_mas_code']."]</option>";
}?>
</select></td></tr><tr><td colspan='2' align='right'><input type='submit' value='Submit'></td></tr>
</table></form>
<br><br>
<table width='80%' align='center' bgcolor='#CDCDCD'>
<tr><td colspan='3' align='center'><font color='#676767' size='+2'>Advance Link</td></tr>
<tr bgcolor='grey'><td align='center'><font color='white' size='+1'>Type Of Advance</td><td align='center'><font color='white' size='+1'>Asset Code</td><td align='center'><font color='white' size='+1'>Liability Code</td></tr>
<?php
$sql_statement="select * from (
(select a.id,a.adv_desc,g.gl_mas_desc as ast, a.ast_code from advance_link a,gl_master g where a.ast_code=g.gl_mas_code) as a 
join 
(select a.id,g.gl_mas_desc as liab , a.liab_code from advance_link a,gl_master g where a.liab_code=g.gl_mas_code) as b
on a.id=b.id)";
//echo $sql_statement;
$TCOLOR='9A9A9A';
$TBGCOLOR='#CDCDCD';
$result=dBConnect($sql_statement);
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
?>
<tr <?echo "bgcolor='$color'";?>>
<td align='center'><?echo ucwords($row['adv_desc']);?></td>
<td align='center'><?echo ucwords($row['ast']);echo "[".$row['ast_code']."]";?></td>
<td align='center'><?echo ucwords($row['liab']);echo "[".$row['liab_code']."]";?></td>
</tr>
<?php
}?>
</table>
</body>

