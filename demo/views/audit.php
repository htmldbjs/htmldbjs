<?php includeView($controller, 'head'); ?>
<body class="" data-active-page-csv="" data-active-dialog="" data-url-prefix="<?php echo $_SPRIT['URL_PREFIX']; ?>"
  data-page-url="companies">
  <?php includeView($controller, 'header'); ?>
  <div class="divFullPageHeader">
    <div class="divTabsContainer z-depth-1">
    </div>
</div>
<div class="divPageSubHeader">
    <h2><a href="<?php echo $_SPRIT['URL_PREFIX']; ?>home">Anasayfa</a>&nbsp;<i class="ion-chevron-right"></i>&nbsp;<a href="<?php echo $_SPRIT['URL_PREFIX']; ?>companies">Firmalar</a>&nbsp;<i class="ion-chevron-right"></i>&nbsp;<a href="#" class="aCompanyNameLink HTMLDBFieldContent" data-htmldb-source="divAuditHTMLDBReader" data-htmldb-field="company_idDisplayText"></a>&nbsp;<i class="ion-chevron-right"></i>&nbsp;<a href="#" class="aUnitNameLink HTMLDBFieldContent" data-htmldb-source="divAuditHTMLDBReader" data-htmldb-field="unit_idDisplayText"></a></h2>
    <h1 class="HTMLDBFieldContent" data-htmldb-source="divAuditHTMLDBReader" data-htmldb-field="audit_code">&nbsp;</h1>
