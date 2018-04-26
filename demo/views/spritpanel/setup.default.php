<?php includeView($controller, 'spritpanel/head'); ?>
<body class="bodySetup" data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-active-dialog-csv="">
	<?php if ($controller->prerequisitiesError) {
		?>
		<div id="divPrerequisitiesError" class="divPageContent divMessageDialog" style="background-color: transparent;display:block;">
			<div class="divContentWrapper level3">
				<div class="divDialogContentContainer">
					<header class="headerHero z-depth-1 red darken-4">
						<div class="divHeaderInfo">
							<h3 class="red-text text-darken-4"><?php echo __('Error'); ?></h3>
						</div>
					</header>
					<div class="divContentPanel z-depth-1 red darken-4">
						<div class="white-text">
							<p id="pFormErrorText"><?php echo $controller->prerequisitiesErrorText; ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	} else {
		?>
		<div id="divSetup" class="divPageContent divMessageDialog" style="background-color: transparent;">
			<div class="divContentWrapper divSetupContentWrapper">
				<div class="divDialogContentContainer">
					<header class="headerHero z-depth-1 blue darken-4">
						<div class="divHeaderInfo">
							<h3 class="blue-text text-darken-4"><?php echo $_SPRIT['PROJECT_TITLE']; ?> <?php echo __('Setup'); ?></h3>
						</div>
					</header>
					<div class="divContentPanel z-depth-1" style="padding:0px;">
						<div id="divSetupProgress" class="carousel carousel-slider center" data-indicators="true">
							<div class="carousel-fixed-item center">
								<button class="buttonPrevious btn waves-effect white grey-text darken-text-2"><i class="ion-chevron-left"></i></button>
								<button class="buttonNext btn waves-effect white grey-text darken-text-2"><i class="ion-chevron-right"></i></button>
							</div>
							<div class="carousel-item pink darken-3 white-text" href="#three!">
								<h2><?php echo __('FTP Configuration'); ?></h2>
								<p class="white-text"><?php echo __('Please specify FTP access details.'); ?></p>
								<button id="buttonChangeFTPConfiguration" name="buttonChangeFTPConfiguration" class="buttonOpenDialog btn-large waves-effect white pink-text text-darken-2" data-dialog-id="divFTPConfiguration"><?php echo __('Change FTP Configuration...'); ?></button>
							</div>
							<div class="carousel-item blue darken-4 white-text" href="#one!">
								<h2><?php echo __('Choose Interface Language'); ?></h2>
								<p class="white-text"><?php echo __('Please specify interface language.'); ?></p>
								<form id="formChangeLanguage" name="formChangeLanguage" method="post" action="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>setup/formchangelanguage" class="form-horizontal" target="iframeFormChangeLanguage">
									<div class="row">
										<div class="col s12 m6 push-m3 l6 push-l3">
											<select id="languageISOCode" name="languageISOCode" class="selectSelectizeSingle">
												<option value="en" <?php echo (('en' == $controller->languageISOCode) ? 'selected' : ''); ?>><?php echo __('English'); ?></option>
												<option value="tr" <?php echo (('tr' == $controller->languageISOCode) ? 'selected' : ''); ?>><?php echo __('Turkish'); ?></option>
											</select>
										</div>
										<div class="col s12">
											<button id="buttonChangeLanguage" name="buttonChangeLanguage" data-default-text="<?php echo __('Change Language'); ?>" data-loading-text="<?php echo __('Changing Language...'); ?>" type="button" class="btn-large waves-effect white blue-text text-darken-4"><?php echo __('Change Language'); ?></button>
										</div>
									</div>
								</form>
							</div>
							<div class="carousel-item orange accent-3 white-text" href="#three!">
								<h2><?php echo __('Access Configuration'); ?></h2>
								<p class="white-text"><?php echo __('Please specify root access details.'); ?></p>
								<button id="buttonChangeAccessConfiguration" name="buttonChangeAccessConfiguration" class="buttonOpenDialog btn-large waves-effect white orange-text text-accent-3" data-dialog-id="divAccessConfiguration"><?php echo __('Change Access Configuration...'); ?></button>
							</div>
							<div class="carousel-item purple darken-3 white-text" href="#three!">
								<h2><?php echo __('Database Configuration'); ?></h2>
								<p class="white-text"><?php echo __('Please specify database access details.'); ?></p>
								<button id="buttonChangeDBConfiguration" name="buttonChangeDBConfiguration" class="buttonOpenDialog btn-large waves-effect white purple-text text-darken-3" data-dialog-id="divDBConfiguration"><?php echo __('Change DB Configuration...'); ?></button>
							</div>
							<div class="carousel-item green white-text" href="#three!">
								<h2><?php echo __('Completed!'); ?></h2>
								<p class="white-text"><?php echo __('Congratulations! You have completed the setup process.'); ?></p>
								<div class="col s12">
									<form id="formStartRightNow" name="formStartRightNow" method="post" action="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>setup/formstartrightnow" class="form-horizontal" target="iframeFormStartRightNow">
										<input type="hidden" id="bStartRightNow" name="bStartRightNow" value="0">
									</form>
									<button id="buttonStartRightNow" name="buttonStartRightNow" data-default-text="<?php echo __('Start Right Now!'); ?>" data-loading-text="<?php echo __('Starting...'); ?>" type="button" class="btn-large waves-effect white green-text"><?php echo __('Start Right Now!'); ?></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="divAccessConfiguration" class="divDialogContent divMessageDialog">
			<div class="divContentWrapper level3">
				<div class="divDialogContentContainer">
					<header class="headerHero z-depth-1 blue darken-4">
						<div class="divHeaderInfo">
							<h3 class="blue-text text-darken-4"><?php echo __('Access Configuration'); ?></h3>
						</div>
						<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"><i class="ion-android-close blue-text text-darken-4"></i></button>
					</header>
					<div class="divContentPanel z-depth-1">
						<form id="formAccessConfiguration" name="formAccessConfiguration" method="post" action="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>setup/formaccessconfiguration" class="form-horizontal" target="iframeFormAccessConfiguration">
							<div class="row">
								<div class="col s12">
									<label for="strRootUsername"><?php echo __('Root Username'); ?></label>
								</div>
								<div class="input-field">
									<div class="col s12">
										<input id="strRootUsername" name="strRootUsername" type="text" class="blue-text text-darken-4" value="" placeholder="">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<label for="strRootUsername"><?php echo __('Root Password'); ?></label>
								</div>
								<div class="input-field">
									<div class="col s12">
										<input id="strRootPassword" name="strRootPassword" type="password" class="blue-text text-darken-4" value="" placeholder="">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="input-field">
									<div class="col s12">
										<button id="buttonSaveAccessConfiguration" name="buttonSaveAccessConfiguration" data-default-text="<?php echo __('Save'); ?>" data-loading-text="<?php echo __('Saving...'); ?>" type="button" class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('Save'); ?></button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="divFTPConfiguration" class="divDialogContent divMessageDialog">
			<div class="divContentWrapper level3">
				<div class="divDialogContentContainer">
					<header class="headerHero z-depth-1 blue darken-4">
						<div class="divHeaderInfo">
							<h3 class="blue-text text-darken-4"><?php echo __('FTP Configuration'); ?></h3>
						</div>
						<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"><i class="ion-android-close blue-text text-darken-4"></i></button>
					</header>
					<div class="divContentPanel z-depth-1">
						<form id="formFTPConfiguration" name="formFTPConfiguration" method="post" action="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>setup/formftpconfiguration" class="form-horizontal" target="iframeFormFTPConfiguration">
							<input type="hidden" id="bTestFTPConfiguration" name="bTestFTPConfiguration" value="0">
							<input type="hidden" id="bSaveFTPConfiguration" name="bSaveFTPConfiguration" value="0">
							<div class="row">
								<div class="col s12">
									<label for="lFTPSecureEnabled"><?php echo __('FTP Security'); ?></label>
								</div>
								<div class="input-field">
									<div class="col s12">
										<select id="lFTPSecureEnabled" name="lFTPSecureEnabled" class="selectSelectizeSingle">
											<option value="0"><?php echo __('Standart FTP'); ?></option>
											<option value="1"><?php echo __('Secure FTP'); ?></option>
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
											<input id="strFTPHost" name="strFTPHost" type="text" class="blue-text text-darken-4" value="" placeholder="">
										</div>
									</div>
								</div>
								<div class="col s3">
									<div>
										<label for="lFTPPort"><?php echo __('FTP Port'); ?></label>
									</div>
									<div class="input-field">
										<div>
											<input id="lFTPPort" name="lFTPPort" type="text" class="blue-text text-darken-4" value="21" placeholder="">
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
											<input id="strFTPUsername" name="strFTPUsername" type="text" class="blue-text text-darken-4" value="" placeholder="">
										</div>
									</div>
								</div>
								<div class="col s12 m6 l6">
									<div>
										<label for="strFTPPassword"><?php echo __('FTP Password'); ?></label>
									</div>
									<div class="input-field">
										<div>
											<input id="strFTPPassword" name="strFTPPassword" type="password" class="blue-text text-darken-4" value="" placeholder="">
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
										<input id="strFTPHomeDirectory" name="strFTPHomeDirectory" type="text" class="blue-text text-darken-4" value="" placeholder="">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="input-field">
									<div class="col s12">
										<span id="spanFTPMessage" class="spanButtonTooltip spanSuccess white-text"><i class="ion-checkmark"></i> Connected!</span>
										<button id="buttonTestFTPConfiguration" name="buttonTestFTPConfiguration" data-default-text="<?php echo __('Test FTP Connection'); ?>" data-loading-text="<?php echo __('Testing FTP Connection...'); ?>" type="button" class="waves-effect waves-dark btn-large white blue-text text-darken-4 col s12"><?php echo __('Test FTP Connection'); ?></button>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="input-field">
									<div class="col s12">
										<button id="buttonSaveFTPConfiguration" name="buttonSaveFTPConfiguration" data-default-text="<?php echo __('Save'); ?>" data-loading-text="<?php echo __('Saving...'); ?>" type="button" class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('Save'); ?></button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="divDBConfiguration" class="divDialogContent divMessageDialog">
			<div class="divContentWrapper level3">
				<div class="divDialogContentContainer">
					<header class="headerHero z-depth-1 blue darken-4">
						<div class="divHeaderInfo">
							<h3 class="blue-text text-darken-4"><?php echo __('DB Configuration'); ?></h3>
						</div>
						<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"><i class="ion-android-close blue-text text-darken-4"></i></button>
					</header>
					<div class="divContentPanel z-depth-1">
						<form id="formDBConfiguration" name="formDBConfiguration" method="post" action="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>setup/formdbconfiguration" class="form-horizontal" target="iframeFormDBConfiguration">
							<input type="hidden" id="bTestDBConfiguration" name="bTestDBConfiguration" value="0">
							<input type="hidden" id="bSaveDBConfiguration" name="bSaveDBConfiguration" value="0">
							<div class="row">
								<div class="col s12">
									<label for="lDatabaseType"><?php echo __('Database Type'); ?></label>
								</div>
								<div class="input-field">
									<div class="col s12">
										<select id="lDatabaseType" name="lDatabaseType" class="selectSelectizeSingle">
											<option value="0">MySQL</option>
											<option value="1"><?php echo __('Sprit Flat File DB'); ?></option>
										</select>
									</div>
								</div>
							</div>
							<div class="row mysql-content">
								<div class="col s9">
									<div>
										<label for="strMySQLHost"><?php echo __('MySQL Host'); ?></label>
									</div>
									<div class="input-field">
										<div>
											<input id="strMySQLHost" name="strMySQLHost" type="text" class="blue-text text-darken-4" value="" placeholder="">
										</div>
									</div>
								</div>
								<div class="col s3">
									<div>
										<label for="strMySQLPort"><?php echo __('MySQL Port'); ?></label>
									</div>
									<div class="input-field">
										<div>
											<input id="strMySQLPort" name="strMySQLPort" type="text" class="blue-text text-darken-4" value="3306" placeholder="">
										</div>
									</div>
								</div>
							</div>
							<div class="row mysql-content">
								<div class="col s12">
									<label for="strMySQLDBName"><?php echo __('MySQL Database Name'); ?></label>
								</div>
								<div class="input-field">
									<div class="col s12">
										<input id="strMySQLDBName" name="strMySQLDBName" type="text" class="blue-text text-darken-4" value="" placeholder="">
									</div>
								</div>
							</div>
							<div class="row mysql-content">
								<div class="col s6">
									<div>
										<label for="strMySQLUsername"><?php echo __('MySQL Username'); ?></label>
									</div>
									<div class="input-field">
										<div>
											<input id="strMySQLUsername" name="strMySQLUsername" type="text" class="blue-text text-darken-4" value="" placeholder="">
										</div>
									</div>
								</div>
								<div class="col s6">
									<div>
										<label for="strMySQLPassword"><?php echo __('MySQL Password'); ?></label>
									</div>
									<div class="input-field">
										<div>
											<input id="strMySQLPassword" name="strMySQLPassword" type="password" class="blue-text text-darken-4" value="" placeholder="">
										</div>
									</div>								
								</div>
							</div>
						    <div class="row">
						      <div class="col s12">
						      </div>
						    </div>
							<div class="row mysql-content">
								<div class="input-field">
									<div class="col s12">
										<span id="spanDBMessage" class="spanButtonTooltip spanSuccess white-text"><i class="ion-checkmark"></i> Connected!</span>
										<button id="buttonTestDBConfiguration" name="buttonTestDBConfiguration" data-default-text="<?php echo __('Test MySQL Connection'); ?>" data-loading-text="<?php echo __('Testing MySQL Connection...'); ?>" type="button" class="waves-effect waves-dark btn-large white blue-text text-darken-4 col s12"><?php echo __('Test MySQL Connection'); ?></button>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="input-field">
									<div class="col s12">
										<button id="buttonSaveDBConfiguration" name="buttonSaveDBConfiguration" data-default-text="<?php echo __('Save'); ?>" data-loading-text="<?php echo __('Saving...'); ?>" type="button" class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('Save'); ?></button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<iframe id="iframeFormChangeLanguage" name="iframeFormChangeLanguage" class="iframeFormPOST"></iframe>
		<iframe id="iframeFormAccessConfiguration" name="iframeFormAccessConfiguration" class="iframeFormPOST"></iframe>
		<iframe id="iframeFormFTPConfiguration" name="iframeFormFTPConfiguration" class="iframeFormPOST"></iframe>
		<iframe id="iframeFormDBConfiguration" name="iframeFormDBConfiguration" class="iframeFormPOST"></iframe>
		<iframe id="iframeFormStartRightNow" name="iframeFormStartRightNow" class="iframeFormPOST"></iframe>
		<?php
	}
	?>
	<script src="assets/js/global.js"></script>
	<script src="assets/js/setup.js"></script>
</body>
<?php
if (!$controller->prerequisitiesError) {
	?>
	<div id="divSuccessDialog" class="divDialogContent divAlertDialog divSuccessDialog">
		<div class="divContentWrapper level3">
			<div class="divDialogContentContainer">
				<header class="headerHero z-depth-1 green darken-4">
					<div class="divHeaderInfo">
						<h3 class="green-text text-darken-4"><?php echo __('Success'); ?></h3>
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
	<?php
}
?>
</html>