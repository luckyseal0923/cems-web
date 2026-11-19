<?php
  require("_inc.php");
  $pageName = "p2";
  $subPageName = "p2_3";
  $nav=$home.$icon.$p2.$icon.$p2_3;
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
<meta name="description" content="" />
<meta name="keywords" content="<?php echo $m_keywords;?>" />
<meta name="Robots" content="all" />
<?php require("_in_javascript.php"); ?>
<script>
$(document).ready(function() {
//Examples of how to assign the Colorbox event to elements
$(".group1").colorbox({
  rel: 'group1'
});
$(".iframe").colorbox({
  iframe: true,
  width: "820px",
  height: "550px"
});

//Example of preserving a JavaScript event for inline calls.
$("#click").click(function() {
  $('#click').css({
    "background-color": "#f00",
    "color": "#fff",
    "cursor": "inherit"
  }).text("Open this window again and this message will still be here.");
  return false;
});
});
</script>
</head>

<body <?php echo $bodytxt; ?>>
  <div id="wrapper">
    <?php require("_menu.php"); ?>
    <?php require("_header.php"); ?>
    <div class="container clearfix">
      <?php require("_sidebar.php"); ?>
      <div class="main">
        <h2><?php echo $p2_3;?></h2>
        <div class="site"><?php echo $nav;?>
        </div>
        <div class="intro_box">
          <table width="100%" border="0" cellpadding="0" cellspacing="0" class="about_table">
            <tbody>
              <tr>
                <td>Lin, Thomas Che-Wei</td>
                <td>
                  <ul>
                    <li>Director</li>
                    <li>Chief Executive Officer</li>
                    <li><a href="mailto:thomas0205@tmu.edu.tw">thomas0205@tmu.edu.tw</a></li>
                  </ul>
                </td>
                <td>
                  <ul>
                      <li>Supervision of Medical Simulation Center affairs</li>
                      <li>Implementation of various affairs relating to the Center</li>
                      <li>Planning of Medical Simulation Teacher Education courses and workshops</li>
                      <li>Facilitation of development of medical simulation education</li>
                  </ul>
                </td>
                <td><ul>
                  <li>Primary Proxy：Huang, Wen-Cheng</li>
                  <li>Secondary Proxy：Wu, Jen-Chieh</li>
                </ul></td>
              </tr>
              <tr>
                <td>Huang, Wen-Cheng</td>
                <td>
                  <ul>
                    <li>Deputy Director</li>
                    <li><a href="mailto:ynew0207@gmail.com">ynew0207@gmail.com</a></li>
                  </ul>
                </td>
                <td>
                  <ul>
                    <li>Supervision of Medical Simulation Center affairs</li>
                    <li>Implementation of various affairs relating to the Center</li>
                    <li>Planning of Medical Simulation Teacher Education courses and workshops</li>
                    <li>Facilitation of development of medical simulation education</li>
                  </ul>
                </td>
                <td><ul>
                  <li>Primary Proxy：Wu, Jen-Chieh</li>
                  <li>Secondary Proxy：Lin, Thomas Che-Wei</li>
                </ul></td>
              </tr>
              <tr>
                <td>Wu, Jen-Chieh</td>
                <td>
                  <ul>
                    <li>Deputy Director</li>
                    <li><a href="mailto:lendiswu@hotmail.com">lendiswu@hotmail.com</a></li>
                  </ul>
                </td>
                <td>
                  <ul>
                      <li>Supervision of Medical Simulation Center affairs</li>
                      <li>Implementation of various affairs relating to the Center</li>
                      <li>Planning of Medical Simulation Teacher Education courses and workshops</li>
                      <li>Facilitation of development of medical simulation education</li>
                  </ul>
                </td>
                <td><ul>
                  <li>Primary Proxy：Huang, Wen-Cheng</li>
                  <li>Secondary Proxy：Lin, Thomas Che-Wei</li>
                </ul></td>
              </tr>
              <tr>
                <td>Chen, Hao-Yu</td>
                <td>
                  <ul>
                    <li>Contract Staff</li>
                    <li>3333</li>
                    <li><a href="mailto:haoyu68@tmu.edu.tw">haoyu68@tmu.edu.tw</a></li>
                  </ul>
                </td>
                <td>
                  <ul>
                    <li>International conferences and teacher training workshops</li>
                      <li>Planning of Medical Simulation Teacher Education courses and workshops</li>
                      <li>Implementation of business model</li>
                </ul></td>
                <td><ul>
                  <li>Primary Proxy：Chen, Hung-Chen</li>
                  <li>Secondary Proxy：Ho, Jung</li>
                </ul></td>
              </tr>
              <tr>
                <td>Chen, Hung-Chen</td>
                <td><ul>
                  <li>Contract Staff</li>
                  <li>3330</li>
                  <li><a href="mailto:hungchen@tmu.edu.tw">hungchen@tmu.edu.tw</a></li>
                </ul></td>
                <td><ul>
                  <li>Website design and management</li>
                  <li>Management of center facilities and model scheduling</li>
                  <li>Project execution and budget management</li>
                </ul></td>
                <td><ul>
                  <li>Primary Proxy：Ho, Jung</li>
                  <li>Secondary Proxy：Chen, Hao-Yu</li>
                </ul></td>
              </tr>
              <tr>
                <td>Ho, Jung</td>
                <td><ul>
                  <li>Contract Staff</li>
                  <li>3336</li>
                  <li><a href="mailto:john.jh0@tmu.edu.tw">john.jh0@tmu.edu.tw</a></li>
                </ul></td>
                <td><ul>
                  <li>Promotion of medical simulation education</li>
                  <li>Project execution and budget management</li>
                  <li>Higher Education Sprout Project management</li>
                </ul></td>
                <td><ul>
                  <li>Primary Proxy：Chen, Hao-Yu</li>
                  <li>Secondary Proxy：Chen, Hung-Chen</li>
                </ul></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php require("_footer.php"); ?>
</body>

</html>