</div>
<section id="sectionDetails" class="sectionContent">
    <div class="col s12">
        <form id="formDetails" name="formDetails">
            <div class="card horizontal grey lighten-3">
                <div class="card-stacked">
                    <div class="card-content">
                        <div class="row">
                            <span id="spanCompanyId" data-htmldb-field="company_id" data-htmldb-source="divAuditHTMLDBReader" class="HTMLDBFieldContent" style="display: none;"></span>
                            <span id="spanUnitId" data-htmldb-field="unit_id" data-htmldb-source="divAuditHTMLDBReader" class="HTMLDBFieldContent" style="display: none;"></span>
                            <div class="col l3 m3 s12">
                                <label><?php echo __('Denetim Tarihi'); ?></label>
                                <div class="input-field">
                                    <p class="HTMLDBFieldContent" data-htmldb-source="divAuditHTMLDBReader" data-htmldb-field="audit_date">&nbsp;</p>
                                </div>
                            </div>
                            <div class="col l3 m3 s12">
                                <label><?php echo __('Denetim Kodu'); ?></label>
                                <div class="input-field">
                                    <p class="HTMLDBFieldContent" data-htmldb-source="divAuditHTMLDBReader" data-htmldb-field="audit_code">&nbsp;</p>
                                </div>
                            </div>
                            <div class="col l6 m6 s12">
                                <label><?php echo __('Alan'); ?></label>
                                <div class="input-field">
                                    <a href="#" class="aUnitNameLink blue-text text-darken-4"><p class="HTMLDBFieldContent" data-htmldb-source="divAuditHTMLDBReader" data-htmldb-field="unit_idDisplayText">&nbsp;</p></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col l3 m3 s12">
                                <label><?php echo __('Denetim Türü'); ?></label>
                                <div class="input-field">
                                    <p class="HTMLDBFieldContent" data-htmldb-source="divAuditHTMLDBReader" data-htmldb-field="audit_type_idDisplayText">&nbsp;</p>
                                </div>
                            </div>
                            <div class="col l3 m3 s12">
                                <label><?php echo __('Denetim Durumu'); ?></label>
                                <div class="input-field">
                                    <p class="HTMLDBFieldContent" data-htmldb-source="divAuditHTMLDBReader" data-htmldb-field="audit_state_idDisplayText">&nbsp;</p>
                                </div>
                            </div>
                            <div class="col l6 m6 s12">
                                <label><?php echo __('Denetim Skoru'); ?></label>
                                <div class="input-field">
                                    <p id="pScore" class="HTMLDBFieldContent" data-htmldb-source="divAuditHTMLDBReader" data-htmldb-field="score">&nbsp;</p>
                                </div>
                            </div>
                            <div class="col l6 m6 s12" style="display:none;">
                                <label><?php echo __('Notlar'); ?></label>
                                <div class="input-field">
                                    <p class="HTMLDBFieldContent" data-htmldb-source="divAuditHTMLDBReader" data-htmldb-field="notes">&nbsp;</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button id="buttonEdit" type="button" name="buttonEdit" data-htmldb-field="id" data-htmldb-attribute="data-htmldb-row-id" data-htmldb-dialog="divAuditDialog" data-htmldb-source="divAuditHTMLDBReader" data-htmldb-row-id="" class="buttonAction HTMLDBAction HTMLDBEdit HTMLDBFieldAttribute waves-effect waves-dark cyan-text text-darken-1 btn white"><i class="ion-edit col s12"></i> <?php echo __('UPDATE'); ?></button>
                        <button id="buttonDownloadPhotos" type="button" name="buttonDownloadPhotos" class=" waves-effect waves-dark cyan-text text-darken-1 btn white"><i class="ion-android-download col s12"></i> Fotoğrafları İndir</button>
                    </div>
                </div>
            </div>
            <div class="card horizontal grey lighten-3">
                <div class="card-stacked">
                    <div class="card-content">
                        <div class="row">
                            <span class="card-title activator grey-text text-darken-4">Denetim Adımları</span>
                            <button id="buttonAddAuditStep" name="buttonAddAuditStep" class="waves-effect white-text btn right cyan darken-1 HTMLDBAction HTMLDBAdd" type="button" data-htmldb-dialog="divAddAuditStepDialog" data-htmldb-source="divAuditStepHTMLDBReader" data-htmldb-row-id="0"><i class="ion-plus"></i> YENİ ADIM</button>
                            <ul id="ulAuditStepCategory" class="tabs tabs-fixed-width center-align z-depth-1">
                                <li class="tab"><a id="aAuditStepCategoryAll" class="active" data-index="0" href="JavaScript:void(0);">TÜMÜ <span id="spanAllCompletedCount"></span></a></li>
                                <li class="tab"><a class="" data-index="1" href="JavaScript:void(0);">AYIKLA <span id="spanStep1CompletedCount"></span></a></li>
                                <li class="tab"><a class="" data-index="2" href="JavaScript:void(0);">YERLEŞTİR <span id="spanStep2CompletedCount"></span></a></li>
                                <li class="tab"><a class="" data-index="3" href="JavaScript:void(0);">PARLAT <span id="spanStep3CompletedCount"></span></a></li>
                                <li class="tab"><a class="" data-index="4" href="JavaScript:void(0);">ALIŞTIR <span id="spanStep4CompletedCount"></span></a></li>
                                <li class="tab"><a class="" data-index="5" href="JavaScript:void(0);">KALICI KIL <span id="spanStep5CompletedCount"></span></a></li>
                            </ul>
                            <div id="audit_step1_list">
                                <table id="tableAuditStep1List" class="tableList tableAuditStepList highlight" data-related-table-id="tableGhostObjectList">
                                    <thead>
                                        <tr><th colspan="5"><span class="card-title activator grey-text text-darken-4">Ayıkla</span></th>
                                        <tr>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">Soru Tipi&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                data-column-index="1">
                                                No&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span></button>
                                                </th>
                                                <th>
                                                    <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                    data-column-index="1">
                                                    Aksiyon&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                        class="ion-arrow-down-b"></i></span><span
                                                        class="sorting sorting-asc blue-text text-darken-4"><i
                                                        class="ion-arrow-up-b"></i></span></button>
                                                </th>
                                                <th>
                                                    <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                    data-column-index="1">
                                                    Evet / Hayır&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                        class="ion-arrow-down-b"></i></span><span
                                                        class="sorting sorting-asc blue-text text-darken-4"><i
                                                        class="ion-arrow-up-b"></i></span></button>
                                                </th>
                                                <th style="width: 50px;"></th>
                                                <th style="width: 50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyAuditStep1List"></tbody>
                                </table>
                            </div>
                            <div id="audit_step2_list" style="display: none;">
                                <table id="tableAuditStep2List" class="tableList tableAuditStepList highlight" data-related-table-id="tableGhostObjectList">
                                    <thead>
                                        <tr><th colspan="5"><span class="card-title activator grey-text text-darken-4">Yerleştir</span></th>
                                        <tr>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">Soru Tipi&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                data-column-index="1">
                                                No&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span></button>
                                                </th>
                                                <th>
                                                    <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                    data-column-index="1">
                                                    Aksiyon&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                        class="ion-arrow-down-b"></i></span><span
                                                        class="sorting sorting-asc blue-text text-darken-4"><i
                                                        class="ion-arrow-up-b"></i></span></button>
                                                </th>
                                                <th>
                                                    <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                    data-column-index="1">
                                                    Evet / Hayır&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                        class="ion-arrow-down-b"></i></span><span
                                                        class="sorting sorting-asc blue-text text-darken-4"><i
                                                        class="ion-arrow-up-b"></i></span></button>
                                                </th>
                                                <th style="width: 50px;"></th>
                                                <th style="width: 50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyAuditStep2List"></tbody>
                                </table>
                            </div>
                            <div id="audit_step3_list" style="display: none;">
                                <table id="tableAuditStep3List" class="tableList tableAuditStepList highlight" data-related-table-id="tableGhostObjectList">
                                    <thead>
                                        <tr><th colspan="5"><span class="card-title activator grey-text text-darken-4">Parlat</span></th>
                                        <tr>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">Soru Tipi&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                data-column-index="1">
                                                No&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span></button>
                                                </th>
                                                <th>
                                                    <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                    data-column-index="1">
                                                    Aksiyon&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                        class="ion-arrow-down-b"></i></span><span
                                                        class="sorting sorting-asc blue-text text-darken-4"><i
                                                        class="ion-arrow-up-b"></i></span></button>
                                                </th>
                                                <th>
                                                    <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                    data-column-index="1">
                                                    Evet / Hayır&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                        class="ion-arrow-down-b"></i></span><span
                                                        class="sorting sorting-asc blue-text text-darken-4"><i
                                                        class="ion-arrow-up-b"></i></span></button>
                                                </th>
                                                <th style="width: 50px;"></th>
                                                <th style="width: 50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyAuditStep3List"></tbody>
                                </table>
                            </div>
                            <div id="audit_step4_list" style="display: none;">
                                <table id="tableAuditStep4List" class="tableList tableAuditStepList highlight" data-related-table-id="tableGhostObjectList">
                                    <thead>
                                        <tr><th colspan="5"><span class="card-title activator grey-text text-darken-4">Alıştır</span></th>
                                        <tr>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">Soru Tipi&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                data-column-index="1">
                                                No&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span></button>
                                                </th>
                                                <th>
                                                    <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                    data-column-index="1">
                                                    Aksiyon&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                        class="ion-arrow-down-b"></i></span><span
                                                        class="sorting sorting-asc blue-text text-darken-4"><i
                                                        class="ion-arrow-up-b"></i></span></button>
                                                </th>
                                                <th>
                                                    <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                    data-column-index="1">
                                                    Evet / Hayır&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                        class="ion-arrow-down-b"></i></span><span
                                                        class="sorting sorting-asc blue-text text-darken-4"><i
                                                        class="ion-arrow-up-b"></i></span></button>
                                                </th>
                                                <th style="width: 50px;"></th>
                                                <th style="width: 50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyAuditStep4List"></tbody>
                                </table>
                            </div>
                            <div id="audit_step5_list" style="display: none;">
                                <table id="tableAuditStep5List" class="tableList tableAuditStepList highlight" data-related-table-id="tableGhostObjectList">
                                    <thead>
                                        <tr><th colspan="5"><span class="card-title activator grey-text text-darken-4">Kalıcı Kıl</span></th>
                                        <tr>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">Soru Tipi&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                data-column-index="1">
                                                No&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span></button>
                                                </th>
                                                <th>
                                                    <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                    data-column-index="1">
                                                    Aksiyon&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                        class="ion-arrow-down-b"></i></span><span
                                                        class="sorting sorting-asc blue-text text-darken-4"><i
                                                        class="ion-arrow-up-b"></i></span></button>
                                                </th>
                                                <th>
                                                    <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                    data-column-index="1">
                                                    Evet / Hayır&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                        class="ion-arrow-down-b"></i></span><span
                                                        class="sorting sorting-asc blue-text text-darken-4"><i
                                                        class="ion-arrow-up-b"></i></span></button>
                                                </th>
                                                <th style="width: 50px;"></th>
                                                <th style="width: 50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyAuditStep5List"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?php includeView($controller, 'edit.audit.dialog'); ?>
