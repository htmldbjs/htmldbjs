<?php includeView($controller, 'head'); ?>
<body class="" data-active-page-csv="" data-active-dialog="" data-url-prefix="<?php echo $_SPRIT['URL_PREFIX']; ?>"
  data-page-url="companies">
  <?php includeView($controller, 'header'); ?>
  <div class="divFullPageHeader">
    <div class="divTabsContainer z-depth-1">
    </div>
</div>
<div class="divPageSubHeader">
    <h2><a href="<?php echo $_SPRIT['URL_PREFIX']; ?>home">Anasayfa</a>&nbsp;<i class="ion-chevron-right"></i>&nbsp;<a href="<?php echo $_SPRIT['URL_PREFIX']; ?>companies">Firmalar</a>&nbsp;<i class="ion-chevron-right"></i>&nbsp;<a href="#" class="aCompanyNameLink HTMLDBFieldContent" data-htmldb-source="divApplicationHTMLDBReader" data-htmldb-field="company_idDisplayText"></a>&nbsp;<i class="ion-chevron-right"></i>&nbsp;<a href="#" class="aUnitNameLink HTMLDBFieldContent" data-htmldb-source="divApplicationHTMLDBReader" data-htmldb-field="unit_idDisplayText"></a></h2>
    <h1 class="HTMLDBFieldContent" data-htmldb-source="divApplicationHTMLDBReader" data-htmldb-field="application_code">&nbsp;</h1>
