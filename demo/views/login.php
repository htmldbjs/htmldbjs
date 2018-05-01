<?php includeView($controller, 'head'); ?>
<body class="bodyLogin" data-url-prefix="<?php echo $_SPRIT['URL_PREFIX']; ?>" data-active-dialog-csv="">
	<div class="divDialogContent divMessageDialog" id="divLogin" style="background-color: transparent;">
		<div class="divContentWrapper level4">
			<div class="divDialogContentContainer">
				<header class="headerHero z-depth-1 blue darken-4">
					<div class="divHeaderInfo">
						<h3 class="blue-text text-darken-4"><?php echo __('SPAC 5S'); ?></h3>
					</div>
				</header>
				<div class="divContentPanel z-depth-1">
					<form id="formLogin" name="formLogin" method="post" action="<?php echo $_SPRIT['URL_PREFIX']; ?>login/read" class="form-horizontal htmldb-form" data-htmldb-table="loginHTMLDB" onsubmit="return false;">
						<input type="hidden" name="id" id="id" class="htmldb-field" data-htmldb-field="id" value="0">
						<div class="row" style="margin-bottom: 40px;">
							<div class="col s12">
								<?php echo __('Hesabınıza giriş yapmak için lütfen e-mail adresinizi ve şifrenizi giriniz.'); ?>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<input id="login_email_address" name="login_email_address" data-htmldb-field="email_address" type="text" class="blue-text text-darken-4 htmldb-field" value="" placeholder="<?php echo __('E-mail Address'); ?>" style="font-size: 1.25rem">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<input id="login_password" name="login_password" data-htmldb-field="password" type="password" class="blue-text text-darken-4 htmldb-field" value="" placeholder="<?php echo __('Password'); ?>" style="font-size: 1.25rem">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col s6 left-align">
								<a id="aSignupLink" class="blue-text text-darken-4" href="<?php echo $_SPRIT['URL_PREFIX']; ?>signup"><?php echo __('Kayıt Ol'); ?></a>
							</div>
							<div class="col s6 right-align">
								<a id="aForgotPasswordLink" class="blue-text text-darken-4" href="JavaScript:void(0);"><?php echo __('Şifremi Unuttum'); ?></a>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<button id="buttonSubmitLoginForm" name="buttonSubmitLoginForm" data-default-text="<?php echo __('GİRİŞ YAP'); ?>" data-loading-text="<?php echo __('GİRİŞ YAPILIYOR...'); ?>" type="submit" class="waves-effect waves-light btn-large blue darken-4 col s12 htmldb-button-save" data-htmldb-table="loginHTMLDB"><?php echo __('GİRİŞ YAP'); ?></button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="divDialogContent divMessageDialog" id="divForgotPassword" style="background-color: transparent;">
		<div class="divContentWrapper level4">
			<div class="divDialogContentContainer">
				<header class="headerHero z-depth-1 blue darken-4">
					<div class="divHeaderInfo">
						<h3 class="blue-text text-darken-4"><?php echo __('Şifremi Unuttum'); ?></h3>
					</div>
				</header>
				<div class="divContentPanel z-depth-1">
					<form id="formForgotPassword" name="formForgotPassword" method="post" action="<?php echo $_SPRIT['URL_PREFIX']; ?>login/formforgotpassword" class="form-horizontal" target="iframeFormForgotPassword">
						<div class="row" style="margin-bottom: 40px;">
							<div class="col s12">
								<?php echo __('Şifrenizi sıfırlamak için lütfen e-mail adresinizi giriniz.'); ?>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<input id="strForgotPasswordEmail" name="strForgotPasswordEmail" type="text" class="blue-text text-darken-4" value="" placeholder="<?php echo __('E-mail Adresi'); ?>" style="font-size: 1.25rem">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<button type="button" id="buttonSubmitForgotPasswordForm" name="buttonSubmitForgotPasswordForm" data-default-text="<?php echo __('Şifreyi Sıfırla'); ?>" data-loading-text="<?php echo __('Şifre sıfırlanıyor...'); ?>"  class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('Şifreyi Sıfırla'); ?></button>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col s12 center">
								<?php echo __('Hesabınız var mı?'); ?> <a href="JavaScript:void(0);" class="aLoginLink blue-text text-darken-4"><?php echo __('Giriş Yap'); ?></a>
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
	<div class="divDialogContent divLoader" id="divLoader">
	    <div class="divContentWrapper level4">
	        <div class="divDialogContentContainer">
	            <div class="row">
	                <div class="col s12 center-align">
	                    <img src="assets/img/loader.svg" width="70" height="70" />
	                </div>
	            </div>
	            <div class="row">
	                <div id="divLoaderText" class="col s12 m12 l12 blue-text text-darken-4 center" data-default-text=""></div>
	            </div>
	        </div>
	    </div>
	</div>
	<div id="loginHTMLDB" class="htmldb-table" data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>login/read" data-htmldb-validate-url="<?php echo $_SPRIT['URL_PREFIX']; ?>login/validate" data-htmldb-write-url="<?php echo $_SPRIT['URL_PREFIX']; ?>login/write" data-htmldb-writeonly="1" data-htmldb-loader="divLoader" data-htmldb-redirect="<?php echo $_SPRIT['URL_PREFIX']; ?>home"></div>
	<div id="forgotPasswordHTMLDB" class="htmldb-table" data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>forgotpassword/read" data-htmldb-validate-url="<?php echo $_SPRIT['URL_PREFIX']; ?>forgotpassword/validate" data-htmldb-write-url="<?php echo $_SPRIT['URL_PREFIX']; ?>forgotpassword/write" data-htmldb-writeonly="1" data-htmldb-loader="divLoader"></div>
	<script type="text/javascript" src="assets/js/global.js"></script>
	<script type="text/javascript" src="../source/htmldb.js"></script>
	<script type="text/javascript" src="assets/js/spritpanel.htmldb.js"></script>
	<script type="text/javascript" src="assets/js/login.js"></script>
</body>
</html>