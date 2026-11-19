<div class="m-footer">
  <div class="m-copyright">&copy;
      <? echo $pageTitle1;?>
    版權所有. All Rights Reserved. &nbsp; <a href="http://www.tsg.com.tw/" target="_blank">TSG</a> <a href="http://www.touchweb.com.tw/" target="_blank">網頁設計</a></div>
  <?php if (! stristr(strtolower($_SERVER["PHP_SELF"]),"list.php") && ! stristr(strtolower($_SERVER["PHP_SELF"]),"/login/")) {?>
  <a href="list.php" class="btn btn-sm btn-default m-back">回上一頁</a>
  <?php } ?>
</div>