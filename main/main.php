<?php
include "../config/config.php";
// PHP4
$status=$_REQUEST['status'];
$staff_id=verifyAutho();
if($status=='fail'){
  header("Location: ../index.php");
}
else{
$login_timestamp=time();
setcookie("login_time",$login_timestamp);
if(empty($login_timestamp)){
	$login_timestamp=time();
	setcookie("login_time",$login_timestamp);
}
?>
<HTML>
<HEAD>
<SCRIPT>
   function op() {
     // This function is for folders that do not open pages themselves.
     // See the online instructions for more information.
   }
  </SCRIPT>
<TITLE>Main Internal</TITLE>
</HEAD>
<FRAMESET ROWS="55,*,22" FRAMEBODER=NO BORDER=0 BORDERCOLOR="#448844" FRAMESPACING=0>
<FRAME SRC="../design/top_i1.php" target="display"  marginheight=0 marginwidth=0 scrolling="no" noresize FRAMEBODER=NO BORDER=0 BORDERCOLOR="#448844" FRAMESPACING=0 ></FRAME>
<FRAMESET COLS="*,200" onResize="if (navigator.family == 'nn4') window.location.reload()">
<FRAME SRC="myzone.php" name="basefrm"></FRAME>
<FRAME SRC="LeftFrame.php" name="treeframe"></FRAME>
</FRAMESET>
<FRAME SRC="../design/footer.php"></FRAME>
</FRAMESET>

</HTML>
<?php } ?>