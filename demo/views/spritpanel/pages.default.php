<?php includeView($controller, 'spritpanel/head'); ?>
    <body data-active-page-csv="" data-active-dialog="" data-url-prefix="<?php echo $_SPRIT['SPRITPANEL_URL_PREFIX']; ?>" data-page-url="pages">
        <?php includeView($controller, 'spritpanel/header'); ?>
        <ul id="ulPageTopMenuMore" class="ulPageTopMenuMore dropdown-content">
            <li><a href="JavaScript:void(0);" class="buttonPageTopMenuAdd">New...</a></li>
            <li class="divider"></li>
            <li><a href="JavaScript:void(0);" class="">Search...</a></li>
            <li><a href="JavaScript:void(0);" class="">Go To...</a></li>
            <li class="divider"></li>
            <li><a href="JavaScript:void(0);" class="">Copy<span class="spanSelection"></span>...</a></li>
            <li class="divider"></li>
            <li><a href="JavaScript:void(0);" class="" id="aDeleteObjects">Delete<span class="spanSelection"></span>...</a></li>
        </ul>
        <div class="divFullPageHeader">
            <div class="row">
                <div class="divFullPageBG col s12"></div>
                <div class="list-container col s12">
                    <div class="list-header">
                        <div class="col s6">
                            <h3 id="h3PageHeader" class="white-text">Pages / anasayfa</h3>
                            <h4 id="h4PageHeader" class="white-text"></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="divPageFrame" class="divPageContent divFullPage" data-page-header="Pages / anasayfa">
            <div class="divContentWrapper ">               
                <div class="divDialogContentContainer col s12">
                    <div class="divContentPanel z-depth-1">
                    </div>
                </div>
            </div>
        </div>
        <?php includeView($controller, 'spritpanel/footer'); ?>
        <div class="divHiddenElements">
            <div id="divActionCreateButtonTemplate">
                <button data-spritpanel-object-type="__TYPE__">Create...</button>
            </div>
            <div id="divActionEditButtonTemplate">
                <button data-spritpanel-object-id="__ID__" data-spritpanel-object-type="__TYPE__">Edit...</button>
            </div>
            <div id="divActionDeleteButtonTemplate">
                <button data-spritpanel-object-id="__ID__" data-spritpanel-object-type="__TYPE__">Delete...</button>
            </div>
            <div id="divActionListButtonTemplate">
                <button data-spritpanel-object-id="__ID__" data-spritpanel-object-type="__TYPE__">List...</button>
            </div>
        </div>
        <script src="assets/js/global.js"></script>
        <script src="assets/js/pages.js"></script>
    </body>
</html>