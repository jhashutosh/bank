<?
include "../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
echo "<head>";
echo "<title>Employee Search";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/mini_clienthint.js\"></script>";
echo "</head>";
echo "<body bgcolor='aqua'>";
echo"<form>";
echo"<table align='center' width='100%'>
<tr><th bgcolor='silver'><font color='darkblue'><b>Search By</b></font></th></tr>";
/*echo"<tr><td>Employee Id:</td></tr><tr>";
echo"<td><select name='ei'default='0'> <option value='0'>null</option>";
for($j=0; $j<pg_NumRows($result); $j++) {
$row=pg_fetch_array($result,$j);
//echo $row['eid'];
echo"<option value='".$row['eid']."'>".$row['eid']."</option>";
                                        }
echo"</select>";
echo"</td></tr>";*/
echo"<tr><td align=\"left\">Employee Name:</td></tr><tr><td><input type='text' name=\"name\" id=\"name\" size='15' onkeyup=\"showEmpHint(this.value)\"  $HIGHLIGHT ><label align=\"left\"></label></td></tr>";
//echo"<tr><td><a href='sas.php?id=' target='content'>Search</a></td></tr></form>";
//echo"<tr><td><input type='submit' value='search'></td></tr></form>";
echo"<tr><td><br></td></tr>";
echo"</form>
<p><span id='txtHint'></span></p>";
echo "</body>";
echo "</html>";
?>

