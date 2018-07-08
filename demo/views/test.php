<?php includeView($controller, 'head'); ?>
<body data-active-page-csv="" data-active-dialog="" data-url-prefix="<?php echo $_SPRIT['URL_PREFIX']; ?>" data-page-url="companies">
    <?php includeView($controller, 'header'); ?>
    <div class="divFullPageHeader">
        <div class="divTabsContainer z-depth-1"></div>
    </div>
    <div class="divPageSubHeader">
        <h2><a href="<?php echo $_SPRIT['URL_PREFIX']; ?>home">Anasayfa</a></h2>
        <h1>Firmalar</h1>
    </div>
    <section class="sectionContent">
        <div class="divDialogContentContainer col s12">
            <div class="divContentPanel z-depth-1">
                <button class="waves-effect white-text btn right cyan darken-1 htmldb-button-add" type="button" data-htmldb-form="formCompany"><i class="ion-plus"></i> YENİ FİRMA</button>
                <nav class="navSearch" style="margin-top:60px">
                    <div class="nav-wrapper">
                        <form>
                            <div class="input-field"><input id="strSearchObject" name="strSearchObject"
                                class="blue-text text-darken-4" placeholder="Ara..."
                                type="search"><label for="strSearchObject" class="active"><i
                                    class="blue-text text-darken-4 material-icons ion-android-search"></i></label>
                            </div>
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
                            <th>
                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                data-column-index="0">ID&nbsp;<span
                                class="sorting sorting-desc blue-text text-darken-4"><i
                                class="ion-arrow-down-b"></i></span><span
                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                            </th>
                            <th>
                                <button type="button" class="buttonTableColumn buttonTableColumn1" data-column-index="1">Firma&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                        class="ion-arrow-down-b"></i></span><span
                                        class="sorting sorting-asc blue-text text-darken-4"><i
                                        class="ion-arrow-up-b"></i></span></button>
                            </th>
                            <th>
                                <button type="button" class="buttonTableColumn buttonTableColumn1" data-column-index="1">Puan&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"><i
                                                class="ion-arrow-up-b"></i></span></button>
                            </th>
                            <th>
                                <button type="button" class="buttonTableColumn buttonTableColumn1" data-column-index="1">Tür&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                        class="ion-arrow-down-b"></i></span><span
                                                        class="sorting sorting-asc blue-text text-darken-4"><i
                                                        class="ion-arrow-up-b"></i></span></button>
                            </th>
                            <th>
                                <button type="button" class="buttonTableColumn buttonTableColumn1" data-column-index="1">Danışman&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                                class="ion-arrow-down-b"></i></span><span
                                                                class="sorting sorting-asc blue-text text-darken-4"><i
                                                                class="ion-arrow-up-b"></i></span></button>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbodyObjectList"></tbody>
                </table>
                <div class="row">
                    <button id="buttonShowMore" class="buttonShowMore btn-flat waves-effect waves-dark btn-large white blue-text text-darken-4 col s12" style="display: none;">Show More...</button>
                </div>
            </div>
        </div>
    </section>
    <?php includeView($controller, 'add.company.dialog'); ?>
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
    <div id="companyTypesHTMLDB" class="htmldb-table" data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>company/readcompanytype" data-htmldb-readonly="1" data-htmldb-priority="0"></div>
    <div id="companyHTMLDB" class="htmldb-table" data-htmldb-local="1" data-htmldb-read-url="<?php echo $_SPRIT['URL_PREFIX']; ?>companies/read" data-htmldb-validate-url="<?php echo $_SPRIT['URL_PREFIX']; ?>companies/validate" data-htmldb-write-url="<?php echo $_SPRIT['URL_PREFIX']; ?>companies/write" data-htmldb-readonly="1" data-htmldb-priority="1" data-htmldb-redirect="<?php echo $_SPRIT['URL_PREFIX']; ?>company/last" data-htmldb-loader="divLoader"></div>
    <script type="text/html" id="tbodyObjectListTemplate" class="htmldb-template" data-htmldb-table="companyHTMLDB" data-htmldb-template-target="tbodyObjectList">
        <tr class="tr{{id}}" data-object-id="{{id}}">
            <td class="center">
                <label class="checkbox2 left-align" for="bSelectObject{{id}}">
                    <input data-object-id="{{id}}" class="bSelectObject" id="bSelectObject{{id}}" name="bSelectObject{{id}}" value="1" type="checkbox">
                    <span class="outer">
                        <span class="inner"></span>
                    </span>
                </label>
            </td>
            <td class="tdEditObject">{{id}}</td>
            <td class="tdEditObject">{{company_name}}</td>
            <td class="tdEditObject">{{type}}</td>
            <td class="tdEditObject">
                <button class="buttonTableListAction buttonEditObject right htmldb-button-edit" data-htmldb-edit-id="{{id}}" type="button" data-htmldb-table="companyHTMLDB" data-htmldb-form="formCompany"><i class="ion-android-delete"></i></button>
                <a data-object-id="{{id}}" class="buttonTableListAction buttonEditObject right" href="<?php echo $_SPRIT['URL_PREFIX']; ?>company/{{id}}">
                    <i class="ion-android-search"></i>
                </a>
            </td>
        </tr>
    </script>
    <script src="assets/js/global.js"></script>
    <script src="../src/htmldb.js"></script>
    <script src="assets/js/spritpanel.htmldb.js"></script>
</body>
</html>