	<div id="divUploadStepPhotoDialog" class="divDialogContent" data-target-file-list="" data-media-type="">
		<div class="divContentWrapper level2">
			<div class="divDialogContentContainer">
				<header class="headerHero z-depth-1 blue darken-4">
					<div class="divHeaderInfo">
						<h3 class="blue-text text-darken-4">Gözat</h3>
					</div>
					<button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat" data-container-dialog="divBrowseMediaDialog"><i class="ion-android-close blue-text text-darken-4"></i></button>
				</header>
				<div class="divContentPanel z-depth-1 white">
					<form id="formUpload" name="formUpload" action="<?php echo $_SPRIT['URL_PREFIX']; ?>uploadstepphoto/formupload" onsubmit="return false;" enctype="multipart/form-data">
						<input id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="5120000" type="hidden">   
						<div class="divDropzonePanel">
							<div class="row">
								<button id="buttonUploadMedia" name="buttonUploadMedia" type="button" class="waves-effect waves-dark btn-large white blue-text text-darken-4 col s12">Dosya Yükle...</button>
							</div>
							<div id="divDropzone" class="divDropzone row dz-clickable" style="min-height: 400px;">
								<div class="col s12">
									<ul id="ulUploadedFiles" class="ulUploadedFiles"></ul>
									<div id="divUploaderInputContainer">
										<input accept=".3gp,.7z,.ae,.ai,.avi,.bmp,.cdr,.csv,.divx,.doc,.docx,.dwg,.eps,.flv,.gif,.gz,.ico,.iso,.jpg,.jpeg,.mov,.mp3,.mp4,.mpeg,.pdf,.png,.ppt,.ps,.psd,.rar,.svg,.swf,.tar,.tiff,.txt,.wav,.zip" id="inputUploadMedia" multiple="multiple" name="inputUploadMedia" class="inputUploader" style="display:none;" type="file">
									</div>
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<button id="buttonSelectMedia" name="buttonSelectMedia" type="button" data-text-pattern="%1 DOSYA SEÇİLDİ" data-class-name="Step" data-zero-selection-pattern="DOSYA SEÇİLMEDİ" class="waves-effect waves-light btn-large blue darken-4 col s12"></button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="divHiddenElements">
		<div id="divMediaHTMLDB" class="divHTMLDB"></div>
		<div id="divMediaSessionHTMLDB" class="divHTMLDB"></div>
		<ul id="ulFileListTemplate" style="display:none;">
			<li id="liFileListItem__GUID__" class="collection-item liMediaType__MEDIA_TYPE__" data-file-name="__FILE_NAME__" data-media-type="__MEDIA_TYPE__">
				<span class="grippy"></span>
				<a href="" target="_blank" class="aFileListItemFileURL aMediaType__MEDIA_TYPE__"><img width="64" src="" alt="" class="imgFileListItemFileURL"></a>
				<a href="" target="_blank" class="aFileListItemFileURL aMediaType__MEDIA_TYPE__"><span class="title" class="spanFileListItemFileName">__FILE_NAME__</span></a>
				<a href="JavaScript:void(0);" class="aDeleteFileListItem secondary-content blue-text text-darken-4"><i class="ion-android-close"></i></a>
			</li>
		</ul>
		<ul id="ulImageListTemplate" style="display:none;">
			<li id="liFileListItem__GUID__" class="collection-item liMediaType__MEDIA_TYPE__" data-file-name="__FILE_NAME__" data-media-type="__MEDIA_TYPE__">
				<span class="grippy"></span>
				<a href="" target="_blank" class="aFileListItemFileURL aMediaType__MEDIA_TYPE__"><img width="64" src="" alt="" class="imgFileListItemFileURL"></a>
				<a href="" target="_blank" class="aFileListItemFileURL aMediaType__MEDIA_TYPE__"><span class="title" class="spanFileListItemFileName">__FILE_NAME__</span></a>
				<a href="JavaScript:void(0);" class="aDeleteFileListItem secondary-content blue-text text-darken-4"><i class="ion-android-close"></i></a>
			</li>
		</ul>
		<ul id="ulFilesToUploadTemplate">
			<li id="liUploader__GUID__" data-guid="__GUID__" class="liUploader blue lighten-5">
				<div class="progress blue-grey lighten-4">
					<div id="divProgressBar__GUID__" class="determinate blue darken-4" style="width: 100%"></div>
				</div>
				<div class="divFileImage">
					<img src="assets/img/blank-file-type.png" width="32" height="32" /></a>
				</div>
				<div class="divFileInformation">
					<div class="divFileName">__FILE_NAME__</div>
					<div class="divFileSize grey-text">__FILE_SIZE__</div>
				</div>
			</li>
		</ul>
		<ul id="ulUploadedFilesTemplate">
			<li id="liFile__GUID__" class="liUploadedFile liMediaType__MEDIA_TYPE__" data-guid="__GUID__" data-media-type="__MEDIA_TYPE__">
				<div class="divCheckbox">
					<label class="checkbox2 left-align" for="bSelectMediaObject__GUID__">
						<input class="bSelectMediaObject" id="bSelectMediaObject__GUID__" name="imageCheckbox__GUID__" value="__FILE_NAME__" type="checkbox" data-object-id="__GUID__">
						<span class="outer">
							<span class="inner"></span>
						</span>
					</label>
				</div>
				<div class="divFileImage">
					<a id="aMediaImage__GUID__" class="__FILE_NAME_CLASS__" href="JavaScript:void(0);" target="__FILE_LINK_TARGET__" alt="__FILE_NAME__" data-directory-url="__FILE_NAME__"><img id="imgMedia__GUID__" src="" data-img-directory="" /></a>
				</div>
				<div class="divFileInformation">
					<div class="divFileName"><a id="aMedia__GUID__" class="__FILE_NAME_CLASS__" href="JavaScript:void(0);" target="__FILE_LINK_TARGET__" data-directory-url="__FILE_NAME__">__FILE_NAME__</a></div>
					<div class="divFileSize grey-text">__FILE_SIZE__</div>
				</div>
			</li>
		</ul>
		<ul id="ulUploadedDirectoriesTemplate">
			<li id="liDirectory__GUID__" data-guid="__GUID__">
				<div class="divFileImage">
					<a id="aMediaImage__GUID__" class="__FILE_NAME_CLASS__" href="JavaScript:void(0);" target="__FILE_LINK_TARGET__" alt="__FILE_NAME__" data-directory-url="__FILE_NAME__"><img id="imgMedia__GUID__" src="" data-img-directory="" /></a>
				</div>
				<div class="divFileInformation">
					<div class="divFileName"><a id="aMedia__GUID__" class="__FILE_NAME_CLASS__" href="JavaScript:void(0);" target="__FILE_LINK_TARGET__" data-directory-url="__FILE_NAME__">__FILE_NAME__</a></div>
					<div class="divFileSize grey-text">__FILE_SIZE__</div>
				</div>
			</li>
		</ul>
		<ul id="ulFilesCurrentDirectoryTemplate">
			<li id="liCurrentDirectory__BLANK__" class="liCurrentDirectory blue-grey lighten-5">
				<div class="divCheckboxAll">
					<label class="checkbox2 left-align" for="bSelectMediaObjects__BLANK__">
						<input class="bSelectMediaObjects" id="bSelectMediaObjects__BLANK__" name="imageCheckboxCurrentDirectory__BLANK__" value="" type="checkbox">
						<span class="outer">
							<span class="inner"></span>
						</span>
					</label>
				</div>
				<div class="divFileImage">
					<a id="aMediaImageCurrentDirectory__BLANK__" href="JavaScript:void(0);" alt="__FILE_NAME__"><img id="imgMediaCurrentDirectory__BLANK__" src="assets/img/directory.png" width="32" height="32" /></a>
				</div>
				<div class="divFileInformation">
					<div class="divFileName">__DIRECTORY_LINKS__</div>
					<div class="divFileSize grey-text">Current Directory</div>
				</div>
			</li>			
		</ul>
		<div id="divDirectoryLinkTemplate" data-directory-description="Directory">
			<a href="JavaScript:void(0);" class="aMediaDirectory aCurrentDirectory" data-directory-url="__DIRECTORY_URL__">__DIRECTORY_NAME__</a>&nbsp;/
		</div>
		<div id="divInputUploaderTemplate">
			<input type="file" accept=".3gp,.7z,.ae,.ai,.avi,.bmp,.cdr,.csv,.divx,.doc,.docx,.dwg,.eps,.flv,.gif,.gz,.ico,.iso,.jpg,.jpeg,.mov,.mp3,.mp4,.mpeg,.pdf,.png,.ppt,.ps,.psd,.rar,.svg,.swf,.tar,.tiff,.txt,.wav,.zip" id="inputUploadMedia__BLANK__" name="inputUploadMedia__BLANK__" multiple="multiple" class="inputUploader" style="display:none;">
		</div>
		<ul id="lastUploadedPhotoNameList"></ul>
	</div>