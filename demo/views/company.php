<?php includeView($controller, 'head'); ?>
<body class="" data-active-page-csv="" data-active-dialog="" data-url-prefix="<?php echo $_SPRIT['URL_PREFIX']; ?>"
      data-page-url="companies">
<?php includeView($controller, 'header'); ?>
<div class="divFullPageHeader">
    <div class="divTabsContainer z-depth-1">
    </div>
</div>
<div class="divPageSubHeader">
    <h2><a href="<?php echo $_SPRIT['URL_PREFIX']; ?>home">Anasayfa</a>&nbsp;<i class="ion-chevron-right"></i>&nbsp;<a href="<?php echo $_SPRIT['URL_PREFIX']; ?>companies">Firmalar</a></h2>
    <h1 class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="company_name">&nbsp;</h1>
</div>
<section id="sectionDetails" class="sectionContent">
    <div class="col s12 m7">
        <form id="formDetails" name="formDetails">
            <div class="card horizontal grey lighten-3">
                <div class="card-stacked">
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Genel Bilgiler</span>
                        <div class="row">
                            <div style="display: none;">
                                <input id="detailsPersonal" name="detailsPersonal" type="checkbox" class="HTMLDBFieldValue" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="personal" value="">
                            </div>
                            <div class="col l3 m3 s12">
                                <label><?php echo __('Firma'); ?></label>
                                <div class="input-field">
                                    <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="company_name">&nbsp;</p>
                                </div>
                            </div>
                            <div class="col l3 m3 s12">
                                <label><?php echo __('Puan'); ?></label>
                                <div class="input-field">
                                    <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="score">&nbsp;</p>
                                </div>
                            </div>
                            <div class="col l3 m3 s12">
                                <label><?php echo __('Bireysel'); ?></label>
                                <div class="input-field">
                                    <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="personal">&nbsp;</p>
                                </div>
                            </div>
                            <div class="col l3 m3 s12">
                                <label><?php echo __('Danışman'); ?></label>
                                <div class="input-field">
                                    <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="consultantDisplayText">&nbsp;</p>
                                </div>
                            </div>
                        </div>
                        <div class="sh-element sh-detailsPersonal-false" style="display: none;">
                            <span class="card-title activator grey-text text-darken-4">Sponsor</span>
                            <div class="row">
                                <div class="col l3 m3 s12">
                                    <label><?php echo __('Ad'); ?></label>
                                    <div class="input-field">
                                        <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="sponsor_firstname">&nbsp;</p>
                                    </div>
                                </div>
                                <div class="col l3 m3 s12">
                                    <label><?php echo __('Soyad'); ?></label>
                                    <div class="input-field">
                                        <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="sponsor_lastname">&nbsp;</p>
                                    </div>
                                </div>
                                <div class="col l6 m6 s12">
                                    <label><?php echo __('E-posta'); ?></label>
                                    <div class="input-field">
                                        <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="sponsor_email">&nbsp;</p>
                                    </div>
                                </div>
                            </div>
                            <span class="card-title activator grey-text text-darken-4">Koordinatör</span>
                            <div class="row">
                                <div class="col l3 m3 s12">
                                    <label><?php echo __('Ad'); ?></label>
                                    <div class="input-field">
                                        <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="coordinator_firstname">&nbsp;</p>
                                    </div>
                                </div>
                                <div class="col l3 m3 s12">
                                    <label><?php echo __('Soyad'); ?></label>
                                    <div class="input-field">
                                        <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="coordinator_lastname">&nbsp;</p>
                                    </div>
                                </div>
                                <div class="col l6 m6 s12">
                                    <label><?php echo __('E-posta'); ?></label>
                                    <div class="input-field">
                                        <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="coordinator_email">&nbsp;</p>
                                    </div>
                                </div>
                            </div>
                            <span class="card-title activator grey-text text-darken-4">Yayılım Şampiyonu</span>
                            <div class="row">
                                <div class="col l3 m3 s12">
                                    <label><?php echo __('Ad'); ?></label>
                                    <div class="input-field">
                                        <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="propagation_champion_firstname">&nbsp;</p>
                                    </div>
                                </div>
                                <div class="col l3 m3 s12">
                                    <label><?php echo __('Soyad'); ?></label>
                                    <div class="input-field">
                                        <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="propagation_champion_lastname">&nbsp;</p>
                                    </div>
                                </div>
                                <div class="col l6 m6 s12">
                                    <label><?php echo __('E-posta'); ?></label>
                                    <div class="input-field">
                                        <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="propagation_champion_email">&nbsp;</p>
                                    </div>
                                </div>
                            </div>

                            <span class="card-title activator grey-text text-darken-4">Bölüm Temsilcileri</span>
                            <div class="row">
                                <div class="col l6 m6 s12">
                                    <label><?php echo __('İSG Temsilcisi'); ?></label>
                                    <div class="input-field">
                                        <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="hse_responsible">&nbsp;</p>
                                    </div>
                                </div>
                                <div class="col l6 m6 s12">
                                    <label><?php echo __('İK Temsilcisi'); ?></label>
                                    <div class="input-field">
                                        <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="hr_responsible">&nbsp;</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l6 m6 s12">
                                    <label><?php echo __('Planlama Temsilcisi'); ?></label>
                                    <div class="input-field">
                                        <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="planning_responsible">&nbsp;</p>
                                    </div>
                                </div>
                                <div class="col l6 m6 s12">
                                    <label><?php echo __('Bakım Temsilcisi'); ?></label>
                                    <div class="input-field">
                                        <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="maintenance_responsible">&nbsp;</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l6 m6 s12">
                                    <label><?php echo __('Kalite Temsilcisi'); ?></label>
                                    <div class="input-field">
                                        <p class="HTMLDBFieldContent" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="quality_responsible">&nbsp;</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button id="buttonEdit" type="button" name="buttonEdit" data-htmldb-field="id" data-htmldb-attribute="data-htmldb-row-id" data-htmldb-dialog="divCompanyDialog" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-row-id="" class="buttonAction HTMLDBAction HTMLDBEdit HTMLDBFieldAttribute waves-effect waves-dark cyan-text text-darken-1 btn white"><i class="ion-edit col s12"></i> <?php echo __('UPDATE'); ?></button>
                    </div>
                </div>
            </div>
        <div class="card horizontal grey lighten-3">
            <div class="card-stacked">
                <div class="card-content">
                    <div class="row">
                        <span class="card-title activator grey-text text-darken-4">Alanlar</span>
                        <button class="waves-effect white-text btn right cyan darken-1 HTMLDBAction HTMLDBAdd" type="button" data-htmldb-dialog="divUnitDialog" data-htmldb-source="divUnitHTMLDBReader" data-htmldb-row-id=""><i class="ion-plus"></i> YENİ ALAN</button>
                        <table id="tableObjectList" class="tableList highlight"
                               data-related-table-id="tableGhostObjectList">
                            <thead>
                            <tr>
                                <th class="center" style="width: 40px;">
                                    <label class="checkbox2 left-align" for="bSelectObjects">
                                        <input class="" id="bSelectObjects" name="bSelectObjects" value="1"
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
                                        Alan&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span></button>
                                </th>

                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="tbodyUnitList">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</section>
