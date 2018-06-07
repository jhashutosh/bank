<HTML>
<?php include "../config/config.php"; 
deregisterSession();
?>
<TITLE>
Login  to CAS
</TITLE>
<LINK href="../css/test.css" type="text/css" rel=STYLESHEET>
<script language="javascript">
function onLoadFocus(){
document.getElementById("name1").focus();
}
</script>
<BODY bgcolor="silver"  onload="onLoadFocus()">
<CENTER>
<BR>

<BR>
<h1><font color=#000080>
Welcome to 
<I><?php echo $PROJECT_TITLE; ?></I></h1>
<font color=#448844> 
<I><?php echo $SYSTEM_TITLE; ?></I>
Version - <?php echo $VERSION_INFO; ?> 
</FONT>
<BR>
<FORM  method=POST action="authorization.php?loginform=true" target=_top>

<TABLE width="700">
<tr>
<td>
<font color=gray><I>To access advance facilities, administrator(s) should go through login procedure.<BR>Please ask system administrator if you want to open a new account.</I></FONT>
</td>
<td>
<TABLE width="350">
<TR><td><br><td>
<TR>
<TD align=left><b>User Id :<TD align=left><INPUT type="text"  id="name1" name="id" value="" size=25 <?php echo $HIGHLIGHT; ?> >
<TR>
<TD align=left><b>Password:<TD aligh=left><INPUT type="password"  name="password" value="" size=25 <?php echo $HIGHLIGHT; ?> >
<tr>
<TD align=left><b>Financial Year:<TD aligh=left>

<?php makeSelectFromDB("fy_list","fy","fy");?>
<INPUT type="hidden"  name="lgn" value="1">
<INPUT type="hidden"  name="yes" value="y">
<TR><TD><TD align=center><INPUT type="submit" name="submit" value=" Sign In "></TD>
</TABLE>
</td>
</tr>
</TABLE>

</FORM>
<CENTER>
</BODY>
</HTML>

