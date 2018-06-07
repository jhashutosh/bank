<?php 
include "../config/config.php"; 
$staff_id=verifyAutho();
$fy=$_SESSION["fy"];
echo "<HTML>";
echo "<HEAD>";
echo "<LINK href=\"../css/test.css\" type=text/css rel=STYLESHEET>";
echo "<TITLE>$SYSTEM_TITLE";
echo "</TITLE>";
echo "</HEAD>";
echo "<BODY BGCOLOR=\"$FRAMECOLOR\" VLINK=WHITE LINK=WHITE  ALINK=WHITE ALIGN=\"CENTER\">";
echo "<DIV ID=\"menu_item\" style=\"position:relative; top:2\">";
echo "<TABLE>";
echo "<TR>";
echo "<TD width=500 align=left>";
echo "<I>$SYSTEM_TITLE<font color=white>&nbsp;$VERSION_INFO</FONT></I></FONT>";
echo "<BR>";
echo "<tt><font color=BLACK  size=+1>$ORGANISATION_TITLE</font></tt><BR>";
echo "</TD>";

echo "<TD width=300 align=center ><font color=#333333  size=2px>Login ID    : ".$staff_id."<br>Login Year: ".$fy."</font></td>";
echo "<TD width=500 align=right><font color=white >".date('l dS \of F Y h:i:s A')."</font></TD></tr>";
/*echo "<TD width=500 align=right>";
echo "<I>$SYSTEM_TITLE<font color=white>&nbsp;$VERSION_INFO</FONT></I></FONT>";
echo "<BR>";
echo "<tt><font color=BLACK  size=+1>$ORGANISATION_TITLE</font></tt><BR>";
echo "</TD>";
echo "<TD>";
echo "<A HREF=\"../main/main.php\" target=_top><img src=\"../image/logo.gif\" width=35 height=45></A></td></tr>";*/
echo "</TABLE>";
echo "</DIV>";
echo "</BODY>";
echo "</HTML>";
?>
