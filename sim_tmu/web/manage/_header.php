<div id="header">
  <div class="header_login">
    <? if(! stristr($_SERVER["PHP_SELF"],"index.php")){?>
    <a href="../index.php?Action=Logout">登出</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <? ;}?>
    <a href="../../index.php?Action=Logout">登出到首頁</a> </div>
  <div class="logo"><img src="../../images/logo_top.gif" width="454" height="134" hspace="5" vspace="5" /></div>
  <div class="headername">後端管理介面</div>
</div>