<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$account_no=$_REQUEST['account_no'];
$account_type=$_REQUEST['account_type'];
$type_of=$_REQUEST['type_of'];
$bank_name=$_REQUEST['bank_name'];
$branch_name=$_REQUEST['branch_name'];
$certifiacate_no=$_REQUEST['cer_no'];
$op_date=$_REQUEST['op_date'];
$remarks=$_REQUEST['remarks'];
$period=$_REQUEST["period"];
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/loading1.js\"></script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<title>Investment";
echo "</title>";
?>
<SCRIPT LANGUAGE="JavaScript">
function onCheck(){
	if(str.length==0){
		alert("You Should select First")
	}
	else{
		if(str=="ln"){
			alert(str)
			document.form1.gl_code.disabled=false;
		
			}
		
	}
}
function f1(){
showHint(str);
}
function f2(str){
if(str=='po'){
//alert(str);
document.form1.ac_type.disabled=false;
}
else{
document.form1.ac_type.disabled=true;
}
document.form1.gl_code.disabled=true;
}
function f3(str){
if(str=='cash'){
document.form1.ch_no.value=0;
document.form1.ch_no.disabled=true;
document.form1.bank_ac_no.disabled=true;
document.form1.rm.focus();
}
if(str=='ch'){
document.form1.ch_no.disabled=false;
document.form1.bank_ac_no.disabled=false;
document.form1.ch_no.value='';
document.form1.ch_no.focus();
}
if(str=='trf'){
document.form1.ch_no.value=0;
document.form1.ch_no.disabled=true;
document.form1.bank_ac_no.disabled=false;
document.form1.bank_ac_no.focus();
}
if(str=='dft'){
document.form1.ch_no.disabled=false;
document.form1.bank_ac_no.disabled=true;
document.form1.ch_no.value='';
document.form1.ch_no.focus();
}
if(str.length==0){
document.form1.ch_no.value=0;
document.form1.ch_no.disabled=true;
document.form1.bank_ac_no.disabled=true;
}
}
</script>
<?

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\"/>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"f1();\">";
echo "<hr>";
//========================Entry Form ====================================
echo "<form name=\"form1\" method=\"post\" action=\"new_rd_investment1.php?menu=bb&o=i\">";
echo "<table align=center width=100% bgcolor=\"BLACK\">";
echo "<tr><th colspan=\"6\" bgcolor=\"#8B008B\"><font color=white size=5>Create New Investment In Bank</font></th>";
echo "<tr>";
echo "<td bgcolor=\"#6B8E23\">Type of :<td bgcolor=\"#6B8E23\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

makeSelectwithJS($bk_type_array,'type_of',"","type_of","onchange=\"f2(this.value);\"");
echo "<td bgcolor=\"#6B8E23\">Account Type:<td bgcolor=\"#6B8E23\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
makeSelectwithJS($in_type_bank,'account_type',"","account_type","onchange=\"showHint(this.value);\"");
//echo"<input type=TEXT name=\"ac_type\" id=\"ac_type\" size=\"7\" $HIGHLIGHT disabled>";
//echo "<td bgcolor=\"#6B8E23\">Investment Catagory:<td bgcolor=\"#6B8E23\">";
//makeSelectDisabled($ccb_loan_array,'gl_code',"");

echo "<td bgcolor=\"#6B8E23\">Bank Name:<td bgcolor=\"#6B8E23\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=TEXT name=\"bank_name\" size=\"12\" $HIGHLIGHT>";
echo "<tr>";
echo "<td bgcolor=\"#6B8E23\">Branch Name:<td bgcolor=\"#6B8E23\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=TEXT name=\"branch_name\" size=\"12\" $HIGHLIGHT>";
echo "<td bgcolor=\"#6B8E23\">Opening Date:<td bgcolor=\"#6B8E23\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=TEXT name=\"op_date\" size=\"12\" VALUE=\"".date('d.m.Y')."\" $HIGHLIGHT>";


echo "<td bgcolor=\"#6B8E23\">Account No:<td bgcolor=\"#6B8E23\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=TEXT name=\"account_no\" size=\"12\" $HIGHLIGHT>";
echo "<tr>";
echo "<td bgcolor=\"#6B8E23\">Certificate No:<td bgcolor=\"#6B8E23\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=TEXT name=\"cer_no\" size=\"12\" $HIGHLIGHT>";
echo "<td bgcolor=\"#6B8E23\">Principal:<td bgcolor=\"#6B8E23\">&nbsp;Rs.<input type=TEXT name=\"principal\" size=\"12\" $HIGHLIGHT>";

