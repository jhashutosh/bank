<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$menu=$_REQUEST['menu'];
isPermissible($menu);

echo "<html>";
echo "<head>";
echo "<title>SHARE";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
?>
<script type="text/javascript">

function click1(node){

	var a=document.getElementById("member_no").value;	
	//alert(a)
	node.value="";node.value=a;
//node.focus();
}

</script>
<?php

echo "<body bgcolor=\"silver\" onload=\"unit.focus();\">";
$id=getCustomerIdFromMember($account_no);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
share_current_balance($account_no,$no,$val);

echo "<form method=\"POST\" name=\"form1\" action=\"sh_ledger_wadd.php?menu=$menu\">";
echo "<table bgcolor=#D8BFD8 width=90% align=center>";
echo "<tr><th colspan=4 bgcolor=Yellow>Entry Form of $name<font size=+1>[$account_no]</font> Current balance:Value of Share:Rs. <font size=+2>$val/=</font></tr>";
echo "<tr><td align=\"left\">Membership no:<td><input type=\"TEXT\" name=\"membership_no\" size=\"20\" value=\"$account_no\" readonly $HIGHLIGHT>";
echo "<td align=\"left\">Action date:<td><input type=\"TEXT\" name=\"action_date\" size=\"12\" value=\"".date('d.m.Y')."\" $HIGHLIGHT>";
echo "&nbsp;&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.action_date,'dd/mm/yyyy','Choose Date')\">";

echo "<tr><td align=\"left\">Closing Unit:<td><input type=\"TEXT\" name=\"unit\" size=\"20\" id=\"unit\" value=\"$no\" $HIGHLIGHT><br>";
//echo "<input type=\"hidden\" name=\"close\" value=\"1\" >";

echo "<td align=\"left\">Value of Share:<td><input type=\"TEXT\" name=\"val_share\" size=\"12\" value=\"$val\" $HIGHLIGHT><br>";

echo "<tr><td>Transfer Membership No. :<td><input type=\"TEXT\" name=\"member_no\" id=\"ac\" size=\"20\"  value=\"M-\" onclick=\"return click1(this);\" $HIGHLIGHT>";
echo "&nbsp;<INPUT TYPE=\"button\" name=\"s1\" id=\"ac\" VALUE=\"Search\" onClick=\"sbChild();\">";

echo "<tr><td valign=\"top\" align=\"left\">Remarks:<td colspan=2><textarea name=\"remarks\" rows=\"3\" cols=\"49\" $HIGHLIGHT></textarea><br>";
echo "<td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Process\">";

echo "</table>";
echo "</form>";
}
echo "</body>";
echo "</html>";
?>

<SCRIPT LANGUAGE="JavaScript">
function openChild(file,window){
       	childWindow=open(file,window, 'toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=300,left=250, width=600,height=300');
    if(childWindow.opener == null) childWindow.opener = self;
    }

function sbChild(){

	var str=document.getElementById('ac').value;
//alert(str)
	if(str.length == 0){
		alert("Account No Should not be null!!!");
		//document.orderform.ac.focus();	
		return false;
	}
  	else{
		URL="../main/pop_up_account.php?menu=sh&account_no="+str;
	window.open(URL,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, scrollbars=yes,top=100,left=150,width=950,height=450');
return false;
 }
}

</SCRIPT>
