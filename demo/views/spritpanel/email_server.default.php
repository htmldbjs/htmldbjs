<?php includeView($controller, 'spritpanel/head'); ?>
<body data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-active-dialog-csv="" data-page-url="email_server">
	<?php includeView($controller, 'spritpanel/header'); ?>
	<div class="divFullPageHeader">
		<div class="row">
			<div class="divFullPageBG col s12"></div>
			<div class="list-container col s12">
				<div class="list-header">
					<div class="col s6"><h3 class="white-text"><?php echo __('Email Configuration'); ?></h3><h4 class="white-text"></h4></div>
				</div>
			</div>
		</div>
	</div>
	<div id="divEmailConfigurationContent" class="divPageContent divMessageDialog divFullPage row" style="background-color: transparent;">
		<div class="divContentWrapper ">
			<div class="divDialogContentContainer">
				<div class="divContentPanel z-depth-1">
					<form id="formEmailConfiguration" name="formEmailConfiguration" method="post" target="iframeFormEmailConfiguration" action="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>email_server/formemailconfiguration" class="form-horizontal">
						<input type="hidden" name="bSaveEmailConfiguration" id="bSaveEmailConfiguration" value="0"/>
						<input type="hidden" name="bTestSMTP" id="bTestSMTP" value="0"/>
						<div class="row">
							<div class="col s12">
								<label for="lEmailType"><?php echo __('Mail Type'); ?></label>

								<div class="input-field">
									<select id="lEmailType" name="lEmailType" class="selectSelectizeSingle">
										<option <?php echo ((0 == $controller->lEmailType) ? 'selected' : ''); ?> value="0"><?php echo __('Standart Mail'); ?></option>
										<option <?php echo ((1 == $controller->lEmailType) ? 'selected' : ''); ?> value="1"><?php echo __('SMTP'); ?></option>
									</select>
								</div>


							</div>
						</div>
						<div class="row sh-element sh-lEmailType-1">
							<div class="col s6">
								<div>
									<label for="strEmailFromName"><?php echo __('Email From Name'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<input type="text" name="strEmailFromName" id="strEmailFromName" class="blue-text text-darken-4" value="<?php echo $controller->strEmailFromName; ?>">
									</div>
								</div>
							</div>
							<div class="col s6">
								<div>
									<label for="strEmailReplyTo"><?php echo __('Email Reply To'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<input id="strEmailReplyTo" name="strEmailReplyTo" type="text" class="blue-text text-darken-4" value="<?php echo $controller->strEmailReplyTo; ?>">
									</div>
								</div>								
							</div>
						</div>
						<div class="row sh-element sh-lEmailType-1">
							<div class="col s12">
								<label for="strSMTPHost"><?php echo __('SMTP Host'); ?></label>

								<div class="input-field">
									<input id="strSMTPHost" name="strSMTPHost" type="text" class="blue-text text-darken-4" value="<?php echo $controller->strSMTPHost; ?>">
								</div>

							</div>

						</div>
						<div class="row sh-element sh-lEmailType-1">
							<div class="col s6">
								<div>
									<label for="strSMTPUser"><?php echo __('SMTP User'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<input type="text" name="strSMTPUser" id="strSMTPUser" class="blue-text text-darken-4" value="<?php echo $controller->strSMTPUser; ?>">
									</div>
								</div>
							</div>
							<div class="col s6">
								<div>
									<label for="strSMTPPassword"><?php echo __('SMTP Password'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<input id="strSMTPPassword" name="strSMTPPassword" type="password" class="blue-text text-darken-4" autocomplete="off">
									</div>
								</div>								
							</div>
						</div>
						<div class="row sh-element sh-lEmailType-1">
							<div class="col s6">
								<div>
									<label for="lSMTPEncryption"><?php echo __('Encryption'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<select id="lSMTPEncryption" name="lSMTPEncryption" class="selectSelectizeSingle">
											<option <?php echo ((0 == $controller->lSMTPEncryption) ? 'selected' : ''); ?> value="0">TLS</option>
											<option <?php echo ((1 == $controller->lSMTPEncryption) ? 'selected' : ''); ?> value="1">SSL</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col s6">
								<div>
									<label class="col-md-12"><?php echo __('Port'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<input type="text" name="lSMTPPort" id="lSMTPPort" class="blue-text text-darken-4" value="<?php echo $controller->lSMTPPort; ?>">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col s12">
								<label for="lEmailFormat"><?php echo __('Mail Format'); ?></label>

								<div class="input-field">
									<select id="lEmailFormat" name="lEmailFormat" class="selectSelectizeSingle">
										<option <?php echo ((0 == $controller->lEmailFormat) ? 'selected' : ''); ?> value="0"><?php echo __('HTML'); ?></option>
										<option <?php echo ((1 == $controller->lEmailFormat) ? 'selected' : ''); ?> value="1"><?php echo __('Text'); ?></option>
									</select>
								</div>

							</div>
						</div>
						<div class="row sh-element sh-lEmailType-1">
							<div class="input-field">
								<div class="col s12">
									<span id="spanEmailTestMessage" class="spanButtonTooltip spanSuccess white-text"><i class="ion-checkmark"></i> Connected!</span>
									<button id="buttonTestSMTP" name="buttonTestSMTP" data-default-text="<?php echo __('Test SMTP Connection'); ?>" data-loading-text="<?php echo __('Testing SMTP Connection...'); ?>" type="button" class="waves-effect waves-dark btn-large white blue-text text-darken-4 col s12"><?php echo __('Test SMTP Connection'); ?></button>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<span id="spanEmailSaveMessage" class="spanButtonTooltip spanSuccess white-text"><i class="ion-checkmark"></i> Saved!</span>
									<button id="buttonSaveEmailConfiguration" name="buttonSaveEmailConfiguration" data-default-text="<?php echo __('Save'); ?>" data-loading-text="<?php echo __('Saving...'); ?>" type="submit" class="waves-effect waves-dark btn-large blue darken-4 col s12"><?php echo __('Save'); ?></button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<iframe id="iframeFormEmailConfiguration" name="iframeFormEmailConfiguration" class="iframeFormPOST"></iframe>
	<?php includeView($controller, 'spritpanel/footer'); ?>
	<script src="assets/js/global.js"></script>
	<script src="assets/js/email_server.js"></script>
</body>
</html>