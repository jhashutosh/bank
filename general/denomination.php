<?php
include "../config/config.php";
$staff_id=verifyAutho();
echo "<html>";
echo "<head>";
echo "<title>Denomination Form";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<table align=center bgcolor=\"silver\"><tr><td  align=\"\"><b><font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "</table>";
echo "<form name=\"denomfrm\" action=\"denomination_eadd.php?menu=deno\" method=\"POST\" onSubmit=\"return varify();\">";
echo "<table bgcolor=BLACK align=center width=70%>";
echo "<tr bgcolor=#4B0082><TH bgcolor=#4B0082><font color=WHITE size=3 align=\"center\"><b>Denomination Chart";
echo "<td align=\"right\"><font color=WHITE size=3>Action Date:<td><input type=\"TEXT\" name=\"ac_dt\" id=\"ac_dt\" size=\"10\"
 value=\"".date('d.m.Y')."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"date1\" value=\"...\" onclick=\"showCalendar(denomfrm.ac_dt,'dd/mm/yyyy','Choose Date')\">";
echo "<tr><td colspan=3 align=\"CENTER\" bgcolor=#98C3F1><b>NOTE</td>";
echo "<tr bgcolor=#E0C6EB><td align=\"CENTER\"  width=10%>1000 &nbsp;&nbsp;X</td>
	  <td align=\"CENTER\" width=10%><input type=\"TEXT\" name=\"note1000\" size=\"5\" id=\"note1000\" value=\"$note1000\" onfocus=\"tot_cal()\"onChange=\"tot_cal()\" onKeyup=\"tot_cal()\" onclick=\"f3(this.id);\" onkeypress=\"return numbersonly(event)\" $HIGHLIGHT></td><td align=\"CENTER\"   width=10%><input type='text' name='val1000' id='val1000' value=\"\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#E0C6EB><td align=\"CENTER\"   width=10%>500 &nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\"   width=10%><input type=\"TEXT\" name=\"note500\" size=\"5\" id=\"note500\" value=\"$note500\" onfocus=\"tot_cal()\"onChange=\"tot_cal()\" onKeyup=\"tot_cal()\"onkeypress=\"return numbersonly(event)\" $HIGHLIGHT></td><td align=\"CENTER\"   width=10%><input type='text' name='val500' id='val500' value=\"\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#E0C6EB><td align=\"CENTER\"   width=10%>100 &nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\"   width=10%><input type=\"TEXT\" name=\"note100\" size=\"5\" id=\"note100\" value=\"$note100\" onfocus=\"tot_cal()\"onChange=\"tot_cal()\" onKeyup=\"tot_cal()\" onkeypress=\"return numbersonly(event)\" $HIGHLIGHT></td><td align=\"CENTER\"   width=10%><input type='text' name='val100' id='val100' value=\"\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#E0C6EB><td align=\"CENTER\"   width=10%>50 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\"   width=10%><input type=\"TEXT\" name=\"note50\" size=\"5\" id=\"note50\"value=\"$note50\" onfocus=\"tot_cal()\"onChange=\"tot_cal()\" onKeyup=\"tot_cal()\" onkeypress=\"return numbersonly(event)\" $HIGHLIGHT></td><td align=\"CENTER\"   width=10%><input type='text' name='val50' id='val50' value=\"\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#E0C6EB><td align=\"CENTER\"   width=10%>20 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\"   width=10%><input type=\"TEXT\" name=\"note20\" size=\"5\" id=\"note20\"value=\"$note20\" onfocus=\"tot_cal()\"onChange=\"tot_cal()\" onKeyup=\"tot_cal()\" onkeypress=\"return numbersonly(event)\" $HIGHLIGHT></td><td align=\"CENTER\"   width=10%><input type='text' name='val20' id='val20' value=\"\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#E0C6EB><td align=\"CENTER\"   width=10%>10 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\"   width=10%><input type=\"TEXT\" name=\"note10\" size=\"5\" id=\"note10\"value=\"$note10\" onfocus=\"tot_cal()\"onChange=\"tot_cal()\" onKeyup=\"tot_cal()\" onkeypress=\"return numbersonly(event)\" $HIGHLIGHT></td><td align=\"CENTER\"   width=10%><input type='text' name='val10' id='val10' value=\"\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#E0C6EB><td align=\"CENTER\"   width=10%>5 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\"   width=10%><input type=\"TEXT\" name=\"note5\" size=\"5\" id=\"note5\"value=\"$note5\" onfocus=\"tot_cal()\"onChange=\"tot_cal()\" onKeyup=\"tot_cal()\" onkeypress=\"return numbersonly(event)\" $HIGHLIGHT></td><td align=\"CENTER\"   width=10%><input type='text' name='val5' id='val5' value=\"\" size='10' $HIGHLIGHT READONLY></td>";
