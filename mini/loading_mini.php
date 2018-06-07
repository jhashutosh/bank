<?
include "../mini/cust_land_crop_dtl.php";
$l=$_REQUEST['l'];
$q=$_REQUEST['q'];
$a=$_REQUEST['a'];
if($q){
//echo $q;
makeSelectFromDBWithCode('c.customer_id','c.name1','customer_master c,lc_mini_customer_link l','c_id','where c.customer_id=l.id_customer_master and l.id_mini_master='.$q.'','onchange=land(this.value)');
}
if($l){
makeSelectFromDBWithCodef3('land_id','dag_no','mouja_no','customer_id','land_info','land_id',"where customer_id ='".$l."'",'onchange=area(this.value)');
}
if($a){
$sql="select land_area from land_info where land_id='$a'";
$r=dBConnect($sql);
$area=pg_result($r,'land_area');
echo"<input type='text' name='area' value='$area'>";
}
?>
