<?php includeView($controller, 'spritpanel/head'); ?>
    <body data-active-page-csv="" data-active-dialog="" data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-page-url="auditclass">
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
                        
<th><button type="button" class="buttonTableColumn"><?php echo __('Audit Date'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Audit Code'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Unit'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Audit State'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Audit Type'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Score'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tbodyGhostObjectList">
                </tbody>
            </table>
        </div>
        <div id="divObjectsContent" class="divPageContent divFullPage" data-page-header="<?php echo __('Audit'); ?>">
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
                                    
<th><button type="button" class="buttonTableColumn"><?php echo __('Audit Date'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Audit Code'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Unit'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Audit State'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Audit Type'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Score'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
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
        <div id="divObjectContent" class="divPageContent divFullPage" data-page-header="<?php echo __('Audit'); ?>">
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
                            
	<div class="col l12 m12 s12 " id="divaudit_date">
		<label for="audit_date"><?php echo __('Audit Date'); ?>  </label>
		<div class="input-field">
			<input id="audit_date" name="audit_date" type="date" class="datepickerDate blue-text text-darken-4" placeholder="" value=""  >
		</div>
	</div>
	<div class="col l12 m12 s12 " id="divaudit_code">
                                    <label for="audit_code"><?php echo __('Audit Code'); ?> </label>
                                    <div class="input-field">
                                        <input id="audit_code" name="audit_code" type="text" class="blue-text text-darken-4" placeholder="" value=""  >
                                    </div>
                                </div>
								<div class="col l12 m12 s12 " id="divunit_id">
									<label for="unit_id"><?php echo __('Unit'); ?>  </label>
									<select class="selectClassSelection" id="unit_id" style="width: 100%" name="unit_id" data-min-selection="2" data-max-selection="2">
										<option value=""><?php echo __('Please Select'); ?></option>
									</select>
								</div>
								<div class="col l12 m12 s12 " id="divaudit_type_id">
									<label for="audit_type_id"><?php echo __('Audit Type'); ?>  </label>
									<select class="selectClassSelection" id="audit_type_id" style="width: 100%" name="audit_type_id" data-min-selection="2" data-max-selection="2">
										<option value=""><?php echo __('Please Select'); ?></option>
									</select>
								</div>
								<div class="col l12 m12 s12 " id="divaudit_state_id">
									<label for="audit_state_id"><?php echo __('Audit State'); ?>  </label>
									<select class="selectClassSelection" id="audit_state_id" style="width: 100%" name="audit_state_id" data-min-selection="2" data-max-selection="2">
										<option value=""><?php echo __('Please Select'); ?></option>
									</select>
								</div>
	<div class="col l12 m12 s12 " id="divscore">
	                                    <label for="score"><?php echo __('Score'); ?> </label>
	                                    <div class="input-field">
		                                    <input id="score" name="score" type="text" class="blue-text text-darken-4" placeholder="" min="" max="" value="" >
	                                    </div>
                                    </div>
	<div class="col l12 m12 s12 " id="divnotes">
	                                    <label for="notes"><?php echo __('Notes'); ?> </label>
	                                    <div class="input-field">
		                                    <textarea id="notes" name="notes" class="materialize-textarea blue-text text-darken-4" placeholder="" style="height:0px;overflow-y:hidden;" ></textarea>
	                                    </div>
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
                                    <?php echo __('Selected'); ?> <span id="spanDeleteSelection"></span> <?php echo __('Audit object'); ?><span id="spanPluralSuffix"><?php echo __('s'); ?></span> <?php echo __('will be deleted.'); ?> <?php echo __('Do you confirm?'); ?>
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
            <div id="divAuditHTMLDB" class="divHTMLDB"></div>
            <div id="divAuditTableHTMLDB" class="divHTMLDB"></div>
            <div id="divunit_idPropertyOptionsHTMLDB" class="divHTMLDB"></div>
            <div id="divaudit_type_idPropertyOptionsHTMLDB" class="divHTMLDB"></div>
            <div id="divaudit_state_idPropertyOptionsHTMLDB" class="divHTMLDB"></div>
            <div id="divSessionHTMLDB" class="divHTMLDB"></div>
            <table>
                <tbody id="tbodyGhostObjectListTemplate">
                    <tr class="tr#divAuditTableHTMLDB.id">
                        <td class="center">
                            <label class="checkbox2 left-align" for="bSelectObjectGhost#divAuditTableHTMLDB.id">
                                <input data-object-id="#divAuditTableHTMLDB.id" class="" id="bSelectObjectGhost#divAuditTableHTMLDB.id" name="bSelectObjectGhost#divAuditTableHTMLDB.id" value="1" type="checkbox">
                                <span class="outer">
                                    <span class="inner"></span>
                                </span>
                            </label>
                        </td>
                        <td>#divAuditTableHTMLDB.id</td>
                        
<td>#divAuditTableHTMLDB.column0</td>
<td>#divAuditTableHTMLDB.column1</td>
<td>#divAuditTableHTMLDB.column2</td>
<td>#divAuditTableHTMLDB.column3</td>
<td>#divAuditTableHTMLDB.column4</td>
<td>#divAuditTableHTMLDB.column5</td>
                        <td>
                            <button data-object-id="#divAuditTableHTMLDB.id" class="buttonTableListAction buttonDeleteObject right" type="button">
                                <i class="ion-android-delete"></i>
                            </button>
                            <button data-object-id="#divAuditTableHTMLDB.id" class="buttonTableListAction buttonEditObject right" type="button">
                                <i class="ion-android-create"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tbody id="tbodyObjectListTemplate">
                    <tr class="tr#divAuditTableHTMLDB.id">
                        <td class="center">
                            <label class="checkbox2 left-align" for="bSelectObject#divAuditTableHTMLDB.id">
                                <input data-object-id="#divAuditTableHTMLDB.id" class="bSelectObject" id="bSelectObject#divAuditTableHTMLDB.id" name="bSelectObject#divAuditTableHTMLDB.id" value="1" type="checkbox">
                                <span class="outer">
                                    <span class="inner"></span>
                                </span>
                            </label>
                        </td>
                        <td>#divAuditTableHTMLDB.id</td>
                        
<td>#divAuditTableHTMLDB.column0</td>
<td>#divAuditTableHTMLDB.column1</td>
<td>#divAuditTableHTMLDB.column2</td>
<td>#divAuditTableHTMLDB.column3</td>
<td>#divAuditTableHTMLDB.column4</td>
<td>#divAuditTableHTMLDB.column5</td>
                        <td>
                            <button data-object-id="#divAuditTableHTMLDB.id" class="buttonTableListAction buttonDeleteObject right" type="button">
                                <i class="ion-android-delete"></i>
                            </button>
                            <button data-object-id="#divAuditTableHTMLDB.id" class="buttonTableListAction buttonEditObject right" type="button">
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
        <script src="assets/js/auditclass.js"></script>
    </body>
</html>