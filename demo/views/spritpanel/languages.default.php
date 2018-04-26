<?php includeView($controller, 'spritpanel/head'); ?>
<body data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-active-dialog-csv="" data-page-url="languages">
	<?php includeView($controller, 'spritpanel/header'); ?>
	<div class="divFullPageHeader">
		<div class="row">
			<div class="divFullPageBG col s12"></div>
			<div class="list-container col s12">
				<div class="list-header">
					<div class="col s6"><h3 class="white-text"><?php echo __('Languages'); ?></h3><h4 class="white-text"></h4></div>
				</div>
			</div>
		</div>
	</div>
	<div id="divLanguagesContent" class="divPageContent divMessageDialog divFullPage row" style="background-color: transparent;">
		<div class="divContentWrapper ">
			<div class="divDialogContentContainer">
				<div class="divContentPanel z-depth-1">
					<form method="post" class="form-horizontal">
						<div class="row">
							<div class="col l6 m6 s12">
								<div>
									<label for="languageCode"><?php echo __('Language'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<select id="languageCode" name="languageCode" class="selectSelectizeSingle" data-required-error-text="<?php echo __('Please select language.'); ?>">
											<option value="">(<?php echo __('Select Language'); ?>)</option>
											<option value="ar">العربية</option>
											<option value="az">Azərbaycanca</option>
											<option value="azb">تۆرکجه</option>
											<option value="ba">Башҡортса</option>
											<option value="bg">Български</option>
											<option value="bs">Bosanski</option>
											<option value="ca">Català</option>
											<option value="crh">Qırımtatarca</option>
											<option value="cs">Čeština</option>
											<option value="cv">Чӑвашла</option>
											<option value="da">Dansk</option>
											<option value="de">Deutsch</option>
											<option value="el">Ελληνικά</option>
											<option value="en">English</option>
											<option value="eo">Esperanto</option>
											<option value="es">Español</option>
											<option value="et">Eesti</option>
											<option value="eu">Euskara</option>
											<option value="fa">فارسی</option>
											<option value="fi">Suomi</option>
											<option value="fr">Français</option>
											<option value="gag">Gagauz</option>
											<option value="he">עברית</option>
											<option value="hi">हिन्दी</option>
											<option value="hr">Hrvatski</option>
											<option value="hu">Magyar</option>
											<option value="id">Bahasa Indonesia</option>
											<option value="it">İtaliano</option>
											<option value="ja">日本語</option>
											<option value="kaa">Qaraqalpaqsha</option>
											<option value="ka">ქართული</option>
											<option value="kk">Қазақша</option>
											<option value="ko">한국어</option>
											<option value="krc">Къарачай-малкъар</option>
											<option value="ku">Kurdî</option>
											<option value="ky">Кыргызча</option>
											<option value="la">Latina</option>
											<option value="lt">Lietuvių</option>
											<option value="mk">Македонски</option>
											<option value="ms">Bahasa Melayu</option>
											<option value="nl">Nederlands</option>
											<option value="nn">Norsk nynorsk</option>
											<option value="no">Norsk bokmål</option>
											<option value="pl">Polski</option>
											<option value="pt">Português</option>
											<option value="ro">Română</option>
											<option value="ru">Русский</option>
											<option value="sh">Srpskohrvatski / српскохрватски</option>
											<option value="sk">Slovenčina</option>
											<option value="sl">Slovenščina</option>
											<option value="sq">Shqip</option>
											<option value="sr">Српски / srpski</option>
											<option value="sv">Svenska</option>
											<option value="th">ไทย</option>
											<option value="tr">Türkçe</option>
											<option value="tk">Türkmençe</option>
											<option value="tt">Татарча/tatarça</option>
											<option value="ug">ئۇيغۇرچە / Uyghurche</option>
											<option value="uk">Українська</option>
											<option value="uz">Oʻzbekcha/ўзбекча</option>
											<option value="vi">Tiếng Việt</option>
											<option value="vo">Volapük</option>
											<option value="zh">中文</option>	
										</select>
									</div>
								</div>
							</div>
							<div class="col l6 m6 s12">
								<div>
									<label for="languagePage"><?php echo __('Page'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<select id="languagePage" name="languagePage" class="selectSelectizeSingle" data-required-error-text="<?php echo __('Please select page.'); ?>">
										</select>
									</div>
								</div>
							</div>
						</div>
						<div id="divTranslationContainer">
							<div class="row" id="divTranslations">
								<div class="col s12 divPlaceholder">
									<div class="card white">
										<div class="card-content">
											<div class="center">
												<p class="center"><?php echo __('Not listing any translation. Please select language and page to list translations.'); ?></p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="divTranslationButtonsContainer" style="display: none;">
								<div class="row">
									<div class="col s12">
										<button id="buttonNewTranslation" name="buttonNewTranslation" data-default-text="<?php echo __('Add New Translation...'); ?>" data-loading-text="<?php echo __('Add New Translation...'); ?>" type="button" class="waves-effect waves-dark btn-large white blue-text text-darken-4 col s12"><?php echo __('Add New Translation...'); ?></button>
									</div>
								</div>
								<div class="row">
									<div class="col s12">
										<button id="buttonShowCopyTranslationsForm" name="buttonShowCopyTranslationsForm" data-default-text="<?php echo __('Copy Translations...'); ?>" data-loading-text="<?php echo __('Copy Translations...'); ?>" type="button" class="waves-effect waves-dark btn-large white blue-text text-darken-4 col s12"><?php echo __('Copy Translations...'); ?></button>
									</div>
								</div>
								<div class="row">
									<div class="input-field">
										<div class="col s12">
											<span id="spanSaveMessage" class="spanButtonTooltip spanSuccess white-text"><i class="ion-checkmark"></i> Saved!</span>
											<button id="buttonSaveTranslations" name="buttonSaveTranslations" data-default-text="<?php echo __('Save Translations'); ?>" data-loading-text="<?php echo __('Saving Translations...'); ?>" data-error-text="Connection error. Please try again later."  type="button" class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('Save Translations'); ?></button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    <div id="divNewTranslationDialog" class="divDialogContent">
        <div class="divContentWrapper level3">
            <div class="divDialogContentContainer">
                <header class="headerHero z-depth-1 blue darken-4">
                    <div class="divHeaderInfo">
                        <h3 class="blue-text text-darken-4"><?php echo __('New Translation'); ?></h3>
                    </div>
                    <button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat" data-container-dialog="divNewTranslationDialog"><i class="ion-android-close blue-text text-darken-4"></i></button>
                </header>
                <div class="divContentPanel z-depth-1 white">
                    <form id="formNewTranslation" name="formNewTranslation" method="post" class="form-horizontal">
                        <div class="row">
							<div class="col s12">
                                <label for="directoryName">Sentence</label>
                                <div class="input-field">
                                    <textarea rows="4" id="newSentence" name="newSentence" class="materialize-textarea blue-text text-darken-4" data-required-error-text="<?php echo __('Please specify language identifier sentence.'); ?>"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field">
                                <div class="col s12">
                                    <button id="buttonAddTranslation" name="buttonAddTranslation" type="button" class="waves-effect waves-light btn-large blue darken-4 col s12" data-default-text="<?php echo __('Add Translation'); ?>" data-loading-text="<?php echo __('Adding Translation...'); ?>"><?php echo __('Add Translation'); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="divCopyTranslationsDialog" class="divDialogContent">
        <div class="divContentWrapper level3">
            <div class="divDialogContentContainer">
                <header class="headerHero z-depth-1 blue darken-4">
                    <div class="divHeaderInfo">
                        <h3 class="blue-text text-darken-4"><?php echo __('Copy Translations'); ?></h3>
                    </div>
                    <button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat" data-container-dialog="divCopyTranslationsDialog"><i class="ion-android-close blue-text text-darken-4"></i></button>
                </header>
                <div class="divContentPanel z-depth-1 white">
                    <form id="formCopyTranslations" name="formCopyTranslations" method="post" class="form-horizontal">
                        <div class="row">
							<div class="col s12">
								<div>
									<label for="languageCopyPage"><?php echo __('Page'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<select id="languageCopyPage" name="languageCopyPage" class="selectSelectizeSingle" data-required-error-text="<?php echo __('Please select page.'); ?>">
										</select>
									</div>
								</div>
							</div>
							<div class="col s12">
								<div>
									<label for="fromLanguageCode"><?php echo __('Copy From Language'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<select id="fromLanguageCode" name="fromLanguageCode" class="selectSelectizeSingle" data-required-error-text="<?php echo __('Please select language to be copied from.'); ?>">
											<option value="">(<?php echo __('Select Language'); ?>)</option>
											<option value="ar">العربية</option>
											<option value="az">Azərbaycanca</option>
											<option value="azb">تۆرکجه</option>
											<option value="ba">Башҡортса</option>
											<option value="bg">Български</option>
											<option value="bs">Bosanski</option>
											<option value="ca">Català</option>
											<option value="crh">Qırımtatarca</option>
											<option value="cs">Čeština</option>
											<option value="cv">Чӑвашла</option>
											<option value="da">Dansk</option>
											<option value="de">Deutsch</option>
											<option value="el">Ελληνικά</option>
											<option value="en">English</option>
											<option value="eo">Esperanto</option>
											<option value="es">Español</option>
											<option value="et">Eesti</option>
											<option value="eu">Euskara</option>
											<option value="fa">فارسی</option>
											<option value="fi">Suomi</option>
											<option value="fr">Français</option>
											<option value="gag">Gagauz</option>
											<option value="he">עברית</option>
											<option value="hi">हिन्दी</option>
											<option value="hr">Hrvatski</option>
											<option value="hu">Magyar</option>
											<option value="id">Bahasa Indonesia</option>
											<option value="it">İtaliano</option>
											<option value="ja">日本語</option>
											<option value="kaa">Qaraqalpaqsha</option>
											<option value="ka">ქართული</option>
											<option value="kk">Қазақша</option>
											<option value="ko">한국어</option>
											<option value="krc">Къарачай-малкъар</option>
											<option value="ku">Kurdî</option>
											<option value="ky">Кыргызча</option>
											<option value="la">Latina</option>
											<option value="lt">Lietuvių</option>
											<option value="mk">Македонски</option>
											<option value="ms">Bahasa Melayu</option>
											<option value="nl">Nederlands</option>
											<option value="nn">Norsk nynorsk</option>
											<option value="no">Norsk bokmål</option>
											<option value="pl">Polski</option>
											<option value="pt">Português</option>
											<option value="ro">Română</option>
											<option value="ru">Русский</option>
											<option value="sh">Srpskohrvatski / српскохрватски</option>
											<option value="sk">Slovenčina</option>
											<option value="sl">Slovenščina</option>
											<option value="sq">Shqip</option>
											<option value="sr">Српски / srpski</option>
											<option value="sv">Svenska</option>
											<option value="th">ไทย</option>
											<option value="tr">Türkçe</option>
											<option value="tk">Türkmençe</option>
											<option value="tt">Татарча/tatarça</option>
											<option value="ug">ئۇيغۇرچە / Uyghurche</option>
											<option value="uk">Українська</option>
											<option value="uz">Oʻzbekcha/ўзбекча</option>
											<option value="vi">Tiếng Việt</option>
											<option value="vo">Volapük</option>
											<option value="zh">中文</option>	
										</select>
									</div>
								</div>
							</div>
							<div class="col s12">
								<div>
									<label for="toLanguageCode"><?php echo __('Copy To Language'); ?></label>
								</div>
								<div class="input-field">
									<div>
										<select id="toLanguageCode" name="toLanguageCode" class="selectSelectizeSingle" data-required-error-text="<?php echo __('Please select language to be copied to.'); ?>">
											<option value="">(<?php echo __('Select Language'); ?>)</option>
											<option value="ar">العربية</option>
											<option value="az">Azərbaycanca</option>
											<option value="azb">تۆرکجه</option>
											<option value="ba">Башҡортса</option>
											<option value="bg">Български</option>
											<option value="bs">Bosanski</option>
											<option value="ca">Català</option>
											<option value="crh">Qırımtatarca</option>
											<option value="cs">Čeština</option>
											<option value="cv">Чӑвашла</option>
											<option value="da">Dansk</option>
											<option value="de">Deutsch</option>
											<option value="el">Ελληνικά</option>
											<option value="en">English</option>
											<option value="eo">Esperanto</option>
											<option value="es">Español</option>
											<option value="et">Eesti</option>
											<option value="eu">Euskara</option>
											<option value="fa">فارسی</option>
											<option value="fi">Suomi</option>
											<option value="fr">Français</option>
											<option value="gag">Gagauz</option>
											<option value="he">עברית</option>
											<option value="hi">हिन्दी</option>
											<option value="hr">Hrvatski</option>
											<option value="hu">Magyar</option>
											<option value="id">Bahasa Indonesia</option>
											<option value="it">İtaliano</option>
											<option value="ja">日本語</option>
											<option value="kaa">Qaraqalpaqsha</option>
											<option value="ka">ქართული</option>
											<option value="kk">Қазақша</option>
											<option value="ko">한국어</option>
											<option value="krc">Къарачай-малкъар</option>
											<option value="ku">Kurdî</option>
											<option value="ky">Кыргызча</option>
											<option value="la">Latina</option>
											<option value="lt">Lietuvių</option>
											<option value="mk">Македонски</option>
											<option value="ms">Bahasa Melayu</option>
											<option value="nl">Nederlands</option>
											<option value="nn">Norsk nynorsk</option>
											<option value="no">Norsk bokmål</option>
											<option value="pl">Polski</option>
											<option value="pt">Português</option>
											<option value="ro">Română</option>
											<option value="ru">Русский</option>
											<option value="sh">Srpskohrvatski / српскохрватски</option>
											<option value="sk">Slovenčina</option>
											<option value="sl">Slovenščina</option>
											<option value="sq">Shqip</option>
											<option value="sr">Српски / srpski</option>
											<option value="sv">Svenska</option>
											<option value="th">ไทย</option>
											<option value="tr">Türkçe</option>
											<option value="tk">Türkmençe</option>
											<option value="tt">Татарча/tatarça</option>
											<option value="ug">ئۇيغۇرچە / Uyghurche</option>
											<option value="uk">Українська</option>
											<option value="uz">Oʻzbekcha/ўзбекча</option>
											<option value="vi">Tiếng Việt</option>
											<option value="vo">Volapük</option>
											<option value="zh">中文</option>	
										</select>
									</div>
								</div>
							</div>
                        </div>
                        <div class="row">
                            <div class="input-field">
                                <div class="col s12">
                                    <button id="buttonCopyTranslations" name="buttonCopyTranslations" type="button" class="waves-effect waves-light btn-large blue darken-4 col s12" data-default-text="<?php echo __('Copy Translations'); ?>" data-loading-text="<?php echo __('Copy Translations'); ?>"><?php echo __('Copy Translations'); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="divDeleteDialog" class="divDialogContent divAlertDialog divDeleteDialog">
        <div class="divContentWrapper level3">
            <div class="divDialogContentContainer">
                <header class="headerHero z-depth-1 red darken-4">
                    <div class="divHeaderInfo">
                        <h3 class="red-text text-darken-4"><?php echo __('Confirm Delete'); ?></h3>
                    </div>
                    <button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"><i class="ion-android-close red-text text-darken-4"></i></button>
                </header>
                <div class="divContentPanel z-depth-1 white">
                    <form id="formConfirmDelete" name="formConfirmDelete" method="post" class="form-horizontal">
                        <div class="row" style="margin-bottom: 40px;">
                            <div class="col s12 red-text text-darken-4">
                                <?php echo __('Current language translations will be deleted.'); ?> <?php echo __('Do you confirm?'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field">
                                <div class="col s6">
                                    <button id="buttonDeleteCancel" type="button" class="buttonCloseDialog waves-effect waves-light btn-large white red-text text-darken-4 col s12"><?php echo __('Cancel'); ?></button>
                                </div>
                                <div class="col s6">
                                    <button data-object-id-csv="" id="buttonDeleteConfirm" type="button" class="waves-effect waves-light btn-large red darken-4 col s12"><?php echo __('Delete'); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
	<div class="divHiddenElements">
		<div id="divPagesHTMLDB" class="divHTMLDB"></div>
		<div id="divTranslationsHTMLDB" class="divHTMLDB"></div>
		<div id="divCopyTranslationsHTMLDB" class="divHTMLDB"></div>
		<select id="selectLanguagePageTemplate">
			<option value="#divPagesHTMLDB.module/#divPagesHTMLDB.name">#divPagesHTMLDB.name&nbsp;(#divPagesHTMLDB.module)</option>
		</select>
		<select id="selectLanguagePageTemplateHeader">
			<option value="">(<?php echo __('Select Page'); ?>)</option>
		</select>
		<div id="divTranslationsTemplate">
			<div id="divTranslation#divTranslationsHTMLDB.id" data-row-id="#divTranslationsHTMLDB.id" class="col s12 divTranslation">
				<div class="card white">
					<button type="button" class="buttonDeleteTranslation waves-effect waves-dark btn-flat btn-large white blue-text text-darken-4 right"><i class="ion-android-close"></i></button>
					<div class="card-content">
						<div>
							<label id="labelTranslation#divTranslationsHTMLDB.id" for="inputTranslation#divTranslationsHTMLDB.id">#divTranslationsHTMLDB.sentence</label>
						</div>
						<div class="input-field">
							<input id="inputTranslation#divTranslationsHTMLDB.id" name="inputTranslation#divTranslationsHTMLDB.id" type="text" class="blue-text text-darken-4" value="#divTranslationsHTMLDB.translation" placeholder="">
						</div>
					</div>
				</div>	
			</div>
		</div>
		<div id="divAddNewTranslationTemplate">
			<div id="divTranslation__ID__" data-row-id="__ID__" class="col s12 divTranslation">
				<div class="card white">
					<button type="button" class="buttonDeleteTranslation waves-effect waves-dark btn-flat btn-large white blue-text text-darken-4 right"><i class="ion-android-close"></i></button>
					<div class="card-content">
						<div>
							<label id="labelTranslation__ID__" for="inputTranslation__ID__">__SENTENCE__</label>
						</div>
						<div class="input-field">
							<input id="inputTranslation__ID__" name="inputTranslation__ID__" type="text" class="blue-text text-darken-4" value="" placeholder="">
						</div>
					</div>
				</div>	
			</div>
		</div>
		<div id="divTranslationsPlaceholderTemplate">
			<div class="col s12 divPlaceholder">
				<div class="card white">
					<div class="card-content">
						<div class="center">
							<p class="center"><?php echo __('Not listing any translation. Please select language and page to list translations.'); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="divDialogContent divLoader" id="divLoader">
		<div class="divContentWrapper level4">
			<div class="divDialogContentContainer">
				<div class="progress blue-grey lighten-4">
					<div id="divLoaderProgress" class="indeterminate blue darken-4" style="width: 100%;" data-progress="100"></div>
				</div>
				<div class="row">
					<div id="divLoaderText" class="col s12 m12 l12 blue-text text-darken-4 center" data-default-text="Loading Languages..."></div>
				</div>
			</div>
		</div>
	</div>
	<?php includeView($controller, 'spritpanel/footer'); ?>
	<script src="assets/js/global.js"></script>
	<script src="assets/js/languages.js"></script>
</body>
</html>