<?php includeView($controller, 'edit.company.dialog'); ?>
<?php includeView($controller, 'add.unit.dialog'); ?>
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
    <div id="divConsultantHTMLDBReader"></div>
    <div id="divCompanyHTMLDBReader" class="HTMLDBAction HTMLDBLoopReader"></div>
    <div id="divCompanyHTMLDBWriter" class="HTMLDBAction HTMLDBLoopWriter" data-htmldb-reader="divCompanyHTMLDBReader"></div>
    <div id="divUnitHTMLDBReader" class="HTMLDBAction HTMLDBLoopReader"></div>
    <div id="divUnitHTMLDBWriter" class="HTMLDBAction HTMLDBLoopWriter" data-htmldb-redirect="<?php echo $_SPRIT['URL_PREFIX']; ?>unit/last"></div>
    <table>
        <tbody id="tbodyUnitListTemplate">
            <tr class="tr#divUnitHTMLDBReader.id">
                <td class="center">
                    <label class="checkbox2 left-align" for="bSelectObject#divUnitHTMLDBReader.id">
                        <input data-object-id="#divUnitHTMLDBReader.id" class="bSelectObject" id="bSelectObject#divUnitHTMLDBReader.id" name="bSelectObject#divUnitHTMLDBReader.id" value="1" type="checkbox">
                        <span class="outer">
                            <span class="inner"></span>
                        </span>
                    </label>
                </td>
                <td>#divUnitHTMLDBReader.id</td>
                <td>#divUnitHTMLDBReader.name</td>
                <td>
                    <a data-object-id="#divUnitHTMLDBReader.id" class="buttonTableListAction buttonEditObject right" href="<?php echo $_SPRIT['URL_PREFIX']; ?>unit/#divUnitHTMLDBReader.id">
                        <i class="ion-android-search"></i>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script src="assets/js/global.js"></script>
<script src="assets/js/htmldb_helpers.js"></script>
<script src="assets/js/company.js"></script>
</body>
</html>