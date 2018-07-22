<?php includeView($controller, 'head'); ?>
<body class="" data-active-page-csv="" data-active-dialog="" data-url-prefix="<?php echo $_SPRIT['URL_PREFIX']; ?>"
      data-page-url="companies">
<?php includeView($controller, 'header'); ?>
<div class="divFullPageHeader">
    <div class="divTabsContainer z-depth-1">
        <ul class="tabs tabs-fixed-width center-align z-depth-1">
            <li class="tab"><a class="active" href="#sectionDetails">DETAYLAR</a></li>
            <li class="tab"><a class="" href="#sectionCrews">ORGANİGRAM</a></li>
            <li class="tab"><a class="" href="#sectionUnits">ALANLAR</a></li>
            <li class="tab"><a class="" href="#sectionAudits">DENETİMLER</a></li>
            <li class="tab"><a class="" href="#sectionApplications">UYGULAMALAR</a></li>
        </ul>
    </div>
</div>
<div class="divPageSubHeader htmldb-section" data-htmldb-table="companyHTMLDB">
    <h2><a href="<?php echo $_SPRIT['URL_PREFIX']; ?>home">Anasayfa</a>&nbsp;<i class="ion-chevron-right"></i>&nbsp;<a href="<?php echo $_SPRIT['URL_PREFIX']; ?>companies">Firmalar</a></h2>
    <h1 data-htmldb-content="{{company_name}}">&nbsp;</h1>
