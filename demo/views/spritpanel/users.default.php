<?php includeView($controller, 'spritpanel/head'); ?>
<body data-active-page-csv="" data-active-dialog="" data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-page-url="users">
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
                    <div class="col s12">
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
                    <th><button type="button" class="buttonTableColumn buttonTableColumn0" data-column-index="0"><?php echo __('ID'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
                    <th><button type="button" class="buttonTableColumn buttonTableColumn1" data-column-index="1"><?php echo __('Email'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
                    <th><button type="button" class="buttonTableColumn buttonTableColumn2" data-column-index="2"><?php echo __('Name'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbodyGhostObjectList">
            </tbody>
        </table>
    </div>
    <div id="divObjectsContent" class="divPageContent divFullPage" data-page-header="<?php echo __('UserList'); ?>">
        <div class="divContentWrapper ">
            <div class="divDialogContentContainer col s12">
                <div class="divContentPanel z-depth-1 divObjectListContainer">
                    <nav class="navSearch">
                        <div class="nav-wrapper">
                            <form onsubmit="return false;">
                                <div class="input-field"><input id="strSearchObject" name="strSearchObject" class="blue-text text-darken-4" placeholder="Search..." type="search"><label for="strSearchObject" class="active"><i class="blue-text text-darken-4 material-icons ion-android-search"></i></label></div>
                            </form>
                        </div>
                </nav>
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
                                <th><button type="button" class="buttonTableColumn buttonTableColumn0" data-column-index="0"><?php echo __('ID'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
                                <th><button type="button" class="buttonTableColumn buttonTableColumn1" data-column-index="1"><?php echo __('Email'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
                                <th><button type="button" class="buttonTableColumn buttonTableColumn2" data-column-index="2"><?php echo __('Name'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
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
    <div id="divObjectContent" class="divPageContent divFullPage" data-page-header="<?php echo __('User'); ?>">
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
                        <input type="hidden" name="permissionsCSV" id="permissionsCSV" value="">
                        <div class="row">
                            <div class="col l12 m12 s12" style="margin-bottom:10px;">
                                <div class="switch collapsed switchrefresh">
                                    <label>
                                        <input id="active" name="active" type="checkbox" checked="true">
                                        <span class="lever"></span>
                                    </label>
                                    <label for="active"><?php echo __('Enable'); ?></label>
                                </div>
                            </div>
                            <div class="col s12">
                                <label for="emailAddress"><?php echo __('Email'); ?></label>
                                <div class="input-field">
                                    <input id="emailAddress" name="emailAddress" type="text" class="blue-text text-darken-4" placeholder="" value="">
                                </div>
                            </div>
                            <div class="col s12">
                                <label for="name"><?php echo __('Name'); ?></label>
                                <div class="input-field">
                                    <input id="name" name="name" type="text" class="blue-text text-darken-4" placeholder="" value="">
                                </div>
                            </div>
                            <div class="col l12 m12 s12" style="margin-top:10px;margin-bottom:10px;">
                                <div class="switch collapsed switchrefresh">
                                    <label>
                                        <input id="changePassword" name="changePassword" type="checkbox">
                                        <span class="lever"></span>
                                    </label>
                                    <label for="changePassword">Change User Password</label>
                                </div>
                            </div>
                            <div class="col l6 m12 s12 sh-element sh-changePassword-true">
                                <label for="password"><?php echo __('Password'); ?></label>
                                <div class="input-field">
                                    <input id="password" name="password" type="password" class="blue-text text-darken-4" placeholder="" value="">
                                </div>
                            </div>
                            <div class="col l6 m12 s12 sh-element sh-changePassword-true">
                                <label for="password2"><?php echo __('Password (Again)'); ?></label>
                                <div class="input-field">
                                    <input id="password2" name="password2" type="password" class="blue-text text-darken-4" placeholder="" value="">
                                </div>
                            </div>
                            <div class="col l12 m12 s12" style="margin-top:10px;margin-bottom:10px;">
                                <div class="switch collapsed switchrefresh">
                                    <label>
                                        <input id="enableAPIAccess" name="enableAPIAccess" type="checkbox">
                                        <span class="lever"></span>
                                    </label>
                                    <label for="enableAPIAccess"><?php echo __('Enable API Access'); ?></label>
                                </div>
                            </div>
                            <div class="col l6 m12 s12 sh-element sh-enableAPIAccess-true">
                                <label for="publicAPIKey"><?php echo __('Public API Key'); ?></label>
                                <div class="input-field">
                                    <input id="publicAPIKey" readonly="true" name="publicAPIKey" type="text" class="blue-text text-darken-4" placeholder="" value="">
                                </div>
                            </div>
                            <div class="col l6 m12 s12 sh-element sh-enableAPIAccess-true">
                                <label for="privateAPIKey"><?php echo __('Private API Key (Do Not Share This Key)'); ?></label>
                                <div class="input-field">
                                    <input id="privateAPIKey" readonly="true" name="privateAPIKey" type="text" class="blue-text text-darken-4" placeholder="" value="">
                                </div>
                            </div>
                            <div class="col s12 sh-element sh-enableAPIAccess-true">
                                <button id="buttonGenerateAPIKeys" name="buttonGenerateAPIKeys" data-default-text="" data-loading-text="" type="button" class="waves-effect waves-dark btn-large white blue-text text-darken-4 col s12"><?php echo __('Generate API Keys'); ?></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field">
                                <div class="col s12">
                                    <button id="buttonChangeUserPermissions" name="buttonChangeUserPermissions" data-default-text="" data-loading-text="" type="button" class="buttonOpenDialog waves-effect waves-dark btn-large white blue-text text-darken-4 col s12" data-open-dialog="divUserPermissionsDialog"><?php echo __('Change User Permissions...');?></button>
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
    <div id="divUserPermissionsDialog" class="divDialogContent">
        <div class="divContentWrapper">
            <div class="divDialogContentContainer">
                <header class="headerHero z-depth-1 blue darken-4">
                    <div class="divHeaderInfo">
                        <h3 class="blue-text text-darken-4"><?php echo __('User Permissions'); ?></h3>
                    </div>
                    <button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat" data-container-dialog="divUserPermissionsDialog"><i class="ion-android-close blue-text text-darken-4"></i></button>
                </header>
                <div class="divContentPanel z-depth-1 white">
                    <form id="formUserPermissions" name="formUserPermissions" method="post" class="form-horizontal">
                        <div class="row">
                            <div class="input-field">
                                <div class="col s12 m4 l4">
                                    <select id="lApplyAllPermission" name="lApplyAllPermission" class=" selectSelectizeStandard" data-initial-value="3">
                                        <option value="0"><?php echo __('None'); ?></option>
                                        <option value="1"><?php echo __('Read'); ?></option>
                                        <option value="2"><?php echo __('Read/Write'); ?></option>
                                        <option value="3"><?php echo __('Read/Write/Delete'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-field">                                
                                <div class="col s12 m4 l4">
                                    <button id="buttonGrantApplyAll" type="button" class="waves-effect waves-dark btn-large white blue-text text-darken-4 col s12" style="margin-top:15px;"><?php echo __('Apply All'); ?></button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <label><?php echo __('Please specify user menu permissions'); ?></label>
                            </div>
                        </div>
                        <div id="divMenuPermissions" class="row">
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <label><?php echo __('Please specify user API class permissions'); ?></label>
                            </div>
                        </div>
                        <div id="divClassPermissions" class="row">
                        </div>
                        <div class="row">
                            <div class="input-field">
                                <div class="col s6">
                                    <button id="buttonCancelUserPermissions" type="button" class="buttonCloseDialog waves-effect waves-light btn-large white blue-text text-darken-4 col s12" data-container-dialog="divUserPermissionsDialog"><?php echo __('Cancel'); ?></button>
                                </div>
                                <div class="col s6">
                                    <button data-object-id-csv="" id="buttonSaveUserPermissions" type="button" class="waves-effect waves-light btn-large blue darken-4 col s12"><?php echo __('Save'); ?></button>
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
                    <button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"><i class="ion-android-close red-text text-darken-4" data-container-dialog="divDeleteDialog"></i></button>
                </header>
                <div class="divContentPanel z-depth-1 white">
                    <form id="formConfirmDelete" name="formConfirmDelete" method="post" class="form-horizontal">
                        <div class="row" style="margin-bottom: 40px;">
                            <div class="col s12 red-text text-darken-4">
                                <?php echo __('Selected'); ?> <span id="spanDeleteSelection"></span> <?php echo __('User object'); ?><span id="spanPluralSuffix"><?php echo __('s'); ?></span> <?php echo __('will be deleted.'); ?> <?php echo __('Do you confirm?'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field">
                                <div class="col s6">
                                    <button id="buttonDeleteCancel" type="button" class="buttonCloseDialog waves-effect waves-light btn-large white red-text text-darken-4 col s12" data-container-dialog="divDeleteDialog"><?php echo __('Cancel'); ?></button>
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
                    <div id="divLoaderText" class="col s12 m12 l12 blue-text text-darken-4 center" data-default-text="Loading User List..."></div>
                </div>
            </div>
        </div>
    </div>
    <?php includeView($controller, 'spritpanel/footer'); ?>
    <div class="divHiddenElements">
        <div id="divUserHTMLDB" class="divHTMLDB"></div>
        <table>
            <tbody id="tbodyGhostObjectListTemplate">
                <tr class="tr#divUserHTMLDB.id">
                    <td class="center">
                        <label class="checkbox2 left-align" for="bSelectObjectGhost#divUserHTMLDB.id">
                            <input data-object-id="#divUserHTMLDB.id" class="" id="bSelectObjectGhost#divUserHTMLDB.id" name="bSelectObjectGhost#divUserHTMLDB.id" value="1" type="checkbox">
                            <span class="outer">
                                <span class="inner"></span>
                            </span>
                        </label>
                    </td>
                    <td>#divUserHTMLDB.id</td>
                    <td>#divUserHTMLDB.emailAddress</td>
                    <td>#divUserHTMLDB.name</td>
                    <td>
                        <button data-object-id="#divUserHTMLDB.id" class="buttonTableListAction buttonDeleteObject right" type="button">
                            <i class="ion-android-delete"></i>
                        </button>
                        <button data-object-id="#divUserHTMLDB.id" class="buttonTableListAction buttonEditObject right" type="button">
                            <i class="ion-android-create"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <tbody id="tbodyObjectListTemplate">
                <tr class="tr#divUserHTMLDB.id">
                    <td class="center">
                        <label class="checkbox2 left-align" for="bSelectObject#divUserHTMLDB.id">
                            <input data-object-id="#divUserHTMLDB.id" class="bSelectObject" id="bSelectObject#divUserHTMLDB.id" name="bSelectObject#divUserHTMLDB.id" value="1" type="checkbox">
                            <span class="outer">
                                <span class="inner"></span>
                            </span>
                        </label>
                    </td>
                    <td>#divUserHTMLDB.id</td>
                    <td>#divUserHTMLDB.emailAddress</td>
                    <td>#divUserHTMLDB.name</td>
                    <td>
                        <button data-object-id="#divUserHTMLDB.id" class="buttonTableListAction buttonDeleteObject right" type="button">
                            <i class="ion-android-delete"></i>
                        </button>
                        <button data-object-id="#divUserHTMLDB.id" class="buttonTableListAction buttonEditObject right" type="button">
                            <i class="ion-android-create"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="divMenuHTMLDB" class="divHTMLDB"></div>
        <div id="divMenuPermissionsTemplate">
            <div class="col s12 m4 l4">
                <label>#divMenuHTMLDB.name</label>
                <div class="input-field">
                    <select id="lMenuPermission#divMenuHTMLDB.id" name="lMenuPermission#divMenuHTMLDB.id" class="lPermission selectSelectizeStandard" data-identifier="Menu/#divMenuHTMLDB.url" data-initial-value="3">
                        <option value="0"><?php echo __('None'); ?></option>
                        <option value="1"><?php echo __('Read'); ?></option>
                        <option value="2"><?php echo __('Read/Write'); ?></option>
                        <option value="3"><?php echo __('Read/Write/Delete'); ?></option>
                    </select>
                </div>
            </div>
        </div>
        <div id="divClassHTMLDB" class="divHTMLDB"></div>
        <div id="divClassPermissionsTemplate">
            <div class="col s12 m4 l4">
                <label>#divClassHTMLDB.name</label>
                <div class="input-field">
                    <select id="lClassPermission#divClassHTMLDB.id" name="lClassPermission#divClassHTMLDB.id" class="lPermission selectSelectizeStandard" data-identifier="Class/#divClassHTMLDB.name" data-initial-value="3">
                        <option value="0"><?php echo __('None'); ?></option>
                        <option value="1"><?php echo __('Read'); ?></option>
                        <option value="2"><?php echo __('Read/Write'); ?></option>
                        <option value="3"><?php echo __('Read/Write/Delete'); ?></option>
                    </select>
                </div>
            </div>
        </div>
        <div id="divSessionHTMLDB" class="divHTMLDB"></div>
    </div>
    <script src="assets/js/global.js"></script>
    <script src="assets/js/users.js"></script>
</body>
</html>