<div id="divAuditDialog" class="divDialogContent divDialogActive">
	<div class="divContentWrapper level2" style="display: block; opacity: 1;">
		<div class="divDialogContentContainer">
			<header class="headerHero z-depth-1 blue darken-4">
				<div class="divHeaderInfo">
					<h3 class="blue-text text-darken-4"><?php echo __('Denetim Bilgileri'); ?></h3>
				</div>
				<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"
				data-container-dialog="divProfileDialog"><i class="ion-android-close blue-text text-darken-4"></i></button>
			</header>
			<div class="divContentPanel z-depth-1 white">
				<form id="formAudit" name="formAudit" method="post" class="form-horizontal">
					<input type="hidden" name="auditId" id="auditId" value="" class="HTMLDBFieldValue" data-htmldb-field="id" data-htmldb-source="divAuditHTMLDBReader">
					<input type="hidden" name="auditUnitId" id="auditUnitId" value="" class="HTMLDBFieldValue" data-htmldb-field="unit_id" data-htmldb-source="divUnitHTMLDBReader">
					<div class="row">
						<form class="col s12">
							<div class="row">
                                <div class="col s12">
                                    <label for="consultant"><?php echo __('Denetim Türü'); ?>  </label>
                                    <select class="selectClassSelection HTMLDBFieldValue HTMLDBFieldSelect" data-htmldb-option-source="divAuditTypeHTMLDBReader" id="auditAuditType" style="width: 100%" name="auditAuditType" data-htmldb-source="divAuditHTMLDBReader" data-htmldb-field="audit_type_id">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                    </select>
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
								<button id="buttonSaveAudit" data-htmldb-row-id="" data-htmldb-target="divAuditHTMLDBWriter" data-htmldb-dialog="divAuditDialog" data-htmldb-field="id" data-htmldb-attribute="data-htmldb-row-id" data-htmldb-source="divAuditHTMLDBReader" name="buttonSaveAudit" type="button" data-default-text="<?php echo __('KAYDET'); ?>" data-loading-text="<?php echo __('KAYDEDİLİYOR...'); ?>" class="waves-effect waves-light btn-large blue darken-4 col s12 HTMLDBFieldAttribute HTMLDBAction HTMLDBSave"><?php echo __('KAYDET'); ?></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>