</div>
<section id="sectionDetails" class="sectionContent">
    <div class="col s12 m7">
        <form id="formDetails" name="formDetails" class="htmldb-section" data-htmldb-table="companyHTMLDB">
            <div class="card horizontal grey lighten-3">
                <div class="card-stacked">
                    <div class="card-content">
                        <div class="row">
                            <div style="display: none;">
                                <input id="detailsPersonal" name="detailsPersonal" type="checkbox" class="HTMLDBFieldValue" data-htmldb-source="divCompanyHTMLDBReader" data-htmldb-field="personal" value="">
                            </div>
                            <div class="col l3 m3 s12">
                                <label><?php echo __('Firma'); ?></label>
                                <div class="input-field">
                                    <p data-htmldb-content="{{company_name}}">&nbsp;</p>
                                </div>
                            </div>
                            <div class="col l3 m3 s12">
                                <label><?php echo __('Puan'); ?></label>
                                <div class="input-field">
                                    <p data-htmldb-content="{{score}}">&nbsp;</p>
                                </div>
                            </div>
                            <div class="col l3 m3 s12">
                                <label><?php echo __('Türü'); ?></label>
                                <div class="input-field">
                                    <p data-htmldb-content="{{typeDisplayText}}">&nbsp;</p>
                                </div>
                            </div>
                            <div class="col l3 m3 s12">
                                <label><?php echo __('Danışman'); ?></label>
                                <div class="input-field">
                                    <p data-htmldb-content="{{consultantDisplayText}}">&nbsp;</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button id="buttonEdit" type="button" name="buttonEdit" data-htmldb-edit-id="{{$URL.-1}}" data-htmldb-form="formCompany" class="buttonAction htmldb-button-edit waves-effect waves-dark cyan-text text-darken-1 btn white"><i class="ion-edit col s12"></i> <?php echo __('UPDATE'); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<section id="sectionCrews" class="sectionContent">
    <div class="col s12 m7">
        <form id="formCrews" name="formCrews">
            <div class="card horizontal grey lighten-3 hideWhenPersonelCompany" style="display: none;">
                <div class="card-stacked">
                    <div class="card-content">
                        <div class="row">
                            <span class="card-title activator grey-text text-darken-4">Firma Temsilcileri</span>
                            <button class="waves-effect white-text btn right cyan darken-1 HTMLDBAction HTMLDBAdd" type="button" data-htmldb-dialog="divCompanyCrewDialog" data-htmldb-source="divCrewHTMLDBReader" data-htmldb-row-id="0"><i class="ion-plus"></i> YENİ TEMSİLCİ</button>
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
<section id="sectionUnits" class="sectionContent">
    <div class="col s12 m7">
        <form id="formUnits" name="formUnits">
            <div class="card horizontal grey lighten-3">
                <div class="card-stacked">
                    <div class="card-content">
                        <div class="row">
                            <span class="card-title activator grey-text text-darken-4">Alanlar</span>
                            <button class="htmldb-button-add waves-effect white-text btn right cyan darken-1" type="button" data-htmldb-form="formUnit"><i class="ion-plus"></i> YENİ ALAN</button>
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
<section id="sectionAudits" class="sectionContent">
    <div class="col s12">
        <form id="formAudits" name="formAudits">
            <div class="card horizontal grey lighten-3">
                <div class="card-stacked">
                    <div class="card-content">
                        <div class="row">
                            <span class="card-title activator grey-text text-darken-4">Denetimler</span>
                            <button class="htmldb-button-add waves-effect white-text btn right cyan darken-1" type="button" data-htmldb-form="formAudit"><i class="ion-plus"></i> YENİ DENETİM</button>
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
                                            <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                            data-column-index="0">Alan Adı&nbsp;<span
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
<section id="sectionApplications" class="sectionContent">
    <div class="col s12">
        <form id="formApplications" name="formApplications">
            <div class="card horizontal grey lighten-3">
                <div class="card-stacked">
                    <div class="card-content">
                        <div class="row">
                            <span class="card-title activator grey-text text-darken-4">Uygulamalar</span>
                            <button id="buttonAddApplication" class="waves-effect white-text btn right cyan darken-1 HTMLDBAction HTMLDBAdd" type="button" data-htmldb-dialog="divCompanyApplicationDialog" data-htmldb-source="divApplicationHTMLDBReader" data-htmldb-row-id="0"><i class="ion-plus"></i> YENİ UYGULAMA</button>
                            <table id="tableObjectList" class="tableList highlight" data-related-table-id="tableGhostObjectList">
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
                                            <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                            data-column-index="0">Alan Adı&nbsp;<span
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
                                                class="ion-arrow-up-b"></i></span></button>
                                        </th>
                                        <th>
                                            <button type="button" class="buttonTableColumn buttonTableColumn1" data-column-index="1">Uygulama Kodu&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i class="ion-arrow-down-b"></i></span><span class="sorting sorting-asc blue-text text-darken-4"><i class="ion-arrow-up-b"></i></span></button>
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyApplicationList"></tbody>
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
<?php includeView($controller, 'edit.companycrew.dialog'); ?>
<?php includeView($controller, 'add.companyaudit.dialog'); ?>
<?php includeView($controller, 'add.companyapplication.dialog'); ?>
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
<div class="divDialogContent divLoader" id="divLoader">
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
<div id="consultantHTMLDB" class="htmldb-table" data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/readpropertyoptions/consultant" data-htmldb-read-only="1" data-htmldb-priority="0" data-htmldb-loader="divLoader"></div>
<div id="companyTypeHTMLDB" class="htmldb-table" data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/readcompanytype" data-htmldb-read-only="1" data-htmldb-priority="0" data-htmldb-loader="divLoader"></div>
<div id="crewTypeHTMLDB" class="htmldb-table" data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/readcrewtype" data-htmldb-read-only="1" data-htmldb-priority="0" data-htmldb-loader="divLoader"></div>
<div id="auditTypeHTMLDB" class="htmldb-table" data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/readaudittype" data-htmldb-read-only="1" data-htmldb-priority="0" data-htmldb-loader="divLoader"></div>
<div id="companyHTMLDB" data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/read/{{$URL.-1}}" data-htmldb-validate-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/validate/{{$URL.-1}}" data-htmldb-write-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/write/{{$URL.-1}}" class="htmldb-table" data-htmldb-priority="0" data-htmldb-loader="divLoader"></div>
<div id="sehirHTMLDB"
        class="htmldb-table"
        data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/readsehir"
        data-htmldb-read-only="1"
        data-htmldb-priority="0"
        data-htmldb-loader="divLoader"></div>
