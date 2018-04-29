<div id="divPhotoDialogSubTask" class="divDialogContent divDialogActive"  data-target-file-list="" data-media-type="">
	<div class="divContentWrapper level0" style="display: block; opacity: 1;">
		<div class="divDialogContentContainer">
			<header class="headerHero z-depth-1 blue darken-4">
				<div class="divHeaderInfo">
					<h3 class="blue-text text-darken-4">Alt Aksiyon Resimleri</h3>
				</div>
				<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"
				data-container-dialog="divPhotoDialogSubTask"><i class="ion-android-close blue-text text-darken-4"></i></button>
			</header>
			<div class="divContentPanel z-depth-1 white">
				<form id="formSubTaskPhoto" name="formSubTaskPhoto" method="post" class="form-horizontal">
					<input type="hidden" name="uploadPhotoSubTaskId" id="uploadPhotoSubTaskId" value="0" class="HTMLDBFieldValue" data-htmldb-field="id" data-htmldb-source="divApplicationSubTaskHTMLDBReader">
					<div class="divDropzonePanel">
						<div class="row">
							<div class="col l12 m12 s12 ">
								<label for="sub_task_photos">Resimler </label>
								<div class="input-field">
									<textarea id="sub_task_photos" name="sub_task_photos" data-media-type="2" data-max-file-count="10" style="display:none;" class="HTMLDBFieldValue" data-htmldb-source="divApplicationSubTaskHTMLDBReader" data-htmldb-field="photos"></textarea>
									<div class="row" style="margin-top:20px;">
										<button id="buttonBrowseSubTaskPhotosFiles" name="buttonBrowseSubTaskPhotosFiles" type="button" data-target-file-list="ulSubTaskPhotosFileList" class="buttonBrowseFile waves-effect waves-dark btn white blue-text text-darken-4" >
											<i class="ion-ios-folder"></i>&nbsp;<?php echo __('Gözat...'); ?>
										</button>
									</div>
									<div class="row">
										<ul id="ulSubTaskPhotosFileList" class="col s12 collection ulFileList" data-target-input-id="sub_task_photos">
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<button id="buttonSaveSubTaskMedia" data-htmldb-row-id="" data-htmldb-target="divApplicationSubTaskHTMLDBWriter" data-htmldb-dialog="divPhotoDialogSubTask" data-htmldb-field="id" data-htmldb-attribute="data-htmldb-row-id" data-htmldb-source="divApplicationSubTaskHTMLDBReader" name="buttonSaveSubTaskMedia" type="button" data-default-text="<?php echo __('KAYDET'); ?>" data-loading-text="<?php echo __('KAYDEDİLİYOR...'); ?>" class="waves-effect waves-light btn-large blue darken-4 col s12 HTMLDBFieldAttribute HTMLDBAction HTMLDBSave"><?php echo __('KAYDET'); ?></button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>