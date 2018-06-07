<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$menu=$_REQUEST['menu'];
$id=$_REQUEST['id'];
$desc=$_REQUEST['mini_desc'];
$op_name=$_REQUEST['op_name'];
$op=$_REQUEST['op'];
$cust_lnk=$_REQUEST['cust_lnk'];
$page=3;

if(!empty($page)){$_SESSION['page']=$page;}
echo "<html>";
echo "<head>";

echo "<link rel=\"stylesheet\" href=\"../css/autosuggest_inquisitor.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\" />";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/date_validation.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"\" onload=\"customer_id.focus();\">";
echo "<center><font color=BLUE size=+3><b>MINI Customer Opening Balance Entry</b></font></center>";
$color="#6FACC9";
if (empty($op)){
echo "<hr>";
echo "<form method=\"POST\" name=\"f1\" action=\"mini_opening_bal.php?op=i\" onSubmit=\"return check();\">";
echo "<table  align=center width=80% >";
echo "<tr><TH colspan=4 bgcolor=BLUE><font color=WHITE size=+2 align=\"center\"><b>MINI Customer Opening Balance Entry form";
echo "<tr bgcolor=$color><td align=\"left\">Mini Master:<font color=\"RED\">*</font><td>";
makeSelectFromDBWithCode('Id','Mini_name','LC_Mini_Master','mini_id','','onChange=showData(this.value)');
echo "<td align=\"left\">Customer Name: <font color=\"RED\">*</font><td><span id=\"txtHint\"></span></td>";
echo "<tr bgcolor=$color> <td align=\"left\">Op Balance :<font color=\"RED\">*</font><td><input type=\"TEXT\" VALUE=\"\" name=\"op_bal\" size=\"15\" id=\"op_bal\" onkeypress=\"return numbersonly(event)\" $HIGHLIGHT >";
echo "<td align=\"left\">As On:<font color=\"RED\">*</font><td><input type=\"TEXT\" VALUE=\"$f_start_dt\" name=\"lnk_date\" size=\"15\"  $HIGHLIGHT READONLY>&nbsp;(DD/MM/YYYY)";
echo "<tr bgcolor=$color><td align=\"left\">Paid Date:<font color=\"RED\">*</font><td><input type=\"TEXT\" VALUE=".date('d/m/Y')." name=\"end_date\" size=\"15\"  $HIGHLIGHT>(DD/MM/YYYY)";
echo "<input type=\"HIDDEN\" name=\"status\" id=\"status\">";
echo "<td ><td align=\"right\" colspan=\"2\"> <input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\">";
echo "</table>";
echo "</form>";
echo "<hr>";

//--------------------------------------------------------------------------------------------------------------------------------------
$sql_statement="SELECT * FROM LC_Customerwise_Miniwise_Opening_Balance";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if (pg_NumRows($result)>0){
echo "<table bgcolor=BLACK align=center width=80% >";
echo "<tr><TH colspan=6 bgcolor=BLUE><font color=WHITE size=+2 align=\"center\"><b>MINI Customer Opening Details";
echo "<tr bgcolor=GREEN><th> Mini name<th>Customer Name<th> As On Date<th>Paid Date<th>Op Balance<th>Operator Code</tr>";
$color=$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr bgcolor=$color>";
	getCustomerIdWithMini($row['id_mini_customer_link'],&$mini_id,&$cust_id);
	echo "<td>".getName('id',$mini_id,'mini_name','lc_mini_master')."</td>";
	echo "<td>".getName('customer_id',$cust_id,'name1','customer_master')."</td>";
	echo "<td>".$row['balance_as_on']."</td>";
	echo "<td>".$row['paid_date']."</td>";
	echo "<td align=\"RIGHT\">".amount2Rs($row['amount'])."</td>";
	echo "<td>".$row['operator_code']."</td>";
	

		}


	}




}
//--------------------------------------------------------------------------------------------------------------------------------------
if ($op=='i'){
//$cust_lnk;
getCustomerIdWithMini($cust_lnk,&$mini_id,&$cust_id);
$customer_id=$cust_id;
$mini_id=$_REQUEST['mini_id'];
$link_dt=$_REQUEST['lnk_date'];
$end_dt=$_REQUEST['end_date'];
$op_bal=$_REQUEST['op_bal'];
$sql_statement="SELECT LC_Customerwise_Miniwise_Opening_Balance_Save_Fnc('$customer_id','$mini_id',$op_bal, '$link_dt','$end_dt','$staff_id',CAST('$end_dt'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP)) as fnc";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if (pg_NumRows($result)>0){
	$rns=pg_result($result,'fnc');
	if($rns==0){
		echo "<h3> <font color=\"RED\">Fail to Insert database </font></h3>";
	}
	else{
		header('location:mini_opening_bal.php');
		}
	}
}
echo "</body>";
echo "</html>";
//-----------------------------------------------------------------------------------------------------------------------------
function getCustomerIdWithMini($cust_link,$mini_id,$customer_id){
	$sql_statement="SELECT * FROM LC_Mini_Customer_Link WHERE id=$cust_link";
	$result=dBConnect($sql_statement);
	if (pg_NumRows($result)>0){
		$mini_id=pg_result($result,'id_mini_master');
		$customer_id=pg_result($result,'id_customer_master');
	}

}