<div id="ilceHTMLDB"
        class="htmldb-table"
        data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/readilce"
        data-htmldb-read-only="1"
        data-htmldb-priority="0"
        data-htmldb-loader="divLoader"></div>
<div id="sehirIlceHTMLDB"
        class="htmldb-table"
        data-htmldb-table="ilceHTMLDB"
        data-htmldb-filter="sehir/in/{{sehir}}"
        data-htmldb-read-only="1"
        data-htmldb-priority="0"
        data-htmldb-loader="divLoader"
        data-htmldb-form="formCompany"></div>
<div id="unitHTMLDB" class="htmldb-table" data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/readunit/{{$URL.-1}}" data-htmldb-validate-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/validateunit/{{$URL.-1}}" data-htmldb-write-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/writeunit/{{$URL.-1}}" data-htmldb-redirect="<?php echo $_SPRIT['URL_PREFIX']; ?>unit/last" data-htmldb-loader="divLoader"></div>
<div id="crewHTMLDB" class="htmldb-table" data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/readcrew/{{$URL.-1}}" data-htmldb-validate-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/validatecrew/{{$URL.-1}}" data-htmldb-write-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/writecrew/{{$URL.-1}}" data-htmldb-loader="divLoader"></div>
<div id="auditHTMLDB" class="htmldb-table" data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/readaudit/{{$URL.-1}}" data-htmldb-validate-url="<?php echo $_SPRIT['URL_PREFIX']; ?>audit/validate" data-htmldb-write-url="<?php echo $_SPRIT['URL_PREFIX']; ?>audit/write" data-htmldb-redirect="<?php echo $_SPRIT['URL_PREFIX']; ?>audit/last" data-htmldb-loader="divLoader"></div>
<div id="applicationHTMLDB" class="htmldb-table" data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/readapplication/{{$URL.-1}}" data-htmldb-validate-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/validateapplication/{{$URL.-1}}" data-htmldb-write-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/writeapplication/{{$URL.-1}}" data-htmldb-redirect="<?php echo $_SPRIT['URL_PREFIX']; ?>application/last" data-htmldb-loader="divLoader"></div>
<div id="unitForApplicationHTMLDB" class="htmldb-table" data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/readunitforapplication/{{$URL.-1}}" data-htmldb-loader="divLoader"></div>
<div id="unitForAuditHTMLDB" class="htmldb-table" data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/readunitforaudit/{{$URL.-1}}" data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/readcompanytype" data-htmldb-loader="divLoader"></div>
<script type="text/html" id="tbodyApplicationListTemplate" class="htmldb-template" data-htmldb-table="applicationHTMLDB" data-htmldb-template-target="tbodyApplicationList">
    <tr class="trApplication{{id}}" data-object-id="{{id}}">
        <td class="center">
            <label class="checkbox2 left-align" for="bSelectObject{{id}}">
                <input data-object-id="{{id}}" class="bSelectObject" id="bSelectObject{{id}}" name="bSelectObject{{id}}" value="1" type="checkbox">
                <span class="outer">
                    <span class="inner"></span>
                </span>
            </label>
        </td>
        <td class="tdEditObject tdApplicationEditObject">{{id}}</td>
        <td class="tdEditObject tdApplicationEditObject">{{unit_idDisplayText}}</td>
        <td class="tdEditObject tdApplicationEditObject">{{application_date}}</td>
        <td class="tdEditObject tdApplicationEditObject">{{application_code}}</td>
        <td>
            <a href="<?php echo $_SPRIT['URL_PREFIX']; ?>application/{{id}}" data-htmldb-row-id="{{id}}" class="buttonTableListAction buttonEditObject right">
                <i class="ion-android-search"></i>
            </a>
        </td>
    </tr>
