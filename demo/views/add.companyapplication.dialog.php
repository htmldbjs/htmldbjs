<div id="divCompanyApplicationDialog" class="divDialogContent divDialogActive">
	<div class="divContentWrapper level2" style="display: block; opacity: 1;">
		<div class="divDialogContentContainer">
			<header class="headerHero z-depth-1 blue darken-4">
				<div class="divHeaderInfo">
					<h3 class="blue-text text-darken-4"><?php echo __('Uygulama Bilgileri'); ?></h3>
				</div>
				<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"
				data-container-dialog="divProfileDialog"><i class="ion-android-close blue-text text-darken-4"></i></button>
			</header>
			<div class="divContentPanel z-depth-1 white">
				<form id="formApplication" name="formApplication" method="post" class="form-horizontal">
					<input type="hidden" name="applicationId" id="applicationId" value="" class="HTMLDBFieldValue" data-htmldb-field="id" data-htmldb-source="divApplicationHTMLDBReader">
					<div class="row">
						<div class="col s12">
							<label for="application_unit_id"><?php echo __('Uygulama Alanı'); ?> </label>
							<select class="selectClassSelection HTMLDBFieldValue HTMLDBFieldSelect" id="application_unit_id" style="width: 100%" name="application_unit_id" data-htmldb-option-source="divUnitForApplicationHTMLDBReader" data-htmldb-source="divApplicationHTMLDBReader" data-htmldb-field="unit_id">>
								<option value=""><?php echo __('Lütfen Seçiniz'); ?></option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="input-field">
							<div class="col s6">
								<button type="button"
								class="buttonCloseDialog waves-effect waves-light btn-large white blue-text text-darken-4 col s12"><?php echo __('İPTAL'); ?></button>
							</div>
							<div class="col s6">
								<button id="buttonSaveApplication" data-htmldb-row-id="" data-htmldb-target="divApplicationHTMLDBWriter" data-htmldb-dialog="divCompanyApplicationDialog" data-htmldb-field="id" data-htmldb-attribute="data-htmldb-row-id" data-htmldb-source="divApplicationHTMLDBReader" name="buttonSaveApplication" type="button" data-default-text="<?php echo __('KAYDET'); ?>" data-loading-text="<?php echo __('KAYDEDİLİYOR...'); ?>" class="waves-effect waves-light btn-large blue darken-4 col s12 HTMLDBFieldAttribute HTMLDBAction HTMLDBSave"><?php echo __('KAYDET'); ?></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>