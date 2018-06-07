<?php
include "../../config/config.php";

$staff_id=verifyAutho();
//$menu=$_REQUEST['menu'];

if(empty($_REQUEST['OFSET_DEFAULT'])){$OFSET_DEFAULT=0;}
else{$OFSET_DEFAULT=$_REQUEST['OFSET_DEFAULT'];}

echo "<html>";
echo "<head>";
echo "<title>  Customer Summary";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<center>";
echo "<font size=5 color=blue align=center>Customer Summary</font>";
echo "</center>";
echo "<br>";

echo "<table width=90% align=center class=border>";
echo "<tr><th colspan=\"8\" bgcolor=#a9a9a9><font color=white size=5>  Caste and Group wise Customer report</th>";
echo "</tr>";
$color="#CCCCC5555";
echo "<tr>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Caste</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Member</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Non-member</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Total </th>";

echo "</tr>";
echo "<tr>";

echo "<th colspan=\"1\" bgcolor=\"$color\">Male</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">Female</th>";

echo "<th colspan=\"1\" bgcolor=\"$color\">Male</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">Female</th>";


echo "</tr>";
/////////////////////////////////------------- coding area---------------------------------//////////////////////////////////////
///////////////////////// eta male er jonno----------------------for 
$sql_statement="select a.c1,b.c2,c.c3,d.c4 from 
(
select count(sex1) as c1
from customer_master
where sex1='m' and customer_status='mem' and caste1='Gen') a,

(select count(sex1) as c2
from customer_master
where sex1='f' and customer_status='mem' and caste1='Gen') b,

(select count(sex1) as c3
from customer_master
where sex1='m' and customer_status='non' and caste1='Gen') c,

(select count(sex1) as c4
from customer_master
where sex1='f' and customer_status='non' and caste1='Gen') d";


$sql_statement5= "select count(sex1) as c5 from customer_master where caste1= 'Gen' and sex1 in('m','f')";
//echo $sql_statement5;exit;
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);
$result5=dBConnect($sql_statement5);
$row5=pg_fetch_array($result5);
echo "<tr>";
$color=$TBCOLOR;
echo "<th colspan=\"1\" bgcolor=\"$color\">GENERAL</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row['c1'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row['c2'])." </th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row['c3'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row['c4'])." </th>";
$x=($row['c1']+$row['c2']+$row['c3']+$row['c4']);
echo "<th colspan=\"1\" bgcolor=\"$color\">$x</th>";
echo "</tr>";
$mou=$row5['c5'];
$sql_statement1="select a.c1,b.c2,c.c3,d.c4 from 
(
select count(sex1) as c1
from customer_master
where sex1='m' and customer_status='mem' and caste1='SC') a,

(select count(sex1) as c2
from customer_master
where sex1='f' and customer_status='mem' and caste1='SC') b,

(select count(sex1) as c3
from customer_master
where sex1='m' and customer_status='non' and caste1='SC') c,

(select count(sex1) as c4
from customer_master
where sex1='f' and customer_status='non' and caste1='SC') d";
//echo $sql_statement;exit;
$sql_statement6= "select count(sex1) as c6 from customer_master where caste1= 'SC'";
$result1=dBConnect($sql_statement1);
$row1=pg_fetch_array($result1);
$result6=dBConnect($sql_statement6);
$row6=pg_fetch_array($result6);
echo "<tr>";
$color=$TCOLOR;
echo "<th colspan=\"1\" bgcolor=\"$color\">SC</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row1['c1'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row1['c2'])." </th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row1['c3'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row1['c4'])." </th>";
$y=($row1['c1']+$row1['c2']+$row1['c3']+$row1['c4']);
echo "<th colspan=\"1\" bgcolor=\"$color\">$y </th>";
echo "</tr>";
$mou1=$row6['c6'];
$sql_statement2="select a.c1,b.c2,c.c3,d.c4 from 
(
select count(sex1) as c1
from customer_master
where sex1='m' and customer_status='mem' and caste1='ST') a,

(select count(sex1) as c2
from customer_master
where sex1='f' and customer_status='mem' and caste1='ST') b,

(select count(sex1) as c3
from customer_master
where sex1='m' and customer_status='non' and caste1='ST') c,

(select count(sex1) as c4
from customer_master
where sex1='f' and customer_status='non' and caste1='ST') d";
//echo $sql_statement;exit;
$sql_statement7= "select count(sex1) as c6 from customer_master where caste1= 'ST'";
$result2=dBConnect($sql_statement2);
$row2=pg_fetch_array($result2);
$result7=dBConnect($sql_statement7);
$row7=pg_fetch_array($result7);
echo "<tr>";
$color=$TBCOLOR;
echo "<th colspan=\"1\" bgcolor=\"$color\">ST</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row2['c1'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row2['c2'])." </th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row2['c3'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row2['c4'])." </th>";
$z=($row2['c1']+$row2['c2']+$row2['c3']+$row2['c4']);

echo "<th colspan=\"1\" bgcolor=\"$color\">$z</th>";
echo "</tr>";
$mou2=$row7['c6'];
$sql_statement3="select a.c1,b.c2,c.c3,d.c4 from 
(
select count(sex1) as c1
from customer_master
where sex1='m' and customer_status='mem' and caste1='OBC') a,

