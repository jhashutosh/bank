<?php 
include "../config/config.php"; 
echo "<HTML>";
echo "<LINK href=\"../css/test.css\" type=text/css rel=STYLESHEET>";
echo "<TITLE>Index";
echo "</TITLE>";
echo "<BODY VLINK=\"WHITE\" LINK=\"WHITE\"  ALINK=\"WHITE\" ALIGN=\"CENTER\">";
echo "<TABLE>";
echo "<TR>";
echo "<TD width=900 align=right>";
echo "<font size=+1><I>$SYSTEM_TITLE</FONT> <font color=BLUE size=+2><b>$VERSION_INFO</I></FONT>";
//echo "<br>$ORG_CODE";
echo "<BR>";
echo "<I>$PROJECT_TITLE</I><BR>";
echo "<tt>$ORGANISATION_TITLE</tt><BR>";
echo "<TD>";
echo "</TABLE>";
echo "</BODY>";
echo "</HTML>";

?>
