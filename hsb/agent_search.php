<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$agent_id=$_REQUEST['agent'];
echo $agent_id;
echo "<html>";
echo "<head>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<link rel=\"stylesheet\" href=\"../css/autosuggest_inquisitor.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\" />";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";
echo "<script src=\"../JS/clienthint.js\"></script>";
//echo "<script src=\"../JS/autoComplete.js\"></script>";
echo "<body bgcolor=\"silver\" onload=\"agent.focus();\"> ";
echo $setFocus;
echo "<center><h2><font color=blue>Searching by Agent Name...</font></h2></center>";
echo "<hr>";
echo "<table width=\"100%\" BGCOLOR=\"yellow\">";
echo "<form method=\"POST\" name=\"f1\"action=\"commission_detail.php?menu=$menu&agent=$agent_id\">";
echo "<tr><td align=\"Right\"><b>Search The Agent Name :</b><td><input type=\"TEXT\" Name=\"agent\" id=\"agent\" size=\"45\" $HIGHLIGHT>";
echo "&nbsp;&nbsp;<input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "</table>";
echo "</form>";
echo "</body>";
echo "</html>";
?>
<script type="text/javascript">
	var frmvalidator  = new Validator("f1");
 	frmvalidator.addValidation("agent","req","Please Enter the Agent Nmae");
	var options = {
		script:"autoComplete.php?json=true&op=a&",
		varname:"input",
		json:true,
	};
	var as_json1 = new AutoSuggest('agent', options);
</script>

