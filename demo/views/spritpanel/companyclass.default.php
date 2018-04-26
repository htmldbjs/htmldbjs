<?php includeView($controller, 'spritpanel/head'); ?>
    <body data-active-page-csv="" data-active-dialog="" data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-page-url="companyclass">
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
                        
<th><button type="button" class="buttonTableColumn"><?php echo __('Company Name'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Score'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Personal Company'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Consultant'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tbodyGhostObjectList">
                </tbody>
            </table>
        </div>
        <div id="divObjectsContent" class="divPageContent divFullPage" data-page-header="<?php echo __('Company'); ?>">
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
                                    
<th><button type="button" class="buttonTableColumn"><?php echo __('Company Name'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Score'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Personal Company'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
<th><button type="button" class="buttonTableColumn"><?php echo __('Consultant'); ?>&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button></th>
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
        <div id="divObjectContent" class="divPageContent divFullPage" data-page-header="<?php echo __('Company'); ?>">
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
                            
	<div class="col l12 m12 s12 " id="divcompany_name">
                                    <label for="company_name"><?php echo __('Company Name'); ?> </label>
                                    <div class="input-field">
                                        <input id="company_name" name="company_name" type="text" class="blue-text text-darken-4" placeholder="" value=""  >
                                    </div>
                                </div>
	<div class="col l12 m12 s12 " id="divscore">
	                                    <label for="score"><?php echo __('Score'); ?> </label>
	                                    <div class="input-field">
		                                    <input id="score" name="score" type="text" class="blue-text text-darken-4" placeholder="" min="" max="" value="" >
	                                    </div>
                                    </div>
	<div class="col l12 m12 s12 " id="divpersonal">
                                    <p>
                                        <label class="checkbox2" for="personal">
                                        <input id="personal" name="personal" type="checkbox" value="1" >
                                        <span class="outer">
                                            <span class="inner"></span>
                                        </span><?php echo __('Personal Company'); ?> </label>
                                    </p>
                                </div>
								<div class="col l12 m12 s12 " id="divconsultant">
									<label for="consultant"><?php echo __('Consultant'); ?>  </label>
									<select class="selectClassSelection" id="consultant" style="width: 100%" name="consultant" data-min-selection="2" data-max-selection="2">
										<option value=""><?php echo __('Please Select'); ?></option>
									</select>
								</div>
	<div class="col l12 m12 s12 " id="divsponsor_firstname">
                                    <label for="sponsor_firstname"><?php echo __('Sponsor First Name'); ?> </label>
                                    <div class="input-field">
                                        <input id="sponsor_firstname" name="sponsor_firstname" type="text" class="blue-text text-darken-4" placeholder="" value=""  >
                                    </div>
                                </div>
	<div class="col l12 m12 s12 " id="divsponsor_lastname">
                                    <label for="sponsor_lastname"><?php echo __('Sponsor Last Name'); ?> </label>
                                    <div class="input-field">
                                        <input id="sponsor_lastname" name="sponsor_lastname" type="text" class="blue-text text-darken-4" placeholder="" value=""  >
                                    </div>
                                </div>
	<div class="col l12 m12 s12 " id="divsponsor_email">
                                    <label for="sponsor_email"><?php echo __('Sponsor E-mail'); ?> </label>
                                    <div class="input-field">
                                        <input id="sponsor_email" name="sponsor_email" type="email" class="blue-text text-darken-4" placeholder="" value="" >
                                    </div>
                                </div>
	<div class="col l12 m12 s12 " id="divcoordinator_firstname">
                                    <label for="coordinator_firstname"><?php echo __('Coordinator First Name'); ?> </label>
                                    <div class="input-field">
                                        <input id="coordinator_firstname" name="coordinator_firstname" type="text" class="blue-text text-darken-4" placeholder="" value=""  >
                                    </div>
                                </div>
	<div class="col l12 m12 s12 " id="divcoordinator_lastname">
                                    <label for="coordinator_lastname"><?php echo __('Coordinator Last Name'); ?> </label>
                                    <div class="input-field">
                                        <input id="coordinator_lastname" name="coordinator_lastname" type="text" class="blue-text text-darken-4" placeholder="" value=""  >
                                    </div>
                                </div>
	<div class="col l12 m12 s12 " id="divcoordinator_email">
                                    <label for="coordinator_email"><?php echo __('Coordinator E-mail'); ?> </label>
                                    <div class="input-field">
                                        <input id="coordinator_email" name="coordinator_email" type="email" class="blue-text text-darken-4" placeholder="" value="" >
                                    </div>
                                </div>
	<div class="col l12 m12 s12 " id="divhse_responsible">
                                    <label for="hse_responsible"><?php echo __('HSE Responsible'); ?> </label>
                                    <div class="input-field">
                                        <input id="hse_responsible" name="hse_responsible" type="text" class="blue-text text-darken-4" placeholder="" value=""  >
                                    </div>
                                </div>
	<div class="col l12 m12 s12 " id="divhr_responsible">
                                    <label for="hr_responsible"><?php echo __('HR Responsible'); ?> </label>
                                    <div class="input-field">
                                        <input id="hr_responsible" name="hr_responsible" type="text" class="blue-text text-darken-4" placeholder="" value=""  >
                                    </div>
                                </div>
	<div class="col l12 m12 s12 " id="divplanning_responsible">
                                    <label for="planning_responsible"><?php echo __('Planning Responsible'); ?> </label>
                                    <div class="input-field">
                                        <input id="planning_responsible" name="planning_responsible" type="text" class="blue-text text-darken-4" placeholder="" value=""  >
                                    </div>
                                </div>
	<div class="col l12 m12 s12 " id="divmaintenance_responsible">
                                    <label for="maintenance_responsible"><?php echo __('Maintenance Responsible'); ?> </label>
                                    <div class="input-field">
                                        <input id="maintenance_responsible" name="maintenance_responsible" type="text" class="blue-text text-darken-4" placeholder="" value=""  >
                                    </div>
                                </div>
	<div class="col l12 m12 s12 " id="divquality_responsible">
                                    <label for="quality_responsible"><?php echo __('Quality Responsible'); ?> </label>
                                    <div class="input-field">
                                        <input id="quality_responsible" name="quality_responsible" type="text" class="blue-text text-darken-4" placeholder="" value=""  >
                                    </div>
                                </div>
	<div class="col l12 m12 s12 " id="divpropagation_champion_firstname">
                                    <label for="propagation_champion_firstname"><?php echo __('Propagation Champion First Name'); ?> </label>
                                    <div class="input-field">
                                        <input id="propagation_champion_firstname" name="propagation_champion_firstname" type="text" class="blue-text text-darken-4" placeholder="" value=""  >
                                    </div>
                                </div>
	<div class="col l12 m12 s12 " id="divpropagation_champion_lastname">
                                    <label for="propagation_champion_lastname"><?php echo __('Propagation Champion Last Name'); ?> </label>
                                    <div class="input-field">
                                        <input id="propagation_champion_lastname" name="propagation_champion_lastname" type="text" class="blue-text text-darken-4" placeholder="" value=""  >
                                    </div>
                                </div>
	<div class="col l12 m12 s12 " id="divpropagation_champion_email">
                                    <label for="propagation_champion_email"><?php echo __('Propagation Champion Email'); ?> </label>
                                    <div class="input-field">
                                        <input id="propagation_champion_email" name="propagation_champion_email" type="email" class="blue-text text-darken-4" placeholder="" value="" >
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
                                    <?php echo __('Selected'); ?> <span id="spanDeleteSelection"></span> <?php echo __('Company object'); ?><span id="spanPluralSuffix"><?php echo __('s'); ?></span> <?php echo __('will be deleted.'); ?> <?php echo __('Do you confirm?'); ?>
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
            <div id="divCompanyHTMLDB" class="divHTMLDB"></div>
            <div id="divCompanyTableHTMLDB" class="divHTMLDB"></div>
            <div id="divconsultantPropertyOptionsHTMLDB" class="divHTMLDB"></div>
            <div id="divSessionHTMLDB" class="divHTMLDB"></div>
            <table>
                <tbody id="tbodyGhostObjectListTemplate">
                    <tr class="tr#divCompanyTableHTMLDB.id">
                        <td class="center">
                            <label class="checkbox2 left-align" for="bSelectObjectGhost#divCompanyTableHTMLDB.id">
                                <input data-object-id="#divCompanyTableHTMLDB.id" class="" id="bSelectObjectGhost#divCompanyTableHTMLDB.id" name="bSelectObjectGhost#divCompanyTableHTMLDB.id" value="1" type="checkbox">
                                <span class="outer">
                                    <span class="inner"></span>
                                </span>
                            </label>
                        </td>
                        <td>#divCompanyTableHTMLDB.id</td>
                        
<td>#divCompanyTableHTMLDB.column0</td>
<td>#divCompanyTableHTMLDB.column1</td>
<td>#divCompanyTableHTMLDB.column2</td>
<td>#divCompanyTableHTMLDB.column3</td>
                        <td>
                            <button data-object-id="#divCompanyTableHTMLDB.id" class="buttonTableListAction buttonDeleteObject right" type="button">
                                <i class="ion-android-delete"></i>
                            </button>
                            <button data-object-id="#divCompanyTableHTMLDB.id" class="buttonTableListAction buttonEditObject right" type="button">
                                <i class="ion-android-create"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tbody id="tbodyObjectListTemplate">
                    <tr class="tr#divCompanyTableHTMLDB.id">
                        <td class="center">
                            <label class="checkbox2 left-align" for="bSelectObject#divCompanyTableHTMLDB.id">
                                <input data-object-id="#divCompanyTableHTMLDB.id" class="bSelectObject" id="bSelectObject#divCompanyTableHTMLDB.id" name="bSelectObject#divCompanyTableHTMLDB.id" value="1" type="checkbox">
                                <span class="outer">
                                    <span class="inner"></span>
                                </span>
                            </label>
                        </td>
                        <td>#divCompanyTableHTMLDB.id</td>
                        
<td>#divCompanyTableHTMLDB.column0</td>
<td>#divCompanyTableHTMLDB.column1</td>
<td>#divCompanyTableHTMLDB.column2</td>
<td>#divCompanyTableHTMLDB.column3</td>
                        <td>
                            <button data-object-id="#divCompanyTableHTMLDB.id" class="buttonTableListAction buttonDeleteObject right" type="button">
                                <i class="ion-android-delete"></i>
                            </button>
                            <button data-object-id="#divCompanyTableHTMLDB.id" class="buttonTableListAction buttonEditObject right" type="button">
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
        <script src="assets/js/companyclass.js"></script>
    </body>
</html>