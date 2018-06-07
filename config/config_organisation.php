<?php
$SYSTEM_TITLE="<Font Color=#FF5874 size=+1>Common Accounting System (CAS)</FONT>";
$VERSION_INFO="2.0";
$PROJECT_TITLE="Marokhana SKUS Limited";
$ORGANISATION_TITLE="Developed by <i><b>Altalyst Technologies</b></i>";
$ORGANISATION_ADDRESS1="Banglore";
$ORGANISATION_ADDRESS2="Karnataka";
$ORGANISATION_ADDRESS3="INDIA";
$PHONE_BerbatiDEFAULT="--";
$DISTRIC_DEFAULT="Marokhana";
$PIN_DEFAULT="712417";
$VILL_DEFAULT="Marokhana";
$POST_DEFAULT="Marokhana";
$POLICESTATION_DEFAULT="KHANAKUL";
$STATE_DEFAULT="West Bengal";
$COUNTRY_DEFAULT="India";
$DOB_DEFAULT="01.01.1900";
$START_DATE_RETAIL='01.04.2011';
$MINIMUM_SHARE_VALUE="5";//share value for KCC
$DATE_OF_MATURITY_DEFAULT="31.12.3000";
$CROSS_CHECKING=false;
$FURMAR_SELF_INSURANCE=true;
$VAT=false;
$MAX_AGE_FURMAR="70";
$MAX_LIMIT_KCC=150000;
$TRAN_LIMIT=0;
$PENALTY_PERCENTAGE=2; //penalty percentage of RD 

//-----------------------------------------------------------------------------------
function footer(){
	global $SYSTEM_TITLE,$DISTRIC_DEFAULT,$ORGANISATION_ADDRESS2,$ORGANISATION_ADDRESS3;
	echo "<center>";
	echo "<font face=\"helvetica\" color=\"BLACK\" size=-2><B>&copy; 2017-2018,$SYSTEM_TITLE";
	//echo " $DISTRIC_DEFAULT,";
	echo " $ORGANISATION_ADDRESS2, $ORGANISATION_ADDRESS3";
	echo "</center>";
	return;
}
?>
