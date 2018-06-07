function IsPNumeric(strString){
   var strValidChars = "0123456789.";
   var strChar;
   var blnResult = true;
   if (strString.length == 0) return false;
   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++){
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1){
         blnResult = false;
         }
      }
   return blnResult;
   }
/********************************************************************************************/
function varify(){
if(!(IsPNumeric(document.form1.due_int.value))){
	alert("Due Interest Rate Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.due_int.value="";
	document.form1.due_int.focus();
	return false;
	}
if(!(IsPNumeric(document.form1.over_due_int.value))){
	alert("Over Due Interest Rate Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.over_due_int.value="";
	document.form1.over_due_int.focus();
	return false;
	}
if(!(IsPNumeric(document.form1.period.value))){
	alert("Period Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.period.value="";
	document.form1.period.focus();
	return false;
	}
if(!(IsPNumeric(document.form1.applied_amount.value))){
	alert("Applied amount Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.applied_amount.value="";
	document.form1.applied_amount.focus();
	return false;
	}
if(!(IsPNumeric(document.form1.issue_amount.value))){
	alert("Issued amount Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.issue_amount.value="";
	document.form1.issue_amount.focus();
	return false;
	}
var ap_amount=parseFloat(document.form1.applied_amount.value);
var l_amount=parseFloat(document.form1.issue_amount.value);
var l_limit=parseFloat(document.form1.security_amount.value);
       	if(ap_amount>l_limit){
		alert("Loan Limit should not be less than Applied Amount!!!!");
		document.form1.applied_amount.value="";
		document.form1.applied_amount.focus();
		return false;
	}
	if(l_amount>ap_amount){
	alert("Loan Amount should not be more than Applied Amount!!!!! ");
	document.form1.issue_amount.value="";
	document.form1.issue_amount.focus();
	return false;
	}
}
/*************************************FOR SMP AND Staff Loan***********************************/
function varify1(){
if(!(IsPNumeric(document.form1.due_int.value))){
	alert("Due Interest Rate Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.due_int.value="";
	document.form1.due_int.focus();
	return false;
	}
if(!(IsPNumeric(document.form1.over_due_int.value))){
	alert("Over Due Interest Rate Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.over_due_int.value="";
	document.form1.over_due_int.focus();
	return false;
	}
if(!(IsPNumeric(document.form1.period.value))){
	alert("Period Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.period.value="";
	document.form1.period.focus();
	return false;
	}
if(!(IsPNumeric(document.form1.applied_amount.value))){
	alert("Applied amount Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.applied_amount.value="";
	document.form1.applied_amount.focus();
	return false;
	}
if(!(IsPNumeric(document.form1.issue_amount.value))){
	alert("Issued amount Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.issue_amount.value="";
	document.form1.issue_amount.focus();
	return false;
	}
var ap_amount=parseFloat(document.form1.applied_amount.value);
var l_amount=parseFloat(document.form1.issue_amount.value);
       	if(l_amount>ap_amount){
	alert("Loan Amount should not be more than Applied Amount!!!!! ");
	document.form1.issue_amount.value="";
	document.form1.issue_amount.focus();
	return false;
	}
}
