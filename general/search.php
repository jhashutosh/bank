<?php
include "../config/config.php";
$menu=$_REQUEST['menu'];
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/clienthint.js\"></script>";
//echo "<script src=\"../JS/autoComplete.js\"></script>";
echo "<body bgcolor=\"silver\" onload=\"setFocus('".$menu."')\"> ";
echo $setFocus;
echo "<h2><font color=blue>Searching by Name...</font></h2>";
echo "just put necessary details"; 
echo "<hr>";
?>
<form>
<center>Name: <input type="text" size=50 id="txt1" onkeyup="showHint(this.value)" 
<?php echo $HIGHLIGHT;?> >
</form>
<p><span id="txtHint"></span></p>
<?php
echo "</body>";
echo "</html>";

?>
