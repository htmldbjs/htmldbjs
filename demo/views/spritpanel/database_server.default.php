<?php includeView($controller, 'spritpanel/head'); ?>
<body data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-active-dialog-csv="" data-page-url="database_server">
	<?php includeView($controller, 'spritpanel/header'); ?>
	<div class="divFullPageHeader">
		<div class="row">
			<div class="divFullPageBG col s12"></div>
			<div class="list-container col s12">
				<div class="list-header">
					<div class="col s6"><h3 class="white-text"><?php echo __('Database Configuration'); ?></h3><h4 class="white-text"></h4></div>
				</div>
			</div>
		</div>
	</div>
	<div id="divDatabaseContent" class="divPageContent divMessageDialog divFullPage row" style="background-color: transparent;">
		<div class="divContentWrapper ">
			<div class="divDialogContentContainer">
				<div class="divContentPanel z-depth-1">
					<form id="formDatabase" name="formDatabase" method="post" action="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>database_server/formdatabase" class="form-horizontal" target="iframeFormDatabase">
						<input type="hidden" id="bTestDatabase" name="bTestDatabase" value="0">
						<input type="hidden" id="bSaveDatabase" name="bSaveDatabase" value="0">
						<div class="row">
							<div class="col s12">
								<label for="lDatabaseType"><?php echo __('Database Type'); ?></label>

							<div class="input-field">
									<select id="lDatabaseType" name="lDatabaseType" class="selectSelectizeSingle">
										<option <?php echo ((0 == $controller->lDatabaseType) ? 'selected' : ''); ?> value="0"><?php echo __('MySQL'); ?></option>
										<option <?php echo ((1 == $controller->lDatabaseType) ? 'selected' : ''); ?> value="1"><?php echo __('Sprit Flat File DB'); ?></option>
									</select>
							</div>

							</div>
						</div>
						<div class="row sh-element sh-lDatabaseType-0">
							<div class="col s9">
								<div>
									<label for="strDatabaseHost"><?php echo __('MySQL Host'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<input id="strDatabaseHost" name="strDatabaseHost" type="text" class="blue-text text-darken-4" value="<?php echo $controller->strDatabaseHost; ?>" placeholder="">
									</div>
								</div>
							</div>
							<div class="col s3">
								<div>
									<label for="lDatabasePort"><?php echo __('MySQL Port'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<input id="lDatabasePort" name="lDatabasePort" type="text" class="blue-text text-darken-4" value="<?php echo $controller->lDatabasePort; ?>" placeholder="">
									</div>
								</div>
							</div>
						</div>
						<div class="row sh-element sh-lDatabaseType-0">
							<div class="col s12">
								<label for="strDatabaseName"><?php echo __('MySQL Database Name'); ?></label>
								<div class="input-field">
										<input id="strDatabaseName" name="strDatabaseName" type="text" class="blue-text text-darken-4" value="<?php echo $controller->strDatabaseName; ?>" placeholder="">
								</div>
							</div>
						</div>
						<div class="row sh-element sh-lDatabaseType-0">
							<div class="col s6">
								<div>
									<label for="strDatabaseUsername"><?php echo __('MySQL Username'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<input id="strDatabaseUsername" name="strDatabaseUsername" type="text" class="blue-text text-darken-4" value="<?php echo $controller->strDatabaseUsername; ?>" placeholder="">
									</div>
								</div>
							</div>
							<div class="col s6">
								<div>
									<label for="strDatabasePassword"><?php echo __('MySQL Password'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<input id="strDatabasePassword" name="strDatabasePassword" type="password" class="blue-text text-darken-4" autocomplete="off">
									</div>
								</div>								
							</div>
						</div>
						<div class="row sh-element sh-lDatabaseType-0">
							<div class="input-field">
								<div class="col s12">
									<span id="spanDatabaseTestMessage" class="spanButtonTooltip spanSuccess white-text"><i class="ion-checkmark"></i> Connected!</span>
									<button id="buttonTestDatabase" name="buttonTestDatabase" data-default-text="<?php echo __('Test MySQL Connection'); ?>" data-loading-text="<?php echo __('Testing MySQL Connection...'); ?>" type="button" class="waves-effect waves-dark btn-large white blue-text text-darken-4 col s12"><?php echo __('Test MySQL Connection'); ?></button>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<span id="spanDatabaseSaveMessage" class="spanButtonTooltip spanSuccess white-text"><i class="ion-checkmark"></i> Saved!</span>
									<button id="buttonSaveDatabase" name="buttonSaveDatabase" data-default-text="<?php echo __('Save'); ?>" data-loading-text="<?php echo __('Saving...'); ?>" type="submit" class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('Save'); ?></button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<iframe id="iframeFormDatabase" name="iframeFormDatabase" class="iframeFormPOST"></iframe>
	<?php includeView($controller, 'spritpanel/footer'); ?>
	<script src="assets/js/global.js"></script>
	<script src="assets/js/database_server.js"></script>
</body>
</html>