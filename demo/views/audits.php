<?php includeView($controller, 'head'); ?>
<body data-active-page-csv="" data-active-dialog="" data-url-prefix="<?php echo $_SPRIT['URL_PREFIX']; ?>"
      data-page-url="audits">
<?php includeView($controller, 'header'); ?>
<div class="divFullPageHeader">
    <div class="divTabsContainer z-depth-1">
    </div>
</div>
<div class="divPageSubHeader">
    <h2><a href="<?php echo $_SPRIT['URL_PREFIX']; ?>home">Anasayfa</a></h2>
    <h1>Denetimler</h1>
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
                        <button type="button" class="buttonTableColumn buttonTableColumn1" data-column-index="1">
                            Firma&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                        class="ion-arrow-down-b"></i></span><span
                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                        class="ion-arrow-up-b"></i></span></button>
                    </th>

                    <th>
                        <button type="button" class="buttonTableColumn buttonTableColumn1" data-column-index="1">
                            Koordinatör&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                        class="ion-arrow-down-b"></i></span><span
                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                        class="ion-arrow-up-b"></i></span></button>
                    </th>

                    <th>
                        <button type="button" class="buttonTableColumn buttonTableColumn1" data-column-index="1">
                            Birim&nbsp;<span class="sorting sorting-desc blue-text text-darken-4"><i
                                        class="ion-arrow-down-b"></i></span><span
                                    class="sorting sorting-asc blue-text text-darken-4"><i
                                        class="ion-arrow-up-b"></i></span></button>
                    </th>

                    <th></th>
                </tr>
                </thead>
                <tbody id="tbodyObjectList">
                <tr class="tr1">
                    <td class="center"><label class="checkbox2 left-align" for="bSelectObject1"> <input
                                    data-object-id="1" class="bSelectObject" id="bSelectObject1"
                                    name="bSelectObject1" value="1" type="checkbox"> <span class="outer">                                    <span
                                        class="inner"></span>                                </span> </label></td>
                    <td>1</td>
                    <td>Demir Export A.</td>
                    <td>(0312) 333 33 33</td>
                    <td>info@demirexport.com</td>
                    <td>

                        <a class="buttonTableListAction buttonEditObject right"
                           href="<?php $_SPRIT['URL_PREFIX']; ?>firma/1"><i class="ion-edit"></i></a>
                    </td>
                </tr>

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
<div class="fixed-action-btn" style="bottom: 50px; right: 30px">
    <a id="buttonAdd" class="buttonAdd btn-floating waves-effect waves-light btn-large blue darken-4"
            style="display: inline-block;" href="<?php echo $_SPRIT['URL_PREFIX']; ?>firma/1"><i class="ion-plus-round"></i></a>
</div>
<script src="assets/js/global.js"></script>
<script src="assets/js/firms.js"></script>
</body>
</html>