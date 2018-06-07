<?php
include "../config/config.php";
$HIGHLIGHT="onFocus=\"this.style.backgroundColor='#E5E5E5'\" style=\"font-size:12pt;\"  onBlur=\"this.style.backgroundColor='#ffffff'\"style=\"font-size:10pt; font-weight:bold; BACKGROUND-COLOR:#ffffff; BORDER-BOTTOM: #111111 1px dotted; BORDER-COLLAPSE: collapse; BORDER-LEFT: #111111 1px dotted; BORDER-RIGHT: #111111 1px dotted; BORDER-TOP: #111111 1px dotted \"";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
$op=$_REQUEST['typ'];
echo $op;
$opr=$_REQUEST['opr'];
$cust=$_REQUEST['cust'];
$cust_id=getdata($cust);
$mode=$_REQUEST['mode'];
if($mode=='c')	{$dr_gl='28101';
		 $ac_no_dr='';
		 $cr_gl=$_REQUEST['liab_cd'];
		 $ac_no_cr=$cust_id;
		}
if($mode=='d')	{$dr_gl=$_REQUEST['ast_cd'];
		 $ac_no_dr=$cust_id;
		 $cr_gl='28101';
		 $ac_no_cr='';
		}
$n=($op=='c')?'Customer':'Vendor';
if($_REQUEST['message']=='1')$message="<font color=\"red\" SIZE=\"-3\">   * Please Select Proper $n</font>";
$gl_code=($mode=='d')?$_REQUEST['ast_cd']:$_REQUEST['liab_cd'];
$amount=$_REQUEST['amount'];
$opr=(!empty($cust) && !empty($amount))?'i':'';
//echo $cust_id,$gl_code,$amount;
//echo $opr;
	if($opr=='i'){
if($op=='v'){$field='id';$table='retail_master';}
if($op=='c'){$field='customer_id';$table='customer_master';}
$id_v="select count($field) from $table where $field='$cust_id'";
$res_v=dBConnect($id_v);


if(pg_result($res_v,'count')=='0'){
header("location:tran.php?typ=$op&amount=$amount&message=1");}
else	{
$t_id=getTranId();
$sql_statement="insert into gl_ledger_hrd (tran_id,type,action_date,fy,operator_code,entry_time) values ('$t_id','adv','$date','$fy','$staff_id',now())";
$sql_statement.=";insert into gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr,account_no,particulars) values ('$t_id','$cr_gl',$amount,'Cr','$ac_no_cr','adv')";
$sql_statement.=";insert into gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr,account_no,particulars) values ('$t_id','$dr_gl',$amount,'Dr','$ac_no_dr','adv')";
$result=dBConnect($sql_statement);
//echo $sql_statement;
//echo $t_id;
	}


		}


if(!empty($op)){
$_SESSION['op']=$op;
$READONLY='';}
else
{
$READONLY='READONLY';
}
echo "<html>";
echo "<head>";
echo "<title>Advance";
echo "</title>";
echo "<link rel=\"stylesheet\" href=\"../css/autosuggest_inquisitor.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\" />";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";
echo "</head>";

