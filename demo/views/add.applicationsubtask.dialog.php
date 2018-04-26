<div id="divAddApplicationSubTaskDialog" class="divDialogContent divDialogActive">
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
				<form id="formAddApplicationSubTask" name="formAddApplicationSubTask" method="post" class="form-horizontal">
					<input type="hidden" name="addApplicationSubTaskId" id="addApplicationSubTaskId" value="0" class="HTMLDBFieldValue" data-htmldb-field="id" data-htmldb-source="divApplicationSubTaskHTMLDBReader">
					<input type="hidden" name="addApplicationSubTaskApplicationTaskId" id="addApplicationSubTaskApplicationTaskId" value="0" class="HTMLDBFieldValue" data-htmldb-field="application_task_id" data-htmldb-source="divApplicationSubTaskHTMLDBReader">
					<div class="row">
						<form class="col s12">
							<div id="divApplicationSubTaskDetails" class="row">
								<div class="col s12">
									<label for="name"><?php echo __('Başlık'); ?></label>
									<div class="input-field">
										<input id="addApplicationSubTaskTitle" name="addApplicationSubTaskTitle" type="text" value="" data-htmldb-source="divApplicationSubTaskHTMLDBReader" data-htmldb-field="title" class="HTMLDBFieldValue">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<label for="addApplicationSubTaskResponsible"><?php echo __('Sorumlu'); ?></label>
									<div class="input-field">
										<select multiple="multiple" class="selectClassSelection HTMLDBFieldValue HTMLDBFieldSelect" data-htmldb-option-source="divApplicationTaskCrewHTMLDBReader" id="addApplicationSubTaskResponsible" data-reset-value="0" style="width: 100%" name="addApplicationSubTaskResponsible" data-htmldb-source="divApplicationSubTaskHTMLDBReader" data-htmldb-field="responsible">
                                        <option value=""><?php echo __('Please Select'); ?></option>
                                    	</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col l4 m4 s12">
                                    <label for="addApplicationSubTaskStartDate"><?php echo __('Açılma Tarihi'); ?>  </label>
                                    <input id="addApplicationSubTaskStartDate" name="addApplicationSubTaskStartDate" type="date" value="" data-htmldb-field="start_date" data-htmldb-source="divApplicationSubTaskHTMLDBReader" class="HTMLDBFieldValue">
								</div>
								<div class="col l4 m4 s12">
                                    <label for="addApplicationSubTaskTargetDate"><?php echo __('Hedef Tarihi'); ?>  </label>
                                    <input id="addApplicationSubTaskTargetDate" name="addApplicationSubTaskTargetDate" type="date" value="" data-htmldb-field="target_date" data-htmldb-source="divApplicationSubTaskHTMLDBReader" class="HTMLDBFieldValue">
								</div>
								<div class="col l4 m4 s12">
                                    <label for="addApplicationSubTaskActualDate"><?php echo __('Hedef Tarihi'); ?>  </label>
                                    <input id="addApplicationSubTaskActualDate" name="addApplicationSubTaskActualDate" type="date" value="" data-htmldb-field="actual_date" data-htmldb-source="divApplicationSubTaskHTMLDBReader" class="HTMLDBFieldValue">
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<label for="addApplicationSubTaskState"><?php echo __('Durum'); ?></label>
									<div class="input-field">
										<select class="selectClassSelection HTMLDBFieldValue HTMLDBFieldSelect" data-htmldb-option-source="divApplicationTaskStateHTMLDBReader" id="addApplicationSubTaskState" style="width: 100%" name="addApplicationSubTaskState" data-htmldb-source="divApplicationSubTaskHTMLDBReader" data-htmldb-field="application_task_state_id">
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
								<button id="buttonSaveAddedApplicationSubTask" data-htmldb-row-id="" data-htmldb-target="divApplicationSubTaskHTMLDBWriter" data-htmldb-dialog="divAddApplicationSubTaskDialog" data-htmldb-field="id" data-htmldb-attribute="data-htmldb-row-id" data-htmldb-source="divApplicationSubTaskHTMLDBReader" name="buttonSaveAddedApplicationSubTask" type="button" data-default-text="<?php echo __('KAYDET'); ?>" data-loading-text="<?php echo __('KAYDEDİLİYOR...'); ?>" class="waves-effect waves-light btn-large blue darken-4 col s12 HTMLDBFieldAttribute HTMLDBAction HTMLDBSave"><?php echo __('KAYDET'); ?></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>