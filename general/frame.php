<?php
include "../config/config.php";
$sql_statement="
select b.account_no,a.name1,b.opening_date,b.closing_date,b.status from customer_master a,customer_account b where a.customer_id=b.customer_id and b.status='cl'
order by b.status desc
";
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


/*if($row['maturity_date']<'current_date'){
	$color="#DC143C";
	}
	else{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	}*/

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=\"5%\">$j</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=\"19%\">".($row['account_no'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=\"34%\">".($row['name1'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=\"5%\">".($row['opening_date'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=\"18%\">".($row['closing_date'])." </th>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=\"18%\"> </th>";
echo "</tr>";
}

echo "</table>";
}
?>
