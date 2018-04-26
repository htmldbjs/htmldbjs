<div id="divEditAuditStepDialog" class="divDialogContent divDialogActive">
	<div class="divContentWrapper level0" style="display: block; opacity: 1;">
		<div class="divDialogContentContainer">
			<header class="headerHero z-depth-1 blue darken-4">
				<div class="divHeaderInfo">
					<h3 class="blue-text text-darken-4"><?php echo __('Denetim Adımı Bilgileri'); ?></h3>
				</div>
				<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"
				data-container-dialog="divProfileDialog"><i class="ion-android-close blue-text text-darken-4"></i></button>
			</header>
			<div class="divContentPanel z-depth-1 white">
				<form id="formAuditStep" name="formAuditStep" method="post" class="form-horizontal">
					<input type="hidden" name="editAuditStepId" id="editAuditStepId" value="0" class="HTMLDBFieldValue" data-htmldb-field="id" data-htmldb-source="divAuditStepHTMLDBReader">
					<input type="hidden" name="editAuditStepAuditId" id="editAuditStepAuditId" value="0" class="HTMLDBFieldValue" data-htmldb-field="audit_id" data-htmldb-source="divUnitHTMLDBReader">
					<div class="row">
						<form class="col s12">
							<div class="row">
								<div class="col s12">
                                    <label for="editAuditStepAuditNote"><?php echo __('Denetim Notu'); ?>  </label>
									<textarea id="editAuditStepAuditNote" name="editAuditStepAuditNote" class="HTMLDBFieldValue materialize-textarea blue-text text-darken-4" data-htmldb-source="divAuditStepHTMLDBReader" data-htmldb-field="audit_note" placeholder="" style="min-height: 100px;"></textarea>
                                </div>
							</div>
						</form>
					</div>
					<div class="row">
						<div class="input-field">
							<div class="col s6">
								<button type="button"
								class="buttonCloseDialog waves-effect waves-light btn-large white blue-text text-darken-4 col s12"><?php echo __('İPTAL'); ?></button>
							</div>
							<div class="col s6">
								<button id="buttonSaveEditedAuditStep" data-htmldb-row-id="" data-htmldb-target="divAuditStepHTMLDBWriter" data-htmldb-dialog="divEditAuditStepDialog" data-htmldb-field="id" data-htmldb-attribute="data-htmldb-row-id" data-htmldb-source="divAuditStepHTMLDBReader" name="buttonSaveEditedAuditStep" type="button" data-default-text="<?php echo __('KAYDET'); ?>" data-loading-text="<?php echo __('KAYDEDİLİYOR...'); ?>" class="waves-effect waves-light btn-large blue darken-4 col s12 HTMLDBFieldAttribute HTMLDBAction HTMLDBSave"><?php echo __('KAYDET'); ?></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>