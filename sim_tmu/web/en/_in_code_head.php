<!--FB讚用(在FB,滑過讚的項目會出現圖及文章名)-->
<meta property="og:site_name" content="<?php echo $pageTitle;?>"/>
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo $pageTitle;?>"/>
<meta property="og:image" content="<?php echo $this_url;?>images/fb_img.gif"/>
<meta property="og:url" content="<?php echo $this_url;?>" />
<meta property="og:description" content="<?php echo $m_description;?>" />
<meta property="fb:admins" content="aokaku" />
<link rel="image_src" type="image/jpeg" href="<?php echo $this_url;?>images/fb_img.gif" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
<![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<?php
	//title
	if ( $pageName == "p1" ){
		$pageTitle = $p1 . "∣" . $pageTitle2;
	
	} elseif ( $pageName == "p2" ){
		$pageTitle = $p2 . "∣" . $pageTitle2;
		
	} elseif ( $pageName == "p3" ){
		$pageTitle = $p3 . "∣" . $pageTitle2;

	} elseif ( $pageName == "p4" ){
		$pageTitle = $p4 . "∣" . $pageTitle2;

	} elseif ( $pageName == "p5" ){
		$pageTitle = $p5 . "∣" . $pageTitle2;

	} elseif ( $pageName == "p6" ){
		$pageTitle = $p6 . "∣" . $pageTitle2;

	} elseif ( $pageName == "p7" ){
		$pageTitle = $p7 . "∣" . $pageTitle2;
	} elseif ( $pageName == "p8" ){
		$pageTitle = $p8 . "∣" . $pageTitle2;

	} elseif ( $pageName == "p9" ){
		$pageTitle = $p9 . "∣" . $pageTitle2;
	}
?>