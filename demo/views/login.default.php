<?php includeView($controller, 'head'); ?>
<body class="bodyLogin" data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-active-dialog-csv="">
	<div class="divDialogContent divMessageDialog" id="divLogin" style="background-color: transparent;">
		<div class="divContentWrapper level4">
			<div class="divDialogContentContainer">
				<header class="headerHero z-depth-1 blue darken-4">
					<div class="divHeaderInfo">
						<h3 class="blue-text text-darken-4"><?php echo __('SPAC 5S'); ?></h3>
					</div>
				</header>
				<div class="divContentPanel z-depth-1">
					<form id="formLogin" name="formLogin" method="post" action="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>login/formlogin" class="form-horizontal" target="iframeFormLogin">
						<div class="row" style="margin-bottom: 40px;">
							<div class="col s12">
								<?php echo __('Please enter your e-mail address and password to log in to your account'); ?>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<input id="loginEmail" name="loginEmail" type="text" class="blue-text text-darken-4" value="" placeholder="<?php echo __('E-mail Address'); ?>" style="font-size: 1.25rem">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<input id="loginPassword" name="loginPassword" type="password" class="blue-text text-darken-4" value="" placeholder="<?php echo __('Password'); ?>" style="font-size: 1.25rem">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<button id="buttonSubmitLoginForm" name="buttonSubmitLoginForm" data-default-text="<?php echo __('LOG IN'); ?>" data-loading-text="<?php echo __('LOGGING IN...'); ?>" type="submit" class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('LOG IN'); ?></button>
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
						<h3 class="blue-text text-darken-4"><?php echo __('Forgot Password?'); ?></h3>
					</div>
				</header>
				<div class="divContentPanel z-depth-1">
					<form id="formForgotPassword" name="formForgotPassword" method="post" action="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>login/formforgotpassword" class="form-horizontal" target="iframeFormForgotPassword">
						<div class="row" style="margin-bottom: 40px;">
							<div class="col s12">
								<?php echo __('Please enter your e-mail address to reset your password.'); ?>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<input id="strForgotPasswordEmail" name="strForgotPasswordEmail" type="text" class="blue-text text-darken-4" value="" placeholder="<?php echo __('Email Address'); ?>" style="font-size: 1.25rem">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<button type="submit" id="buttonSubmitForgotPasswordForm" name="buttonSubmitForgotPasswordForm" data-default-text="<?php echo __('Reset Password'); ?>" data-loading-text="<?php echo __('Resetting Password...'); ?>"  class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('Reset Password'); ?></button>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col s12 center">
								<?php echo __('Have an account?'); ?> <a href="JavaScript:void(0);" class="aLoginLink blue-text text-darken-4"><?php echo __('Log in'); ?></a>
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
						<h3 class="green-text text-darken-4"><?php echo __('Success!'); ?></h3>
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
						<h3 class="red-text text-darken-4"><?php echo __('Error'); ?></h3>
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
	<iframe id="iframeFormLogin" name="iframeFormLogin" class="iframeFormPOST"></iframe>
	<iframe id="iframeFormForgotPassword" name="iframeFormForgotPassword" class="iframeFormPOST"></iframe>
	<script type="text/javascript" src="assets/js/global.js"></script>
	<script type="text/javascript" src="assets/js/login.js"></script>
</body>
</html>