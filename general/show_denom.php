<?
include "../config/config.php";
$menu=$_REQUEST['menu'];
$t_id=$_REQUEST['tran_id'];
$staff_id=verifyAutho();
?>
<script language="JAVASCRIPT">
function closeme() { 
	close(); 
}

function showJournal(e){
	var unicode=e.charCode? e.charCode : e.keyCode
	if(unicode==114){
	 	var tran_no=document.denomfrm.t_id.value;
		
		var file="../general/voucherdetails.php?tran_id="+tran_no;
		
	
	childWindow=open(file,window, 'addressbar=no,toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=300,left=150, width=700,height=500');
    if(childWindow.opener == null) childWindow.opener = self;	
	}
	
	
}
</script>
<?
$sql_statement="SELECT * FROM denomination_master WHERE tran_id='$t_id'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>New Account</h4>";
} else {
echo "<table align=center bgcolor=\"silver\"><tr><td  align=\"\"><b><font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "<div align='center'><input type='button' onclick='print()' value='print'></div>";
echo "</table>";
echo "<form name=\"denomfrm\" action=\"#\">";
echo "<table bgcolor=BLACK align=center width=50%>";
echo "<tr><TH colspan=3 bgcolor=#4B0082><font color=WHITE size=3 align=\"center\"><b>Denomination Chart";
echo "<tr bgcolor=#AAC9EA><td align=\"CENTER\" width=30%>TRAN_ID</td>";
echo "<td align=\"CENTER\" width=10% colspan=2><input type='text' value=\"".pg_result($result,'tran_id')."\" size='15' name=\"t_id\" $HIGHLIGHT READONLY onkeypress=\"return showJournal(event)\"></td>";
echo "<tr bgcolor=#AAC9EA><td align=\"CENTER\" width=30%>Date:</td>";
echo "<td align=\"CENTER\" width=10% colspan=2><input type='text' value=\"".pg_result($result,'action_date')."\" size='15' $HIGHLIGHT READONLY></td>";
echo "<tr bgcolor=#48D1CC><td colspan=3 align=\"CENTER\"><b>NOTE</td>";
echo "<tr bgcolor=#AAC9EA><td align=\"CENTER\" width=10%>1000 &nbsp;&nbsp;X</td>
	  <td align=\"CENTER\" width=10%><input type=\"TEXT\" name=\"note1000\" size=\"5\" id=\"note1000\" value=\"".pg_result($result,'n_1000')."\" $HIGHLIGHT READONLY></td><td align=\"CENTER\" width=10%><input type='text' name='val1000' id='val1000' value=\"".pg_result($result,'v_1000')."\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#AAC9EA><td align=\"CENTER\" width=10%>500 &nbsp;&nbsp;&nbsp; X</td>
	  <td align=\"CENTER\" width=10%><input type=\"TEXT\" name=\"note500\" size=\"5\" id=\"note500\" value=\"".pg_result($result,'n_500')."\" $HIGHLIGHT READONLY></td><td align=\"CENTER\" width=10%><input type='text' name='val500' id='val500' value=\"".pg_result($result,'v_500')."\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#AAC9EA><td align=\"CENTER\" width=10%>100 &nbsp;&nbsp;&nbsp; X</td>
	  <td align=\"CENTER\" width=10%><input type=\"TEXT\" name=\"note100\" size=\"5\" id=\"note100\" value=\"".pg_result($result,'n_100')."\" $HIGHLIGHT READONLY></td><td align=\"CENTER\" width=10%><input type='text' name='val100' id='val100' value=\"".pg_result($result,'v_100')."\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#AAC9EA><td align=\"CENTER\" width=10%>50 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\" width=10%><input type=\"TEXT\" name=\"note50\" size=\"5\" id=\"note50\"value=\"".pg_result($result,'n_50')."\" $HIGHLIGHT READONLY></td><td align=\"CENTER\" width=10%><input type='text' name='val50' id='val50' value=\"".pg_result($result,'v_50')."\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#AAC9EA><td align=\"CENTER\" width=10%>20 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\" width=10%><input type=\"TEXT\" name=\"note20\" size=\"5\" id=\"note20\"value=\"".pg_result($result,'n_20')."\" $HIGHLIGHT READONLY></td><td align=\"CENTER\" width=10%><input type='text' name='val20' id='val20' value=\"".pg_result($result,'v_20')."\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#AAC9EA><td align=\"CENTER\" width=10%>10 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\" width=10%><input type=\"TEXT\" name=\"note10\" size=\"5\" id=\"note10\"value=\"".pg_result($result,'n_10')."\" $HIGHLIGHT READONLY></td><td align=\"CENTER\" width=10%><input type='text' name='val10' id='val10' value=\"".pg_result($result,'v_10')."\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#AAC9EA><td align=\"CENTER\" width=10%>5 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\" width=10%><input type=\"TEXT\" name=\"note5\" size=\"5\" id=\"note5\"value=\"".pg_result($result,'n_5')."\" $HIGHLIGHT READONLY></td><td align=\"CENTER\" width=10%><input type='text' name='val5' id='val5' value=\"".pg_result($result,'v_5')."\" size='10' $HIGHLIGHT READONLY></td>";
echo "<tr bgcolor=#AAC9EA><td align=\"CENTER\" width=10%>2 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\" width=10%><input type=\"TEXT\" name=\"note2\" size=\"5\" id=\"note2\"value=\"".pg_result($result,'n_2')."\" $HIGHLIGHT READONLY></td><td align=\"CENTER\" width=10%><input type='text' name='val2' id='val2' value=\"".pg_result($result,'v_2')."\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#AAC9EA><td align=\"CENTER\" width=10%>1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\" width=10%><input type=\"TEXT\" name=\"note1\" size=\"5\" id=\"note1\"value=\"".pg_result($result,'n_1')."\" $HIGHLIGHT READONLY></td><td align=\"CENTER\" width=10%><input type='text' name='val1' id='val1' value=\"".pg_result($result,'v_1')."\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr><td colspan=3 align=\"CENTER\" bgcolor=#48D1CC><b>COINS</td>";
echo "<tr bgcolor=#AAC9EA><td align=\"CENTER\" width=10%>10 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\" width=10%><input type=\"TEXT\" name=\"coin10\" size=\"5\" id=\"coin10\"value=\"".pg_result($result,'c_10')."\" $HIGHLIGHT READONLY></td><td align=\"CENTER\" width=10%><input type='text' name='con10' id='con10' value=\"".pg_result($result,'v_c_10')."\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#AAC9EA><td align=\"CENTER\" width=10%>5 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\" width=10%><input type=\"TEXT\" name=\"coin5\" size=\"5\" id=\"coin5\"value=\"".pg_result($result,'c_5')."\" $HIGHLIGHT READONLY></td><td align=\"CENTER\" width=10%><input type='text' name='con5' id='con5' value=\"".pg_result($result,'v_c_5')."\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#AAC9EA><td align=\"CENTER\" width=10%>2 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\" width=10%><input type=\"TEXT\" name=\"coin2\" size=\"5\" id=\"coin2\"value=\"".pg_result($result,'c_2')."\" $HIGHLIGHT READONLY></td><td align=\"CENTER\" width=10%><input type='text' name='con2' id='con2' value=\"".pg_result($result,'v_c_2')."\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#AAC9EA><td align=\"CENTER\" width=10%>1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\" width=10%><input type=\"TEXT\" name=\"coin1\" size=\"5\" id=\"coin1\"value=\"".pg_result($result,'c_1')."\" $HIGHLIGHT READONLY></td><td align=\"CENTER\" width=10%><input type='text' name='con1' id='con1' value=\"".pg_result($result,'v_c_1')."\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#AAC9EA><td align=\"CENTER\" width=10%>0.50 &nbsp;&nbsp;&nbsp;X</td>
	  <td align=\"CENTER\" width=10%><input type=\"TEXT\" name=\"paisa50\" size=\"5\" id=\"paisa50\"value=\"".pg_result($result,'c_50paisa')."\" $HIGHLIGHT READONLY></td><td align=\"CENTER\" width=10%><input type='text' name='pas5' id='pas5' value=\"".pg_result($result,'v_c_50paisa')."\" size='10' $HIGHLIGHT READONLY></td></tr>";
echo "<tr bgcolor=#48D1CC><td align=\"CENTER\" width=10%><b>Total</td>
	  <td align=\"CENTER\" width=10%><td align=\"CENTER\" width=10%><input type=\"TEXT\" name=\"Total\" size=\"12\" id=\"Total\"value=\"".pg_result($result,'total')."\" $HIGHLIGHT READONLY></td></tr>";
echo "</table >";
echo "</form>";
}
?>
