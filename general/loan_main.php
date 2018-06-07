<?php
include "../config/config.php";
$menu=$_REQUEST['menu'];
$account_no=$_REQUEST['account_no'];
$op=$_REQUEST['op'];
//echo "<h1>MENU:$menu</h1>";
$staff_id=verifyAutho();
if($menu=='kcc'){$l_name='KCC';$status='kcc';}
if($menu=='lad'){$l_name='LAD';$status='lad';}
if($menu=='mt'){$l_name='MT';$status='mt';}
if($menu=='mtb'){$l_name='MTB';$status='mtb';}
if($menu=='ser'){$l_name='SER';$status='ser';}
if($menu=='hbl'){$l_name='HBL';$status='hbl';}

if($menu=='car'){$l_name='CAR';$status='car';}
if($menu=='ks'){$l_name='KS';$status='ks';}
if($menu=='pl'){$l_name='PLEDGE';$status='pl';}
if($menu=='sgl'){$l_name='SHG';$status='sgl';}
if($menu=='jgl'){$l_name='JLG';$status='jgl';}
if($menu=='ccl'){$l_name='Cash Credit';$status='ccl';}
if($menu=='kpl'){$l_name='Kishan Bikhash Pathra';$status='kpl';}
if($menu=='bdl'){$l_name='Bond';$status='bdl';}
if($menu=='sfl'){$l_name='Staff';$status='sfl';}
if($menu=='ofl'){$l_name='Own Fud Loan';$status='ofl';}
if($menu=='spl'){$l_name='SMP';$status='spl';}
if($menu=='sao'){$l_name='SAO';$status='sao';}
if($menu=='fis'){$l_name='Fisary';$status='fis';}
if($menu=='ser'){$l_name='SER';$status='ser';}
if($menu=='nf'){$l_name='NF';$status='nf';}
if(empty($op)){$op='a';}
if($op=='a'){$name="All Account List";}
if($op=='i'){$name='New Account List';}
if($op=='d'){$name="Due Account List";}
if($op=='o'){$name='Over Due Account List';}
$WHERE_CONDITIONS="action_date=current_date";
if(!empty($account_no)){
	$arr=explode(",",$account_no); // Multiple entry seperated by ,
	$n=count($arr);
	for($i=0; $i<($n-1);$i++){
		$WHERE_CONDITIONS="$WHERE_CONDITIONS AND account_no='$arr[$i]' OR ";
	}
 
	$WHERE_CONDITIONS="WHERE $WHERE_CONDITIONS AND account_no='$arr[$i]'"; 
	$name='Account No List';
	
} else {
	if($op=='d'||$op=='o'||$op=='i'){
		$WHERE_CONDITIONS="WHERE $WHERE_CONDITIONS AND loan_type='$status' AND status='$op'"; 
       }else{
		$WHERE_CONDITIONS="WHERE $WHERE_CONDITIONS AND loan_type='$status'";
	
	    }
	$name=$name;
	}

echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<script language="javascript">
function onSubmits(f)
{
  f.submit();
}

