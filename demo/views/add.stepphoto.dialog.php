<div id="divStepPhotoDialog" class="divDialogContent divDialogActive"  data-target-file-list="" data-media-type="">
	<div class="divContentWrapper level0" style="display: block; opacity: 1;">
		<div class="divDialogContentContainer">
			<header class="headerHero z-depth-1 blue darken-4">
				<div class="divHeaderInfo">
					<h3 class="blue-text text-darken-4">Denetim Adımı Resimleri</h3>
				</div>
				<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"
				data-container-dialog="divStepPhotoDialog"><i class="ion-android-close blue-text text-darken-4"></i></button>
			</header>
			<div class="divContentPanel z-depth-1 white">
				<form id="formAuditStep" name="formAuditStep" method="post" class="form-horizontal">
					<input type="hidden" name="uploadPhotoStepId" id="uploadPhotoStepId" value="0" class="HTMLDBFieldValue" data-htmldb-field="id" data-htmldb-source="divAuditStepHTMLDBReader">
					<div class="divDropzonePanel">
						<div class="row">
							<div class="col l12 m12 s12 " id="divphotos">
								<label for="photos">Resimler </label>
								<div class="input-field">
									<textarea id="photos" name="photos" data-media-type="2" data-max-file-count="10" style="display:none;" class="HTMLDBFieldValue" data-htmldb-source="divAuditStepHTMLDBReader" data-htmldb-field="photos"></textarea>
									<div class="row" style="margin-top:20px;">
										<button id="buttonBrowsephotosFiles" name="buttonBrowsephotosFiles" type="button" data-class-name="Step" data-target-file-list="ulphotosFileList" class="buttonBrowseFile waves-effect waves-dark btn white blue-text text-darken-4" >
											<i class="ion-ios-folder"></i>&nbsp;<?php echo __('Gözat...'); ?>
										</button>
									</div>
									<div class="row">
										<ul id="ulphotosFileList" class="col s12 collection ulFileList" data-target-input-id="photos">
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field">
								<div class="col s12">
									<button id="buttonSaveStepMedia" data-htmldb-row-id="" data-htmldb-target="divAuditStepHTMLDBWriter" data-htmldb-dialog="divStepPhotoDialog" data-htmldb-field="id" data-htmldb-attribute="data-htmldb-row-id" data-htmldb-source="divAuditStepHTMLDBReader" name="buttonSaveStepMedia" type="button" data-default-text="<?php echo __('KAYDET'); ?>" data-loading-text="<?php echo __('KAYDEDİLİYOR...'); ?>" class="waves-effect waves-light btn-large blue darken-4 col s12 HTMLDBFieldAttribute HTMLDBAction HTMLDBSave"><?php echo __('KAYDET'); ?></button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>