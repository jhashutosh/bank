<?include "../config/config.php";
echo $id;

function cust_ven_name($id)
	{
	$id_p=explode('-',$id);
	echo $id_p[0];
	if($id_p[0] =='C')
		{
		$field='name1';
		$table='customer_master';
		$filter='customer_id';
		}
	if($id_p[0] =='V')
		{
		$field='name';
		$table='retail_master';
		$filter='id';
		}
	$sql_statement="select $field from $table where $filter='$id'";
	echo $sql_statement;	
	$result=dBConnect($sql_statement);
	$name=pg_result($result,$field);
	return $name;
	}

$n=cust_ven_name($id);

echo "<h1>hiiiii:$n</h1>";

?>