echo "<tr bgcolor=#E0C6EB><td align=\"CENTER\"   width=10%>2 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\"   width=10%><input type=\"TEXT\" name=\"note2\" size=\"5\" id=\"note2\"value=\"$note2\" onfocus=\"tot_cal()\"onChange=\"tot_cal()\" onKeyup=\"tot_cal()\" onkeypress=\"return numbersonly(event)\" $HIGHLIGHT></td><td align=\"CENTER\"   width=10%><input type='text' name='val2' id='val2' value=\"\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#E0C6EB><td align=\"CENTER\"   width=10%>1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\"   width=10%><input type=\"TEXT\" name=\"note1\" size=\"5\" id=\"note1\"value=\"$note1\" onfocus=\"tot_cal()\" onChange=\"tot_cal()\" onKeyup=\"tot_cal()\" onkeypress=\"return numbersonly(event)\" $HIGHLIGHT></td><td align=\"CENTER\"   width=10%><input type='text' name='val1' id='val1' value=\"\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr ><td colspan=3 align=\"CENTER\" bgcolor=#98C3F1><b>COINS</td>";
echo "<tr bgcolor=#E0C6EB><td align=\"CENTER\"   width=10%>10 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\"   width=10%><input type=\"TEXT\" name=\"coin10\" size=\"5\" id=\"coin10\"value=\"$coin10\" onfocus=\"tot_cal()\"onChange=\"tot_cal()\" onKeyup=\"tot_cal()\" onkeypress=\"return numbersonly(event)\" $HIGHLIGHT></td><td align=\"CENTER\"   width=10%><input type='text' name='con10' id='con10' value=\"\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#E0C6EB><td align=\"CENTER\"   width=10%>5 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\"   width=10%><input type=\"TEXT\" name=\"coin5\" size=\"5\" id=\"coin5\"value=\"$coin5\" onfocus=\"tot_cal()\"onChange=\"tot_cal()\" onKeyup=\"tot_cal()\" onkeypress=\"return numbersonly(event)\" $HIGHLIGHT></td><td align=\"CENTER\"   width=10%><input type='text' name='con5' id='con5' value=\"\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#E0C6EB><td align=\"CENTER\"   width=10%>2 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\"   width=10%><input type=\"TEXT\" name=\"coin2\" size=\"5\" id=\"coin2\"value=\"$coin2\" onfocus=\"tot_cal()\"onChange=\"tot_cal()\" onKeyup=\"tot_cal()\" onkeypress=\"return numbersonly(event)\" $HIGHLIGHT></td><td align=\"CENTER\"   width=10%><input type='text' name='con2' id='con2' value=\"\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#E0C6EB><td align=\"CENTER\"   width=10%>1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\"   width=10%><input type=\"TEXT\" name=\"coin1\" size=\"5\" id=\"coin1\"value=\"$coin1\" onfocus=\"tot_cal()\"onChange=\"tot_cal()\" onKeyup=\"tot_cal()\" onkeypress=\"return numbersonly(event)\" $HIGHLIGHT></td><td align=\"CENTER\"   width=10%><input type='text' name='con1' id='con1' value=\"\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#E0C6EB><td align=\"CENTER\"   width=10%>0.50 &nbsp;&nbsp;X</td>
	  <td align=\"CENTER\"   width=10%><input type=\"TEXT\" name=\"paisa50\" size=\"5\" id=\"paisa50\"value=\"$paisa50\" onfocus=\"tot_cal()\"onChange=\"tot_cal()\" onKeyup=\"tot_cal()\" onkeypress=\"return numbersonly(event)\" $HIGHLIGHT ></td><td align=\"CENTER\"   width=10%><input type='text' name='pas5' id='pas5' value=\"\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr><td align=\"CENTER\" bgcolor=#98C3F1 width=10%><b>TOTAL</td>
	  <td align=\"CENTER\" bgcolor=#98C3F1 width=10%><td align=\"CENTER\" bgcolor=#98C3F1 width=10%><input type=\"TEXT\" name=\"Total\" size=\"12\" id=\"Total\"value=\"\" onfocus=\"tot_cal()\"onChange=\"tot_cal()\" onKeyup=\"tot_cal()\" onkeypress=\"return numbersonly(event)\" $HIGHLIGHT></td></tr>";
	  echo "<tr bgcolor=cyan><td colspan=\"3\" align=\"right\"><input type=\"SUBMIT\" align=\"RIGHT\" name=\"SUBMIT_BUTTON\" value=\"Submit\"></td>";
