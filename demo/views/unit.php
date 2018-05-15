<?php includeView($controller, 'head'); ?>
<body class="" data-active-page-csv="" data-active-dialog="" data-url-prefix="<?php echo $_SPRIT['URL_PREFIX']; ?>"
  data-page-url="companies">
  <?php includeView($controller, 'header'); ?>
  <div class="divFullPageHeader">
    <div class="divTabsContainer z-depth-1">
        <ul class="tabs tabs-fixed-width center-align z-depth-1">
            <li class="tab"><a class="active" href="#sectionDetails">DETAYLAR</a></li>
            <li class="tab"><a class="" href="#sectionAudits">DENETİMLER</a></li>
            <li class="tab"><a id="showApplication" href="javasript:void(0);">UYGULAMA</a></li>
        </ul>
    </div>
</div>
<div class="divPageSubHeader">
    <h2><a href="<?php echo $_SPRIT['URL_PREFIX']; ?>home">Anasayfa</a>&nbsp;<i class="ion-chevron-right"></i>&nbsp;<a href="<?php echo $_SPRIT['URL_PREFIX']; ?>companies">Firmalar</a>&nbsp;<i class="ion-chevron-right"></i>&nbsp;<a href="#" class="aCompanyNameLink HTMLDBFieldContent" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="company_idDisplayText"></a></h2>
    <h1 class="HTMLDBFieldContent" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="name">&nbsp;</h1>
