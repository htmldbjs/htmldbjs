<div id="divCrewDialog" class="divDialogContent divDialogActive htmldb-dialog-edit">
	<div class="divContentWrapper level2" style="display: block; opacity: 1;">
		<div class="divDialogContentContainer">
			<header class="headerHero z-depth-1 blue darken-4">
				<div class="divHeaderInfo">
					<h3 class="blue-text text-darken-4"><?php echo __('Ekip Bilgileri'); ?></h3>
				</div>
				<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"
				data-container-dialog="divProfileDialog"><i class="ion-android-close blue-text text-darken-4"></i></button>
			</header>
			<div class="divContentPanel z-depth-1 white">
				<form id="formCrew" name="formCrew" method="post" class="form-horizontal">
					<input type="hidden" name="crewId" id="crewId" value="" class="HTMLDBFieldValue" data-htmldb-field="id" data-htmldb-source="divCrewHTMLDBReader">
					<input type="hidden" name="crewUnitId" id="crewUnitId" value="" class="HTMLDBFieldValue" data-htmldb-field="unit_id" data-htmldb-source="divUnitHTMLDBReader">
					<input type="hidden" name="crewType" id="crewType" value="15" class="HTMLDBFieldValue" data-htmldb-field="type" data-htmldb-source="divCrewHTMLDBReader">
					<div class="row">
						<div class="col l6 m6 s12">
							<label for="name"><?php echo __('Ad Soyad'); ?></label>
							<div class="input-field">
								<input id="crewFirstName" name="crewFirstName" type="text" value="" data-htmldb-field="name" data-htmldb-source="divCrewHTMLDBReader" class="HTMLDBFieldValue">
							</div>
						</div>
						<div class="col l6 m6 s12">
							<label for="name"><?php echo __('E-posta'); ?></label>
							<div class="input-field">
								<input id="crewEmail" name="crewEmail" type="text" value="" data-htmldb-source="divCrewHTMLDBReader" data-htmldb-field="email" class="HTMLDBFieldValue">
							</div>
						</div>
						<!-- <div class="col l6 m6 s12">
							<label for="name"><?php echo __('Şifre'); ?></label>
							<div class="input-field">
								<input id="crewPassword" name="crewPassword" type="password" value="" data-htmldb-source="divCrewHTMLDBReader" data-htmldb-field="password" class="HTMLDBFieldValue">
							</div>
						</div> -->
					</div>
					<div class="row">
						<div class="input-field">
							<div class="col s6">
								<button type="button"
								class="buttonCloseDialog waves-effect waves-light btn-large white blue-text text-darken-4 col s12"><?php echo __('İPTAL'); ?></button>
							</div>
							<div class="col s6">
								<button id="buttonSaveCrew" data-htmldb-row-id="" data-htmldb-target="divCrewHTMLDBWriter" data-htmldb-dialog="divCrewDialog" data-htmldb-field="id" data-htmldb-attribute="data-htmldb-row-id" data-htmldb-source="divCrewHTMLDBReader" name="buttonSaveCrew" type="button" data-default-text="<?php echo __('KAYDET'); ?>" data-loading-text="<?php echo __('KAYDEDİLİYOR...'); ?>" class="waves-effect waves-light btn-large blue darken-4 col s12 HTMLDBFieldAttribute HTMLDBAction HTMLDBSave"><?php echo __('KAYDET'); ?></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>