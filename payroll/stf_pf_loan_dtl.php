 <?
include "../config/config.php";
$status=$_REQUEST['status'];
function makeselectemploan($name,$js)
{$sql_statement="select emp_id from emp_master  where emp_id not in (select emp_id from emp_pf_loan_hrd where b_principal>0) order by emp_id";
 //echo  $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\"  $js>";
 echo"<option>select</option>"; 
 if(pg_NumRows($result)==0) {
 echo "<option>Null</option>";
}
else{ 

      for($j=1; $j<=pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,($j-1)); 
      echo "<option value=".$row['emp_id'].">".$row['emp_id']."</option>";
    }
}
echo "</select>";
}
$time=strtotime(date('Y/m/d'));
//$time=date("Y",time())."/".date("m",time())."/".date("d",time());
$t2=strtotime('2013/06/9');
$t3=($time-$t2)/86400;
//$due_int=interest();
//$menu=$_REQUEST['menu'];
echo "<head>";
echo "<title>PF DETAILS";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script src=\"../JS/loading2.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
?>
<script LANGUAGE="JavaScript">
 
function f2(str){
//alert("str"+str);
showHint_subemp(str);

}

function cal_int(){

var years=document.getElementById('mnth').value/12;

var amount=Number(document.getElementById('ac_am').value);
var rate=document.getElementById('d_int').value;
var due_int=Math.round(amount/36);
document.getElementById('inst_amt').value=Math.round(amount/Number(document.getElementById('mnth').value));
var date=new Date(document.getElementById('ln_dt').value);
//var repay=new Date();
var days=Math.round(365.24*years);
date.setDate(date.getDate()+days);
document.getElementById('ln_rp_dt').value=date;
}


function amt_val(f)
{
var amount=Number(document.getElementById('ac_am').value);
var ap_amount=Number(document.getElementById('ap_am').value);
//var lac_no=document.getElementById('loan_ac_no').value.length;
//alert(amount+ap_amount);
         if(ap_amount<amount)
       {
        alert("You can not get loan more than aplied amount");
        return false;
       }
      /* if(lac_no==0)
       {
       alert("You must enter Loan account number");
       return false;
       }*/
      
 }

</script>
<?
echo "<body bgcolor=\"white\">";
//echo $loan_date;
echo"<form  name='f1' action='loan_dtl_add.php' method='post' onsubmit='return amt_val(this.form);' >";
echo"<table valign=\"top\" align='center' width='90%' bgcolor='#EFEFEF'>";//sas1

echo"<tr><th colspan='9' bgcolor='grey' align='center'><font color='white' size='2'>SERVICE BOND LOAN ISSUE</font></th></tr><tr><td  colspan='9'></td></tr><tr><td  colspan='9'></td></tr><tr><td  colspan='9'></td></tr>";
echo"<tr><td colspan='9' align='right'><font size='0' color='red'>** if You don't find Your Employee Id in the Drop Down ,You Have PF Loan due </td></tr>";
echo"<tr><td align='left'> Employee ID  </td><td width='1%'>:</td><td>";
makeselectemploan('id',"onChange=\"f2(this.value);\"");
echo "</td> <td colspan='6'>";
?>
<span id="txtHint"></span>
<?
echo"<tr>";
//echo"<td  align='left'>Loan a/c No </td><td width='1%'>:</td><td colspan='7' align='left'><input type='text' value='MT-' name='pf_loan_ac_no' id=\"pf_loan_ac_no\" size='10'  $HIGHLIGHT>";
//echo"</tr><tr>";
echo"<td> Loan Date</td><td width='1%'>:</td><td> <input type=\"TEXT\" name=\"ln_dt\" id='ln_dt' size=\"12\" value=\"\" onfocus=\"cal_int()\"onChange=\"cal_int()\" onKeyup=\"cal_int()\"  $HIGHLIGHT>";
echo "&nbsp<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.ln_dt,'mm/dd/yyyy','Choose Date')\">&nbsp;mm/dd/yyyy </td>";
echo"<td>Period for loan (in months)</td><td width='1%'>:</td><td> <input type=\"TEXT\" name=\"mnth\" id=\"mnth\" size=\"3\" value=\"12\" onfocus=\"cal_int()\"onChange=\"cal_int()\" onKeyup=\"cal_int()\"  $HIGHLIGHT></td>";
echo"<td>Loan Repay Date</td><td width='1%'>:</td><td><input type=\"TEXT\" name=\"ln_rp_dt\" id='ln_rp_dt' size=\"12\" value=\"\" onfocus=\"cal_int()\"onChange=\"cal_int()\" onKeyup=\"cal_int()\"  $HIGHLIGHT> </td></tr><tr>";
//echo "&nbsp<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.rp_dt,'dd/mm/yyyy','Choose Date')\"></td></tr><tr>";
echo"<td> Applied Amount</td><td width='1%'>:</td><td> <input type=\"TEXT\" name=\"ap_am\" id=\"ap_am\" size=\"7\" onfocus=\"cal_int()\"onChange=\"cal_int()\" onKeyup=\"cal_int()\" $HIGHLIGHT>";
echo"<td> Actual Amount</td><td width='1%'>:</td><td> <input type=\"TEXT\" name=\"ac_am\" id=\"ac_am\" size=\"7\" value=\"\" onclick=\"cal_int()\" onfocus=\"cal_int()\"onChange=\"cal_int()\" onKeyup=\"cal_int()\"  $HIGHLIGHT></td></tr><tr>";
echo"<td> Due Interest Rate </td><td width='1%'>:</td><td> <input type=\"TEXT\" name=\"d_int\" id=\"d_int\" size=\"3\" value=\"10\" onfocus=\"cal_int()\"onChange=\"cal_int()\" onKeyup=\"cal_int()\"  $HIGHLIGHT>&nbsp;%";
//echo"<td> Over Due Interest Rate </td><td width='1%'>:</td><td> <input type=\"TEXT\" name=\"od_int\" size=\"3\" $HIGHLIGHT>&nbsp;%</td></tr><tr><tr><td  colspan='9'></td></tr><tr><td  colspan='9'></td></tr>";
echo"<td> Interest Amount </td><td width='1%'>:</td><td><input type=\"TEXT\" name=\"d_int_am\" id=\"d_int_am\"size=\"5\" value=\"\" $HIGHLIGHT></td>";

echo"<td> Monthly Instalment(principal) </td><td width='1%'>:</td><td><input type=\"TEXT\" name=\"inst_amt\" id=\"inst_amt\"size=\"5\" value=\"\" onfocus=\"cal_int()\"onChange=\"cal_int()\" onKeyup=\"cal_int()\"  $HIGHLIGHT></td></tr>";
//echo"<td align='right' >";
//echo"Total Over Due Interest Amount  </td><td width='1%'>:</td><td><input type=\"TEXT\" name=\"od_int_am\" id=\"od_int_am\" size=\"3\" value=\"\" onfocus=\"cal_int()\" onChange=\"cal_int()\" onKeyup=\"cal_int()\"    $HIGHLIGHT></td></tr>";
echo"<tr><td  colspan='9'></td></tr><tr><td  colspan='9'></td></tr><tr><td  colspan='9'></td></tr><tr><td align='center' colspan='9'><input type='submit' name='submit' value='submit'></td></tr>";
?>
