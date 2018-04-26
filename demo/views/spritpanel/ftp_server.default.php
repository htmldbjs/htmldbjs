<?php includeView($controller, 'spritpanel/head'); ?>
<body data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-active-dialog-csv="" data-page-url="ftp_server">
	<?php includeView($controller, 'spritpanel/header'); ?>
	<div class="divFullPageHeader">
		<div class="row">
			<div class="divFullPageBG col s12"></div>
			<div class="list-container col s12">
				<div class="list-header">
					<div class="col s6"><h3 class="white-text"><?php echo __('FTP Server'); ?></h3><h4 class="white-text"></h4></div>
				</div>
			</div>
		</div>
	</div>
	<div id="divFTPServerContent" class="divPageContent divMessageDialog divFullPage row" style="background-color: transparent;">
		<div class="divContentWrapper ">
			<div class="divDialogContentContainer">
				<div class="divContentPanel z-depth-1">
					<form id="formFTPServer" name="formFTPServer" method="post" action="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>ftp_server/formftpserver" class="form-horizontal" target="iframeFormFTPServer">
						<input type="hidden" id="bTestFTPServer" name="bTestFTPServer" value="0">
						<input type="hidden" id="bSaveFTPServer" name="bSaveFTPServer" value="0">
						<div class="row">
							<div class="col s12">
								<label for="lFTPSecureEnabled"><?php echo __('FTP Security'); ?></label>
							<div class="input-field">
									<select id="lFTPSecureEnabled" name="lFTPSecureEnabled" class="selectSelectizeSingle">
										<option <?php echo ((0 == $controller->lFTPSecureEnabled) ? 'selected' : ''); ?> value="0"><?php echo __('Standart FTP'); ?></option>
										<option <?php echo ((1 == $controller->lFTPSecureEnabled) ? 'selected' : ''); ?> value="1"><?php echo __('Secure FTP'); ?></option>
									</select>
							</div>
							</div>
						</div>
						<div class="row">
							<div class="col s9">
								<div>
									<label for="strFTPHost"><?php echo __('FTP Host'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<input id="strFTPHost" name="strFTPHost" type="text" class="blue-text text-darken-4" value="<?php echo $controller->strFTPHost; ?>" placeholder="">
									</div>
								</div>
							</div>
							<div class="col s3">
								<div>
									<label for="lFTPPort"><?php echo __('FTP Port'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<input id="lFTPPort" name="lFTPPort" type="text" class="blue-text text-darken-4" value="<?php echo $controller->lFTPPort; ?>" placeholder="">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col s12 m6 l6">
								<div>
									<label for="strFTPUsername"><?php echo __('FTP Username'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<input id="strFTPUsername" name="strFTPUsername" type="text" class="blue-text text-darken-4" value="<?php echo $controller->strFTPUsername; ?>" placeholder="">
									</div>
								</div>
							</div>
							<div class="col s12 m6 l6">
								<div>
									<label for="strFTPPassword"><?php echo __('FTP Password'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<input id="strFTPPassword" name="strFTPPassword" type="password" class="blue-text text-darken-4">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col s12">
								<label for="strFTPHomeDirectory"><?php echo __('FTP Home Directory'); ?></label>
							</div>
							<div class="input-field">
								<div class="col s12">
									<input id="strFTPHomeDirectory" name="strFTPHomeDirectory" type="text" class="blue-text text-darken-4" value="<?php echo $controller->strFTPHomeDirectory; ?>" placeholder="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<span id="spanFTPTestMessage" class="spanButtonTooltip spanSuccess white-text"><i class="ion-checkmark"></i> Connected!</span>
									<button id="buttonTestFTPServer" name="buttonTestFTPServer" data-default-text="<?php echo __('Test FTP Connection'); ?>" data-loading-text="<?php echo __('Testing FTP Connection...'); ?>" type="button" class="waves-effect waves-dark btn-large white blue-text text-darken-4 col s12"><?php echo __('Test FTP Connection'); ?></button>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<span id="spanFTPSaveMessage" class="spanButtonTooltip spanSuccess white-text"><i class="ion-checkmark"></i> Saved!</span>
									<button id="buttonSaveFTPServer" name="buttonSaveFTPServer" data-default-text="<?php echo __('Save'); ?>" data-loading-text="<?php echo __('Saving...'); ?>" type="button" class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('Save'); ?></button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<iframe id="iframeFormFTPServer" name="iframeFormFTPServer" class="iframeFormPOST"></iframe>
	<?php includeView($controller, 'spritpanel/footer'); ?>
	<script src="assets/js/global.js"></script>
	<script src="assets/js/ftp_server.js"></script>
</body>
</html>