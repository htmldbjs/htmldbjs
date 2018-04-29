<div id="divAddAuditStepDialog" class="divDialogContent divDialogActive">
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
					<input type="hidden" name="addAuditStepId" id="addAuditStepId" value="0" class="HTMLDBFieldValue" data-htmldb-field="id" data-htmldb-source="divAuditStepHTMLDBReader">
					<input type="hidden" name="addAuditStepAuditId" id="addAuditStepAuditId" value="0" class="HTMLDBFieldValue" data-htmldb-field="audit_id" data-htmldb-source="divUnitHTMLDBReader">
					<div class="row">
						<form class="col s12">
							<div id="divAuditStepDetails" class="row">
								<div class="col l4 m4 s12">
									<label for="addAuditStepCategory"><?php echo __('Kategori'); ?></label>
									<div class="input-field">
										<select class="selectClassSelection HTMLDBFieldValue HTMLDBFieldSelect" data-htmldb-option-source="divAuditStepCategoryHTMLDBReader" id="addAuditStepCategory" style="width: 100%" name="addAuditStepCategory" data-htmldb-source="divAuditStepHTMLDBReader" data-htmldb-field="audit_step_category_id">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                    </select>
									</div>
								</div>
								<div class="col l4 m4 s12">
									<label for="addAuditStepType"><?php echo __('Soru Tipi'); ?></label>
									<div class="input-field">
										<select class="selectClassSelection HTMLDBFieldValue HTMLDBFieldSelect" data-htmldb-option-source="divAuditStepTypeHTMLDBReader" id="addAuditStepType" style="width: 100%" name="addAuditStepType" data-htmldb-source="divAuditStepHTMLDBReader" data-htmldb-field="audit_step_type_id">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                    </select>
									</div>
								</div>
								<div class="col l4 m4 s12">
									<label for="name"><?php echo __('Sıra'); ?></label>
									<div class="input-field">
										<input id="addAuditStepIndex" name="addAuditStepIndex" type="text" value="" data-htmldb-source="divAuditStepHTMLDBReader" data-htmldb-field="index" class="HTMLDBFieldValue">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
                                    <label for="addAuditStepAuditNote"><?php echo __('Yapılacak Aksiyon'); ?>  </label>
									<textarea id="addAuditStepStepAction" name="addAuditStepStepAction" class="HTMLDBFieldValue materialize-textarea blue-text text-darken-4" data-htmldb-source="divAuditStepHTMLDBReader" data-htmldb-field="step_action" placeholder="" style="min-height: 100px;"></textarea>
                                </div>
								<div class="col s12">
									<div class="">
										<p>
											<label class="radio2 left-align" for="addAuditStepSatisfied0">
												<input id="addAuditStepSatisfied0" name="addAuditStepSatisfied" class="HTMLDBFieldValue" value="1" type="radio" data-htmldb-source="divAuditStepHTMLDBReader">
												<span class="outer"><span class="inner"></span></span>&nbsp;<?php echo __('Evet'); ?></label>
										</p>
										<p>
											<label class="radio2 left-align" for="addAuditStepSatisfied1">
												<input id="addAuditStepSatisfied1" name="addAuditStepSatisfied" class="HTMLDBFieldValue" value="0" type="radio" data-htmldb-source="divAuditStepHTMLDBReader">
												<span class="outer"><span class="inner"></span></span>&nbsp;<?php echo __('Hayır'); ?></label>
										</p>
									</div>
								</div>
							</div>
							<div class="row"></div>
							<div class="row">
								<div class="col s12">
                                    <label for="addAuditStepAuditNote"><?php echo __('Denetim Notu'); ?>  </label>
									<textarea id="addAuditStepAuditNote" name="addAuditStepAuditNote" class="HTMLDBFieldValue materialize-textarea blue-text text-darken-4" data-htmldb-source="divAuditStepHTMLDBReader" data-htmldb-field="audit_note" placeholder="" style="min-height: 100px;"></textarea>
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
								<button id="buttonSaveAddedAuditStep" data-htmldb-row-id="" data-htmldb-target="divAuditStepHTMLDBWriter" data-htmldb-dialog="divAddAuditStepDialog" data-htmldb-field="id" data-htmldb-attribute="data-htmldb-row-id" data-htmldb-loader="divLoader" data-htmldb-source="divAuditStepHTMLDBReader" name="buttonSaveAddedAuditStep" type="button" data-default-text="<?php echo __('KAYDET'); ?>" data-loading-text="<?php echo __('KAYDEDİLİYOR...'); ?>" class="waves-effect waves-light btn-large blue darken-4 col s12 HTMLDBFieldAttribute HTMLDBAction HTMLDBSave"><?php echo __('KAYDET'); ?></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>