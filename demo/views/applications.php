<?php includeView($controller, 'head'); ?>
<body data-active-page-csv="" data-active-dialog="" data-url-prefix="<?php echo $_SPRIT['URL_PREFIX']; ?>"
      data-page-url="applications">
<?php includeView($controller, 'header'); ?>
<div class="divFullPageHeader">
    <div class="divTabsContainer z-depth-1">
    </div>
</div>
<div class="divPageSubHeader">
    <h2><a href="<?php echo $_SPRIT['URL_PREFIX']; ?>home">Anasayfa</a></h2>
    <h1>Uygulamalar</h1>
</div>
<section class="sectionContent">
    <div class="divDialogContentContainer col s12">
        <div class="divContentPanel z-depth-1">
            <nav class="navSearch">
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
                        <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                data-column-index="0">Uygulama Kodu&nbsp;<span
                                    class="sorting sorting-desc blue-text text-darken-4"><i
                                        class="ion-arrow-down-b"></i></span><span
                                    class="sorting sorting-asc blue-text text-darken-4"></span></button>
                    </th>
                    <th>
                        <button type="button" class="buttonTableColumn buttonTableColumn1" data-column-index="1">
                            Firma&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                        class="ion-arrow-down-b"></i></span><span
                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                        class="ion-arrow-up-b"></i></span></button>
                    </th>

                    <th>
                        <button type="button" class="buttonTableColumn buttonTableColumn1" data-column-index="1">
                            Alan&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                        class="ion-arrow-down-b"></i></span><span
                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                        class="ion-arrow-up-b"></i></span></button>
                    </th>
                    <th>
                        <button type="button" class="buttonTableColumn buttonTableColumn1" data-column-index="1">
                            Danışman&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                        class="ion-arrow-down-b"></i></span><span
                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                        class="ion-arrow-up-b"></i></span></button>
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="tbodyObjectList">
                </tbody>
            </table>
            <div class="row">
                <button id="buttonShowMore"
                        class="buttonShowMore btn-flat waves-effect waves-dark btn-large white blue-text text-darken-4 col s12"
                        style="display: none;">Show More...
                </button>
            </div>
        </div>
    </div>
</section>
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
    <div id="divApplicationsHTMLDBReader" class="HTMLDBAction HTMLDBLoopReader"></div>
    <div id="divApplicationsHTMLDBWriter" class="HTMLDBAction HTMLDBLoopWriter" data-htmldb-redirect="<?php echo $_SPRIT['URL_PREFIX']; ?>company/last"></div>
    <div id="divSessionHTMLDB" class="divHTMLDB"></div>
    <table>
        <tbody id="tbodyObjectListTemplate">
            <tr class="tr#divApplicationsHTMLDBReader.id">
                <td class="center">
                    <label class="checkbox2 left-align" for="bSelectObject#divApplicationsHTMLDBReader.id">
                        <input data-object-id="#divApplicationsHTMLDBReader.id" class="bSelectObject" id="bSelectObject#divApplicationsHTMLDBReader.id" name="bSelectObject#divApplicationsHTMLDBReader.id" value="1" type="checkbox">
                        <span class="outer">
                            <span class="inner"></span>
                        </span>
                    </label>
                </td>
                <td>#divApplicationsHTMLDBReader.id</td>
                <td>#divApplicationsHTMLDBReader.company_name</td>
                <td>#divApplicationsHTMLDBReader.score</td>
                <td>#divApplicationsHTMLDBReader.personal</td>
                <td>#divApplicationsHTMLDBReader.consultantDisplayText</td>
                <td>
                    <a data-object-id="#divApplicationsHTMLDBReader.id" class="buttonTableListAction buttonEditObject right" href="<?php echo $_SPRIT['URL_PREFIX']; ?>company/#divApplicationsHTMLDBReader.id">
                        <i class="ion-android-search"></i>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script src="assets/js/global.js"></script>
<script src="assets/js/htmldb_helpers.js"></script>
<script src="assets/js/applications.js"></script>
</body>
</html>