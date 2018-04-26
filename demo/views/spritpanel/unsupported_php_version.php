<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SpritPanel</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="stylesheet" href="assets/css/global.css">
	<link rel="stylesheet" href="assets/css/local.css">
	<link rel="shortcut icon" href="assets/img/favicon.ico">
	<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
</head>
<body data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-active-dialog-csv="">
	<div id="divPrerequisitiesError" class="divPageContent divMessageDialog" style="background-color: transparent;display:block;">
		<div class="divContentWrapper level3">
			<div class="divDialogContentContainer">
				<header class="headerHero z-depth-1 red darken-4">
					<div class="divHeaderInfo">
						<h3 class="red-text text-darken-4">Unsupported PHP Version</h3>
					</div>
				</header>
				<div class="divContentPanel z-depth-1 red darken-4 center">
					<div class="white-text">
						<p id="pFormErrorText">You are using an unsupported PHP version.<br>Your PHP version must be equal or higher than 5.3.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>