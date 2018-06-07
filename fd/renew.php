<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no_from_main=$_REQUEST['account_no'];
$menu=$_REQUEST['menu'];
if(empty($account_no_from_main))
	{
	$account_no=$_SESSION["current_account_no"];
	}
else
	{
	$account_no=$account_no_from_main;
	$_SESSION['current_account_no']=$account_no;
	$_SESSION['current_account_type']=$menu;
	}
isPermissible($menu);
?>
<html>
<head>
<title>FD Renewal</title>
<link rel="stylesheet" type="text/css" href="../css/test.css" />
</head>
<body bgcolor="silver" onload="withdrawal_date.focus();">

<?php
$sql1="SELECT (CURRENT_DATE-maturity_date) as days  FROM deposit_info WHERE account_no='$account_no' and account_type='fd' and withdrawal_type is null";

	$res=dBConnect($sql1);
	$row1=pg_fetch_array($res,0);
	$days=$row1['days'];

if($days<0)
		{
		echo "<h1><center><b><blink><font size=\"+8\" color=red>This Account No Is Not Mature!!!!!!!!!!!</h1></center>";
		}
		else
			{

$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);

if($flag==1)	{
echo "<hr>";
$sql_statement="select * from deposit_info where account_no='$account_no' and  withdrawal_date  is null AND action_date<=current_date";
$result=dBConnect($sql_statement);
$maturity_amount=pg_result($result,'maturity_amount');
$principal=pg_result($result,'principal');
$certificate_no=pg_result($result,'certificate_no');
$with_int=pg_result($result,'withdrawal_interest');
$interest=$maturity_amount - $principal-$with_int;
$maturity_date=pg_result($result,'maturity_date');
if(pg_NumRows($result)==0)
 {
  echo "<h1><font color=RED align=CENTER><b>Your Account no is Wrong or You don't have any RI !!!!!!!!!</b></h1></font>";
 }
else
{
 echo "<form method=\"POST\" action=\"renew_evf.php?menu=$menu&sb_account_no=$sb_account_no&account_no=$account_no&period=$period&date_with_effect=$date_with_effect&withdrawal_date=$withdrawal_date&r1=$r1&interest=$interest\">";
?>

<table bgcolor="#3CB371" align="center" width="100%" >
	<tr>
		<th colspan="6" bgcolor="Yellow">
			Renewal Form of [<?echo $account_no?>]
		</th>
	</tr>

	<tr>
		<td align="left" colspan=1>
			Account no:
		</td>

		<td>
			<?echo $account_no ?>
			<input type="hidden" name="account_no" value="<?echo $account_no?>">
		</td>

		<td align="left" colspan=1>
			Renewal Date:
		</td>
		
		<td>
			<input type="TEXT" name="withdrawal_date" size="8" id="withdrawal_date" 
			value="<?echo date('d.m.Y')?>" <? echo $HIGHLIGHT?>>
		</td>

		<td align="left" colspan=1>
			Certificate no:
		</td>
	
		<td><?echo $certificate_no?>
			<input type="hidden" name="certificate_no" value="<?echo $certificate_no?>">
		</td>
	</tr>


	<tr>
		
		<td>
			Renewal Type : 

		</td>

		<td colspan="3" align="left">	
			<select NAME="ren_type" onchange="check(this.value);">

				<option value="tot">Both Interest & Principal</option>
				<option value="tr_sb">Only Principal (Interest Transfer to SB)</option>
				<option value="ca_with">Only Principal (Interest withdrawal by cash)</option>
			</select>
		</td>
	
		<td align="left" colspan=1 id="sb_ac_dis1" style="display:none"> 
			
			SB A/C No.:
		</td>

		<td id="sb_ac_dis2" style="display:none">

			<!--<select name="sb_account_no">-->
			 <?php
$sql="SELECT account_no FROM customer_account WHERE account_type='sb' AND status='op' and customer_id=(SELECT customer_id FROM customer_account WHERE account_no='$account_no')";
$res=dBConnect($sql);?>

			<INPUT TYPE="text" name="sb_account_no" size="5" value="<?echo pg_result($res,'account_no');?>" <?echo $HIGHLIGHT?>>
			
		</td>
	


	</tr>

	<tr>
		<td align="left">
		
			Renewal Amount :

		</td>

		<td>
			 Rs. <input type="TEXT" name="renew_amt" id="renew_amt" size="7" value="<?echo $principal+$interest?>"  <? echo $HIGHLIGHT?>>

<input type="hidden" name="prin" id="prin" size="7" value="<?echo $principal?>">
<input type="hidden" name="prin_int" id="prin_int" size="7" value="<?echo $principal+$interest?>">

		
		</td>

		<td align="left"  id="int_dis1" style="display:none">
		
			Interest <input type="text" size="5" style="border:none;background-color:#3CB371;" id="int_with_type" readonly> Amount :

		</td>

		<td  id="int_dis2" style="display:none">
			 Rs. <input type="TEXT" name="int_with_amt" id="int_with_amt" size="3" value="<?echo $interest?>"  <? echo$HIGHLIGHT?>>

		
		</td>


		<td align="left" colspan=1>
			New Certificate no:
		</td>
	
		<td>
			<input type="text" name="certificate_no_new" size="11" value="<?echo $account_no.'/'.date('dmy')?>" <?echo $HIGHLIGHT ?>>
		</td>

	</tr>

	<tr>

		<td align="left" colspan="1">

			Date With Effect:
		</td>


		<td>
			<input type="TEXT" name="date_with_effect" size="8" value="<?echo $maturity_date?>" <?echo $HIGHLIGHT?>>

		</td>
		
		<td align="left">
		
			Period :

		</td>

		<td>
			<input type="TEXT" name="period" id="period" size="3" <? echo$HIGHLIGHT?>> days

		
		</td>

	<td align="left">
		
			Scheme :

		</td>

		<td>
			<?echo makeSelect($scheme_array,"scheme","Normal Deposit");?>
		
		</td>


	</tr>

 	<tr>
		<td align="right" colspan='6'>
	
			<input type="SUBMIT" name="SUBMIT_BUTTON" value="Proceed">
		</td>
  	</tr>
	
</table>
</form>
<?php
 }
		}
			}