(select count(sex1) as c2
from customer_master
where sex1='f' and customer_status='mem' and caste1='OBC') b,

(select count(sex1) as c3
from customer_master
where sex1='m' and customer_status='non' and caste1='OBC') c,

(select count(sex1) as c4
from customer_master
where sex1='f' and customer_status='non' and caste1='OBC') d";
//echo $sql_statement;exit;
$sql_statement8= "select count(sex1) as c6 from customer_master where caste1= 'OBC'";
$result3=dBConnect($sql_statement3);
$row3=pg_fetch_array($result3);
$result8=dBConnect($sql_statement8);
$row8=pg_fetch_array($result8);
echo "<tr>";
$color=$TCOLOR;
echo "<th colspan=\"1\" bgcolor=\"$color\">OBC</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row3['c1'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row3['c2'])." </th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row3['c3'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row3['c4'])." </th>";
$w=($row3['c1']+$row3['c2']+$row3['c3']+$row3['c4']);


echo "<th colspan=\"1\" bgcolor=\"$color\">$w</th>";
echo "</tr>";
$mou3=$row8['c6'];

$sql_statement4="select a.c1,b.c2,c.c3,d.c4 from 
(
select count(sex1) as c1
from customer_master
where sex1='m' and customer_status='mem' and caste1='min') a,

(select count(sex1) as c2
from customer_master
where sex1='f' and customer_status='mem' and caste1='min') b,

(select count(sex1) as c3
from customer_master
where sex1='m' and customer_status='non' and caste1='min') c,

(select count(sex1) as c4
from customer_master
where sex1='f' and customer_status='non' and caste1='min') d";
//echo $sql_statement;//exit;
$sql_statement9= "select count(sex1) as c6 from customer_master where caste1= 'min'";
$result4=dBConnect($sql_statement4);
$row4=pg_fetch_array($result4);
$result9=dBConnect($sql_statement9);
$row9=pg_fetch_array($result9);
echo "<tr>";
$color=$TBCOLOR;
echo "<th colspan=\"1\" bgcolor=\"$color\">MINORITY</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row4['c1'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row4['c2'])." </th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row4['c3'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row4['c4'])." </th>";
$t=($row4['c1']+$row4['c2']+$row4['c3']+$row4['c4']);



echo "<th colspan=\"1\" bgcolor=\"$color\">$t</th>";
echo "</tr>";
$mou4=$row9['c6'];
/////////////////////////////////// ADD-ons/////////////////////////////////////

$sql_statement5=" select a.c1,b.c2,c.c3,d.c4 from (select count(sex1) as c1
from customer_master
where customer_status='mem' and sex1='m'
group by sex1) a,
(
select count(sex1) as c2
from customer_master
where customer_status='mem' and sex1='f'
group by sex1) b,
(
select count(sex1) as c3
from customer_master
where customer_status='non' and sex1='m'
group by sex1) c,
(
select count(sex1) as c4
from customer_master
where customer_status='non' and sex1='f'
group by sex1) d";
//echo "$sql_statement5";//exit;
$result5=dBConnect($sql_statement5);
$row5=pg_fetch_array($result5);
$mou5=$mou+$mou1+$mou2+$mou3+$mou4;
echo "<tr>";
$color=$TCOLOR;
echo "<th colspan=\"1\" bgcolor=\"$color\">Total</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row5['c1'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row5['c2'])." </th>";
/////////////// changes///////////////////
$nt=$row['c3']+$row1['c3']+$row2['c3']+$row3['c3']+$row4['c3'];
$nt1=$row['c4']+$row1['c4']+$row2['c4']+$row3['c4']+$row4['c4'];
echo "<th colspan=\"1\" bgcolor=\"$color\">$nt</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">$nt1</th>";
//echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row5['c3'])."</th>";
//echo "<th colspan=\"1\" bgcolor=\"$color\">".ucwords($row5['c4'])." </th>";
$b=$x+$y+$z+$t+$w;


echo "<th colspan=\"1\" bgcolor=\"$color\">$b</th>";
echo "</tr>";


/*"select a.c1,b.c2,c.c3,d.c4 from 
(
select count(sex1) as c1
from customer_master
where sex1='m' and customer_status='mem' and caste1='min') a,

(select count(sex1) as c2
from customer_master
where sex1='f' and customer_status='mem' and caste1='min') b,

(select count(sex1) as c3
from customer_master
where sex1='m' and customer_status='non' and caste1='min') c,

(select count(sex1) as c4
from customer_master
where sex1='f' and customer_status='non' and caste1='min') d";*/

/////////////////////////////////////////////////
echo "</table>";
//echo "<p><font size=4 color=green align=center>Sole Account Record =$so</font>&nbsp";
//echo "<p><font size=4 color=green align=center>NREGS Account Record =$nr</font>";
//echo "<p><font size=4 color=green align=center> Organizational Account Record =$or</font>";
//echo "<p><font size=4 color=green align=center>Joint Account Record =$jn</font>";
//echo "<p><font size=4 color=green align=center> Group Account Record =$gp</font> ";
//echo "<p><font size=4 color=green align=center> No of Member Record =$member</font> ";





echo "</body>";
echo "</html>";
?>