echo "</table >";
echo "</fomr>";
echo "<br><br><hr>";

$sql_statement="SELECT * FROM denomination_master";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
$color=$TCOLOR;
echo "<table valign=\"top\" width=\"90%\" align=\"CENTER\">";
echo "<tr bgcolor=#447018>";
echo "<th colspan=\"4\"><h2><font color=blue>Details Information Of Denomination</font><h2></th>";
echo "<tr bgcolor=\"PINK\">";
echo "<th>Transaction Id</th>";
echo "<th>Tatal Amount</th>";
echo "<th>Action Date</th>";
echo "<th>Operatar Name</th>";
for($j=0; $j<pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";

echo "<td  bgcolor=$color><a href=\"../general/show_denom.php?menu=deno&tran_id=".$row['tran_id']."\" target=\"_blank\">".$row['tran_id']."</a></td>";
echo "<td  bgcolor=$color>".$row['total']."</td>";
echo "<td  bgcolor=$color>".$row['action_date']."</td>";
echo "<td  bgcolor=$color>".$row['staff_id']."</td>";
}
echo "<tr bgcolor=AQUA>";
echo "<th colspan=4>Total : $j Infomation Found!!!!!!";
echo "</table>";

}


echo "</body>";
echo "</html>";
?>
<script LANGUAGE="JavaScript">
function tot_cal()
{
var note1000=document.getElementById('note1000').value;
//alert("rarar"+note1000);
var note500=document.getElementById('note500').value;
var note100=document.getElementById('note100').value;
var note50=document.getElementById('note50').value;
var note20=document.getElementById('note20').value;
var note10=document.getElementById('note10').value;
var note5=document.getElementById('note5').value;
var note2=document.getElementById('note2').value;
var note1=document.getElementById('note1').value;
var coin10=document.getElementById('coin10').value;
var coin5=document.getElementById('coin5').value;
var coin2=document.getElementById('coin2').value;
var coin1=document.getElementById('coin1').value;
var paisa50=document.getElementById('paisa50').value;
var total=note1000*1000+note500*500+note100*100+note50*50+note20*20+note10*10+note5*5+note2*2+note1*1+coin10*10+coin5*5+coin2*2+coin1*1+paisa50/2;
document.getElementById('val1000').value=note1000*1000;
document.getElementById('val500').value=note500*500;
document.getElementById('val100').value=note100*100;
document.getElementById('val50').value=note50*50;
document.getElementById('val20').value=note20*20;
document.getElementById('val10').value=note10*10;
document.getElementById('val5').value=note5*5;
document.getElementById('val2').value=note2*2;
document.getElementById('val1').value=note1*1;
document.getElementById('con10').value=coin10*10;
document.getElementById('con5').value=coin5*5;
document.getElementById('con2').value=coin2*2;
document.getElementById('con1').value=coin1*1;
document.getElementById('pas5').value=paisa50/2;
document.getElementById('Total').value=total;
}


function numbersonly(e){
var unicode=e.charCode? e.charCode : e.keyCode
if (unicode!=8){ 
	if (unicode<48||unicode>57) 
		return false 
	}
}
// THIS VALIDATION FOR CHECK the denomination amount is equal or not from deposits/withdrawals amount
function varify(){
	
	if(document.denomfrm.Total.value.length>0)
	{
		if (confirm('Are you sure?'))
		{
			alert('I’m so glad you’re sure! ');
		} 
		else
		{
			alert('I’m sorry to hear you’re not sure.');
			return false;
		}


	}
	else{
		alert("Please Enter the Denomination");
		return false;
		
	}
	
}
</script>


