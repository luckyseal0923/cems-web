<?
require_once("../_inc.php");
$subname=$pageTitle2;
$is_list="1";
$unitprocess=$m_home;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require("../_in_code_head.php"); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $pageTitle1.$pageTitle2 ?></title>
<?php require("../_in_javascript.php"); ?>
</head>

<body>
<?php require("../_top.php"); ?>
<div id="m-wrapper">
  <div class="m-container narrow">
    <?php require("../_sidebar.php"); ?>
    <div class="m-main">
      <?php require("../_banner.php"); ?>
      <div class="m-content">
        <div class="m-crumb"><i class="fa fa-folder-open-o"></i><?php echo $unitprocess;?></div>
        <div class="center">
          <p><?php echo $_SESSION["UserName"] ?>您好，歡迎您的登入</p>
          <p>直接點選功能選單進行管理，謝謝！</p>
        </div>
      </div>
      <!--content-->
      <?php require("../_footer.php"); ?>
    </div>
    <!--main-->
  </div>
  <!--container-->
</div>
<!--wrapper-->
<?php require("../_in_code_bottom.php"); ?>

</body>
</html>