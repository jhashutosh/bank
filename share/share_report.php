<?php 
include "../config/config.php"; 
?>
<HTML>
<TITLE>Share Reports</TITLE>
<LINK href="../css/test.css" type="text/css" rel="STYLESHEET">
<center>
<font color="GREEN">

<H1>Share Reports</H1>
</font>
</center>

<HR color=SKYBLUE>

<BODY>
<table>
<tr>
<td>
<ol>
<li><A HREF="../general/summary_report.php?menu=sh">Summary</A>
<li><A HREF="../general/scroll_sh.php?menu=sh">Scroll</A>
<li><A HREF="share_current_balance.php">Current Balance</A>
<li><A HREF="growth_in_share.php">Growth in Share Capital</A>
<li><A HREF="share_reg.php?menu=sh" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;">Share Register</A>
<li><A HREF="share_ded_name.php?menu=sh">Dead/Alive Share Holder Register</A>
<!--<li><A HREF="../general/scroll_sh.php?menu=sh">Scroll between range</A>-->
<li><A HREF="share_reg_name.php?menu=sh">Share Register By Name</A>
<!--<li><A HREF="share_reg_by_lf.php?menu=sh">Share Reg By Ledger Folio</A>-->
<li><A HREF="share_reg_address.php?menu=sh">Share Register By Address</A>
<li><A HREF="nominy_list.php?menu=sh">Nominee Register</A>
</tr>
</TABLE>
<HR color=SKYBLUE>
</BODY>
</HTML>
