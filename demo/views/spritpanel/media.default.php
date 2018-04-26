<?php includeView($controller, 'spritpanel/head'); ?>
<body data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-active-dialog-csv="" data-page-url="media" data-loading="0">
	<?php includeView($controller, 'spritpanel/header'); ?>
    <ul id="ulPageTopMenuMore" class="ulPageTopMenuMore dropdown-content">
        <li><a href="JavaScript:void(0);" class="buttonPageFABAdd">New Directory&nbsp;...</a></li>
        <li><a href="JavaScript:void(0);" class="" id="aDeleteObjects">Delete<span class="spanSelection">&nbsp;(0)</span>&nbsp;...</a></li>
    </ul>
	<div class="divFullPageHeader">
		<div class="row">
			<div class="divFullPageBG col s12"></div>
			<div class="list-container col s12">
				<div class="list-header">
					<div class="col s6">
						<h3 class="white-text"><?php echo __('Media'); ?></h3>
						<h4 id="h4PageHeader" data-list-template="Listing %1 records" data-selection-template=" (%1 selected)" class="white-text"></h4></div>
				</div>
			</div>
		</div>
	</div>
	<div id="divMediaContent" class="divPageContent divFullPage">
		<div class="divContentWrapper ">
			<div class="divDialogContentContainer">
				<form id="formUpload" name="formUpload" action="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>media/formupload" onsubmit="return false;" enctype="multipart/form-data">
					<input id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="5120000" type="hidden">	
					<div class="divContentPanel divDropzonePanel z-depth-1">
						<div class="row">
							<button id="buttonUploadMedia" name="buttonUploadMedia" type="button" class="waves-effect waves-dark btn-large blue darken-4 white-text col s12">Upload Files...</button>
						</div>
						<div id="divDropzone" class="divDropzone row dz-clickable" style="min-height: 400px;">
							<div class="col s12">
								<ul id="ulUploadedFiles" class="ulUploadedFiles"></ul>
								<div id="divUploaderInputContainer">
									<input accept=".3gp,.7z,.ae,.ai,.avi,.bmp,.cdr,.csv,.divx,.doc,.docx,.dwg,.eps,.flv,.gif,.gz,.ico,.iso,.jpg,.jpeg,.mov,.mp3,.mp4,.mpeg,.pdf,.png,.ppt,.ps,.psd,.rar,.svg,.swf,.tar,.tiff,.txt,.wav,.zip" id="inputUploadMedia" multiple="multiple" name="inputUploadMedia" class="inputUploader" style="display:none;" type="file">
								</div>
							</div>
						</div><!--.row-->
					</div>
				</form>
			</div>
		</div>
	</div>
    <div id="divCreateDirectoryDialog" class="divDialogContent">
        <div class="divContentWrapper level4">
            <div class="divDialogContentContainer">
                <header class="headerHero z-depth-1 blue darken-4">
                    <div class="divHeaderInfo">
                        <h3 class="blue-text text-darken-4">New Directory</h3>
                    </div>
                    <button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat" data-container-dialog="divCreateDirectoryDialog"><i class="ion-android-close blue-text text-darken-4"></i></button>
                </header>
                <div class="divContentPanel z-depth-1 white">
					<form id="formCreateDirectory" name="formCreateDirectory" target="iframeCreateDirectory" action="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>media/formcreatedirectory" method="post">
                        <div class="row">
							<div class="col s12">
                                <label for="directoryName">Directory Name</label>
                                <div class="input-field">
                                    <input id="directoryName" name="directoryName" type="text" class="blue-text text-darken-4" placeholder="" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field">
                                <div class="col s12">
                                    <button data-object-id-csv="" id="buttonCreateDirectory" type="button" class="waves-effect waves-light btn-large blue darken-4 col s12">Create Directory</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="fixed-action-btn" style="bottom: 50px; right: 30px">
        <button id="buttonPageFABAdd" class="buttonPageFABAdd btn-floating waves-effect waves-light btn-large blue darken-4"><i class="ion-plus-round"></i></button>
    </div>
    <div class="divDialogContent divLoader" id="divLoader" style="display: none;">
        <div class="divContentWrapper level4">
            <div class="divDialogContentContainer">
                <div class="progress blue-grey lighten-4">
                    <div id="divLoaderProgress" class="indeterminate blue darken-4" style="width: 100%;" data-progress="100"></div>
                </div>
                <div class="row">
                    <div id="divLoaderText" class="col s12 m12 l12 blue-text text-darken-4 center" data-default-text="Loading..."></div>
                </div>
            </div>
        </div>
    </div>
    <div id="divDeleteDialog" class="divDialogContent divAlertDialog divDeleteDialog">
        <div class="divContentWrapper level3">
            <div class="divDialogContentContainer">
                <header class="headerHero z-depth-1 red darken-4">
                    <div class="divHeaderInfo">
                        <h3 class="red-text text-darken-4">Confirm Delete</h3>
                    </div>
                    <button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"><i class="ion-android-close red-text text-darken-4"></i></button>
                </header>
                <div class="divContentPanel z-depth-1 white">
                    <form id="formConfirmDelete" name="formConfirmDelete" method="post" class="form-horizontal">
                        <div class="row" style="margin-bottom: 40px;">
                            <div class="col s12 red-text text-darken-4">
                                Selected <span id="spanDeleteSelection"></span> item<span id="spanPluralSuffix">s</span>  will be deleted. Do you confirm?
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field">
                                <div class="col s6">
                                    <button id="buttonDeleteCancel" type="button" class="buttonCloseDialog waves-effect waves-light btn-large white red-text text-darken-4 col s12">Cancel</button>
                                </div>
                                <div class="col s6">
                                    <button data-object-id-csv="" id="buttonDeleteConfirm" type="button" class="waves-effect waves-light btn-large red darken-4 col s12">Delete</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
	<?php includeView($controller, 'spritpanel/footer'); ?>
	<div class="divHiddenElements">		
		<div id="divInputUploaderTemplate">
			<input type="file" accept=".3gp,.7z,.ae,.ai,.avi,.bmp,.cdr,.csv,.divx,.doc,.docx,.dwg,.eps,.flv,.gif,.gz,.ico,.iso,.jpg,.jpeg,.mov,.mp3,.mp4,.mpeg,.pdf,.png,.ppt,.ps,.psd,.rar,.svg,.swf,.tar,.tiff,.txt,.wav,.zip" id="inputUploadMedia__BLANK__" name="inputUploadMedia__BLANK__" multiple="multiple" class="inputUploader" style="display:none;">
		</div>
		<div id="divMediaHTMLDB" class="divHTMLDB"></div>
		<div id="divSessionHTMLDB" class="divHTMLDB"></div>
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
			<li id="liFile__GUID__" data-guid="__GUID__" data-media-type="__MEDIA_TYPE__">
				<div class="divCheckbox">
                    <label class="checkbox2 left-align" for="bSelectObject__GUID__">
                        <input class="bSelectObject" id="bSelectObject__GUID__" name="imageCheckbox__GUID__" value="__FILE_NAME__" type="checkbox" data-object-id="__GUID__">
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
		<ul id="ulFilesCurrentDirectoryTemplate">
			<li id="liCurrentDirectory__BLANK__" class="liCurrentDirectory blue-grey lighten-5">
				<div class="divCheckboxAll">
                    <label class="checkbox2 left-align" for="bSelectObjects__BLANK__">
                        <input class="bSelectObjects" id="bSelectObjects__BLANK__" name="imageCheckboxCurrentDirectory__BLANK__" value="" type="checkbox">
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
		<form id="formDeleteMedia" name="formDeleteMedia" target="iframeDeleteMedia" action="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>media/formdeletemedia" method="post">
			<input type="hidden" name="deletedFileNames" id="deletedFileNames" value="">
		</form>
		<iframe id="iframeDeleteMedia" name="iframeDeleteMedia" class="iframeFormPOST" data-loading-text="Deleting Files..."></iframe>
		<iframe id="iframeCreateDirectory" name="iframeCreateDirectory" class="iframeFormPOST"></iframe>
	</div>
	<script src="assets/js/global.js"></script>
	<script src="assets/js/media.js"></script>
</body>
</html>