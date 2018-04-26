<?php includeView($controller, 'spritpanel/head'); ?>
    <body data-active-page-csv="" data-active-dialog="" data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-page-url="mainstepclass">
        <?php includeView($controller, 'spritpanel/header'); ?>
        <ul id="ulPageTopMenuMore" class="ulPageTopMenuMore dropdown-content">
            <li><a href="JavaScript:void(0);" class="buttonPageFABAdd"><?php echo __('New'); ?>&nbsp;...</a></li>
            <li><a href="JavaScript:void(0);" class="" id="aDeleteObjects"><?php echo __('Delete'); ?><span class="spanSelection">&nbsp;(0)</span>&nbsp;...</a></li>
        </ul>
        <div class="divFullPageHeader">
            <div class="row">
                <div class="divFullPageBG col s12"></div>
                <div class="list-container col s12">
                    <div class="list-header">
                        <div class="col s6">
                            <h3 id="h3PageHeader" class="white-text"></h3>
                            <h4 id="h4PageHeader" data-list-template="Listing %1 records" data-selection-template=" (%1 selected)" class="white-text"></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="divGhostHeaderContainer" class="divGhostHeaderContainer">
            <table id="tableGhostObjectList" class="tableList highlight" data-related-table-id="tableObjectList">
                <thead>
                    <tr>
                        <th class="center" style="width: 40px;">
                            <label class="checkbox2 left-align" for="bSelectObjectsGhost">
                                <input class="" id="bSelectObjectsGhost" name="bSelectObjectsGhost" value="1" type="checkbox">
                                <span class="outer">
                                    <span class="inner"></span>
                                </span>
                            </label>
                        </th>
                        <th><button type="button" class="buttonTableColumn buttonTableColumn0" data-column-index="0">ID&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
                        
