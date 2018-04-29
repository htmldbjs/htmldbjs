<div id="divPhotoDialogTask" class="divDialogContent divDialogActive"  data-target-file-list="" data-media-type="">
	<div class="divContentWrapper level0" style="display: block; opacity: 1;">
		<div class="divDialogContentContainer">
			<header class="headerHero z-depth-1 blue darken-4">
				<div class="divHeaderInfo">
					<h3 class="blue-text text-darken-4">Uygulama Adımı Resimleri</h3>
				</div>
				<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"
				data-container-dialog="divPhotoDialogTask"><i class="ion-android-close blue-text text-darken-4"></i></button>
			</header>
			<div class="divContentPanel z-depth-1 white">
				<form id="formTaskPhoto" name="formTaskPhoto" method="post" class="form-horizontal">
					<input type="hidden" name="uploadPhotoTaskId" id="uploadPhotoTaskId" value="0" class="HTMLDBFieldValue" data-htmldb-field="id" data-htmldb-source="divApplicationTaskHTMLDBReader">
					<div class="divDropzonePanel">
						<div class="row">
							<div class="col l12 m12 s12 " id="divphotos">
								<label for="task_photos">Resimler </label>
								<div class="input-field">
									<textarea id="task_photos" name="task_photos" data-media-type="2" data-max-file-count="10" style="display:none;" class="HTMLDBFieldValue" data-htmldb-source="divApplicationTaskHTMLDBReader" data-htmldb-field="photos"></textarea>
									<div class="row" style="margin-top:20px;">
										<button id="buttonBrowseTaskPhotosFiles" name="buttonBrowseTaskPhotosFiles" type="button" data-target-file-list="ulTaskPhotosFileList" class="buttonBrowseFile waves-effect waves-dark btn white blue-text text-darken-4" >
											<i class="ion-ios-folder"></i>&nbsp;<?php echo __('Gözat...'); ?>
										</button>
									</div>
									<div class="row">
										<ul id="ulTaskPhotosFileList" class="col s12 collection ulFileList" data-target-input-id="task_photos">
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<button id="buttonSaveTaskMedia" data-htmldb-row-id="" data-htmldb-target="divApplicationTaskHTMLDBWriter" data-htmldb-dialog="divPhotoDialogTask" data-htmldb-field="id" data-htmldb-attribute="data-htmldb-row-id" data-htmldb-source="divApplicationTaskHTMLDBReader" name="buttonSaveTaskMedia" type="button" data-default-text="<?php echo __('KAYDET'); ?>" data-loading-text="<?php echo __('KAYDEDİLİYOR...'); ?>" class="waves-effect waves-light btn-large blue darken-4 col s12 HTMLDBFieldAttribute HTMLDBAction HTMLDBSave"><?php echo __('KAYDET'); ?></button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>