//echo "<td bgcolor=\"#6B8E23\">Total Principal:<td bgcolor=\"#6B8E23\">&nbsp;Rs.<input type=TEXT name=\"t_principal\" size=\"12\" $HIGHLIGHT>";

echo "<td bgcolor=\"#6B8E23\">Maturity Amount:<td bgcolor=\"#6B8E23\">&nbsp;Rs.<input type=TEXT name=\"m_amount\" size=\"12\" $HIGHLIGHT>";
echo "<tr>";
echo "<td bgcolor=\"#6B8E23\">Interest:<td bgcolor=\"#6B8E23\">&nbsp;Rs.<input type=TEXT name=\"interest\" size=\"12\" $HIGHLIGHT>";

echo "<td bgcolor=\"#6B8E23\">Period:<td bgcolor=\"#6B8E23\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=TEXT name=\"period\" size=\"12\" $HIGHLIGHT>";

echo "<td bgcolor=\"#6B8E23\">Maturity Date<td bgcolor=\"#6B8E23\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=TEXT name=\"mat_dt\" size=\"12\" $HIGHLIGHT>";
echo "<tr>";
echo "<td bgcolor=\"#6B8E23\">Rate of Interest:<td bgcolor=\"#6B8E23\">&nbsp;Rs.<input type=TEXT name=\"int_rate\" size=\"5\" $HIGHLIGHT> &nbsp;%";

//echo "<td bgcolor=\"#6B8E23\">Maturity Amount:<td bgcolor=\"#6B8E23\">&nbsp;Rs.<input type=TEXT name=\"mat_amt\" size=\"10\" VALUE=\"\" $HIGHLIGHT>";


echo "<td bgcolor=\"#6B8E23\">Payment Mode:<td bgcolor=\"#6B8E23\" colspan='3'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
makeSelectwithJS($mode_array,'p_mode',"","p_mode","onchange=\"f3(this.value);\"");
echo "<tr>";
echo "<td bgcolor=\"#6B8E23\">Cheque No:<td bgcolor=\"#6B8E23\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=TEXT name=\"ch_no\" size=\"12\" id=\"ch_no\" value=\"0\" disabled $HIGHLIGHT>";

echo "<td bgcolor=\"#6B8E23\">Transfer From<td bgcolor=\"#6B8E23\" colspan='3'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
selectBankAccount('bank_ac_no','DISABLED');
echo "<tr>";
echo "<td bgcolor=\"#6B8E23\">Remarks:<td colspan=5 bgcolor=\"#6B8E23\" valign=\"center\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea name=\"remarks\" rows=\"2\" cols=\"50\" id=\"rm\" $HIGHLIGHT></textarea>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"submit\" value=\"submit\">";
echo "</table>";
echo "</form>";

//-------------------------------------------------


//---------------------------------------------------------------------------------------------
/*
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("form1");
  frmvalidator.addValidation("type_of","req","Please Select Bank Type.");
  frmvalidator.addValidation("account_type","req","Please Select Bank Account Type");
  frmvalidator.addValidation("op_date","req","Please enter Account Opening date");
  frmvalidator.addValidation("bank_name","req","Please enter the Bank Name");
  frmvalidator.addValidation("account_no","req","Please enter Account No");
  frmvalidator.addValidation("branch_name","req","Please enter Branch Name");
  frmvalidator.addValidation("principal","req","Please Enter the principal Amount!!!!");
  frmvalidator.addValidation("principal","dec","Princpal Amount Should be positive numeric Number!!!!!!");
  frmvalidator.addValidation("mat_amt","req","Please enter Maturity Amount");
  frmvalidator.addValidation("mat_dt","req","Please enter Maturity Date");
  frmvalidator.addValidation("ch_no","req","Please enter Cheque No");
  frmvalidator.addValidation("p_mode","req","Payment Mode should not be Null!!!!");
  frmvalidator.addValidation("int_rate","req","Please enter Rate of Interest");
  frmvalidator.addValidation("mat_amt","dec","Maturity Amount Should be positive numeric Number!!!!!!");
  frmvalidator.addValidation("int_rate","dec","interest Rate Should be positive numeric Number!!!!!!");
 
  
  </script>*/