</script>
<script type="text/html" id="tbodyUnitListTemplate" class="htmldb-template" data-htmldb-table="unitHTMLDB" data-htmldb-template-target="tbodyUnitList">
    <tr class="trUnit{{id}}" data-object-id="{{id}}">
        <td class="center">
            <label class="checkbox2 left-align" for="bSelectObject{{id}}">
                <input data-object-id="{{id}}" class="bSelectObject" id="bSelectObject{{id}}" name="bSelectObject{{id}}" value="1" type="checkbox">
                <span class="outer">
                    <span class="inner"></span>
                </span>
            </label>
        </td>
        <td class="tdEditObject tdUnitEditObject">{{id}}</td>
        <td class="tdEditObject tdUnitEditObject">{{name}}</td>
        <td>
            <a data-object-id="{{id}}" class="buttonTableListAction buttonEditObject right" href="<?php echo $_SPRIT['URL_PREFIX']; ?>unit/{{id}}">
                <i class="ion-android-search"></i>
            </a>
        </td>
    </tr>
</script>
<script type="text/html" id="tbodyCrewListTemplate" class="htmldb-template" data-htmldb-table="crewHTMLDB" data-htmldb-template-target="tbodyCrewList">
    <tr class="trCrew{{id}}">
        <td class="center">
            <label class="checkbox2 left-align" for="bSelectCrew{{id}}">
                <input data-object-id="{{id}}" class="bSelectCrew" id="bSelectCrew{{id}}" name="bSelectCrew{{id}}" value="1" type="checkbox">
                <span class="outer">
                    <span class="inner"></span>
                </span>
            </label>
        </td>
        <td>{{id}}</td>
        <td>{{typeDisplayText}}</td>
        <td>{{name}}</td>
        <td>{{email}}</td>
        <td>
            <button type="button" data-htmldb-row-id="{{id}}" class="buttonTableListAction buttonEditObject right htmldb-button-edit" data-htmldb-table="crewHTMLDB">
                <i class="ion-android-create"></i>
            </button>
        </td>
    </tr>
</script>
<script type="text/html" id="tbodyAuditListTemplate" class="htmldb-template" data-htmldb-table="auditHTMLDB" data-htmldb-template-target="tbodyAuditList">
    <tr class="trAudit{{id}}" data-object-id="{{id}}">
        <td class="center">
            <label class="checkbox2 left-align" for="bSelectAudit{{id}}">
                <input data-object-id="{{id}}" class="bSelectAudit" id="bSelectAudit{{id}}" name="bSelectAudit{{id}}" value="1" type="checkbox">
                <span class="outer">
                    <span class="inner"></span>
                </span>
            </label>
        </td>
        <td class="tdEditObject tdAuditEditObject">{{id}}</td>
        <td class="tdEditObject tdAuditEditObject">{{unit_idDisplayText}}</td>
        <td class="tdEditObject tdAuditEditObject">{{audit_date}}</td>
        <td class="tdEditObject tdAuditEditObject">{{audit_code}}</td>
        <td class="tdEditObject tdAuditEditObject">{{audit_type_idDisplayText}}</td>
        <td class="tdEditObject tdAuditEditObject">{{audit_state_idDisplayText}}</td>
        <td class="tdEditObject tdAuditEditObject">{{score}}</td>
        <td>
            <a href="<?php echo $_SPRIT['URL_PREFIX']; ?>audit/{{id}}" data-htmldb-row-id="{{id}}" class="buttonTableListAction buttonEditObject right">
                <i class="ion-android-search"></i>
            </a>
        </td>
    </tr>
</script>
<script src="assets/js/global.js"></script>
<script src="../src/htmldb.js"></script>
<script src="assets/js/spritpanel.htmldb.js"></script>
<script src="assets/js/company.js"></script>
</body>
</html>