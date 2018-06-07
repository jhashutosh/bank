<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$start_dt=$_REQUEST['start_dt'];
$end_dt=$_REQUEST['end_dt'];
if(empty($start_dt)){$start_dt=date("d.m.Y",time()-604600);}
if(empty($end_dt)){$end_dt=date("d.m.Y");}
echo "<html>";
echo "<head>";
echo "<title>Vouchar Details";
echo "</title>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"start_dt.focus();\">";
//------------------------------------------------------------------------------------------------
echo "<form name=\"form1\" action=\"voucherDaily.php\"method=\"post\">";
echo "<table align =\"center\" width =\"100%\" Bgcolor=\"\" class=\"border\"><tr>";
echo "<td>Date Between :&nbsp;<td><input type=\"TEXT\" name=\"start_dt\" id=\"start_dt\" value=\"$start_dt\" onclick=\"this.value=' '\" $HIGHLIGHT> AND <input type=\"TEXT\" name=\"end_dt\" id=\"end_dt\" value=\"$end_dt\" onclick=\"this.value=' '\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"SUBMIT\" VALUE=\"ENTER\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table>";
echo "</form>";
echo "<hr>";

//------------------------------------------------------------------------------------------------
$sql_statement="SELECT * FROM gl_ledger_hrd WHERE action_date BETWEEN '$start_dt' AND '$end_dt'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
 echo "<h1><font color=red><b>Sorry Header Information Not Found!!!!!!!!!</b></font></h1>";
}
else{
echo "<table align =\"center\" width =\"100%\" class=\"border\">";
echo "<tr>";
echo "<th bgcolor=\"GREEN\" rowspan=\"2\">Action Date";
echo "<th bgcolor=\"GREEN\" rowspan=\"2\">Transaction Id";
echo "<th bgcolor=\"GREEN\" colspan=\"2\">Account Header";
echo "<th bgcolor=\"GREEN\" rowspan=\"2\">Remarks";
echo "<th bgcolor=\"GREEN\" rowspan=\"2\">Staff Id";
echo "<tr>";
echo "<th bgcolor=\"GREEN\" colspan=\"1\">Header(Dr)";
echo "<th bgcolor=\"GREEN\" colspan=\"1\">Header(Cr)";
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td bgcolor=$color valign=\"middle\">".$row['action_date'];
echo "<th bgcolor=$color ><b><a href =\"../general/voucherdetails.php?tran_id=".$row['tran_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=700,height=500'); return false;\" >".$row['tran_id']."</a>";
$dr_str=getHeaderInfo($row['tran_id'],'Dr',$end_dt);
echo "<td bgcolor=$color><b>".$dr_str;
$cr_str=getHeaderInfo($row['tran_id'],'Cr',$end_dt);
echo "<td bgcolor=$color><b>".$cr_str;
echo "<td bgcolor=$color>".ucwords($row['remarks']);
echo "<td bgcolor=$color>".$row['operator_code'];
	}
echo "<tr>";
echo "<th bgcolor=AQUA colspan=\"7\">".$j." Voucher Entry Found During the date !!!!!";
echo "</table>";
}
//----------------------------------------------------------------------------------------------
?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("form1");
 frmvalidator.addValidation("start_dt","req","Please enter the Start Date");
 frmvalidator.addValidation("end_dt","req","Please enter the End Date");
 </script>