function alert1(node){
	node.value="";
	node.value=document.getElementById("ac_ty").value;
	document.getElementById("hintspan").innerHTML="";
	//node.focus
	//alert("You can't select.");
	return false;
}
function click1(node){
	var a=document.getElementById("account_no").value;	
	node.value="";node.value=a;
//node.focus();
}
function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	//alert(unicode)
	if (unicode!=8){ 
		if (unicode<46||unicode>57||unicode==47) {
			return false;		
		}
	}
	else{
if(document.getElementById("ac_ty").value==document.getElementById("account_no").value){return false;}else{return true;}
	
	}
}
function showaccounthints(e){
		if(e.type=='blur'){
		document.getElementById("account_no").style.backgroundColor='white';

		}
		
		//alert("okkkkk");return true;
		var a1=document.getElementById("account_no").value;
		var a2=document.getElementById("ac_ty").value;
		if(a1!=a2){
		
		var account_no =a1;
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
				if(xmlhttp.responseText==1){
				document.getElementById("hintspan").innerHTML="<blink><font color=\"dark green\"><em>OK</em></font></blink>";
				document.getElementById("submit").disabled=false;		
				return true;
				}
				else{
				document.getElementById("hintspan").innerHTML=xmlhttp.responseText;
				document.getElementById("submit").disabled=true;return true;	
				}		
					
    				}
  			}
		
		xmlhttp.open("GET","checkaccountno.php?account_no="+account_no+"&menu=kcc",true);
		xmlhttp.send();
		//alert()
	}
	else{document.getElementById("hintspan").innerHTML="";}
}
</script>
<?php
echo "</head>";
echo "<body bgcolor=\"silver\">";
$sql_statement="SELECT loan_calculation('$status',current_date) as int";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_result($result,'int')=='k'){
$sql_statement="SELECT COUNT(*) as row_no,round(SUM(d)) as due,round(SUM(o)) as odue,round(SUM(p)) as principal FROM (select SUM(due_int) as d,SUM(overdue_int) as o,SUM(principal) as p from loan_cal_int  $WHERE_CONDITIONS group by account_no) as foo";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
	$no_row=pg_result($result,'row_no');
	$due_int=pg_result($result,'due');
	$odue_int=pg_result($result,'odue');
	$principal=pg_result($result,'principal');
}
else{
	$no_row=0;
	$due_int=0;
	$odue_int=0;
	$principal=0;
}
echo "<form action=\"loan_main.php\">";
//echo "<h1>MENU=$menu</h1>";
echo "<table width=\"100%\" bgcolor=\"yellow\" align=\"center\"><tr><th>";
echo "Viewing Option :&nbsp";
echo "<select name=\"op\" onchange=\"onSubmits(this.form);\">";
echo "<option value=\"s\">Select";
echo "<option value=\"a\">All List";
echo "<option value=\"d\">Due List";
echo "<option value=\"o\">Overdue List";
echo "<option value=\"i\">New List";
echo "</select>"; 
echo " <input type=\"HIDDEN\" value=\"$menu\" name=\"menu\"readonly>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Search By Account No: <input type=\"HIDDEN\" name=\"ac_ty\" id=\"ac_ty\" size=5 value=\"".strtoupper($l_name)."-\" readonly><input type=\"text\" name=\"account_no\" id=\"account_no\" value=\"".strtoupper($l_name)."-\" onkeyup=\"return showaccounthints(event);\" onblur=\"return showaccounthints(event);\" onselect=\"return alert1(this);\" onclick=\"return click1(this);\" onkeypress=\"return numbersonly(event);\" $HIGHLIGHT>&nbsp;<span id=\"hintspan\"></span>";
echo"<tr bgcolor=\"yellow\"><td  align=\"right\"><input type=\"SUBMIT\" name=\"submit\" value=\"Enter\" ></tr></tr>";
echo "</table>";
echo "<table  width=\"100%\">";
//echo"<tr bgcolor=\"yellow\"><td colspan=\"11\" align=\"right\"><input type=\"SUBMIT\" name=\"submit\" value=\"Enter\" ></tr></tr>";
echo "<tr><td bgcolor=\"#808000\" colspan=\"10\" align=\"center\"><font color=\"white\"><b>MAIN MENU OF $l_name of $name as on ".date('d.m.Y')."</font>";
echo "</form>";
$color="GREEN";
echo "<tr>";
echo "<th bgcolor=$color width =\"80\" Rowspan=\"2\">A/C No</th>";
echo "<th bgcolor=$color width =\"200\" Rowspan=\"2\">Name</th>";
echo "<th bgcolor=$color width=\"80\" Rowspan=\"2\">Principal<br>(Rs.)</th>";
echo "<th bgcolor=$color width =\"150\" colspan=\"2\">Interest</th>";
echo "<th bgcolor=$color width =\"80\" Rowspan=\"2\">Total<br>(Rs.)</th>";

if($menu=='kcc')
{
echo "<th bgcolor=$color width=\"70\"Rowspan=\"2\">Total Land</th>";
echo "<th bgcolor=$color width=\"80\" Rowspan=\"2\">Value of Share(Rs.)</th>";
}
echo "<th bgcolor=$color Rowspan=\"2\">Operation</th>";
echo "<tr><th bgcolor=$color width =\"75\">Due</th>";
echo "<th bgcolor=$color width =\"75\">Overdue</th>";
echo "<tr><td colspan=\"10\" align=\"center\"><iframe src=\"loan_main_db.php?menu=$menu&c=$WHERE_CONDITIONS\" width=\"900%\" height=\"350\"></iframe></td></tr>";

echo "<tr bgcolor=\"AQUA\"><th colspan=\"2\">Total:  ".$no_row." Account Found!!!!!<th align=\"right\">$principal <th align=\"right\">$due_int<th align=\"right\">$odue_int<th align=\"right\">".($principal+$due_int+$odue_int)."<th>";
if($menu=='kcc')
{
echo "<th colspan=\"2\">";

}
echo "</table>";
	
}
else{
echo "<h1>Record Not Found!!!!!!</h1>";

}
echo "</body>";
echo "</html>";
?>