</div>
<section id="sectionDetails" class="sectionContent">
    <div class="col s12">
        <form id="formDetails" name="formDetails">
            <div class="card horizontal grey lighten-3">
                <div class="card-stacked">
                    <div class="card-content">
                        <div class="row">
                            <div class="col l6 m6 s12">
                                <label><?php echo __('Alan'); ?></label>
                                <div class="input-field">
                                    <p class="HTMLDBFieldContent" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="name">&nbsp;</p>
                                </div>
                            </div>
                            <div class="col l6 m6 s12">
                                <label><?php echo __('Firma'); ?></label>
                                <div class="input-field">
                                    <span id="spanCompanyId" data-htmldb-field="company_id" data-htmldb-source="divUnitHTMLDBReader" class="HTMLDBFieldContent" style="display: none;"></span>
                                    <a href="#" class="aCompanyNameLink blue-text text-darken-4"><p class="HTMLDBFieldContent" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-field="company_idDisplayText">&nbsp;</p></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button id="buttonEdit" type="button" name="buttonEdit" data-htmldb-field="id" data-htmldb-attribute="data-htmldb-row-id" data-htmldb-dialog="divUnitDialog" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-row-id="" class="buttonAction HTMLDBAction HTMLDBEdit HTMLDBFieldAttribute waves-effect waves-dark cyan-text text-darken-1 btn white"><i class="ion-edit col s12"></i> <?php echo __('UPDATE'); ?></button>
                    </div>
                </div>
            </div>
            <div class="card horizontal grey lighten-3">
                <div class="card-stacked">
                    <div class="card-content">
                        <div class="row">
                            <span class="card-title activator grey-text text-darken-4">Alan Temsilcileri</span>
                            <button class="waves-effect white-text btn right cyan darken-1 HTMLDBAction HTMLDBAdd" type="button" data-htmldb-dialog="divUnitCrewDialog" data-htmldb-source="divUnitCrewHTMLDBReader" data-htmldb-row-id="0"><i class="ion-plus"></i> YENİ TEMSİLCİ</button>
                            <table id="tableObjectList" class="tableList highlight" data-related-table-id="tableGhostObjectList">
                                <thead>
                                    <tr>
                                        <th class="center" style="width: 40px;">
                                            <label class="checkbox2 left-align" for="bSelectUnitCrews">
                                                <input class="" id="bSelectUnitCrews" name="bSelectUnitCrews" value="1"
                                                type="checkbox">
                                                <span class="outer">
                                                    <span class="inner"></span>
                                                </span>
                                            </label>
                                        </th>
                                        <th>
                                            <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                            data-column-index="0">ID&nbsp;<span
                                            class="sorting sorting-desc blue-text text-darken-4"><i
                                            class="ion-arrow-down-b"></i></span><span
                                            class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                        </th>
                                        <th></th>
                                        <th>
                                            <button type="button" class="buttonTableColumn buttonTableColumn1"
                                            data-column-index="1">
                                            Ad Soyad&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                            class="ion-arrow-down-b"></i></span><span
                                            class="sorting sorting-asc blue-text text-darken-4"><i
                                            class="ion-arrow-up-b"></i></span></button>
                                        </th>
                                        <th>
                                            <button type="button" class="buttonTableColumn buttonTableColumn1"
                                            data-column-index="1">
                                            E-posta&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                            class="ion-arrow-down-b"></i></span><span
                                            class="sorting sorting-asc blue-text text-darken-4"><i
                                            class="ion-arrow-up-b"></i></span></button>
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyUnitCrewList"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card horizontal grey lighten-3">
                <div class="card-stacked">
                    <div class="card-content">
                        <div class="row">
                            <span class="card-title activator grey-text text-darken-4">Ekip Üyeleri</span>
                            <button class="waves-effect white-text btn right cyan darken-1 HTMLDBAction HTMLDBAdd" type="button" data-htmldb-dialog="divCrewDialog" data-htmldb-source="divCrewHTMLDBReader" data-htmldb-row-id="0"><i class="ion-plus"></i> YENİ ÜYE</button>
                            <table id="tableObjectList" class="tableList highlight" data-related-table-id="tableGhostObjectList">
                                <thead>
                                    <tr>
                                        <th class="center" style="width: 40px;">
                                            <label class="checkbox2 left-align" for="bSelectCrews">
                                                <input class="" id="bSelectCrews" name="bSelectCrews" value="1"
                                                type="checkbox">
                                                <span class="outer">
                                                    <span class="inner"></span>
                                                </span>
                                            </label>
                                        </th>
                                        <th>
                                            <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                            data-column-index="0">ID&nbsp;<span
                                            class="sorting sorting-desc blue-text text-darken-4"><i
                                            class="ion-arrow-down-b"></i></span><span
                                            class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                        </th>
                                        <th></th>
                                        <th>
                                            <button type="button" class="buttonTableColumn buttonTableColumn1"
                                            data-column-index="1">
                                                Ad Soyad&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"><i
                                                class="ion-arrow-up-b"></i></span></button>
                                        </th>
                                        <th>
                                            <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                data-column-index="1">
                                                E-posta&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span></button>
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyCrewList"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<section id="sectionAudits" class="sectionContent">
    <div class="col s12">
        <form id="formAudits" name="formAudits">
            <div class="card horizontal grey lighten-3">
                <div class="card-stacked">
                    <div class="card-content">
                        <div class="row">
                            <span class="card-title activator grey-text text-darken-4">Denetimler</span>
                            <button class="waves-effect white-text btn right cyan darken-1 HTMLDBAction HTMLDBAdd" type="button" data-htmldb-dialog="divAuditDialog" data-htmldb-source="divAuditHTMLDBReader" data-htmldb-row-id="0"><i class="ion-plus"></i> YENİ DENETİM</button>
                            <table id="tableObjectList" class="tableList highlight" data-related-table-id="tableGhostObjectList">
                                <thead>
                                    <tr>
                                        <th class="center" style="width: 40px;">
                                            <label class="checkbox2 left-align" for="bSelectAudits">
                                                <input class="" id="bSelectAudits" name="bSelectAudits" value="1"
                                                type="checkbox">
                                                <span class="outer">
                                                    <span class="inner"></span>
                                                </span>
                                            </label>
                                        </th>
                                        <th>
                                            <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                            data-column-index="0">ID&nbsp;<span
                                            class="sorting sorting-desc blue-text text-darken-4"><i
                                            class="ion-arrow-down-b"></i></span><span
                                            class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                        </th>
                                        <th>
                                            <button type="button" class="buttonTableColumn buttonTableColumn1"
                                            data-column-index="1">
                                            Tarih&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"><i
                                                class="ion-arrow-up-b"></i></span>
                                            </button>
                                        </th>
                                        <th>
                                            <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                data-column-index="1">
                                                Denetim Kodu&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span>
                                            </button>
                                        </th>
                                        <th>
                                            <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                data-column-index="1">
                                                Denetim Türü&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span>
                                            </button>
                                        </th>
                                        <th>
                                            <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                data-column-index="1">
                                                Denetim Durumu&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span>
                                            </button>
                                        </th>
                                        <th>
                                            <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                data-column-index="1">
                                                Denetim Skoru&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span>
                                            </button>
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyAuditList"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?php includeView($controller, 'edit.unit.dialog'); ?>
<?php includeView($controller, 'edit.unitcrew.dialog'); ?>
<?php includeView($controller, 'edit.crew.dialog'); ?>
<?php includeView($controller, 'add.audit.dialog'); ?>
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
    <div id="divAuditTypeHTMLDBReader"></div>
    <div id="divUnitHTMLDBReader"></div>
    <div id="divUnitHTMLDBWriter" class="HTMLDBAction HTMLDBLoopWriter" data-htmldb-reader="divUnitHTMLDBReader"></div>
    <div id="divCrewTypeHTMLDBReader"></div>
    <div id="divUnitCrewHTMLDBWriter" class="HTMLDBAction HTMLDBLoopWriter" data-htmldb-reader="divUnitCrewHTMLDBReader"></div>
    <div id="divUnitCrewHTMLDBReader"></div>
    <div id="divCrewHTMLDBReader"></div>
    <div id="divCrewHTMLDBWriter" class="HTMLDBAction HTMLDBLoopWriter" data-htmldb-reader="divCrewHTMLDBReader"></div>
    <div id="divAuditHTMLDBReader"></div>
    <div id="divAuditHTMLDBWriter" class="HTMLDBAction HTMLDBLoopWriter" data-htmldb-redirect="<?php echo $_SPRIT['URL_PREFIX']; ?>audit/last"></div>
    <div id="divApplicationHTMLDBReader"></div>
    <div id="divApplicationHTMLDBWriter" class="HTMLDBAction HTMLDBLoopWriter" data-htmldb-redirect="<?php echo $_SPRIT['URL_PREFIX']; ?>application/last"></div>
    <table>
        <tbody id="tbodyCrewListTemplate">
            <tr class="tr#divCrewHTMLDBReader.id">
                <td class="center">
                    <label class="checkbox2 left-align" for="bSelectCrew#divCrewHTMLDBReader.id">
                        <input data-object-id="#divCrewHTMLDBReader.id" class="bSelectCrew" id="bSelectCrew#divCrewHTMLDBReader.id" name="bSelectCrew#divCrewHTMLDBReader.id" value="1" type="checkbox">
                        <span class="outer">
                            <span class="inner"></span>
                        </span>
                    </label>
                </td>
                <td>#divCrewHTMLDBReader.id</td>
                <td>#divCrewHTMLDBReader.typeDisplayText</td>
                <td>#divCrewHTMLDBReader.name</td>
                <td>#divCrewHTMLDBReader.email</td>
                <td>
                    <button type="button" data-htmldb-row-id="#divCrewHTMLDBReader.id" class="buttonTableListAction buttonEditObject right HTMLDBAction HTMLDBEdit" data-htmldb-source="divCrewHTMLDBReader" data-htmldb-dialog="divCrewDialog">
                        <i class="ion-android-create"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody id="tbodyAuditListTemplate">
            <tr class="tr#divAuditHTMLDBReader.id" data-object-id="#divAuditHTMLDBReader.id">
                <td class="center">
                    <label class="checkbox2 left-align" for="bSelectAudit#divAuditHTMLDBReader.id">
                        <input data-object-id="#divAuditHTMLDBReader.id" class="bSelectAudit" id="bSelectAudit#divAuditHTMLDBReader.id" name="bSelectAudit#divAuditHTMLDBReader.id" value="1" type="checkbox">
                        <span class="outer">
                            <span class="inner"></span>
                        </span>
                    </label>
                </td>
                <td class="tdEditObject">#divAuditHTMLDBReader.id</td>
                <td class="tdEditObject">#divAuditHTMLDBReader.audit_date</td>
                <td class="tdEditObject">#divAuditHTMLDBReader.audit_code</td>
                <td class="tdEditObject">#divAuditHTMLDBReader.audit_type_idDisplayText</td>
                <td class="tdEditObject">#divAuditHTMLDBReader.audit_state_idDisplayText</td>
                <td class="tdEditObject">#divAuditHTMLDBReader.score</td>
                <td>
                    <a href="<?php echo $_SPRIT['URL_PREFIX']; ?>audit/#divAuditHTMLDBReader.id" data-htmldb-row-id="#divAuditHTMLDBReader.id" class="buttonTableListAction buttonEditObject right" data-htmldb-source="divAuditHTMLDBReader">
                        <i class="ion-android-search"></i>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody id="tbodyUnitCrewListTemplate">
            <tr class="tr#divUnitCrewHTMLDBReader.id">
                <td class="center">
                    <label class="checkbox2 left-align" for="bSelectCrew#divUnitCrewHTMLDBReader.id">
                        <input data-object-id="#divUnitCrewHTMLDBReader.id" class="bSelectCrew" id="bSelectCrew#divUnitCrewHTMLDBReader.id" name="bSelectCrew#divUnitCrewHTMLDBReader.id" value="1" type="checkbox">
                        <span class="outer">
                            <span class="inner"></span>
                        </span>
                    </label>
                </td>
                <td>#divUnitCrewHTMLDBReader.id</td>
                <td>#divUnitCrewHTMLDBReader.typeDisplayText</td>
                <td>#divUnitCrewHTMLDBReader.name</td>
                <td>#divUnitCrewHTMLDBReader.email</td>
                <td>
                    <button type="button" data-htmldb-row-id="#divUnitCrewHTMLDBReader.id" class="buttonTableListAction buttonEditObject right HTMLDBAction HTMLDBEdit" data-htmldb-source="divUnitCrewHTMLDBReader" data-htmldb-dialog="divUnitCrewDialog">
                        <i class="ion-android-create"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script src="assets/js/global.js"></script>
<script src="assets/js/htmldb_helpers.js"></script>
<script src="assets/js/unit.js"></script>
</body>
</html>