?>
</body>
</html>

<script language=javascript>
function check(x){
	//alert(x)
var pr_in=parseFloat(document.getElementById('prin_int').value);
var inte=parseFloat(document.getElementById('int_with_amt').value);
var prin=pr_in-inte;
	if(x=='tr_sb'){
		
		document.getElementById('sb_ac_dis1').style.display='';
		document.getElementById('sb_ac_dis2').style.display='';
		document.getElementById('int_dis1').style.display='';
		document.getElementById('int_with_type').value="transfer";
		document.getElementById('renew_amt').value=prin;
		document.getElementById('int_dis2').style.display='';
		
	}
	else{
		document.getElementById('sb_ac_dis1').style.display='none';
		document.getElementById('sb_ac_dis2').style.display='none';
		
		if(x=='tot')	{

		document.getElementById('int_dis1').style.display='none';
		document.getElementById('int_dis2').style.display='none';
		document.getElementById('renew_amt').value=pr_in;

				}
		else 	{
		document.getElementById('renew_amt').value=prin;
		document.getElementById('int_dis1').style.display='';
		document.getElementById('int_with_type').value="withdraw";
		document.getElementById('int_dis2').style.display='';
			}

		

	}
}
function varify_sb(x){
	//alert(document.getElementById('r1').value)
	if(document.getElementById('r1').checked){
		
		if(document.getElementById('sb_account_no').value.length==0){
		alert("Select Account No before submit");
		return false;
		}
		if(document.getElementById('interest').value.length==0){
		alert("Please Enter the valid Interest");
		document.getElementById('interest').focus();
		return false;
		}


	}



}
</script>
