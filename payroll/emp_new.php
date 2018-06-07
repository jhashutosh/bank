<?
include "../config/config.php";
echo "<head>";
echo "<title>Employee";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo"<body bgcolor='66CCFF'>";
echo"<form name='f1' action='emp_ef.php' method='post'>";
echo"<table width='100%'><tr><th bgcolor='white'>Creation of new Employee</th></tr></table>";
echo"<table align='center'>";
echo"<tr><td >Already a Customer </td><td width='1%'>:</td><td><input type='radio' name='check' value='y' onclick=\"c_id.disabled=false\">Yes<input type='radio' name='check' value='n' onclick=\"c_id.disabled=true\" >No</td></tr><tr><td align='left'>Give your Customer Id</td><td width='1%'>:</td><td> <input type='text' name='c_id' value='C-' size='25' $HIGHLIGHT>";
echo"<tr><th colspan='3'><input type='submit' name='Submit' value='Go'></th></tr>";
echo"</table>";
echo"</body>";
?>