</div>
<section id="sectionDetails" class="sectionContent">
    <div class="col s12">
        <form id="formDetails" name="formDetails">
            <div class="card horizontal grey lighten-3">
                <div class="card-stacked">
                    <div class="card-content">
                        <div class="row">
                            <span id="spanCompanyId" data-htmldb-field="company_id" data-htmldb-source="divApplicationHTMLDBReader" class="HTMLDBFieldContent" style="display: none;"></span>
                            <span id="spanUnitId" data-htmldb-field="unit_id" data-htmldb-source="divApplicationHTMLDBReader" class="HTMLDBFieldContent" style="display: none;"></span>
                            <div class="col l3 m3 s12">
                                <label><?php echo __('Uygulama Tarihi'); ?></label>
                                <div class="input-field">
                                    <p class="HTMLDBFieldContent" data-htmldb-source="divApplicationHTMLDBReader" data-htmldb-field="application_date">&nbsp;</p>
                                </div>
                            </div>
                            <div class="col l3 m3 s12">
                                <label><?php echo __('Uygulama Kodu'); ?></label>
                                <div class="input-field">
                                    <p class="HTMLDBFieldContent" data-htmldb-source="divApplicationHTMLDBReader" data-htmldb-field="application_code">&nbsp;</p>
                                </div>
                            </div>
                            <div class="col l6 m6 s12">
                                <label><?php echo __('Alan'); ?></label>
                                <div class="input-field">
                                    <a href="#" class="aUnitNameLink blue-text text-darken-4"><p class="HTMLDBFieldContent" data-htmldb-source="divApplicationHTMLDBReader" data-htmldb-field="unit_idDisplayText">&nbsp;</p></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card horizontal grey lighten-3">
                <div class="card-stacked">
                    <div class="card-content">
                        <div class="row">
                            <span class="card-title activator grey-text text-darken-4">Uygulama Adımları</span>
                            <button id="buttonAddApplicationTask" name="buttonAddApplicationTask" class="waves-effect white-text btn right cyan darken-1 HTMLDBAction HTMLDBAdd" type="button" data-htmldb-dialog="divAddApplicationTaskDialog" data-htmldb-source="divApplicationTaskHTMLDBReader" data-htmldb-row-id="0"><i class="ion-plus"></i> YENİ ADIM</button>
                            <ul id="ulApplicationTaskCategory" class="tabs tabs-fixed-width center-align z-depth-1">
                                <li class="tab"><a class="" data-index="1" href="JavaScript:void(0);">HAZIRLIK</a></li>
                                <li class="tab"><a class="" data-index="2" href="JavaScript:void(0);">AYIKLA</a></li>
                                <li class="tab"><a class="" data-index="3" href="JavaScript:void(0);">YERLEŞTİR</a></li>
                                <li class="tab"><a class="" data-index="4" href="JavaScript:void(0);">PARLAT</a></li>
                                <li class="tab"><a class="" data-index="5" href="JavaScript:void(0);">ALIŞTIR</a></li>
                                <li class="tab"><a class="" data-index="6" href="JavaScript:void(0);">KALICI KIL</a></li>
                            </ul>
                            <div id="application_task1_list">
                                <table id="tableApplicationTask1List" class="tableList tableApplicationTaskList highlight" data-related-table-id="tableGhostObjectList">
                                    <thead>
                                        <tr><th colspan="5"><span class="card-title activator grey-text text-darken-4">Hazırlık</span></th>
                                        <tr>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">ID&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">Aksiyon&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                data-column-index="1">
                                                Durum&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span></button>
                                            </th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyApplicationTask1List"></tbody>
                                </table>
                            </div>
                            <div id="application_task2_list" style="display: none;">
                                <table id="tableApplicationTask2List" class="tableList tableApplicationTaskList highlight" data-related-table-id="tableGhostObjectList">
                                    <thead>
                                        <tr><th colspan="5"><span class="card-title activator grey-text text-darken-4">Ayıkla</span></th>
                                        <tr>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">ID&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">Aksiyon&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                data-column-index="1">
                                                Durum&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span></button>
                                            </th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyApplicationTask2List"></tbody>
                                </table>
                            </div>
                            <div id="application_task3_list" style="display: none;">
                                <table id="tableApplicationTask3List" class="tableList tableApplicationTaskList highlight" data-related-table-id="tableGhostObjectList">
                                    <thead>
                                        <tr><th colspan="5"><span class="card-title activator grey-text text-darken-4">Yerleştir</span></th>
                                        <tr>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">ID&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">Aksiyon&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                data-column-index="1">
                                                Durum&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span></button>
                                            </th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyApplicationTask3List"></tbody>
                                </table>
                            </div>
                            <div id="application_task4_list" style="display: none;">
                                <table id="tableApplicationTask4List" class="tableList tableApplicationTaskList highlight" data-related-table-id="tableGhostObjectList">
                                    <thead>
                                        <tr><th colspan="5"><span class="card-title activator grey-text text-darken-4">Parlat</span></th>
                                        <tr>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">ID&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">Aksiyon&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                data-column-index="1">
                                                Durum&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span></button>
                                            </th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyApplicationTask4List"></tbody>
                                </table>
                            </div>
                            <div id="application_task5_list" style="display: none;">
                                <table id="tableApplicationTask5List" class="tableList tableApplicationTaskList highlight" data-related-table-id="tableGhostObjectList">
                                    <thead>
                                        <tr><th colspan="5"><span class="card-title activator grey-text text-darken-4">Alıştır</span></th>
                                        <tr>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">ID&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">Aksiyon&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                data-column-index="1">
                                                Durum&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span></button>
                                            </th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyApplicationTask5List"></tbody>
                                </table>
                            </div>
                            <div id="application_task6_list" style="display: none;">
                                <table id="tableApplicationTask6List" class="tableList tableApplicationTaskList highlight" data-related-table-id="tableGhostObjectList">
                                    <thead>
                                        <tr><th colspan="5"><span class="card-title activator grey-text text-darken-4">Kalıcı Kıl</span></th>
                                        <tr>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">ID&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn0 sorting-asc"
                                                data-column-index="0">Aksiyon&nbsp;<span
                                                class="sorting sorting-desc blue-text text-darken-4"><i
                                                class="ion-arrow-down-b"></i></span><span
                                                class="sorting sorting-asc blue-text text-darken-4"></span></button>
                                            </th>
                                            <th>
                                                <button type="button" class="buttonTableColumn buttonTableColumn1"
                                                data-column-index="1">
                                                Durum&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                                    class="ion-arrow-down-b"></i></span><span
                                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                                    class="ion-arrow-up-b"></i></span></button>
                                            </th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyApplicationTask6List"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?php includeView($controller, 'add.applicationtask.dialog'); ?>
