<?php
include "../config/config.php";
$sql_statement="SELECT * FROM customer_master order by cast(substring(customer_id,3) as int);";
//echo $sql_statement;
$db=pg_pConnect("host=$HOST dbname=$DATABASE");
$result=pg_Exec($db,$DATESTYLE);
$result=pg_Exec($db,$sql_statement);
echo "<head>";
echo "<title>List of accounts";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
if(pg_NumRows($result)==0)
{
echo "<center>";
echo "<h4><font size=5 color=green><blink> Please Enter Customer Details!!!</blink></font></h4>";
echo "</center>";
}

else{


echo "<table width=\"100%\">";
$color==$TCOLOR;
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td bgcolor=$color width=\"10%\" >".$row['c_id']."</td>";
echo "<td bgcolor=$color width=\"13%\" >".$row['customer_id']."</td>";
echo "<td bgcolor=$color width=\"15%\" >".ucwords($row['name1'])."</td>";
echo "<td bgcolor=$color width=\"30%\" >".ucwords($row['address11'])."</td>";
echo "<td bgcolor=$color width=\"10%\" >".ucwords($row['voter_id_no1'])."</td>";
}
echo "</table>";
}
?>
