<div id="divEditApplicationSubTaskDialog" class="divDialogContent divDialogActive">
	<div class="divContentWrapper level3" style="display: block; opacity: 1;">
		<div class="divDialogContentContainer">
			<header class="headerHero z-depth-1 blue darken-4">
				<div class="divHeaderInfo">
					<h3 class="blue-text text-darken-4"><?php echo __('Alt Adım Bilgileri'); ?></h3>
				</div>
				<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"
				data-container-dialog="divProfileDialog"><i class="ion-android-close blue-text text-darken-4"></i></button>
			</header>
			<div class="divContentPanel z-depth-1 white">
				<form id="formEditApplicationSubTask" name="formEditApplicationSubTask" method="post" class="form-horizontal">
					<input type="hidden" name="editApplicationSubTaskId" id="editApplicationSubTaskId" value="0" class="HTMLDBFieldValue" data-htmldb-field="id" data-htmldb-source="divApplicationSubTaskHTMLDBReader">
					<input type="hidden" name="editApplicationSubTaskApplicationTaskId" id="editApplicationSubTaskApplicationTaskId" value="0" class="HTMLDBFieldValue" data-htmldb-field="application_task_id" data-htmldb-source="divApplicationSubTaskHTMLDBReader">
					<div class="row">
						<form class="col s12">
							<div id="divApplicationSubTaskDetails" class="row">
								<div class="col s12">
									<label for="name"><?php echo __('Başlık'); ?></label>
									<div class="input-field">
										<input id="editApplicationSubTaskTitle" name="editApplicationSubTaskTitle" type="text" value="" data-htmldb-source="divApplicationSubTaskHTMLDBReader" data-htmldb-field="title" class="HTMLDBFieldValue">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<label for="editApplicationSubTaskResponsible"><?php echo __('Sorumlu'); ?></label>
									<div class="input-field">
										<select multiple="multiple" class="selectClassSelection HTMLDBFieldValue HTMLDBFieldSelect" data-htmldb-option-source="divApplicationTaskCrewHTMLDBReader" id="editApplicationSubTaskResponsible" data-reset-value="0" style="width: 100%" name="editApplicationSubTaskResponsible" data-htmldb-source="divApplicationSubTaskHTMLDBReader" data-htmldb-field="responsible">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                    	</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col l4 m4 s12">
                                    <label for="editApplicationSubTaskStartDate"><?php echo __('Açılma Tarihi'); ?>  </label>
                                    <input id="editApplicationSubTaskStartDate" name="editApplicationSubTaskStartDate" type="date" value="" data-htmldb-field="start_date" data-htmldb-source="divApplicationSubTaskHTMLDBReader" class="HTMLDBFieldValue">
								</div>
								<div class="col l4 m4 s12">
                                    <label for="editApplicationSubTaskTargetDate"><?php echo __('Hedef Tarihi'); ?>  </label>
                                    <input id="editApplicationSubTaskTargetDate" name="editApplicationSubTaskTargetDate" type="date" value="" data-htmldb-field="target_date" data-htmldb-source="divApplicationSubTaskHTMLDBReader" class="HTMLDBFieldValue">
								</div>
								<div class="col l4 m4 s12">
                                    <label for="editApplicationSubTaskActualDate"><?php echo __('Hedef Tarihi'); ?>  </label>
                                    <input id="editApplicationSubTaskActualDate" name="editApplicationSubTaskActualDate" type="date" value="" data-htmldb-field="actual_date" data-htmldb-source="divApplicationSubTaskHTMLDBReader" class="HTMLDBFieldValue">
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<label for="editApplicationSubTaskState"><?php echo __('Durum'); ?></label>
									<div class="input-field">
										<select class="selectClassSelection HTMLDBFieldValue HTMLDBFieldSelect" data-htmldb-option-source="divApplicationTaskStateHTMLDBReader" id="editApplicationSubTaskState" style="width: 100%" name="editApplicationSubTaskState" data-htmldb-source="divApplicationSubTaskHTMLDBReader" data-htmldb-field="application_task_state_id">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                    </select>
									</div>
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
								<button id="buttonSaveEditedApplicationSubTask" data-htmldb-row-id="" data-htmldb-target="divApplicationSubTaskHTMLDBWriter" data-htmldb-dialog="divEditApplicationSubTaskDialog" data-htmldb-field="id" data-htmldb-attribute="data-htmldb-row-id" data-htmldb-source="divApplicationSubTaskHTMLDBReader" name="buttonSaveEditedApplicationSubTask" type="button" data-default-text="<?php echo __('KAYDET'); ?>" data-loading-text="<?php echo __('KAYDEDİLİYOR...'); ?>" class="waves-effect waves-light btn-large blue darken-4 col s12 HTMLDBFieldAttribute HTMLDBAction HTMLDBSave"><?php echo __('KAYDET'); ?></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>