<?php includeView($controller, 'edit.applicationtask.dialog'); ?>
<?php includeView($controller, 'edit.applicationsubtasks.dialog'); ?>
<?php includeView($controller, 'add.applicationsubtask.dialog'); ?>
<?php includeView($controller, 'edit.applicationsubtask.dialog'); ?>
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
    <div id="divApplicationTaskCrewHTMLDBReader" class="HTMLDBAction HTMLDBLoopReader"></div>
    <div id="divApplicationTaskStateHTMLDBReader" class="HTMLDBAction HTMLDBLoopReader"></div>
    <div id="divApplicationTaskCategoryHTMLDBReader" class="HTMLDBAction HTMLDBLoopReader"></div>
    <div id="divApplicationHTMLDBReader" class="HTMLDBAction HTMLDBLoopReader"></div>
    <div id="divApplicationHTMLDBWriter" class="HTMLDBAction HTMLDBLoopWriter" data-htmldb-reader="divApplicationHTMLDBReader"></div>
    <div id="divApplicationTaskHTMLDBReader" class="HTMLDBAction HTMLDBLoopReader"></div>
    <div id="divApplicationTaskHTMLDBWriter" class="HTMLDBAction HTMLDBLoopWriter" data-htmldb-reader="divApplicationTaskHTMLDBReader"></div>
    <div id="divApplicationSubTaskHTMLDBReader" class="HTMLDBAction HTMLDBLoopReader"></div>
    <div id="divApplicationSubTaskHTMLDBWriter" class="HTMLDBAction HTMLDBLoopWriter" data-htmldb-reader="divApplicationSubTaskHTMLDBReader"></div>
    <div id="divApplicationTask1HTMLDBReader" class="HTMLDBAction HTMLDBLoopReader"></div>
    <div id="divApplicationTask2HTMLDBReader" class="HTMLDBAction HTMLDBLoopReader"></div>
    <div id="divApplicationTask3HTMLDBReader" class="HTMLDBAction HTMLDBLoopReader"></div>
    <div id="divApplicationTask4HTMLDBReader" class="HTMLDBAction HTMLDBLoopReader"></div>
    <div id="divApplicationTask5HTMLDBReader" class="HTMLDBAction HTMLDBLoopReader"></div>
    <div id="divApplicationTask6HTMLDBReader" class="HTMLDBAction HTMLDBLoopReader"></div>
    <table>
        <tbody id="tbodyApplicationTask1ListTemplate">
            <tr class="tr#divApplicationTask1HTMLDBReader.id">
                <td>#divApplicationTask1HTMLDBReader.application_task_code</td>
                <td><span>#divApplicationTask1HTMLDBReader.task_action</span><br><span class="spanNote red-text text-darken-4">#divApplicationTask1HTMLDBReader.description</span></td>
                <td>#divApplicationTask1HTMLDBReader.application_task_state_idDisplayText</td>
                <td>
                    <button type="button" data-htmldb-row-id="#divApplicationTask1HTMLDBReader.id" class="buttonEditApplicationTask buttonTableListAction buttonEditObject right HTMLDBAction HTMLDBEdit" data-htmldb-source="divApplicationTaskHTMLDBReader" data-htmldb-dialog="divEditApplicationTaskDialog">
                        <i class="ion-android-search"></i>
                    </button>
                </td>
                <td>
                    <button type="button" data-htmldb-row-id="#divApplicationTask1HTMLDBReader.id" class="buttonEditApplicationSubTask buttonTableListAction buttonEditObject right">
                        <i class="ion-clipboard"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody id="tbodyApplicationTask2ListTemplate">
            <tr class="tr#divApplicationTask2HTMLDBReader.id">
                <td>#divApplicationTask2HTMLDBReader.application_task_code</td>
                <td><span>#divApplicationTask2HTMLDBReader.task_action</span><br><span class="spanNote red-text text-darken-4">#divApplicationTask2HTMLDBReader.description</span></td>
                <td>#divApplicationTask2HTMLDBReader.application_task_state_idDisplayText</td>
                <td>
                    <button type="button" data-htmldb-row-id="#divApplicationTask2HTMLDBReader.id" class="buttonEditApplicationTask buttonTableListAction buttonEditObject right HTMLDBAction HTMLDBEdit" data-htmldb-source="divApplicationTaskHTMLDBReader" data-htmldb-dialog="divEditApplicationTaskDialog">
                        <i class="ion-android-search"></i>
                    </button>
                </td>
                <td>
                    <button type="button" data-htmldb-row-id="#divApplicationTask2HTMLDBReader.id" class="buttonEditApplicationSubTask buttonTableListAction buttonEditObject right">
                        <i class="ion-clipboard"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody id="tbodyApplicationTask3ListTemplate">
            <tr class="tr#divApplicationTask3HTMLDBReader.id">
                <td>#divApplicationTask3HTMLDBReader.application_task_code</td>
                <td><span>#divApplicationTask3HTMLDBReader.task_action</span><br><span class="spanNote red-text text-darken-4">#divApplicationTask3HTMLDBReader.description</span></td>
                <td>#divApplicationTask3HTMLDBReader.application_task_state_idDisplayText</td>
                <td>
                    <button type="button" data-htmldb-row-id="#divApplicationTask3HTMLDBReader.id" class="buttonEditApplicationTask buttonTableListAction buttonEditObject right HTMLDBAction HTMLDBEdit" data-htmldb-source="divApplicationTaskHTMLDBReader" data-htmldb-dialog="divEditApplicationTaskDialog">
                        <i class="ion-android-search"></i>
                    </button>
                </td>
                <td>
                    <button type="button" data-htmldb-row-id="#divApplicationTask3HTMLDBReader.id" class="buttonEditApplicationSubTask buttonTableListAction buttonEditObject right">
                        <i class="ion-clipboard"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody id="tbodyApplicationTask4ListTemplate">
            <tr class="tr#divApplicationTask4HTMLDBReader.id">
                <td>#divApplicationTask4HTMLDBReader.application_task_code</td>
                <td><span>#divApplicationTask4HTMLDBReader.task_action</span><br><span class="spanNote red-text text-darken-4">#divApplicationTask4HTMLDBReader.description</span></td>
                <td>#divApplicationTask4HTMLDBReader.application_task_state_idDisplayText</td>
                <td>
                    <button type="button" data-htmldb-row-id="#divApplicationTask4HTMLDBReader.id" class="buttonEditApplicationTask buttonTableListAction buttonEditObject right HTMLDBAction HTMLDBEdit" data-htmldb-source="divApplicationTaskHTMLDBReader" data-htmldb-dialog="divEditApplicationTaskDialog">
                        <i class="ion-android-search"></i>
                    </button>
                </td>
                <td>
                    <button type="button" data-htmldb-row-id="#divApplicationTask4HTMLDBReader.id" class="buttonEditApplicationSubTask buttonTableListAction buttonEditObject right">
                        <i class="ion-clipboard"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody id="tbodyApplicationTask5ListTemplate">
            <tr class="tr#divApplicationTask5HTMLDBReader.id">
                <td>#divApplicationTask5HTMLDBReader.application_task_code</td>
                <td><span>#divApplicationTask5HTMLDBReader.task_action</span><br><span class="spanNote red-text text-darken-4">#divApplicationTask5HTMLDBReader.description</span></td>
                <td>#divApplicationTask5HTMLDBReader.application_task_state_idDisplayText</td>
                <td>
                    <button type="button" data-htmldb-row-id="#divApplicationTask5HTMLDBReader.id" class="buttonEditApplicationTask buttonTableListAction buttonEditObject right HTMLDBAction HTMLDBEdit" data-htmldb-source="divApplicationTaskHTMLDBReader" data-htmldb-dialog="divEditApplicationTaskDialog">
                        <i class="ion-android-search"></i>
                    </button>
                </td>
                <td>
                    <button type="button" data-htmldb-row-id="#divApplicationTask5HTMLDBReader.id" class="buttonEditApplicationSubTask buttonTableListAction buttonEditObject right">
                        <i class="ion-clipboard"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody id="tbodyApplicationTask6ListTemplate">
            <tr class="tr#divApplicationTask6HTMLDBReader.id">
                <td>#divApplicationTask6HTMLDBReader.application_task_code</td>
                <td><span>#divApplicationTask6HTMLDBReader.task_action</span><br><span class="spanNote red-text text-darken-4">#divApplicationTask6HTMLDBReader.description</span></td>
                <td>#divApplicationTask6HTMLDBReader.application_task_state_idDisplayText</td>
                <td>
                    <button type="button" data-htmldb-row-id="#divApplicationTask6HTMLDBReader.id" class="buttonEditApplicationTask buttonTableListAction buttonEditObject right HTMLDBAction HTMLDBEdit" data-htmldb-source="divApplicationTaskHTMLDBReader" data-htmldb-dialog="divEditApplicationTaskDialog">
                        <i class="ion-android-search"></i>
                    </button>
                </td>
                <td>
                    <button type="button" data-htmldb-row-id="#divApplicationTask6HTMLDBReader.id" class="buttonEditApplicationTask buttonTableListAction buttonEditObject right HTMLDBAction HTMLDBEdit" data-htmldb-source="divApplicationTaskHTMLDBReader" data-htmldb-dialog="divEditApplicationTaskDialog">
                        <i class="ion-clipboard"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody id="tbodyApplicationSubTaskListTemplate">
            <tr class="tr#divApplicationSubTaskHTMLDBReader.id">
                <td>#divApplicationSubTaskHTMLDBReader.title</td>
                <td>
                    <button type="button" data-htmldb-row-id="#divApplicationSubTaskHTMLDBReader.id" class="buttonEditApplicationTask buttonTableListAction buttonEditObject right HTMLDBAction HTMLDBEdit" data-htmldb-source="divApplicationSubTaskHTMLDBReader" data-htmldb-dialog="divEditApplicationSubTaskDialog">
                        <i class="ion-android-search"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script src="assets/js/global.js"></script>
<script src="assets/js/htmldb_helpers.js"></script>
<script src="assets/js/application.js"></script>
</body>
</html>