	<div id="divUploadPhotoDialogSubTask" class="divDialogContent" data-target-file-list="" data-media-type="">
		<div class="divContentWrapper level2">
			<div class="divDialogContentContainer">
				<header class="headerHero z-depth-1 blue darken-4">
					<div class="divHeaderInfo">
						<h3 class="blue-text text-darken-4">Gözat</h3>
					</div>
					<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat" data-container-dialog="divBrowseMediaDialog"><i class="ion-android-close blue-text text-darken-4"></i></button>
				</header>
				<div class="divContentPanel z-depth-1 white">
					<form id="formUploadSubTask" name="formUploadSubTask" action="<?php echo $_SPRIT['URL_PREFIX']; ?>uploadtaskphoto/formupload" onsubmit="return false;" enctype="multipart/form-data">
						<div class="divDropzonePanel">
							<div class="row">
								<button name="buttonUploadMedia" data-class-name="SubTask" type="button" class="buttonUploadMedia waves-effect waves-dark btn-large white blue-text text-darken-4 col s12">Dosya Yükle...</button>
							</div>
							<div id="divSubTaskDropzone" class="divDropzone row dz-clickable" style="min-height: 400px;">
								<div class="col s12">
									<ul id="ulUploadedFilesSubTask" class="ulUploadedFiles"></ul>
									<div id="divUploaderInputContainerSubTask">
										<input accept=".3gp,.7z,.ae,.ai,.avi,.bmp,.cdr,.csv,.divx,.doc,.docx,.dwg,.eps,.flv,.gif,.gz,.ico,.iso,.jpg,.jpeg,.mov,.mp3,.mp4,.mpeg,.pdf,.png,.ppt,.ps,.psd,.rar,.svg,.swf,.tar,.tiff,.txt,.wav,.zip" data-class-name="SubTask" multiple="multiple" name="inputUploadMedia" class="inputUploadMedia inputUploader" style="display:none;" type="file">
									</div>
								</div>
							</div><!--.row-->
						</div>
					</form>
					<div class="row">
						<button id="buttonSelectMediaSubTask" name="buttonSelectMediaSubTask" type="button" data-text-pattern="%1 DOSYA SEÇİLDİ" data-zero-selection-pattern="DOSYA SEÇİLMEDİ" class="buttonSelectMedia waves-effect waves-light btn-large blue darken-4 col s12"></button>
					</div>
				</div>
			</div>
		</div>
	</div>