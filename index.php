<!doctype HTML>
<html>
<head>
<?php
	/* 
	require_once("mobile/Mobile_Detect.php"); 
	$d = new Mobile_Detect(); 
	if ($d->isMobile() || $d->isTablet()) 
		header("Location: http://m.jkode.us/captcha"); 
	*/ 
?>
<title>JKurtz Captcha</title>
<link rel="icon" type="image/jpg" href="images/icon.jpg">
<link rel="stylesheet" type="text/css" href="captcha.css">
<script type="text/javascript" src="jquery-stable.js"></script>
<script type="text/javascript" src="captcha.js"></script>
</head>
<body>
<div id="container">
<div id="header">JKODE Captcha</div>
<div id="copy">Developed by <a href="#" title="jason@jkurtz.net">Jason Kurtz</a></div>
<div class="inst">
	<span>Type what you see. Without the spaces.</span>
	<br>
	<span>Click the image to generate a new one.</span>
</div>
<div>
	<span><img src="images/minus.png" id="minus_img" width=25 height=25></span>
	<span><a id="captcha"><img id="captcha_image" src="captcha.php"></a></span>
	<span><img src="images/plus.png" id="plus_img" width=25 height=25></span>
</div>
<div><input type="text" id="input"></div>
<div id="ri_container"><img id="result_image" width=30 height=20></div>
</div>
</body>
</html>