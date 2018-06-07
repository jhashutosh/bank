function enable_txt(val){
 	if(val=="yes"){
		 document.f1.n_name.disabled=false;
		 document.f1.n_add.disabled=false;
		 document.f1.n_age.disabled=false;
		 document.f1.relation.disabled=false;
		 document.f1.n_name.focus();
 		}
	else{
		document.f1.n_name.disabled=true;
    		document.f1.n_add.disabled=true;
		document.f1.n_age.disabled=true;
		document.f1.relation.disabled=true;
  		}
	}
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

function IsPInteger(strString){
   
   var strValidChars = "0123456789";
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
function checkKccIssue(f){
	var share_capital=document.getElementById("sh_val").value;
	var min_per=document.getElementById("min_sh_cap").value;
	var amount=document.getElementById("amount").value;
	var issued_amount=document.getElementById("issued_amount").value;
	var bal_limit=document.getElementById("bal_limit").value;
	if(IsPNumeric(amount)){
		amount=parseFloat(amount);
		min_per=parseFloat(min_per);
		share_capital=parseFloat(share_capital);
		issued_amount=parseFloat(issued_amount);
		bal_limit=parseFloat(bal_limit);
		if(bal_limit>=amount){
			issued_amount=issued_amount+amount;
			i=(issued_amount*min_per/100);
			if(i<=share_capital){
				f.submit();
			}
			else{
				alert("You Dont Have sufficent Share capital \nYour Value of Share is: Rs. "+share_capital +" /= \nBut You have to buy Rs."+(i-share_capital) +" /= share to take this loan")	
				
				return false;
				}
			}
		else{
			alert("Amount Should be less than or Equal to Remaining Limit")
			return false;
		}
	}
	else{
		alert("Amount Must Be Positive Numeric Value")
		return false;
		
	}
	
}
function checkKccReturn(f){
	var p=document.getElementById("p").value;
	var d=document.getElementById("d").value;
	var amount=document.getElementById("amount").value;
	var o=document.getElementById("o").value;
	if(IsPNumeric(amount)){
	amount=parseFloat(amount);
	p=parseFloat(p);
	d=parseFloat(d);
	o=parseFloat(o);
	if(amount>(p+d+o)){
	alert("Amount Should not Be more than Total Dues")
	return false;
	
		}	
	}
	else{
	alert("Amount Must Be Positive Numeric Value")
	return false;
	}
}
