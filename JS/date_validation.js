function IsDateLess(DateValue1, DateValue2){
var DaysDiff;
//alert(DateValue1);
Date1 = new Date(dateFormat(DateValue1));
Date2 = new Date(dateFormat(DateValue2));
DaysDiff = Math.floor((Date1.getTime() - Date2.getTime())/(1000*60*60*24));
//alert(DateValue1+"->"+DateValue2+"\n"+Date1+"->"+Date2)
//alert("DaysDiff ="+DaysDiff)
if(DaysDiff <= 0)
return true;
else
return false;
}
//----------------------------------------------------------------------------------------------
function IsDateEqual(DateValue1, DateValue2){
var DaysDiff;
Date1 = new Date(dateFormat(DateValue1));
Date2 = new Date(dateFormat(DateValue2));
DaysDiff = Math.floor((Date1.getTime() - Date2.getTime())/(1000*60*60*24));
if(DaysDiff == 0)
	return true;
else
	return false;
}
//----------------------------------------------------------------------------------------------
function dateFormat(DateVal){
var fdate;
var pType;
fdate=DateVal.split('/');
if(fdate.length>1){
pType="/";
}
else{
pType=".";
}
switch(pType){
	case '/':
	{
		fdate=DateVal.split('/');
		fdate=fdate[1]+"/"+fdate[0]+"/"+fdate[2];
	}
	break;
	case '.':
	{
		fdate=DateVal.split('.');
		fdate=fdate[1]+"."+fdate[0]+"."+fdate[2];
	}
	break;
}

return fdate;
 }
//----------------------------------------------------------------------------------------------
