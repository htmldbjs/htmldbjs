<?php includeView($controller, 'spritpanel/head'); ?>
<body data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-active-dialog-csv="" data-page-url="general_settings">
	<?php includeView($controller, 'spritpanel/header'); ?>
	<div class="divFullPageHeader">
		<div class="row">
			<div class="divFullPageBG col s12"></div>
			<div class="list-container col s12">
				<div class="list-header">
					<div class="col s6"><h3 class="white-text"><?php echo __('General Settings'); ?></h3><h4 class="white-text"></h4></div>
				</div>
			</div>
		</div>
	</div>
	<div id="divGeneralSettingsContent" class="divPageContent divMessageDialog divFullPage row" style="background-color: transparent;">
		<div class="divContentWrapper ">
			<div class="divDialogContentContainer">
				<div class="divContentPanel z-depth-1">
					<div class="row">
						<div class="col s12">
							<ul class="tabs">
								<li class="tab col s4"><a href="#tab1"><?php echo __('General Settings'); ?></a></li>
								<li class="tab col s4"><a href="#tab2"><?php echo __('SpritPanel Settings'); ?></a></li>
							</ul>
						</div>
					</div>
					<div id="tab1">
						<div class="row">
							<div class="divTabContent">
								<form id="formGeneralSettings" name="formGeneralSettings" method="post" class="form-horizontal">
									<div>
										<div class="col s12">
											<div class="switch collapsed switchrefresh">
												<label>
													<input id="debugMode" name="debugMode" type="checkbox">
													<span class="lever"></span>
												</label>
												<label for="debugMode"><?php echo __('Debug Mode'); ?></label>
											</div>
										</div>
									</div>
									<div>
										<div class="col s12">
											<div class="switch collapsed switchrefresh">
												<label>
													<input id="shortURLs" name="shortURLs" type="checkbox">
													<span class="lever"></span>
												</label>
												<label for="shortURLs"><?php echo __('Short URLs'); ?></label>
											</div>
										</div>
									</div>
									<div>
										<div class="col s12">
											<div>
												<label for="projectTitle"><?php echo __('Project Title'); ?></label>
											</div>
											<div class="row input-field">
												<input id="projectTitle" name="projectTitle" type="text" class="blue-text text-darken-4" value="" placeholder="">
											</div>
										</div>
									</div>
									<div>
										<div class="col s12">
											<div class="row">
												<label for="defaultPage"><?php echo __('Default Page'); ?></label>
											</div>
											<div class="row input-field">
												<select id="defaultPage" name="defaultPage" class="selectSelectizeSingle">
												</select>
											</div>
										</div>
									</div>
									<div>
										<div class="col s12">
											<div>
												<label for="URLDirectory"><?php echo __('URL Directory'); ?></label>
											</div>
											<div class="row input-field">
												<input id="URLDirectory" name="URLDirectory" type="text" class="blue-text text-darken-4" value="" placeholder="">
											</div>
										</div>
									</div>
									<div>
										<div class="col s12">
											<div class="row">
												<label for="defaultLanguage"><?php echo __('Default Language'); ?></label>
											</div>
											<div class="row input-field">
												<select id="defaultLanguage" name="defaultLanguage" class="selectSelectizeSingle">
												</select>
											</div>
										</div>
									</div>
									<div>
										<div class="col s12">
											<div class="row">
												<label for="timezone"><?php echo __('Timezone'); ?></label>
											</div>
											<div class="row input-field">
												<select id="timezone" name="timezone" class="selectSelectizeSingle">
												</select>
											</div>
										</div>
									</div>
									<div>
										<div class="col s12">
											<div class="row">
												<label for="dateFormat"><?php echo __('Date Format'); ?></label>
											</div>
											<div class="row input-field">
												<select id="dateFormat" name="dateFormat" class="selectSelectizeSingle">
													<option value="d/m/Y">15/06/1981</option>
													<option value="j/n/Y">15/6/1981</option>
													<option value="d/m/y">15/06/81</option>
													<option value="j/n/y">15/6/81</option>
													<option value="d-m-Y">15-06-1981</option>
													<option value="j-n-Y">15-6-1981</option>
													<option value="d-m-y">15-06-81</option>
													<option value="j-n-y">15-6-81</option>
													<option value="d.m.Y">15.06.1981</option>
													<option value="j.n.Y">15.6.1981</option>
													<option value="d.m.y">15.06.81</option>
													<option value="j.n.y">15.6.81</option>
													<option value="m/d/Y">06/15/1981</option>
													<option value="n/j/Y">6/15/1981</option>
													<option value="m/d/y">06/15/81</option>
													<option value="n/j/y">6/15/81</option>
													<option value="m-d-Y">06-15-1981</option>
													<option value="n-j-Y">6-15-1981</option>
													<option value="m-d-y">06-15-81</option>
													<option value="n-j-y">6-15-81</option>
													<option value="m.d.Y">06.15.1981</option>
													<option value="n.j.Y">6.15.1981</option>
													<option value="m.d.y">06.15.81</option>
													<option value="n.j.y">6.15.81</option>
													<option value="Y/m/d">1981/06/15</option>
													<option value="Y/n/j">1981/6/15</option>
													<option value="y/m/d">81/06/15</option>
													<option value="y/n/j">81/6/15</option>
													<option value="Y-m-d">1981-06-15</option>
													<option value="Y-n-j">1981-6-15</option>
													<option value="y-m-d">81-06-15</option>
													<option value="y-n-j">81-6-15</option>
													<option value="Y.m.d">1981.06.15</option>
													<option value="Y.n.j">1981.6.15</option>
													<option value="y.m.d">81.06.15</option>
													<option value="y.n.j">81.6.15</option>
													<option value="j F Y"><?php echo __('15 June 1981'); ?></option>
													<option value="j F y"><?php echo __('15 June 81'); ?></option>
													<option value="j M Y"><?php echo __('15 Jun 1981'); ?></option>
													<option value="j M y"><?php echo __('15 Jun 81'); ?></option>
													<option value="F j, Y"><?php echo __('June 15, 1981'); ?></option>
													<option value="F j, y"><?php echo __('June 15, 81'); ?></option>
													<option value="F j, Y"><?php echo __('Jun 15, 1981'); ?></option>
													<option value="M j, y"><?php echo __('Jun 15, 81'); ?></option>
												</select>
											</div>
										</div>
									</div>
									<div>
										<div class="col s12">
											<div class="row">
												<label for="timeFormat"><?php echo __('Time Format'); ?></label>
											</div>
											<div class="row input-field">
												<select id="timeFormat" name="timeFormat" class="selectSelectizeSingle">
													<option value="H:i">17:00</option>
													<option value="h:i a">05:00 pm</option>
													<option value="H:i:s">17:00:00</option>
													<option value="h:i:s a">05:00:00 pm</option>
												</select>
											</div>
										</div>
									</div>
									<div>
										<div class="col l6 m12 s12">
											<div class="row">
												<label><?php echo __('FTP Configuration'); ?></label>
											</div>
											<div class="row input-field">
												<a href="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>ftp_server" target="_blank" class="waves-effect waves-dark btn-large white blue-text text-darken-4 col s12">Update FTP Configuration ...</a>
											</div>
										</div>
									</div>
									<div>
										<div class="col l6 m12 s12">
											<div class="row">
												<label><?php echo __('Database Configuration'); ?></label>
											</div>
											<div class="row input-field">
												<a href="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>database_server" target="_blank" class="waves-effect waves-dark btn-large white blue-text text-darken-4 col s12">Update Database Configuration ...</a>
											</div>
										</div>
									</div>
									<div>
										<div class="col s12">
											<div class="row">
												<label><?php echo __('Languages'); ?></label>
											</div>
											<div class="row input-field">
												<a href="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>languages" target="_blank" class="waves-effect waves-dark btn-large white blue-text text-darken-4 col s12">Update Languages ...</a>
											</div>
										</div>
									</div>
									<div class="divFTPConnectionRequired">
										<div class="col s12">
											<div class="row">
												<label><?php echo __('Cache Manager'); ?></label>
											</div>
											<div class="row input-field">
												<a id="aRebuildCache" target="_blank" href="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>cache_manager/rebuild" class="buttonRebuildCache waves-effect waves-dark btn-large white blue-text text-darken-4 col s12">Rebuild Cache ...</a>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div id="tab2">
						<div class="row">
							<div class="divTabContent">
								<form id="formAdminSettings" name="formAdminSettings" method="post" class="form-horizontal">
									<div>
										<div class="col s12">
											<div class="switch collapsed switchrefresh">
												<label>
													<input id="enableRootLogin" name="SPRITPANEL_ENABLE_ROOT_LOGIN" type="checkbox">
													<span class="lever"></span>
												</label>
												<label for="SPRITPANEL_ENABLE_ROOT_LOGIN"><?php echo __('Enable Root Login'); ?></label>
											</div>
										</div>
									</div>
									<div>
										<div class="col s12">
											<div class="switch collapsed switchrefresh">
												<label>
													<input id="enableSetupMode" name="enableSetupMode" type="checkbox">
													<span class="lever"></span>
												</label>
												<label for="enableSetupMode"><?php echo __('Enable Setup Mode'); ?></label>
											</div>
										</div>
									</div>
									<div>
										<div class="col s12">
											<div class="switch collapsed switchrefresh">
												<label>
													<input id="adminShortURLs" name="adminShortURLs" type="checkbox">
													<span class="lever"></span>
												</label>
												<label for="adminShortURLs"><?php echo __('Short SpritPanel URLs'); ?></label>
											</div>
										</div>
									</div>
									<div>
										<div class="col s12">
											<div class="row">
												<label for="adminDefaultPage"><?php echo __('SpritPanel Default Page'); ?></label>
											</div>
											<div class="row input-field">
												<select id="adminDefaultPage" name="adminDefaultPage" class="selectSelectizeSingle">
												</select>
											</div>
										</div>
									</div>
									<div>
										<div class="col s12">
											<div>
												<label for="adminURLDirectory"><?php echo __('SpritPanel URL Directory'); ?></label>
											</div>
											<div class="row input-field">
												<input id="adminURLDirectory" name="adminURLDirectory" type="text" class="blue-text text-darken-4" value="" placeholder="">
											</div>
										</div>
									</div>
									<div>
										<div class="col s12">
											<div class="row">
												<label for="adminDefaultLanguage"><?php echo __('SpritPanel Default Language'); ?></label>
											</div>
											<div class="row input-field">
												<select id="adminDefaultLanguage" name="adminDefaultLanguage" class="selectSelectizeSingle">
												</select>
											</div>
										</div>
									</div>
									<div>
										<div class="col s12">
											<div class="row">
												<label><?php echo __('SpritPanel Menu Configuration'); ?></label>
											</div>
											<div class="row input-field">
												<a href="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>menu_configuration" target="_blank" class="waves-effect waves-dark btn-large white blue-text text-darken-4 col s12">Update Menu Configuration ...</a>
											</div>
										</div>
									</div>
								</form>
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="input-field">
							<div class="col s12">
								<span id="spanSettingsSaveMessage" class="spanButtonTooltip spanSuccess white-text"><i class="ion-checkmark"></i> Saved!</span>
								<button id="buttonSaveSettings" name="buttonSaveSettings" data-default-text="<?php echo __('Save'); ?>" data-loading-text="<?php echo __('Saving...'); ?>" type="submit" class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('Save'); ?></button>
							</div>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>
	<div class="divHiddenElements">
		<div id="divSettingsHTMLDB" class="divHTMLDB"></div>
		<div id="divDefaultPagesHTMLDB" class="divHTMLDB"></div>
		<select id="selectDefaultPagesTemplate">
			<option value="#divDefaultPagesHTMLDB.name">#divDefaultPagesHTMLDB.name</option>
		</select>
		<div id="divAdminPagesHTMLDB" class="divHTMLDB"></div>
		<select id="selectAdminPagesTemplate">
			<option value="#divAdminPagesHTMLDB.name">#divAdminPagesHTMLDB.name</option>
		</select>
		<div id="divDefaultLanguageNamesHTMLDB" class="divHTMLDB"></div>
		<select id="selectDefaultLanguageNamesTemplate">
			<option value="#divDefaultLanguageNamesHTMLDB.iso">#divDefaultLanguageNamesHTMLDB.name</option>
		</select>
		<div id="divAdminLanguageNamesHTMLDB" class="divHTMLDB"></div>
		<select id="selectAdminLanguageNamesTemplate">
			<option value="#divAdminLanguageNamesHTMLDB.iso">#divAdminLanguageNamesHTMLDB.name</option>
		</select>
		<div id="divTimezoneHTMLDB" class="divHTMLDB"></div>
		<select id="selectTimezoneTemplate">
			<option value="#divTimezoneHTMLDB.timezone">#divTimezoneHTMLDB.timezone</option>
		</select>
	</div>
    <div class="divDialogContent divLoader" id="divLoader">
        <div class="divContentWrapper level4">
            <div class="divDialogContentContainer">
                <div class="progress blue-grey lighten-4">
                    <div id="divLoaderProgress" class="indeterminate blue darken-4" style="width: 100%;" data-progress="100"></div>
                </div>
                <div class="row">
                    <div id="divLoaderText" class="col s12 m12 l12 blue-text text-darken-4 center" data-default-text="Loading General Settings..."></div>
                </div>
            </div>
        </div>
    </div>
	<?php includeView($controller, 'spritpanel/footer'); ?>
	<script src="assets/js/global.js"></script>
	<script src="assets/js/general_settings.js"></script>
</body>
</html>