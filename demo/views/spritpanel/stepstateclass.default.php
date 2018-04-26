<?php includeView($controller, 'spritpanel/head'); ?>
    <body data-active-page-csv="" data-active-dialog="" data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-page-url="stepstateclass">
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
                        
<th><button type="button" class="buttonTableColumn"><?php echo __('Name'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tbodyGhostObjectList">
                </tbody>
            </table>
        </div>
        <div id="divObjectsContent" class="divPageContent divFullPage" data-page-header="<?php echo __('StepState'); ?>">
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
                                    
<th><button type="button" class="buttonTableColumn"><?php echo __('Name'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
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
        <div id="divObjectContent" class="divPageContent divFullPage" data-page-header="<?php echo __('StepState'); ?>">
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
                            
	<div class="col l12 m12 s12 " id="divname">
                                    <label for="name"><?php echo __('Name'); ?> </label>
                                    <div class="input-field">
                                        <input id="name" name="name" type="text" class="blue-text text-darken-4" placeholder="" value=""  >
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
                                    <?php echo __('Selected'); ?> <span id="spanDeleteSelection"></span> <?php echo __('StepState object'); ?><span id="spanPluralSuffix"><?php echo __('s'); ?></span> <?php echo __('will be deleted.'); ?> <?php echo __('Do you confirm?'); ?>
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
            <div id="divStepStateHTMLDB" class="divHTMLDB"></div>
            <div id="divStepStateTableHTMLDB" class="divHTMLDB"></div>
            <div id="divSessionHTMLDB" class="divHTMLDB"></div>
            <table>
                <tbody id="tbodyGhostObjectListTemplate">
                    <tr class="tr#divStepStateTableHTMLDB.id">
                        <td class="center">
                            <label class="checkbox2 left-align" for="bSelectObjectGhost#divStepStateTableHTMLDB.id">
                                <input data-object-id="#divStepStateTableHTMLDB.id" class="" id="bSelectObjectGhost#divStepStateTableHTMLDB.id" name="bSelectObjectGhost#divStepStateTableHTMLDB.id" value="1" type="checkbox">
                                <span class="outer">
                                    <span class="inner"></span>
                                </span>
                            </label>
                        </td>
                        <td>#divStepStateTableHTMLDB.id</td>
                        
<td>#divStepStateTableHTMLDB.column0</td>
                        <td>
                            <button data-object-id="#divStepStateTableHTMLDB.id" class="buttonTableListAction buttonDeleteObject right" type="button">
                                <i class="ion-android-delete"></i>
                            </button>
                            <button data-object-id="#divStepStateTableHTMLDB.id" class="buttonTableListAction buttonEditObject right" type="button">
                                <i class="ion-android-create"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tbody id="tbodyObjectListTemplate">
                    <tr class="tr#divStepStateTableHTMLDB.id">
                        <td class="center">
                            <label class="checkbox2 left-align" for="bSelectObject#divStepStateTableHTMLDB.id">
                                <input data-object-id="#divStepStateTableHTMLDB.id" class="bSelectObject" id="bSelectObject#divStepStateTableHTMLDB.id" name="bSelectObject#divStepStateTableHTMLDB.id" value="1" type="checkbox">
                                <span class="outer">
                                    <span class="inner"></span>
                                </span>
                            </label>
                        </td>
                        <td>#divStepStateTableHTMLDB.id</td>
                        
<td>#divStepStateTableHTMLDB.column0</td>
                        <td>
                            <button data-object-id="#divStepStateTableHTMLDB.id" class="buttonTableListAction buttonDeleteObject right" type="button">
                                <i class="ion-android-delete"></i>
                            </button>
                            <button data-object-id="#divStepStateTableHTMLDB.id" class="buttonTableListAction buttonEditObject right" type="button">
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
        <script src="assets/js/stepstateclass.js"></script>
    </body>
</html>