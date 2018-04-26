<div id="divUnitDialog" class="divDialogContent divDialogActive">
	<div class="divContentWrapper level0" style="display: block; opacity: 1;">
		<div class="divDialogContentContainer">
			<header class="headerHero z-depth-1 blue darken-4">
				<div class="divHeaderInfo">
					<h3 class="blue-text text-darken-4"><?php echo __('Alan Bilgileri'); ?></h3>
				</div>
				<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"
				data-container-dialog="divProfileDialog"><i class="ion-android-close blue-text text-darken-4"></i></button>
			</header>
			<div class="divContentPanel z-depth-1 white">
				<form id="formUnit" name="formUnit" method="post" class="form-horizontal">
					<input type="hidden" name="unitId" id="unitId" value="" class="HTMLDBFieldValue" data-htmldb-field="id" data-htmldb-source="divUnitHTMLDBReader">
					<input type="hidden" name="companyId" id="companyId" value="" class="HTMLDBFieldValue" data-htmldb-field="company_id" data-htmldb-source="divUnitHTMLDBReader">
					<div class="row">
						<div class="col s12">
							<div class="row">
								<div class="col s12"><h5 class="blue-text text-darken-4">Genel Bilgiler</h5></div>
								<div class="col s12">
									<label for="name"><?php echo __('Alan'); ?></label>
									<div class="input-field">
										<input id="unitName" name="unitName" type="text" value="" data-htmldb-field="name" data-htmldb-source="divUnitHTMLDBReader" class="HTMLDBFieldValue">
									</div>
								</div>
								<div class="col s12"><h5 class="blue-text text-darken-4">Süreç Sahibi</h5></div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('Ad'); ?></label>
									<div class="input-field">
										<input id="unitProcessOwnerFirstName" name="unitProcessOwnerFirstName" type="text" value="" data-htmldb-field="process_owner_firstname" data-htmldb-source="divUnitHTMLDBReader" class="HTMLDBFieldValue">
									</div>
								</div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('Soyad'); ?></label>
									<div class="input-field">
										<input id="unitProcessOwnerLastName" name="unitProcessOwnerLastName" type="text" value="" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="process_owner_lastname" class="HTMLDBFieldValue">
									</div>
								</div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('E-posta'); ?></label>
									<div class="input-field">
										<input id="unitProcessOwnerEmail" name="unitProcessOwnerEmail" type="text" value="" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="process_owner_email" class="HTMLDBFieldValue">
									</div>
								</div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('Şifre'); ?></label>
									<div class="input-field">
										<input id="unitProcessOwnerPassword" name="unitProcessOwnerPassword" type="password" value="" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="process_owner_password" class="HTMLDBFieldValue">
									</div>
								</div>
								<div class="col s12"><h5 class="blue-text text-darken-4">Şampiyon</h5></div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('Ad'); ?></label>
									<div class="input-field">
										<input id="unitChampionFirstName" name="unitChampionFirstName" type="text" value="" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="champion_firstname" class="HTMLDBFieldValue">
									</div>
								</div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('Soyad'); ?></label>
									<div class="input-field">
										<input id="unitChampionLastName" name="unitChampionLastName" type="text" value="" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="champion_lastname" class="HTMLDBFieldValue">
									</div>
								</div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('E-posta'); ?></label>
									<div class="input-field">
										<input id="unitChampionEmail" name="unitChampionEmail" type="text" value="" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="champion_email" class="HTMLDBFieldValue">
									</div>
								</div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('Şifre'); ?></label>
									<div class="input-field">
										<input id="unitChampionPassword" name="unitChampionPassword" type="password" value="" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="champion_password" class="HTMLDBFieldValue">
									</div>
								</div>
								<div class="col s12"><h5 class="blue-text text-darken-4">Rehber</h5></div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('Ad'); ?></label>
									<div class="input-field">
										<input id="unitAdvisorFirstName" name="unitAdvisorFirstName" type="text" value="" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="advisor_firstname" class="HTMLDBFieldValue">
									</div>
								</div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('Soyad'); ?></label>
									<div class="input-field">
										<input id="unitAdvisorLastName" name="unitAdvisorLastName" type="text" value="" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="advisor_lastname" class="HTMLDBFieldValue">
									</div>
								</div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('E-posta'); ?></label>
									<div class="input-field">
										<input id="unitAdvisorEmail" name="unitAdvisorEmail" type="text" value="" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="advisor_email" class="HTMLDBFieldValue">
									</div>
								</div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('Şifre'); ?></label>
									<div class="input-field">
										<input id="unitAdvisorPassword" name="unitAdvisorPassword" type="password" value="" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="advisor_password" class="HTMLDBFieldValue">
									</div>
								</div>
								<div class="col s12"><h5 class="blue-text text-darken-4">Alan Lideri</h5></div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('Ad'); ?></label>
									<div class="input-field">
										<input id="unitLeaderFirstName" name="unitLeaderFirstName" type="text" value="" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="leader_firstname" class="HTMLDBFieldValue">
									</div>
								</div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('Soyad'); ?></label>
									<div class="input-field">
										<input id="unitLeaderLastName" name="unitLeaderLastName" type="text" value="" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="leader_lastname" class="HTMLDBFieldValue">
									</div>
								</div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('E-posta'); ?></label>
									<div class="input-field">
										<input id="unitLeaderEmail" name="unitLeaderEmail" type="text" value="" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="leader_email" class="HTMLDBFieldValue">
									</div>
								</div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('Şifre'); ?></label>
									<div class="input-field">
										<input id="unitLeaderPassword" name="unitLeaderPassword" type="password" value="" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="leader_password" class="HTMLDBFieldValue">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="input-field">
							<div class="col s6">
								<button type="button"
								class="buttonCloseDialog waves-effect waves-light btn-large white blue-text text-darken-4 col s12"><?php echo __('İPTAL'); ?></button>
							</div>
							<div class="col s6">
								<button id="buttonSaveUnit" data-htmldb-row-id="" data-htmldb-target="divUnitHTMLDBWriter" data-htmldb-dialog="divUnitDialog" data-htmldb-field="id" data-htmldb-attribute="data-htmldb-row-id" data-htmldb-source="divUnitHTMLDBReader" name="buttonSaveUnit" type="button" data-default-text="<?php echo __('KAYDET'); ?>" data-loading-text="<?php echo __('KAYDEDİLİYOR...'); ?>" class="waves-effect waves-light btn-large blue darken-4 col s12 HTMLDBFieldAttribute HTMLDBAction HTMLDBSave"><?php echo __('KAYDET'); ?></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>