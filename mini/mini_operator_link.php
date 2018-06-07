<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$id=$_REQUEST['id'];
$desc=$_REQUEST['mini_desc'];
$op_name=$_REQUEST['op_name'];
$op=$_REQUEST['op'];

$page=2;
if(!empty($page)){$_SESSION['page']=$page;}

echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" href=\"../css/autosuggest_inquisitor.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\" />";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/date_validation.js\"></script>";
echo "<title>Mini Operator Link</title>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"customer_id.focus();\">";
echo "<center><font color=BLUE size=+3><b>MINI Operator Link</b></font></center>";
$color="#839EB8";
if (empty($op)){
echo "<hr>";
echo "<form method=\"POST\" name=\"f1\" action=\"mini_operator_link.php?op=i\" onSubmit=\"return check();\">";
echo "<table bgcolor=BLACK align=center width=80% >";
echo "<tr><TH colspan=4 bgcolor=BLUE><font color=WHITE size=+2 align=\"center\"><b>MINI Operator Link form";
echo "<tr bgcolor=$color><td align=\"left\">Mini Master:<font color=\"RED\">*</font><td>";
makeSelectFromDBWithCode('Id','Mini_name','LC_Mini_Master','mini_id');
echo "<td align=\"left\">Operator Name: <font color=\"RED\">*</font><td><input type=\"TEXT\" name=\"customer_id\" size=\"30\" id=\"customer_id\"    onfocus=\"show(this.value)\" onchange=\"show(this.value)\" $HIGHLIGHT>";
echo "<tr bgcolor=$color><td align=\"left\">Link Date:<font color=\"RED\">*</font><td><input type=\"TEXT\" VALUE=\"".date('d/m/Y')."\" name=\"lnk_date\" size=\"15\"  $HIGHLIGHT>&nbsp;(DD/MM/YYYY)";
echo "<td align=\"left\">End Date:<font color=\"RED\">*</font><td><input type=\"TEXT\" VALUE=".date('d/m/Y')." name=\"end_date\" size=\"15\"  $HIGHLIGHT>(DD/MM/YYYY)";
echo "<input type=\"HIDDEN\" name=\"status\" id=\"status\">";
echo "<tr bgcolor=$color><td colspan=3><span id=\"txtHint\"></span><td align=\"right\"> <input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\">";
echo "</table>";
echo "</form>";
echo "<hr>";
 
//--------------------------------------------------------------------------------------------------------------------------------------
$sql_statement="SELECT * FROM LC_Mini_Operator_Link";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if (pg_NumRows($result)>0){
echo "<table bgcolor=BLACK align=center width=80% >";
echo "<tr><TH colspan=5 bgcolor=BLUE><font color=WHITE size=+2 align=\"center\"><b>MINI Operator Link Details";
echo "<tr bgcolor=GREEN><th> Mini name<th>Operator Name<th> Link Date<th>End Date<th>Staff Code</tr>";
$color=$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr bgcolor=$color>";
	echo "<td>".getName('id',$row['id_mini_master'],'mini_name','lc_mini_master')."</td>";
	echo "<td>".getName('id',$row['id_operator_master'],'operator_name','lc_operator_master')."</td>";
	echo "<td>".$row['link_date']."</td>";
	echo "<td>".$row['end_date']."</td>";
	echo "<td>".$row['operator_code']."</td>";
	

		}


	}




}
//--------------------------------------------------------------------------------------------------------------------------------------
if ($op=='i'){
$customer_id=getData($_REQUEST['customer_id']);
$mini_id=$_REQUEST['mini_id'];
$link_dt=$_REQUEST['lnk_date'];
$end_dt=$_REQUEST['end_date'];
$sql_statement="SELECT LC_Mini_Operator_Link_Save_Fnc($mini_id,$customer_id,'$link_dt','$end_dt','$staff_id',CAST('$end_dt'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP)) as fnc";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if (pg_NumRows($result)>0){
	$rns=pg_result($result,'fnc');
	if($rns==0){
		echo "<h3> <font color=\"RED\">Fail to Insert database </font></h3>";
	}
	else{
		header('location:mini_operator_link.php');
		}
	}
}
echo "</body>";
echo "</html>";
?>

<script type="text/javascript">
	var options = {
		script:"mini_customer_load.php?json=true&",
		varname:"input",
		json:true,
	};
	var as_json1 = new AutoSuggest('customer_id', options);

function check(){
	//showData(document.f1.customer_id.value);
	//alert(document.f1.status.value+" ->"+document.f1.status.value.length);
	lnk_date=document.f1.lnk_date.value;
	end_date=document.f1.end_date.value;
	if(end_date.length==0){
	alert("Ending Date Should Not be Null")
		document.f1.end_date.focus();
		return false;
	}
	if(lnk_date.length==0){
	alert("Link Date Should Not be Null")
		document.f1.lnk_date.focus();
		return false;
	}
	if(!IsDateLess(lnk_date,end_date)){
		alert("Starting Date beyond of ending date of Financial Year")
		document.f1.lnk_date.focus();
		return false;
	}
	if(document.f1.status.value.length==0){
		alert("Invalid Operator!!!!!!!!!!");
		document.f1.customer_id.focus();
		return false;
	
	}


}
function showData(x){
	

if(x.length>0){
		var m_id=document.f1.mini_id.value;
		var c_id=document.f1.customer_id.value;
		//document.f1.en_no.value=en_no;
		if (window.XMLHttpRequest) // code for IE7+, Firefox, Chrome, Opera, Safari
 			{
  				xmlhttp=new XMLHttpRequest();
  			}
		else		// code for IE6, IE5
  			{
  				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 			 }

		xmlhttp.onreadystatechange=function() {
  			if (xmlhttp.readyState==4 && xmlhttp.status==200)
    				{
					if(xmlhttp.responseText.length>12){
    						document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
						document.getElementById("status").value='';
					}
					else{
						//document.getElementById("txtHint").innerHTML='Valid Customer';
						document.getElementById("txtHint").innerHTML='';
						document.getElementById("status").value='k';
					}
					
					
    				}
  			}
		var url="miniValidation.php?menu=mcl&customer_id="+c_id+"&mini_id="+m_id;
		xmlhttp.open("GET",url,true);
		xmlhttp.send();
		
}

else{
	//alert("Please enter the valid customer Id");
    	document.f1.customer_id.value='';
	document.f1.customer_id.focus();
	}
}
function show(x){


	document.getElementById("status").value='';
	//alert(document.f1.status.value+"->"+document.f1.status.value.length)
	showData(x);


}
</script>