if(empty($op))
echo "<body bgcolor=\"silver\">";
else
echo "<body bgcolor=\"#606060\" onload=\"fn('$op');\">";
echo "<form action=\"tran.php\" method=\"post\" name=\"f1\" onsubmit=\"return varify();\">";
echo "<table align=center width=60% bgcolor='#EFEFEF'>";
echo"<tr><td align='center' colspan='2' align='center'bgcolor='#676767'><font color='#CDCDCD' size=+3>New Advance Entry Form </th></tr>";
echo"<tr><td align='right' bgcolor=\"#EFEFEF\"><font color='#606060' size=2>Type </td><td><select name='typ'  id='typ' onchange='submit(this.form)'>";
if(empty($op))
echo"<option value=''>Select</option>";
else
echo"<option value='$op'>$n</option>";
if($op!='c')
echo"<option value='c'>Customer</option>";
if($op!='v')
echo"<option value='v'>Vendor</option>";
echo"</td></tr>";
echo "<tr style='display:none' id='trow'><td align='right' bgcolor=\"#EFEFEF\"><font color='#606060' size=2>";
echo" $n Name </td><td><input type=\"TEXT\" id=\"cust\"  name=\"cust\" size=\"25\" $HIGHLIGHT $READONLY>$message";
echo"</td></tr>";
echo"<tr style='display:none' id='trow2'><td align='right' bgcolor=\"#EFEFEF\"><font color='#606060' size=2>Advance Mode</td><td><input type='radio' name='mode' id='mode' value='d' 
onclick='dr_cr(this.value);'> Payment<input type='radio' name='mode'  id='mode1'  value='c' onclick='dr_cr(this.value);'> Received</td></tr>";
//---------------------------------------------------------------------------------------
echo"<tr style='display:none' id='trow1'><td align='right' bgcolor=\"#EFEFEF\"><font color='#606060' size=2>Purpose</td><td><select name='ast_cd' id='ast_cd'>";
$sql="select g.gl_mas_desc as ast, a.ast_code from advance_link a,gl_master g where a.ast_code=g.gl_mas_code";
$res=dBConnect($sql);
for($j;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
echo"<option value='".$row['ast_code']."'>".ucwords($row['ast'])."[".$row['ast_code']."]</option>";
}
echo"</select></td></tr>";
echo"<tr style='display:none' id='trow5'><td align='right' bgcolor=\"#EFEFEF\"><font color='#606060' size=2>Purpose</td><td><select name='liab_cd' id='liab_cd'>";
$sql="select distinct g.gl_mas_desc as liab , a.liab_code from advance_link a,gl_master g where a.liab_code=g.gl_mas_code";
$res=dBConnect($sql);
echo $sql;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
echo"<option value='".$row['liab_code']."'>".ucwords($row['liab'])."[".$row['liab_code']."]</option>";
}
echo"</select></td></tr>";
//---------------------------------------------------------------------------------------
echo"<tr style='display:none' id='trow3'><td align='right' bgcolor=\"#EFEFEF\"><font color='#606060' size=2>Amount</td><td><input type='text' VALUE='$amount' name='amount' id='amount' size='5'  $HIGHLIGHT >  Rs.</td></tr>";
echo"<tr style='display:none' id='trow6'><td align='right' bgcolor=\"#EFEFEF\"><font color='#606060' size=2>Date</td><td><input type='text' VALUE='".date('d/m/Y')."' size='8' name='date' id='date' size='5'  $HIGHLIGHT ></td></tr>";
echo"<tr style='display:none' id='trow4'><td colspan='2' align='right'><input type='submit' value='submit' onclick='return vald();'></td></tr>";
echo"</table>";
echo "</form></body>";
echo "</html>";
?>
<script type="text/javascript">
	var options = {
		script:"autoComplete.php?json=true&",
		varname:"input",
		json:true,
	};
	var as_json1 = new AutoSuggest('cust', options);

	function fn(s){
	//alert(s);
	document.getElementById('trow').style.display='';
	//document.getElementById('trow1').style.display='';
	document.getElementById('trow2').style.display='';
	document.getElementById('trow3').style.display='';
	document.getElementById('trow4').style.display='';
	document.getElementById('trow6').style.display='';
	}
	
	function dr_cr(s){
	//alert(s);
	if(s=='d'){
	document.getElementById('trow5').style.display='none';
	document.getElementById('trow1').style.display='';
	}
	if(s=='c'){
	document.getElementById('trow1').style.display='none';
	document.getElementById('trow5').style.display='';
	}
	}
	
	function vald(){
	alert(document.getElementById('mode1').checked);
	var msg='';
	var i=1;
	if(document.getElementById('typ').value=='c') var nm='Customer';
	else var nm='Vendor';
	var cst_l=parseInt(document.getElementById('cust').value.length);
	var amt_l=parseInt(document.getElementById('amount').value.length);
	var date_l=parseInt(document.getElementById('date').value.length);	
	var mode=document.getElementById('mode').checked;
	var mode1=document.getElementById('mode1').checked;
	if(cst_l==0)	msg+=(i++) +". Please Enter " +nm +" name \n";
	if(mode==false && mode1==false ) msg+=(i++) +". Please Select Advance Mode\n";
	if(amt_l==0)	msg+=(i++) +". Please Enter Amount\n";
	if(date_l==0)	msg+=(i++) +". Please Enter Date\n";
	
	if(msg=='')
	
	return true;
	
	else
	{
	//alert(msg)
	return false;
	}
	
	}
	
</script>
