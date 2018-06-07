 <?
include "../config/config.php";
echo "<head>";
echo "<title>Adhoc DETAILS";
echo "</title>";
echo "<script src=\"../JS/loading2.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
?>
<script LANGUAGE="JavaScript">
 
function f2(str){
//alert("str"+str);
showHint_grantemp(str);

}

</script>
<?
echo "<body bgcolor=\"#E7F0FE\">";
//echo $loan_date;
echo"<form  name='f1' action='loan_dtl_add.php' method='post' onsubmit='return amt_val(this.form);' >";
echo"<table valign=\"top\" align='center' width='100%'>";//sas1
echo"<tr><th colspan='3' bgcolor='#BEFFB5'><font color='darkblue'>ADHOC GRANT FROM GOVT.</th></tr>";
echo"<tr><th colspan='3' bgcolor='#AFDFFA'><font color='darkblue'>Employee wise Statement</th></tr></table><table bgcolor='#F7FFAF' width='100%'>";
echo"<tr><td align='right' width='50%' bgcolor='#F7FFAF'><font color='#00613F'>Select Employee</td><td width='1%' bgcolor='#F7FFAF'>:</td><td width='49%' bgcolor='#F7FFAF'>";makeselectempgrant('id',"onChange=\"f2(this.value);\"");
echo "</td></tr></table>";
?>
<span id="txtHint"></span>
<?

?>
