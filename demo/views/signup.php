<?php includeView($controller, 'head'); ?>
<body class="bodyLogin" data-url-prefix="<?php echo $_SPRIT['URL_PREFIX']; ?>" data-active-dialog-csv="">
	<div class="divDialogContent divMessageDialog" id="divLogin" style="background-color: transparent;">
		<div class="divContentWrapper level4" style="margin-top:0px;">
			<div class="divDialogContentContainer">
				<header class="headerHero z-depth-1 blue darken-4">
					<div class="divHeaderInfo">
						<h3 class="blue-text text-darken-4"><?php echo __('SPAC 5S'); ?></h3>
					</div>
				</header>
				<div class="divContentPanel z-depth-1">
					<form id="formSignup" name="formSignup" method="post" action="<?php echo $_SPRIT['URL_PREFIX']; ?>signup/formsignup" class="form-horizontal" target="iframeFormSignup">
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<input id="firstname" name="firstname" type="text" class="blue-text text-darken-4" value="" placeholder="<?php echo __('Ad'); ?>" style="font-size: 1.25rem">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<input id="lastname" name="lastname" type="text" class="blue-text text-darken-4" value="" placeholder="<?php echo __('Soyad'); ?>" style="font-size: 1.25rem">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<input id="email" name="email" type="text" class="blue-text text-darken-4" value="" placeholder="<?php echo __('E-mail Adres'); ?>" style="font-size: 1.25rem">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<input id="password" name="password" type="password" class="blue-text text-darken-4" value="" placeholder="<?php echo __('Şifre'); ?>" style="font-size: 1.25rem">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<input id="repassword" name="repassword" type="password" class="blue-text text-darken-4" value="" placeholder="<?php echo __('Şifre Tekrar'); ?>" style="font-size: 1.25rem">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col s12 center">
								<a id="aLoginLink" class="blue-text text-darken-4" href="<?php echo $_SPRIT['URL_PREFIX']; ?>login"><?php echo __('Hesabınız var mı?'); ?></a>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<button id="buttonSubmitSignupForm" name="buttonSubmitSignupForm" data-default-text="<?php echo __('KAYIT OL'); ?>" data-loading-text="<?php echo __('KAYIT OLUYOR...'); ?>" type="submit" class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('KAYIT OL'); ?></button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="divSuccessDialog" class="divDialogContent divAlertDialog divSuccessDialog">
		<div class="divContentWrapper level3">
			<div class="divDialogContentContainer">
				<header class="headerHero z-depth-1 green darken-4">
					<div class="divHeaderInfo">
						<h3 class="green-text text-darken-4"><?php echo __('Başarılı!'); ?></h3>
					</div>
				</header>
				<div class="divContentPanel z-depth-1 green darken-4">
					<div class="white-text">
						<p id="pFormSuccessText"></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="divErrorDialog" class="divDialogContent divAlertDialog divErrorDialog">
		<div class="divContentWrapper level3">
			<div class="divDialogContentContainer">
				<header class="headerHero z-depth-1 red darken-4">
					<div class="divHeaderInfo">
						<h3 class="red-text text-darken-4"><?php echo __('Hata'); ?></h3>
					</div>
					<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"><i class="ion-android-close red-text text-darken-4"></i></button>
				</header>
				<div class="divContentPanel z-depth-1 red darken-4">
					<div class="white-text">
						<p id="pFormErrorText"></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<iframe id="iframeFormSignup" name="iframeFormSignup" class="iframeFormPOST"></iframe>
	<script type="text/javascript" src="assets/js/global.js"></script>
	<script type="text/javascript" src="assets/js/signup.js"></script>
</body>
</html>