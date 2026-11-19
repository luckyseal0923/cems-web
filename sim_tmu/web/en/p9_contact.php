<?php
  require("_inc.php");
	$pageName = "p9";
	$subPageName = "p9_1";
  $nav=$home.$icon.$p9;
?>
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<?php require("_in_code_head.php"); ?>
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
<![endif]-->

<!-- Mobile layout control 若需自適應打開此設定 
<meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->
<title><?php echo $pageTitle;?></title>
<meta name="description" content="<?php echo $m_description;?>" />
<meta name="keywords" content="<?php echo $m_keywords;?>" />
<meta name="Robots" content="all" />
<?php require("_in_javascript.php"); ?>
<script language="JavaScript" type="text/javascript">
  /*-----------------------------------------*/
  //秀出驗證圖
  $(function() {
    $("#imgg").attr("src", "code.php?" + Math.random());
    $("#renew").click(function() {
      $("#imgg").attr("src", "code.php?" + Math.random());
    });
  });
  /*-----------------------------------------*/
  //偵測Form裡的各欄位----^_^
  function sbForm() {
    var theForm = document.chkForm;
    if (fieldCheck0(theForm)) {
      theForm.Send.value = "OK";
      theForm.submit();
    }
  }
  /*-----------------------------------------*/
  function fieldCheck0(theForm) {
    /*====================================*/
    if (theForm.strName.value == "") {
      alert("Please enter your Name");
      theForm.strName.focus();
      return false;
    }
    /*====================================*/
    if (theForm.Tel.value == "") {
      alert("Please enter your phone number");
      theForm.Tel.focus();
      return false;
    }
    /*====================================*/
    var reg = /^([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+$/i;
    if (!reg.test(theForm.EMail.value)) {
      alert("[Email] Blank or wrong format");
      theForm.EMail.focus();
      return false;
    }
    /*====================================*/
    if (theForm.Message.value == "") {
      alert("Please enter your messages");
      theForm.Message.focus();
      return false;
    }
    /*====================================*/
    if (theForm.Code.value == "") {
      alert("Please enter your Confirmation Code");
      theForm.Code.focus();
      return false;
    }
    /*====================================*/
    return true;
  }
  /*-----------------------------------------*/
</script>
</head>
<body <?php echo $bodytxt; ?>>
  <div id="wrapper">
    <?php require("_menu.php"); ?>
    <?php require("_header.php"); ?>
    <div class="container clearfix">
      <?php require("_sidebar.php"); ?>
      <div class="main">
        <h2><?php echo $p9;?></h2>
        <div class="site"><?php echo $nav;?></div>
        <form method="post" action="mail.php" name="chkForm" id="chkForm">
          <div class="formWrap">
            <table>
              <tr>
                <td class="form_item">Company</td>
                <td class="form_date"><input name="Company" id="Company" type="text" class="date_text" onclick="javascript:this.value='';" /></td>
              </tr>
              <tr>
                <td class="form_item">Name</td>
                <td class="form_date">
                  <input name="strName" type="text" class="date_text" id="strName" size="20" onclick="javascript:this.value='';" />
                  <input name="Sex" type="radio" value="Mr." checked="checked" />Mr.
                  <input name="Sex" type="radio" value="Ms." />Ms.</td>
              </tr>
              <tr>
                <td class="form_item">Tel</td>
                <td class="form_date">
                  <input name="Tel" type="text" class="date_text" onclick="javascript:this.value='';" id="Tel" size="20" />
                  <!--<input name="Tel" id="Tel" value="聯絡電話" type="text" class="date_text" onclick="javascript:this.value='';"  required />-->
                </td>
              </tr>
              <tr>
                <td class="form_item">Fax</td>
                <td class="form_date"><input name="Fax" id="Fax" type="text" class="date_text" onclick="javascript:this.value='';" /></td>
              </tr>
              <tr>
                <td class="form_item">Address</td>
                <td class="form_date"><input name="Address" id="Address" type="text" class="date_text" onclick="javascript:this.value='';" /></td>
              </tr>
              <tr>
                <td class="form_item">E-mail</td>
                <td class="form_date"><input name="EMail" id="EMail" type="email" class="date_text" onclick="javascript:this.value='';" /></td>
              </tr>
              <tr>
                <td class="form_item">Messages</td>
                <td class="form_date"><textarea name="Message" id="Message" class="date_message" required></textarea>
                  <span class="ex">※ Press Enter to branch</span></td>
              </tr>
              <tr>
                <td class="form_item">Verification code</td>
                <td class="form_date"><input name="Code" id="Code" value="Enter the number on the right" type="text" maxlength="6" class="date_code" onclick="javascript:this.value='';" />
                  <img src="../images/all/loader.white.gif" id="imgg" name="imgg" align="absmiddle" />
                  <input type="hidden" name="Send" id="Send" />
                  <a href="javascript:;" id="renew"><i class="fa fa-refresh"></i></a></td>
              </tr>
            </table>
          </div>
          <div class="btnWrap">
            <div class="reset_btn flt">
              <a href="javascript:document.chkForm.reset();">Empty refill</a>
            </div>
            <div class="Send_btn flt">
              <a href="javascript:sbForm(); " onMouseOut="MM_swapImgRestore()">Submit</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php require("_footer.php"); ?>
</body>

</html>
