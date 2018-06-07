<?php
include "../config/config.php";
$staff_id==verifyAutho();
$TCOLOR='white';
$TBGCOLOR='#80ADF6';
$op=$_REQUEST['op'];
?>
<script LANGUAGE="JavaScript">
function val(f)
{
var grnl=document.getElementById('cat_sub').value.length;
var sandl=document.getElementById('cat').value.length;
var cat=document.getElementById('cat').value;
if(sandl==0)
{
alert("You Must select Category");
return false;
}
/*if(grnl==0)
{
alert("You Must enter "+cat+"- sub type\neg. Individual,Society,PF");
return false;
}*/
}
</script>
<?
if($op=='i'){
$cat_sub=strtoupper($_REQUEST['cat_sub']);
$cat=$_REQUEST['cat'];
$category=(empty($_REQUEST['cat_sub']))?$cat:$cat_sub.'-'.$cat;
$sql="insert into category_mas values(nextval('category_id_seq'),'$category')";
$res=dBConnect($sql);
echo $sql;
}
echo "<html>";
echo "<head>";
echo "<title>Adhoc Master</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<body bgcolor=\"#E1FFEF\"><br>";
echo "<form name=\"f1\" METHOD=\"POST\" ACTION=\"cat_mas.php?op=i\" onSubmit=\"return val(this.form);\">";
echo "<table width=\"40%\" bgcolor='#D2E9F2' align='center' valign='bottom'>";
echo "<tr><td bgcolor=\"006666\" colspan=\"5\" align=\"center\"><b><font color=\"WHITE\">Diposit Category Master</font>";
echo "<tr>";
echo "<td bgcolor=\"#D2E9F2\" align='center'>Select Diposit Category";
echo"<td bgcolor=\"#D2E9F2\">:</td><td bgcolor=\"#D2E9F2\" align='right'>";makeSelectcategory($type_of_diposit_array,"cat");
echo"</td>";
echo"</td><td bgcolor=\"#D2E9F2\">-";
echo"<td bgcolor=\"#D2E9F2\"><input type='text' name='cat_sub' id='cat_sub' size='8' $HIGHLIGHT></td></tr><tr><td bgcolor=\"#D2E9F2\"></td></tr><tr><td bgcolor=\"#D2E9F2\"></td></tr><tr><td bgcolor=\"#D2E9F2\"></td></tr><tr>";
echo"<td bgcolor=\"#D2E9F2\" colspan='5' align='center'><input type='submit' name='Enter' value='Enter'></td>";
echo"<table width=\"40%\" bgcolor='#D2E9F2' align='center'><tr><th bgcolor='#1773D0' align='center'><font color='white'>Diposit Category</th></tr>";
$sql_statement="select * from category_mas";
$result=dBConnect($sql_statement);
for($j=0;$j<pg_NumRows($result);$j++)
{$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo"<tr><td align='center' bgcolor=$color>";
echo $row['category_name'];
echo"</td></tr>";
}
echo"</table>";

?>
