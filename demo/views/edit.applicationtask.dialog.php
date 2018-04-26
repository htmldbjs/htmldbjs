<div id="divEditApplicationTaskDialog" class="divDialogContent divDialogActive">
	<div class="divContentWrapper level0" style="display: block; opacity: 1;">
		<div class="divDialogContentContainer">
			<header class="headerHero z-depth-1 blue darken-4">
				<div class="divHeaderInfo">
					<h3 class="blue-text text-darken-4"><?php echo __('Uygulama Adımı Bilgileri'); ?></h3>
				</div>
				<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"
				data-container-dialog="divProfileDialog"><i class="ion-android-close blue-text text-darken-4"></i></button>
			</header>
			<div class="divContentPanel z-depth-1 white">
				<form id="formEditApplicationTask" name="formEditApplicationTask" method="post" class="form-horizontal">
					<input type="hidden" name="editApplicationTaskId" id="editApplicationTaskId" value="0" class="HTMLDBFieldValue" data-htmldb-field="id" data-htmldb-source="divApplicationTaskHTMLDBReader">
					<input type="hidden" name="editApplicationTaskApplicationId" id="editApplicationTaskApplicationId" value="0" class="HTMLDBFieldValue" data-htmldb-field="application_id" data-htmldb-source="divUnitHTMLDBReader">
					<div class="row">
						<form class="col s12">
							<div id="divApplicationTaskDetails" class="row">
								<div class="col l6 m6 s12">
									<label for="editApplicationTaskCategory"><?php echo __('Kategori'); ?></label>
									<div class="input-field">
										<select class="selectClassSelection HTMLDBFieldValue HTMLDBFieldSelect" data-htmldb-option-source="divApplicationTaskCategoryHTMLDBReader" id="editApplicationTaskCategory" style="width: 100%" name="editApplicationTaskCategory" data-htmldb-source="divApplicationTaskHTMLDBReader" data-htmldb-field="application_task_category_id">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                    </select>
									</div>
								</div>
								<div class="col l6 m6 s12">
									<label for="name"><?php echo __('Aksiyon Kodu'); ?></label>
									<div class="input-field">
										<input id="editApplicationTaskCode" name="editApplicationTaskCode" type="text" value="" data-htmldb-source="divApplicationTaskHTMLDBReader" data-htmldb-field="application_task_code" class="HTMLDBFieldValue">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
                                    <label for="editApplicationTaskApplicationNote"><?php echo __('Yapılacak Aksiyon'); ?>  </label>
									<textarea id="editApplicationTaskTaskAction" name="editApplicationTaskTaskAction" class="HTMLDBFieldValue materialize-textarea blue-text text-darken-4" data-htmldb-source="divApplicationTaskHTMLDBReader" data-htmldb-field="task_action" placeholder="" style="min-height: 100px;"></textarea>
                                </div>
							</div>
							<div class="row">
								<div class="col s12">
                                    <label for="editApplicationTaskApplicationNote"><?php echo __('Yapılan Tespit'); ?>  </label>
									<textarea id="editApplicationTaskStepDescription" name="editApplicationTaskStepDescription" class="HTMLDBFieldValue materialize-textarea blue-text text-darken-4" data-htmldb-source="divApplicationTaskHTMLDBReader" data-htmldb-field="description" placeholder="" style="min-height: 100px;"></textarea>
                                </div>
							</div>
							<div class="row">
								<div class="col s12">
									<label for="editApplicationTaskCategory"><?php echo __('Sorumlu'); ?></label>
									<div class="input-field">
										<select multiple="multiple" class="selectClassSelection HTMLDBFieldValue HTMLDBFieldSelect" data-htmldb-option-source="divApplicationTaskCrewHTMLDBReader" id="editApplicationTaskResponsible" data-reset-value="0" style="width: 100%" name="editApplicationTaskResponsible" data-htmldb-source="divApplicationTaskHTMLDBReader" data-htmldb-field="responsible">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                    	</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col l4 m4 s12">
                                    <label for="editApplicationTaskStartDate"><?php echo __('Açılma Tarihi'); ?>  </label>
                                    <input id="editApplicationTaskStartDate" name="editApplicationTaskStartDate" type="date" value="" data-htmldb-field="start_date" data-htmldb-source="divApplicationTaskHTMLDBReader" class="HTMLDBFieldValue">
								</div>
								<div class="col l4 m4 s12">
                                    <label for="editApplicationTaskTargetDate"><?php echo __('Hedef Tarihi'); ?>  </label>
                                    <input id="editApplicationTaskTargetDate" name="editApplicationTaskTargetDate" type="date" value="" data-htmldb-field="target_date" data-htmldb-source="divApplicationTaskHTMLDBReader" class="HTMLDBFieldValue">
								</div>
								<div class="col l4 m4 s12">
                                    <label for="editApplicationTaskActualDate"><?php echo __('Gerçekleşme Tarihi'); ?>  </label>
                                    <input id="editApplicationTaskActualDate" name="editApplicationTaskActualDate" type="date" value="" data-htmldb-field="actual_date" data-htmldb-source="divApplicationTaskHTMLDBReader" class="HTMLDBFieldValue">
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<span>Aksiyon Gerçekleştirme Süresi: <span data-htmldb-field="durationDisplayText" data-htmldb-source="divApplicationTaskHTMLDBReader" class="strong HTMLDBFieldContent"></span>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<label for="editApplicationTaskState"><?php echo __('Durum'); ?></label>
									<div class="input-field">
										<select class="selectClassSelection HTMLDBFieldValue HTMLDBFieldSelect" data-htmldb-option-source="divApplicationTaskStateHTMLDBReader" id="editApplicationTaskState" style="width: 100%" name="editApplicationTaskState" data-htmldb-source="divApplicationTaskHTMLDBReader" data-htmldb-field="application_task_state_id">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                    </select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
                                    <label for="editApplicationTaskNotes"><?php echo __('Açıklama'); ?>  </label>
									<textarea id="editApplicationTaskNotes" name="editApplicationTaskNotes" class="HTMLDBFieldValue materialize-textarea blue-text text-darken-4" data-htmldb-source="divApplicationTaskHTMLDBReader" data-htmldb-field="notes" placeholder="" style="min-height: 100px;"></textarea>
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
								<button id="buttonSaveEditedApplicationTask" data-htmldb-row-id="" data-htmldb-target="divApplicationTaskHTMLDBWriter" data-htmldb-dialog="divEditApplicationTaskDialog" data-htmldb-field="id" data-htmldb-attribute="data-htmldb-row-id" data-htmldb-source="divApplicationTaskHTMLDBReader" name="buttonSaveEditedApplicationTask" type="button" data-default-text="<?php echo __('KAYDET'); ?>" data-loading-text="<?php echo __('KAYDEDİLİYOR...'); ?>" class="waves-effect waves-light btn-large blue darken-4 col s12 HTMLDBFieldAttribute HTMLDBAction HTMLDBSave"><?php echo __('KAYDET'); ?></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>