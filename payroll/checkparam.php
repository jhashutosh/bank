<?
include "../config/config.php";
$staff_id=verifyAutho();
$date=$_REQUEST['date'];
	if(empty($date))
		{ echo"<font color='red'>Please Enter Date with Effect</font>";}
	else
		{
		$sql_statement="select count(*),case when to_date('$date','dd/mm/yyyy') between '1950-01-01' and '2100-01-01' then 1 else 0 end as val from emp_sal_param where effected_from=to_date('$date','dd/mm/yyyy')";
		//echo "$sql_statement";
		$result=dBConnect($sql_statement);
		$row=pg_fetch_array($result,0);
		if($row['count']==0 and $row['val']==1){echo 1;}
		else{echo "<font color='red'>Enter Proper Date </font>";}
		}

?>
