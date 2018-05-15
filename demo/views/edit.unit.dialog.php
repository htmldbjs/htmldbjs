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
								<div class="col s12">
									<label for="name"><?php echo __('Alan'); ?></label>
									<div class="input-field">
										<input id="unitName" name="unitName" type="text" value="" data-htmldb-field="name" data-htmldb-source="divUnitHTMLDBReader" class="HTMLDBFieldValue">
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