<?php includeView($controller, 'add.auditstep.dialog'); ?>
<?php includeView($controller, 'edit.auditstep.dialog'); ?>
<?php includeView($controller, 'add.stepphoto.dialog'); ?>
<?php includeView($controller, 'upload.stepphoto.dialog'); ?>
<div id="divErrorDialog" class="divDialogContent divAlertDialog divErrorDialog">
    <div class="divContentWrapper level3">
        <div class="divDialogContentContainer">
            <header class="headerHero z-depth-1 red darken-4">
                <div class="divHeaderInfo">
                    <h3 class="red-text text-darken-4"><?php echo __('Error'); ?></h3>
                </div>
                <button class="buttonCloseDialog right btn-icon-only waves-effect waves-light btn-flat"><i class="ion-android-close red-text text-darken-4"></i></button>
            </header>
            <div class="divContentPanel z-depth-1 red darken-4">
                <div class="white-text">
                    <p id="pFormErrorText"></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="divLoaderNonBlocking"><img src="assets/img/loader-oval.svg" width="20" height="20" /><span class="blue-text text-darken-4">Loading</span></div>
<div class="divDialogContent divLoader" id="divLoader" style="display: none;">
    <div class="divContentWrapper level4">
        <div class="divDialogContentContainer">
            <div class="row">
                <div class="col s12 center-align">
                    <img src="assets/img/loader.svg" width="70" height="70" />
                </div>
            </div>
            <div class="row">
                <div id="divLoaderText" class="col s12 m12 l12 blue-text text-darken-4 center" data-default-text=""></div>
            </div>
        </div>
    </div>