<th><button type="button" class="buttonTableColumn"><?php echo __('Step Type'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Action'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Detection'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('State'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tbodyGhostObjectList">
                </tbody>
            </table>
        </div>
        <div id="divObjectsContent" class="divPageContent divFullPage" data-page-header="<?php echo __('MainStep'); ?>">
            <div class="divContentWrapper ">               
                <div class="divDialogContentContainer col s12">
                    <div class="divContentPanel z-depth-1">
                        <nav class="navSearch"><div class="nav-wrapper">
                            <form onsubmit="return false;">
                                <div class="input-field"><input id="strSearchObject" name="strSearchObject" class="blue-text text-darken-4" placeholder="Search..." type="search"><label for="strSearchObject" class="active"><i class="blue-text text-darken-4 material-icons ion-android-search"></i></label></div>
                            </form>
                        </div></nav>
                        <table id="tableObjectList" class="tableList highlight" data-related-table-id="tableGhostObjectList">
                            <thead>
                                <tr>
                                    <th class="center" style="width: 40px;">
                                        <label class="checkbox2 left-align" for="bSelectObjects">
                                            <input class="" id="bSelectObjects" name="bSelectObjects" value="1" type="checkbox">
                                            <span class="outer">
                                                <span class="inner"></span>
                                            </span>
                                        </label>
                                    </th>
                                    <th><button type="button" class="buttonTableColumn buttonTableColumn0" data-column-index="0">ID&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
                                    
<th><button type="button" class="buttonTableColumn"><?php echo __('Step Type'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Action'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Detection'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('State'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tbodyObjectList">
                            </tbody>
                        </table>
                        <div class="row">
                            <button id="buttonShowMore" class="buttonShowMore btn-flat waves-effect waves-dark btn-large white blue-text text-darken-4 col s12">Show More...</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="divObjectContent" class="divPageContent divFullPage" data-page-header="<?php echo __('MainStep'); ?>">
            <div class="divContentWrapper ">
                <div class="divDialogContentContainer col s12">
                    <div class="divContentPanel z-depth-1">
                        <div class="row divCancelObjectDialog">
                            <div class="col s12">
                                <button id="buttonCancelObjectDialog" type="button" class="buttonCloseDialog waves-effect waves-dark btn-flat btn-large white right"><i class="ion-android-close"></i></button>
                            </div>
                        </div>
                        <form id="formObject" name="formObject" method="post" class="form-horizontal">
                            <input type="hidden" name="id" id="id" value="">
                            <div class="row"> 
                            
								<div class="col l12 m12 s12 " id="divsteptype_id">
									<label for="steptype_id"><?php echo __('Step Type'); ?>  </label>
									<select class="selectClassSelection" id="steptype_id" style="width: 100%" name="steptype_id" data-min-selection="2" data-max-selection="2">
										<option value=""><?php echo __('Please Select'); ?></option>
									</select>
								</div>
	<div class="col l12 m12 s12 " id="divaction">
	                                    <label for="action"><?php echo __('Action'); ?> </label>
	                                    <div class="input-field">
		                                    <textarea id="action" name="action" class="materialize-textarea blue-text text-darken-4" placeholder="" style="height:0px;overflow-y:hidden;" ></textarea>
	                                    </div>
                                    </div>
	<div class="col l12 m12 s12 " id="divdetection">
	                                    <label for="detection"><?php echo __('Detection'); ?> </label>
	                                    <div class="input-field">
		                                    <textarea id="detection" name="detection" class="materialize-textarea blue-text text-darken-4" placeholder="" style="height:0px;overflow-y:hidden;" ></textarea>
	                                    </div>
                                    </div>
	<div class="col l12 m12 s12 " id="divphoto">
    	                                <label for="photo"><?php echo __('Photo'); ?> </label>
        	                            <div class="input-field">
        	                            	<textarea id="photo" name="photo" data-media-type="2" data-max-file-count="1" style="display:none;"></textarea>
		                                	<div class="row" style="margin-top:20px;">
		                                		<button id="buttonBrowsephotoFiles" name="buttonBrowsephotoFiles" type="button" data-target-file-list="ulphotoFileList" class="buttonBrowseFile waves-effect waves-dark btn white blue-text text-darken-4" ><i class="ion-ios-folder"></i>&nbsp;<?php echo __('Browse...'); ?></button>
		                                	</div>
		                                	<div class="row">
                	                    		<ul id="ulphotoFileList" class="col s12 collection ulFileList" data-target-input-id="photo">
                	                    		</ul>
                	                    	</div>
                	                    </div>
                    	            </div>
	<div class="col l12 m12 s12 " id="divresponsible">
                                    <label for="responsible"><?php echo __('Responsible Person'); ?> </label>
                                    <div class="input-field">
                                        <input id="responsible" name="responsible" type="text" class="blue-text text-darken-4" placeholder="" value=""  >
                                    </div>
                                </div>
	<div class="col l12 m12 s12 " id="divexplanation_date">
		<label for="explanation_date"><?php echo __('Explanation Date'); ?>  </label>
		<div class="input-field">
			<input id="explanation_date" name="explanation_date" type="date" class="datepickerDate blue-text text-darken-4" placeholder="" value=""  >
		</div>
	</div>
	<div class="col l12 m12 s12 " id="divtarget_date">
		<label for="target_date"><?php echo __('Target Date'); ?>  </label>
		<div class="input-field">
			<input id="target_date" name="target_date" type="date" class="datepickerDate blue-text text-darken-4" placeholder="" value=""  >
		</div>
	</div>
	<div class="col l12 m12 s12 " id="divcompletion_date">
		<label for="completion_date"><?php echo __('Completion Date'); ?>  </label>
		<div class="input-field">
			<input id="completion_date" name="completion_date" type="date" class="datepickerDate blue-text text-darken-4" placeholder="" value=""  >
		</div>
	</div>
	<div class="col l12 m12 s12 " id="divdescription">
	                                    <label for="description"><?php echo __('Description'); ?> </label>
	                                    <div class="input-field">
		                                    <textarea id="description" name="description" class="materialize-textarea blue-text text-darken-4" placeholder="" style="height:0px;overflow-y:hidden;" ></textarea>
	                                    </div>
                                    </div>
								<div class="col l12 m12 s12 " id="divstepstate_id">
									<label for="stepstate_id"><?php echo __('State'); ?>  </label>
									<select class="selectClassSelection" id="stepstate_id" style="width: 100%" name="stepstate_id" data-min-selection="2" data-max-selection="2">
										<option value=""><?php echo __('Please Select'); ?></option>
									</select>
								</div>
                            </div>
                            <div class="row">
                                <div class="input-field">
                                    <div class="col s12">
                                        <button data-object-id="0" id="buttonSaveObject" name="buttonSaveObject" data-default-text="<?php echo __('Save'); ?>" data-loading-text="<?php echo __('Saving...'); ?>" type="button" class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('Save'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="divDeleteDialog" class="divDialogContent divAlertDialog divDeleteDialog">
            <div class="divContentWrapper level3">
                <div class="divDialogContentContainer">
                    <header class="headerHero z-depth-1 red darken-4">
                        <div class="divHeaderInfo">
                            <h3 class="red-text text-darken-4"><?php echo __('Confirm Delete'); ?></h3>
                        </div>
                        <button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"><i class="ion-android-close red-text text-darken-4"></i></button>
                    </header>
                    <div class="divContentPanel z-depth-1 white">
                        <form id="formConfirmDelete" name="formConfirmDelete" method="post" class="form-horizontal">
                            <div class="row" style="margin-bottom: 40px;">
                                <div class="col s12 red-text text-darken-4">
                                    <?php echo __('Selected'); ?> <span id="spanDeleteSelection"></span> <?php echo __('MainStep object'); ?><span id="spanPluralSuffix"><?php echo __('s'); ?></span> <?php echo __('will be deleted.'); ?> <?php echo __('Do you confirm?'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field">
                                    <div class="col s6">
                                        <button id="buttonDeleteCancel" type="button" class="buttonCloseDialog waves-effect waves-light btn-large white red-text text-darken-4 col s12"><?php echo __('Cancel'); ?></button>
                                    </div>
                                    <div class="col s6">
                                        <button data-object-id-csv="" id="buttonDeleteConfirm" type="button" class="waves-effect waves-light btn-large red darken-4 col s12"><?php echo __('Delete'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <div id="divBrowseMediaDialog" class="divDialogContent" data-target-file-list="" data-media-type="">
        <div class="divContentWrapper level2">
            <div class="divDialogContentContainer">
                <header class="headerHero z-depth-1 blue darken-4">
                    <div class="divHeaderInfo">
                        <h3 class="blue-text text-darken-4">Browse Media</h3>
                    </div>
                    <button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat" data-container-dialog="divBrowseMediaDialog"><i class="ion-android-close blue-text text-darken-4"></i></button>
                </header>
                <div class="divContentPanel z-depth-1 white">
                    <form id="formUpload" name="formUpload" action="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>media/formupload" onsubmit="return false;" enctype="multipart/form-data">
                        <input id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="5120000" type="hidden">   
                        <div class="divContentPanel divDropzonePanel">
                            <div class="row">
                                <button id="buttonUploadMedia" name="buttonUploadMedia" type="button" class="waves-effect waves-dark btn-large white blue-text text-darken-4 col s12">Upload Files...</button>
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
                    <div class="row">
                        <button id="buttonSelectMedia" name="buttonSelectMedia" type="button" data-text-pattern="Select %1 File(s)" data-zero-selection-pattern="No File Selected" class="waves-effect waves-light btn-large blue darken-4 col s12"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="fixed-action-btn" style="bottom: 50px; right: 30px">
            <button id="buttonPageFABAdd" class="buttonPageFABAdd btn-floating waves-effect waves-light btn-large blue darken-4"><i class="ion-plus-round"></i></button>
        </div>
        <div class="divDialogContent divLoader" id="divLoader">
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
        <?php includeView($controller, 'spritpanel/footer'); ?>
        <div class="divHiddenElements">
            <div id="divMainStepHTMLDB" class="divHTMLDB"></div>
            <div id="divMainStepTableHTMLDB" class="divHTMLDB"></div>
            <div id="divsteptype_idPropertyOptionsHTMLDB" class="divHTMLDB"></div>
            <div id="divstepstate_idPropertyOptionsHTMLDB" class="divHTMLDB"></div>
            <div id="divMediaHTMLDB" class="divHTMLDB"></div>
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


            <div id="divSessionHTMLDB" class="divHTMLDB"></div>
            <table>
                <tbody id="tbodyGhostObjectListTemplate">
                    <tr class="tr#divMainStepTableHTMLDB.id">
                        <td class="center">
                            <label class="checkbox2 left-align" for="bSelectObjectGhost#divMainStepTableHTMLDB.id">
                                <input data-object-id="#divMainStepTableHTMLDB.id" class="" id="bSelectObjectGhost#divMainStepTableHTMLDB.id" name="bSelectObjectGhost#divMainStepTableHTMLDB.id" value="1" type="checkbox">
                                <span class="outer">
                                    <span class="inner"></span>
                                </span>
                            </label>
                        </td>
                        <td>#divMainStepTableHTMLDB.id</td>
                        
<td>#divMainStepTableHTMLDB.column0</td>
<td>#divMainStepTableHTMLDB.column1</td>
<td>#divMainStepTableHTMLDB.column2</td>
<td>#divMainStepTableHTMLDB.column3</td>
                        <td>
                            <button data-object-id="#divMainStepTableHTMLDB.id" class="buttonTableListAction buttonDeleteObject right" type="button">
                                <i class="ion-android-delete"></i>
                            </button>
                            <button data-object-id="#divMainStepTableHTMLDB.id" class="buttonTableListAction buttonEditObject right" type="button">
                                <i class="ion-android-create"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tbody id="tbodyObjectListTemplate">
                    <tr class="tr#divMainStepTableHTMLDB.id">
                        <td class="center">
                            <label class="checkbox2 left-align" for="bSelectObject#divMainStepTableHTMLDB.id">
                                <input data-object-id="#divMainStepTableHTMLDB.id" class="bSelectObject" id="bSelectObject#divMainStepTableHTMLDB.id" name="bSelectObject#divMainStepTableHTMLDB.id" value="1" type="checkbox">
                                <span class="outer">
                                    <span class="inner"></span>
                                </span>
                            </label>
                        </td>
                        <td>#divMainStepTableHTMLDB.id</td>
                        
<td>#divMainStepTableHTMLDB.column0</td>
<td>#divMainStepTableHTMLDB.column1</td>
<td>#divMainStepTableHTMLDB.column2</td>
<td>#divMainStepTableHTMLDB.column3</td>
                        <td>
                            <button data-object-id="#divMainStepTableHTMLDB.id" class="buttonTableListAction buttonDeleteObject right" type="button">
                                <i class="ion-android-delete"></i>
                            </button>
                            <button data-object-id="#divMainStepTableHTMLDB.id" class="buttonTableListAction buttonEditObject right" type="button">
                                <i class="ion-android-create"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div id="divClassSelectionOptionTemplate">
                <div><span class="name">__NAME__</span></div>
            </div>
        </div>
        <script src="assets/js/global.js"></script>
        <script src="assets/js/mainstepclass.js"></script>
    </body>
</html>