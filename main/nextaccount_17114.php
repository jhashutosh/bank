 <?
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$module=explode("-",$account_no);
$module=strtolower($module[0]);
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
//echo "<h1>$op</h1>";
//--------------sujoy-----------------
//$account_no=$_REQUEST['account_no'];
//echo "module is:$module";
if(empty($account_no)) { $account_no="NIL"; }
if($menu=='sb'){$f_name='SB-';}
elseif($menu=='fd'){$f_name='FD-';}
elseif($menu=='ri'){$f_name='RI-';}
elseif($menu=='rd'){$f_name='RD-';}
elseif($menu=='mis'){$f_name='MIS-';}
elseif($menu=='hsb'){$f_name='HSB-';}
//elseif($menu=='cust'){$f_name='C-';$sub_name='Customer Id :';}
elseif($menu=='sh'){$f_name='M-';$sub_name='Membership Id :';}
elseif($menu=='shg'){$f_name='SHG-';$sub_name='SHG no. :';}
elseif($menu=='mt'){$f_name='MT-';}
elseif($menu=='ks'){$f_name='KS-';}
elseif($menu=='kcc'){$f_name='KCC-';}
elseif($menu=='pl'){$f_name='PL-';}
elseif($menu=='bdl'){$f_name='BDL-';}
elseif($menu=='kpl'){$f_name='KPL-';}
elseif($menu=='spl'){$f_name='SPL-';}
elseif($menu=='sfl'){$f_name='SFL-';}
elseif($menu=='ofl'){$f_name='OFL-';}
elseif($menu=='ccl'){$f_name='CCL-';}
elseif($menu=='jlg'){$f_name='JLG-';$sub_name='JLG no. :';}
elseif($menu=='add'){$f_name='ADD-';}
//-------------sujoy------------------------
elseif($menu=='rsh'){$f_name="";}
//elseif($menu=='staff'){$f_name='ST-'}
elseif($menu=='ln' || $menu=='min'||$menu=='cust'){$f_name='C-'; $sub_name='Customer Id :';}
elseif($menu=='ccb'){$f_name=''; $sub_name='Bank Name :';}
if(empty($sub_name)){$sub_name='Account No. :';}
echo "<html>";
echo "<head>";
echo "<title>Next Account";
echo "</title>";?>
<script language="javascript">
function onLoadFocus(){
var x=document.getElementById("menu").value;

if(x=="ccb"){
	document.getElementById("account_no").focus();
}
else{
	document.getElementById("name").focus();
    }
}
</script>
<?
echo "<link rel=\"stylesheet\" href=\"../css/autosuggest_inquisitor.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\" />";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"onLoadFocus();\">";
//echo "<h3>";
echo "Your present active account number is <b>$account_no</b> of <b>".$module_desc_array[$module]."</b> module.";
echo " For another account, please enter another <br> account number in the below text box and click &#187; Go.";
//echo "</h3>";
echo "<hr>";
echo "<form method=\"POST\" action=\"set_account.php?menu=$menu&op=$op\"><br>";
echo "<table>";
if($menu=='ccb'){
 echo "<tr><td align=\"left\">$sub_name<td><input type=\"TEXT\" name=\"account_no\" size=\"50\" value=\"".$f_name."\" id=\"account_no\" $HIGHLIGHT><br>";
}
elseif($menu=='rsh' && $op=='s'){
echo "<tr><td align=\"left\"><td>Sales Bill No:<input type=\"TEXT\" name=\"account_no\" size=\"30\" value=\"$f_name\" id=\"name\" $HIGHLIGHT><br>";

}
elseif($menu=='rsh' && $op=='p'){
echo "<tr><td align=\"left\"><td>Purchases Bill Id:<input type=\"TEXT\" name=\"account_no\" size=\"30\" value=\"$f_name\" id=\"name\" $HIGHLIGHT><br>";
}

else{
 echo "<tr><td align=\"left\">$sub_name<td><input type=\"TEXT\" name=\"account_no\" size=\"30\" value=\"$f_name\" id=\"name\" $HIGHLIGHT><br>";
}
echo "<td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\" &#187; Go \">";
echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Cancel\"><br>";
echo "<INPUT type=\"hidden\" value=\"$menu\" id=\"menu\">";
echo "</table>";
echo "</form>";
echo "</body>";
echo "</html>";
?>
<script type="text/javascript">
	var options = {
		script:"autoCompleteBank.php?json=true&",
		varname:"input",
		json:true,
	};
	var as_json1 = new AutoSuggest('account_no', options);
</script>