</div>
<div class="divHiddenElements">
    <div id="divAuditStateHTMLDBReader" class=""></div>
    <div id="divAuditStepCategoryHTMLDBReader" class=""></div>
    <div id="divAuditStepTypeHTMLDBReader" class=""></div>
    <div id="divAuditHTMLDBReader" class=""></div>
    <div id="divAuditHTMLDBWriter" class="HTMLDBAction HTMLDBLoopWriter" data-htmldb-reader="divAuditHTMLDBReader"></div>
    <div id="divAuditStepHTMLDBReader" class=""></div>
    <div id="divAuditStepHTMLDBWriter" class="HTMLDBAction HTMLDBLoopWriter" data-htmldb-reader="divAuditStepHTMLDBReader"></div>
    <div id="divAuditStepYesHTMLDBWriter" class="HTMLDBAction HTMLDBLoopWriter" data-htmldb-reader=""></div>
    <div id="divAuditStep1HTMLDBReader" class=""></div>
    <div id="divAuditStep2HTMLDBReader" class=""></div>
    <div id="divAuditStep3HTMLDBReader" class=""></div>
    <div id="divAuditStep4HTMLDBReader" class=""></div>
    <div id="divAuditStep5HTMLDBReader" class=""></div>
    <table>
        <tbody id="tbodyAuditStep1ListTemplate">
            <tr class="tr#divAuditStep1HTMLDBReader.id">
                <td class="center"><span class="spanAuditStepType spanAuditStepType#divAuditStep1HTMLDBReader.audit_step_type_id">#divAuditStep1HTMLDBReader.audit_step_type_idDisplayText</span></td>
                <td>#divAuditStep1HTMLDBReader.index</td>
                <td><span>#divAuditStep1HTMLDBReader.step_action</span><br><span class="spanNote red-text text-darken-4">#divAuditStep1HTMLDBReader.audit_note</span></td>
                <td class="center" nowrap="nowrap">
                    <button id="buttonSatisfiedYes#divAuditStep1HTMLDBReader.id" data-audit-type="#divAuditStep1HTMLDBReader.audit_step_type_id" type="button" data-value="1" class="btn buttonSatisfied buttonSatisfiedYes btn-flat waves-effect waves-light buttonSatisfiedYes#divAuditStep1HTMLDBReader.yes" data-row-id="#divAuditStep1HTMLDBReader.id">E</button>
                    <button id="buttonSatisfiedNo#divAuditStep1HTMLDBReader.id" type="button" data-value="0" class="btn buttonSatisfied buttonSatisfiedNo btn-flat waves-effect waves-light buttonSatisfiedNo#divAuditStep1HTMLDBReader.no" data-row-id="#divAuditStep1HTMLDBReader.id">H</button>
                </td>
                <td>
                    <button type="button" data-row-id="#divAuditStep1HTMLDBReader.id" class="buttonAddStepPhoto buttonTableListAction buttonEditObject right" data-dialog-id="divStepPhotoDialog">
                        <i class="ion-images"><span class="spanIMGCount" id="spanIMGCount#divAuditStep1HTMLDBReader.id"></span></i>
                    </button>
                </td>
                <td>
                    <button type="button" data-htmldb-row-id="#divAuditStep1HTMLDBReader.id" class="buttonEditAuditStep buttonTableListAction buttonEditObject right HTMLDBAction HTMLDBEdit" data-htmldb-source="divAuditStepHTMLDBReader" data-htmldb-dialog="divEditAuditStepDialog">
                        <i class="ion-document"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody id="tbodyAuditStep2ListTemplate">
            <tr class="tr#divAuditStep2HTMLDBReader.id">
                <td class="center"><span class="spanAuditStepType spanAuditStepType#divAuditStep2HTMLDBReader.audit_step_type_id">#divAuditStep2HTMLDBReader.audit_step_type_idDisplayText</span></td>
                <td>#divAuditStep2HTMLDBReader.index</td>
                <td><span>#divAuditStep2HTMLDBReader.step_action</span><br><span class="spanNote red-text text-darken-4">#divAuditStep2HTMLDBReader.audit_note</span></td>
                <td class="center" nowrap="nowrap">
                    <button id="buttonSatisfiedYes#divAuditStep2HTMLDBReader.id" data-audit-type="#divAuditStep2HTMLDBReader.audit_step_type_id" type="button" data-value="1" class="btn buttonSatisfied buttonSatisfiedYes btn-flat waves-effect waves-light buttonSatisfiedYes#divAuditStep2HTMLDBReader.yes" data-row-id="#divAuditStep2HTMLDBReader.id">E</button>
                    <button id="buttonSatisfiedNo#divAuditStep2HTMLDBReader.id" type="button" data-value="0" class="btn buttonSatisfied buttonSatisfiedNo btn-flat waves-effect waves-light buttonSatisfiedNo#divAuditStep2HTMLDBReader.no" data-row-id="#divAuditStep2HTMLDBReader.id">H</button>
                </td>
                <td>
                    <button type="button" data-row-id="#divAuditStep2HTMLDBReader.id" class="buttonAddStepPhoto buttonTableListAction buttonEditObject right" data-dialog-id="divStepPhotoDialog">
                        <i class="ion-images"><span class="spanIMGCount" id="spanIMGCount#divAuditStep2HTMLDBReader.id"></span></i>
                    </button>
                </td>
                <td>
                    <button type="button" data-htmldb-row-id="#divAuditStep2HTMLDBReader.id" class="buttonEditAuditStep buttonTableListAction buttonEditObject right HTMLDBAction HTMLDBEdit" data-htmldb-source="divAuditStepHTMLDBReader" data-htmldb-dialog="divEditAuditStepDialog">
                        <i class="ion-document"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody id="tbodyAuditStep3ListTemplate">
            <tr class="tr#divAuditStep3HTMLDBReader.id">
                <td class="center"><span class="spanAuditStepType spanAuditStepType#divAuditStep3HTMLDBReader.audit_step_type_id">#divAuditStep3HTMLDBReader.audit_step_type_idDisplayText</span></td>
                <td>#divAuditStep3HTMLDBReader.index</td>
                <td><span>#divAuditStep3HTMLDBReader.step_action</span><br><span class="spanNote red-text text-darken-4">#divAuditStep3HTMLDBReader.audit_note</span></td>
                <td class="center" nowrap="nowrap">
                    <button id="buttonSatisfiedYes#divAuditStep3HTMLDBReader.id" data-audit-type="#divAuditStep3HTMLDBReader.audit_step_type_id" type="button" data-value="1" class="btn buttonSatisfied buttonSatisfiedYes btn-flat waves-effect waves-light buttonSatisfiedYes#divAuditStep3HTMLDBReader.yes" data-row-id="#divAuditStep3HTMLDBReader.id">E</button>
                    <button id="buttonSatisfiedNo#divAuditStep3HTMLDBReader.id" type="button" data-value="0" class="btn buttonSatisfied buttonSatisfiedNo btn-flat waves-effect waves-light buttonSatisfiedNo#divAuditStep3HTMLDBReader.no" data-row-id="#divAuditStep3HTMLDBReader.id">H</button>
                </td>
                <td>
                    <button type="button" data-row-id="#divAuditStep3HTMLDBReader.id" class="buttonAddStepPhoto buttonTableListAction buttonEditObject right" data-dialog-id="divStepPhotoDialog">
                        <i class="ion-images"><span class="spanIMGCount" id="spanIMGCount#divAuditStep3HTMLDBReader.id"></span></i>
                    </button>
                </td>
                <td>
                    <button type="button" data-htmldb-row-id="#divAuditStep3HTMLDBReader.id" class="buttonEditAuditStep buttonTableListAction buttonEditObject right HTMLDBAction HTMLDBEdit" data-htmldb-source="divAuditStepHTMLDBReader" data-htmldb-dialog="divEditAuditStepDialog">
                        <i class="ion-document"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody id="tbodyAuditStep4ListTemplate">
            <tr class="tr#divAuditStep4HTMLDBReader.id">
                <td class="center"><span class="spanAuditStepType spanAuditStepType#divAuditStep4HTMLDBReader.audit_step_type_id">#divAuditStep4HTMLDBReader.audit_step_type_idDisplayText</span></td>
                <td>#divAuditStep4HTMLDBReader.index</td>
                <td><span>#divAuditStep4HTMLDBReader.step_action</span><br><span class="spanNote red-text text-darken-4">#divAuditStep4HTMLDBReader.audit_note</span></td>
                <td class="center" nowrap="nowrap">
                    <button id="buttonSatisfiedYes#divAuditStep4HTMLDBReader.id" data-audit-type="#divAuditStep4HTMLDBReader.audit_step_type_id" type="button" data-value="1" class="btn buttonSatisfied buttonSatisfiedYes btn-flat waves-effect waves-light buttonSatisfiedYes#divAuditStep4HTMLDBReader.yes" data-row-id="#divAuditStep4HTMLDBReader.id">E</button>
                    <button id="buttonSatisfiedNo#divAuditStep4HTMLDBReader.id" type="button" data-value="0" class="btn buttonSatisfied buttonSatisfiedNo btn-flat waves-effect waves-light buttonSatisfiedNo#divAuditStep4HTMLDBReader.no" data-row-id="#divAuditStep4HTMLDBReader.id">H</button>
                </td>
                <td>
                    <button type="button" data-row-id="#divAuditStep4HTMLDBReader.id" class="buttonAddStepPhoto buttonTableListAction buttonEditObject right" data-dialog-id="divStepPhotoDialog">
                        <i class="ion-images"><span class="spanIMGCount" id="spanIMGCount#divAuditStep4HTMLDBReader.id"></span></i>
                    </button>
                </td>
                <td>
                    <button type="button" data-htmldb-row-id="#divAuditStep4HTMLDBReader.id" class="buttonEditAuditStep buttonTableListAction buttonEditObject right HTMLDBAction HTMLDBEdit" data-htmldb-source="divAuditStepHTMLDBReader" data-htmldb-dialog="divEditAuditStepDialog">
                        <i class="ion-document"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody id="tbodyAuditStep5ListTemplate">
            <tr class="tr#divAuditStep5HTMLDBReader.id">
                <td class="center"><span class="spanAuditStepType spanAuditStepType#divAuditStep5HTMLDBReader.audit_step_type_id">#divAuditStep5HTMLDBReader.audit_step_type_idDisplayText</span></td>
                <td>#divAuditStep5HTMLDBReader.index</td>
                <td><span>#divAuditStep5HTMLDBReader.step_action</span><br><span class="spanNote red-text text-darken-4">#divAuditStep5HTMLDBReader.audit_note</span></td>
                <td class="center" nowrap="nowrap">
                    <button id="buttonSatisfiedYes#divAuditStep5HTMLDBReader.id" data-audit-type="#divAuditStep5HTMLDBReader.audit_step_type_id" type="button" data-value="1" class="btn buttonSatisfied buttonSatisfiedYes btn-flat waves-effect waves-light buttonSatisfiedYes#divAuditStep5HTMLDBReader.yes" data-row-id="#divAuditStep5HTMLDBReader.id">E</button>
                    <button id="buttonSatisfiedNo#divAuditStep5HTMLDBReader.id" type="button" data-value="0" class="btn buttonSatisfied buttonSatisfiedNo btn-flat waves-effect waves-light buttonSatisfiedNo#divAuditStep5HTMLDBReader.no" data-row-id="#divAuditStep5HTMLDBReader.id">H</button>
                </td>
                <td>
                    <button type="button" data-row-id="#divAuditStep5HTMLDBReader.id" class="buttonAddStepPhoto buttonTableListAction buttonEditObject right" data-dialog-id="divStepPhotoDialog">
                        <i class="ion-images"><span class="spanIMGCount" id="spanIMGCount#divAuditStep5HTMLDBReader.id"></span></i>
                    </button>
                </td>
                <td>
                    <button type="button" data-htmldb-row-id="#divAuditStep5HTMLDBReader.id" class="buttonEditAuditStep buttonTableListAction buttonEditObject right HTMLDBAction HTMLDBEdit" data-htmldb-source="divAuditStepHTMLDBReader" data-htmldb-dialog="divEditAuditStepDialog">
                        <i class="ion-document"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <form id="formCreateZip" name="formCreateZip" method="post" target="iframeFormCreateZip" action="<?php echo $_SPRIT['URL_PREFIX']; ?>audit/formcreatezip"></form>
    <iframe id="iframeFormCreateZip" name="iframeFormCreateZip" class="iframeFormPOST"></iframe>
</div>
<script src="assets/js/global.js"></script>
<script src="assets/js/htmldb_helpers.js"></script>
<script src="assets/js/audit.js"></script>
<script src="assets/js/uploadstepphoto.js"></script>
</body>
</html>