?>

<script type="text/javascript">
	var options = {
		script:"mini_customer_load.php?json=true&",
		varname:"input",
		json:true,
	};
	var as_json1 = new AutoSuggest('customer_id', options);
function onLoad(x){
if(x.length>0){
		
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
    						var str=xmlhttp.responseText;
						//alert("str:"+str)
						a=str.split(',');
						//alert(a[0]+"->"+a[1])
						document.getElementById("status").value='k';
						document.f1.lnk_date.value=a[1];
						document.f1.op_bal.value=a[0];
						document.f1.op_bal.READONLY=true;
						document.f1.end_date.READONLY=false;
						
					}
					else{
						document.f1.end_date.value='';
						document.f1.end_date.READONLY=true;
						document.getElementById("status").value=''
						}
						
					}
					
				}
		
		var url="miniValidation.php?inr=1&mini_id="+x;
		xmlhttp.open("GET",url,true);
		xmlhttp.send();
		
}

else{
	//alert("Please enter the valid customer Id");
    	document.f1.customer_id.value='';
	document.f1.customer_id.focus();
	}
}
function check(){
//	alert(document.f1.mini_id.value+"->"+document.f1.mini_id.value.length);
	lnk_date=document.f1.lnk_date.value;
	end_date=document.f1.end_date.value;
	if(end_date.length==0){
	alert("Paid Date Should Not be Null")
		document.f1.end_date.focus();
		return false;
	}
	if(lnk_date.length==0){
	alert("As On Date Should Not be Null")
		document.f1.lnk_date.focus();
		return false;
	}
	if(!IsDateLess(lnk_date,end_date)){
		alert("Starting Date beyond of ending date of Financial Year")
		document.f1.lnk_date.focus();
		return false;
	}
	if(document.f1.mini_id.value.length==0){
		alert("Select Mini Name!!!!!!");
		document.f1.mini_id.focus();
		return false;
	}
	else{	
		if(document.f1.cust_lnk.value.length==0){
			alert("Invalid customer!!!!!!!!!!");
			document.f1.cust_lnk.focus();
			return false;
		}

	
	}
	if(document.f1.op_bal.value.length==0){
			alert("Opening Balance Should Not Be Null!!!!");
			document.f1.op_bal.focus();
			return false;

	}


}
function showData(x){
if(x.length>0){
		
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
						//document.getElementById("status").value='k';
					}
					else{
						document.getElementById("txtHint").innerHTML='';
						//document.getElementById("status").value='';
					}
						
					}
					
				}
		
		var url="miniValidation.php?mini_id="+x;
		
		xmlhttp.open("GET",url,true);
		xmlhttp.send();
		
}

else{
	//alert("Please enter the valid customer Id");
    	document.f1.customer_id.value='';
	document.f1.customer_id.focus();
	}
}
//-------------------------------------------------------------------------------------------------------------------------
function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	//alert(unicode)
	if (unicode!=8){ 
		if (unicode<46||unicode>57||unicode==47) {
			return false;
		
		}
	}
}
</script>
